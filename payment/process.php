<?php
require_once('../admin/includes/config.php');
require_once('../admin/includes/functions.php');
require_once('../admin/includes/translate.php');
if( $bookingSettings = selectDB('tbl_calendar_settings', "`id` = '1'") ){
	$bookingSettings = $bookingSettings[0];
	$paymentSettings = json_decode($bookingSettings['payment'], true);
	$price = $paymentSettings['price'];
}else{
	$bookingSettings = array();
}
if(isset($_POST['submit'])){
	$select_extra_item = $_POST['select_extra_item'];
	$comm = "";
	$extra_price = 0;
	$select_extra_item_val = "";
	if( count($select_extra_item) > 0 ){
		for( $i = 0; $i < count($select_extra_item); $i++ ){
			$select_extra_item_arr = explode(",",$select_extra_item[$i]);
			$arr = array('item' => $select_extra_item_arr[0],'price' => $select_extra_item_arr[1]); 
			$extra_price = $extra_price + $select_extra_item_arr[1];
			$select_extra_item_val .= $comm.json_encode($arr,JSON_UNESCAPED_UNICODE);
			$comm = ",";
		}
	}else{
		$select_extra_item_val = "";
		$extra_price = 0;
	}
	$personalInfo = json_decode($_POST['personalInfo'], true);
	$bookingSettings['mobile'] = ( isset($personalInfo['1']) && !empty($personalInfo['1']) )  ? $personalInfo['1'] : $bookingSettings['mobile'];
	$extra_items = "[{$select_extra_item_val}]"; 
	$package_id = $_POST['id'];
	$booking_date = $_POST['booking_date'];
	$date = explode('-',$booking_date);
	$booking_date = $date[2].'-'.$date[1].'-'.$date[0];
	$booking_time = $_POST['booking_time'];
	$is_filming = ( isset($_POST['is_filming']) ) ? $_POST['is_filming'] : 0 ;
	date_default_timezone_set('Asia/Riyadh');
	$created_at = date('Y-m-d H:i:s');
die("check 2");
	if( check_bookingTimeAndDate($booking_date,$booking_time,$package_id) ){
		header("LOCATION: {$settingsWebsite}/?v=Reservations&id={$package_id}");die();
	}	 

	$package = get_packages_details($package_id);
	$booking_price = $package['price'] + $extra_price;
	$package_title = $package[direction('en','ar').'Title'];
	$BookingDetails = array(
		'package_id' => $package_id,
		'booking_date' => $booking_date,
		'booking_time' => $booking_time,
		'is_filming' => $is_filming,
		'extra_items' => $extra_items,
		'booking_price' => $booking_price,
		'customer_name' => "{$package_title}",
		'customer_email' => "{$bookingSettings['email']}",
		'mobile_number' => "{$bookingSettings['mobile']}",
		'personal_info' => json_encode($_POST['personalInfo'],JSON_UNESCAPED_UNICODE),
		'status' => 'Pending',
		'created_at' => $created_at,
		"InvoiceItems" => array(
			array(
				"ItemName" => $package_title.' ['.$booking_date.'] ['.$booking_time.']',
				"Quantity" => 1,
				"UnitPrice" => $booking_price,
			)
		)
	);

	if( $checkBookingTime = checkBookingTime($booking_date, $booking_time, $package_id) ){
		var_dump(createAPI($BookingDetails));die();
		if ( $response = createAPI($BookingDetails) ) {
			if ( !empty($response) ) {
				if( $paymentSettings["type"] == "2" ){
					$response = $settingsWebsite."/?v=BookingComplete&booking_id=".$response["InvoiceId"];
				}elseif( $paymentSettings["type"] == "1" ){
					$response = $response["PaymentURL"];
				}elseif( $paymentSettings["type"] == "0" ){
					$response = $response["PaymentURL"];
				}else{
					$error = direction("Payment gateway connection error, Please try again later.","خطأ في الاتصال ببوابة الدفع، يرجى المحاولة مرة أخرى لاحقًا.");
					$error = urlencode(base64_encode($error));
					$response = $settingsWebsite."/?v=BookingFailed&error={$error}";
				}
				header('LOCATION:'.$response);die();
			} else {
				$error = direction("Payment gateway connection error, Please try again later.","خطأ في الاتصال ببوابة الدفع، يرجى المحاولة مرة أخرى لاحقًا.");
				$error = urlencode(base64_encode($error));
				header("LOCATION: {$settingsWebsite}/?v=BookingFailed&error={$error}");die();
			}
		}else{
			$error = direction("Payment gateway connection error, Please try again later.","خطاء في الاتصال ببوابة الدفع، يرجى المحاولة مرة أخرى لاحقًا.");
			$error = urlencode(base64_encode($error));
			header("LOCATION: {$settingsWebsite}/?v=BookingFailed&error={$error}");die();
		}
	}else{
		$checkBookingTime = "Time already booked, Please select another time.";
		$checkBookingTime = urlencode(base64_encode($checkBookingTime));
	    header("LOCATION: {$settingsWebsite}/?v=Reservations&id={$package_id}&error={$checkBookingTime}");die();
	}
}
?>

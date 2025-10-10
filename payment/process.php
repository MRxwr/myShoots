<?php
require_once('../admin/includes/config.php');
require_once('../admin/includes/functions.php');
require_once('../admin/includes/translate.php');
if( $bookingSettings = selectDB('tbl_settings', "`id` = '1'") ){
	$bookingSettings = $bookingSettings[0];
}else{
	$bookingSettings = array();
}

if(isset($_POST['submit'])){
	$select_extra_item = $_POST['select_extra_item'];
	$comm = "";
	$extra_price = 0;
	$select_extra_item_val = "";
	for( $i = 0; $i < count($select_extra_item); $i++ ){
		$select_extra_item_arr = explode(",",$select_extra_item[$i]);
		$arr = array('item' => $select_extra_item_arr[0],'price' => $select_extra_item_arr[1]); 
		$extra_price = $extra_price + $select_extra_item_arr[1];
		$select_extra_item_val .= $comm.json_encode($arr,JSON_UNESCAPED_UNICODE);
		$comm = ",";
	}
	
	$extra_items = "[{$select_extra_item_val}]"; 
	$package_id = $_POST['id'];
	$booking_date = $_POST['booking_date'];
	$date = explode('-',$booking_date);
	$booking_date = $date[2].'-'.$date[1].'-'.$date[0];
	$booking_time = $_POST['booking_time'];
	$is_filming = ( isset($_POST['is_filming']) ) ? $_POST['is_filming'] : 0 ;
	date_default_timezone_set('Asia/Riyadh');
	$created_at = date('Y-m-d H:i:s');

	if( $is_filming == 1 ){
		$booking_price = $_POST['booking_price'];
		$booking_price = $booking_price + $extra_price;
	}else{
		$booking_price = $_POST['booking_price'];
	}

	if( check_bookingTimeAndDate($booking_date,$booking_time,$package_id) ){
		header("LOCATION: {$settingsWebsite}/?v=Reservations&id={$package_id}");die();
	}	 

	$package = get_packages_details($package_id);
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
		'status' => '',
		'created_at' => $created_at,
		"InvoiceItems" => array(
			array(
				"ItemName" => $package_title.' ['.$booking_date.'] ['.$booking_time.']',
				"Quantity" => 1,
				"UnitPrice" => 30.5,
			)
		)
	);

	if( $checkBookingTime = checkBookingTime($booking_date, $booking_time, $package_id) ){
		if ( $response = createAPI($BookingDetails) ) {
			if ( !empty($response) ) {
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

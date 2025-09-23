<?php
include('../languages/lang_config.php');
include('../admin/config/apply.php');
include('../includes/functions.php');
require_once('../admin2/includes/config.php');
require_once('../admin2/includes/functions.php');
if(isset($_POST['submit'])){
	$select_extra_item = $_POST['select_extra_item'];
	$comm="";
	$extra_price = 0;
	$select_extra_item_val ="";
	for($i = 0; $i<count($select_extra_item); $i++){
		$select_extra_item_arr = explode(",",$select_extra_item[$i]);
		$arr = array('item' => $select_extra_item_arr[0],'price' => $select_extra_item_arr[1]); 
		$extra_price = $extra_price + $select_extra_item_arr[1];
		//$select_extra_item_val .= $comm.json_encode($arr);
		$select_extra_item_val .= $comm.json_encode($arr,JSON_UNESCAPED_UNICODE);
		$comm=",";
	}
	
	$extra_items = "[".$select_extra_item_val."]"; 

         $package_id = $obj->sanitize($conn,$_POST['id']);
			$booking_date = $obj->sanitize($conn,$_POST['booking_date']);
			$date = explode('-',$booking_date);
			$booking_date = $date[2].'-'.$date[1].'-'.$date[0];
			$booking_time = $_POST['booking_time'];
			if(isset($select_extra_item)){ $is_filming = 1; }else{ $is_filming =0; }
			$customer_name = $_POST['customer_name'];
			$customer_email = $_POST['customer_email'];
			$arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
			$english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
			$phone = str_replace($arabic, $english, $_POST['mobile_number']);
			$mobile_number = $phone;
			if(isset($_POST['baby_name'])){ $baby_name = $_POST['baby_name']; }else{ $baby_name =''; }
			if(isset($_POST['baby_age'])){ $baby_age = $_POST['baby_age']; }else{ $baby_age =''; }
			if(isset($_POST['instructions'])){ $instructions = $_POST['instructions']; }else{ $instructions =''; }
			date_default_timezone_set('Asia/Riyadh');
					$created_at = date('Y-m-d H:i:s');
		
			if($is_filming == 1){
				$booking_price = $_POST['booking_price'];
				//$hid_extra_items = $_POST['hid_extra_items'];
				 /*$rows = json_decode($hid_extra_items); 
                        foreach($rows as $row ){*/
                           $booking_price = $booking_price + $extra_price;
                       /* }*/
			} else {
				$booking_price = $_POST['booking_price'];
			 }
		 
		 if(check_bookingTimeAnddate($booking_date,$booking_time,$package_id)){
				 $retuen_url = SITEURL.'?page=reservations&id='.$package_id;
				 header('location:'.$retuen_url);
		  }	 
     

      $package = get_packages_details($package_id);
      $package_title = $package['title_'.$_SESSION['lang']];
      $customer_mobile=$mobile_number;
    
	  $BookingDetails = array(
		'package_id' => $package_id,
		'booking_date' => $booking_date,
		'booking_time' => $booking_time,
		'is_filming' => $is_filming,
		'extra_items' => $extra_items,
		'booking_price' => $booking_price,
		'customer_name' => $customer_name,
		'customer_email' => "hello@myshootskw.net",
		'mobile_number' => $mobile_number,
		'baby_name' => $baby_name,
		'baby_age' => $baby_age,
		'instructions' => $instructions,
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
	if ( $response = createAPI($BookingDetails) ) {
		if ( !empty($response) ) {
			header('LOCATION:'.$response);die();
		} else {
			header("LOCATION: index.php?page=booking-faild&error=gatewayConnection");die();
		}
	}else{
	    header("LOCATION: index.php?page=booking-faild&error=createAPI");die();
	}
}
?>

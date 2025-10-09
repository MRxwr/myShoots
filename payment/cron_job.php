<?php
include('../admin/includes/config.php');
include('../admin/includes/functions.php');
include('../admin/includes/translate.php');

$urlLink = "{$settingsWebsite}";
date_default_timezone_set('Asia/Riyadh');
$NewDate = Date("Y-m-d", strtotime('+3 days'));
$bookings = get_activeBookingData($NewDate);  

foreach( $bookings as $key=>$booking ){
	$bookingDate = $booking['booking_date'];
	$currentDate = strtotime($currentDate); 
    $bookingDate = strtotime($bookingDate);
	$dateDiff = ($bookingDate - $currentDate)/60/60/24; 
	$package = get_packages_details($booking['package_id']);
	$arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
	$english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
	$phone = str_replace($arabic, $english, $booking['mobile_number']);
	$mobile = $phone;
	$message="{$settingsTitle} has confirmed your booking for {$package['enTitle']} package, Date: {$booking['booking_date']}, Time: {$booking['booking_time']}, Booking#{$booking['transaction_id']}, Studio location: {$urlLink}";
	/*sendkwtsms($mobile,$message);*/
}
// get all book data for cornjob	
function get_activeBookingData($currentDate){
	if( $res = selectDB("tbl_booking","`booking_date` = '$currentDate' AND `status` = 'Yes'") ){
		if( count($res) > 0 ){
			return $res;
		}else{
			return array();
		}
	}else{
		return array();
	}
}
?>

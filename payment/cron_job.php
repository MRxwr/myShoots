<?php
include('../languages/lang_config.php');
include('../admin/config/apply.php');
include('../admin2/includes/functions.php');

$urlLink = "https://myshootskw.com/location";
date_default_timezone_set('Asia/Riyadh');
$NewDate = Date("Y-m-d", strtotime('+3 days'));
$bookings = get_activeBookingData($NewDate);  

foreach( $bookings as $key=>$booking ){
	$bookingDate = $booking['booking_date'];
	$currentDate = strtotime($currentDate); 
    $bookingDate = strtotime($bookingDate);
	$dateDiff = ($bookingDate - $currentDate)/60/60/24; 
	$package=get_packages_details($booking['package_id']);
	$arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
	$english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
	$phone = str_replace($arabic, $english, $booking['mobile_number']);
	$mobile = $phone;
	$message='MyShoots booking id '.$booking['transaction_id'] . ', Studio location ' . $urlLink;
	sendkwtsms($mobile,$message);
	
}
// get all book data for cornjob	
function get_activeBookingData($currentDate){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_booking';
	$where = "`booking_date` = '$currentDate' AND status='Yes'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if( $res == true ){
		$count_rows = $obj->num_rows($res);
		if( $count_rows > 0 ){
			$res = $res-> fetch_all(MYSQLI_ASSOC);
			return $res;
		}
	}
}
?>

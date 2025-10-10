<?php 

include_once('../includes/config.php');
include_once('../includes/functions.php');
include_once('../includes/translate.php');

$session_id = session_id();
$time = $_POST['time'];
$date = $_POST['date'];
$temp_booking_date = $obj->sanitize($conn,$date);
$temp_date = explode('-',$temp_booking_date);
$temp_booking_date = $temp_date[2].'-'.$temp_date[1].'-'.$temp_date[0];
$searches = get_tempBookingDateTimeNotSession($temp_booking_date,$time,$session_id);

if( count($searches) == 1 ){
	echo 1;
}else{
	$searchesSession = get_tempBookingDateTimeWithSession($temp_booking_date,$session_id);
	if( count($searchesSession) == 0 ){
		$data= array(
			'session_id' => $session_id,
			'temp_booking_date' => $temp_booking_date,
			'temp_booking_time' => $time
		);
		if( insertDB("tbl_temp_date_time", $data) ){
		}
	}else{
		$data = array(
			'temp_booking_date' => $temp_booking_date,
			'temp_booking_time' => $time
		);
		if( updateDB("tbl_temp_date_time", $data, "`session_id` = '{$session_id}'") ){ 
		}
	}
}
?>
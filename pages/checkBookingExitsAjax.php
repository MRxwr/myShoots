<?php 
include('../languages/lang_config.php');
include('../admin/config/apply.php');
include('../includes/functions.php');
  $session_id = session_id();
  $time = $_POST['time'];
  $date = $_POST['date'];
  $package_id = 0;
  $temp_booking_date = $obj->sanitize($conn,$date);
  $temp_date = explode('-',$temp_booking_date);
  $temp_booking_date = $temp_date[2].'-'.$temp_date[1].'-'.$temp_date[0];
    if(check_bookingTimeAnddate($date,$time,$package_id='')){
        echo 1;
    }else{
        echo 0;
    }
    exit;
?>
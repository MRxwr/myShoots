<?php 
	include('languages/lang_config.php');
	include('admin/config/apply.php');
	require_once('admin2/includes/config.php');
	require_once('admin2/includes/functions.php');
	include('includes/functions.php');
	if( get_setting('is_maintenance') == 1 ){
		header('LOCATION: error');die();
	} 
	if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){
		if( checkCreateAPI() ){
			header("LOCATION : ?page=booking-complete&booking_id=".$_GET['requested_order_id']);die();
		}else{
			header("LOCATION: ?page=booking-faild&error=noCaptured");die();
		}
	}
	include('includes/header.php');
	include('includes/body.php');
	include('includes/footer.php');
?>

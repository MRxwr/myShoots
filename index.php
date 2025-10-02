<?php 
require_once('admin2/includes/config.php');
require_once('admin2/includes/functions.php');
require_once('admin2/includes/translate.php');
require_once('templates/header.php');

if( get_setting('is_maintenance') == 1 ){
	header('LOCATION: error');die();
} 
if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){
	if( checkCreateAPI() ){
		header("LOCATION : ?v=booking-complete&booking_id=".$_GET['requested_order_id']);die();
	}else{
		header("LOCATION: ?v=booking-faild&error=noCaptured");die();
	}
}

if( isset($_GET["v"]) && searchFile("views","{$_GET["v"]}.php") ){
	require_once("views/".searchFile("views","{$_GET["v"]}.php"));
}else{
	require_once("views/home.php");
}

require_once('templates/footer.php');
?>

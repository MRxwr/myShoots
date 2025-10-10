<?php 
require_once('admin/includes/config.php');
require_once('admin/includes/functions.php');
require_once('admin/includes/translate.php');

if( get_setting('is_maintenance') == 1 ){
	header('LOCATION: error');die();
} 

if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){
	if( checkCreateAPI() ){
		header("LOCATION : ?v=BookingComplete&booking_id=".$_GET['requested_order_id']);die();
	}else{
		$error = "Payment Error, Please try again later.";
		header("LOCATION: ?v=BookingFailed&error=".urlencode(base64_encode($error)));die();
	}
}

if( isset($_GET['error']) && !empty($_GET['error']) ){
    $error = $_GET['error'];
    $error = base64_decode(urldecode($error));
    echo "
    <script>
        alert('".$error."');
    </script>
    ";
}
require_once('templates/header.php');
if( isset($_GET["v"]) && searchFile("views","blade{$_GET["v"]}.php") ){
	require_once("views/".searchFile("views","blade{$_GET["v"]}.php"));
}else{
	require_once("views/bladeHome.php");
}

require_once('templates/footer.php');
?>

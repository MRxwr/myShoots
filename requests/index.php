<?php 
require_once("../admin/includes/config.php");
require_once("../admin/includes/functions.php");
require_once("../admin/includes/translate.php");

// get viewed apis from requests folder \\
if( isset($_GET["endpoint"]) && isset($_GET["f"]) && searchFile("{$_GET["f"]}","api{$_GET["endpoint"]}.php") ){
	require_once("{$_GET["f"]}/".searchFile("{$_GET["f"]}","api{$_GET["endpoint"]}.php"));
}else{
	echo outputError(array("msg"=>"Invalid request"));
}

?>
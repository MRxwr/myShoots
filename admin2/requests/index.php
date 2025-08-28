<?php 
require_once("../includes/checksouthead.php");

// get viewed apis from requests folder \\
if( isset($_GET["endpoint"]) && isset($_GET["f"]) && searchFile("{$_GET["f"]}","api{$_GET["endpoint"]}.php") ){
	require_once("requests/{$_GET["f"]}/".searchFile("{$_GET["f"]}","api{$_GET["endpoint"]}.php"));
}else{
	echo outputError(array("msg"=>"Invalid request"));
}

?>
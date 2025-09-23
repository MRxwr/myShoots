<?php 
require_once("../admin2/includes/config.php");
require_once("../admin2/includes/functions.php");

// get viewed page from pages folder \\
if( isset($_GET["endpoint"]) && !empty($_GET["endpoint"]) && searchFile("views","api{$_GET["endpoint"]}.php") ){
	require_once("views/".searchFile("views","api{$_GET["endpoint"]}.php"));
}else{
	echo outputError(array("message"=>"Endpoint not found"));
}

?>
<?php 
if( isset($_GET["page"]) && searchFile("pages","{$_GET["page"]}.php") ){
	require_once("pages/".searchFile("pages","{$_GET["page"]}.php"));
}else{
	require_once("pages/home.php");
}
?>
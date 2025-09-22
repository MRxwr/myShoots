<?php 
	include('languages/lang_config.php');
	require_once('admin2/includes/config.php');
	require_once('admin2/includes/functions.php');
	include('admin/config/apply.php');
	include('includes/functions.php');
	if(get_setting('is_maintenance')==1){
		header('LOCATION: error');
	} 
	include('includes/header.php');
	include('includes/body.php');
	include('includes/footer.php');
?>

<?php
include('../admin/includes/config.php');
include('../admin/includes/functions.php');
include('../admin/includes/translate.php');

function delete_1_tempBookingDateTime(){
	$res = deleteDB("tbl_temp_date_time", "id != '0'");
}
delete_1_tempBookingDateTime();
?>

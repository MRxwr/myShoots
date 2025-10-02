<?php
include('../languages/lang_config.php');
include('../admin/config/apply.php');
include('../admin2/includes/functions.php');

function delete_1_tempBookingDateTime(){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_temp_date_time';
	$where = "id != '0'" ;
	$query = $obj->delete_data($tbl_name, $where);
	$res = $obj->execute_query($conn,$query);
}

delete_1_tempBookingDateTime();
?>

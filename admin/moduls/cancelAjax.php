<?php 
include('../../languages/lang_config.php');
include('../config/apply.php');

if (isset($_POST['type']) && isset($_POST['id']) && !empty($_POST['id'])) {
	$id = $_POST['id'];
	$tbl_name = 'tbl_booking';
	$where = "id='$id'";
	$data="
			status='cancel'
		";
		$query = $obj->select_data($tbl_name,$where);
		$ress = $obj->execute_query($conn,$query);
		$count_rows = $obj->num_rows($ress);
		
	if($count_rows>0){
		$row= mysqli_fetch_array($ress);
		//var_dump($row);
		$queryx = $obj->update_data($tbl_name,$data,$where);
		$res = $obj->execute_query($conn,$queryx);
		if($res == true){
				$dt=explode('-',$row['booking_date']);
				$booking_date = $dt[1].'/'.$dt[2].'/'.$dt[0];
				$tbl_namee = 'tbl_disabled_date';
				$wheree = " disabled_date ='".$booking_date."'";
				$querye = $obj->delete_data($tbl_namee, $wheree);
				$res = $obj->execute_query($conn,$querye);
			}  
		echo 'ok';
		exit;
	  }
	}
		
?>


                        
  
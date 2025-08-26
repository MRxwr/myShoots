<?php 
include('../../languages/lang_config.php');
include('../config/apply.php');

if (isset($_POST['id']) && !empty($_POST['id'])) {
	$id = $_POST['id'];
	$tbl_name = 'tbl_booking';
	$where = "id='$id'";
	$data="
			sms=1
		";
		$query = $obj->select_data($tbl_name,$where);
		$ress = $obj->execute_query($conn,$query);
		$count_rows = $obj->num_rows($ress);
		
	if($count_rows>0){
		$row= mysqli_fetch_array($ress);
		//var_dump($row);
		 $id = $row['id'];
        
         $booking_date = $row['booking_date'];
         $booking_time  = $row['booking_time'];
         $orderId= $row['transaction_id'];
         $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
	     $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
	     $phone = str_replace($arabic, $english, $row['mobile_number']);
	     $mobile = $phone;
	     //$mobile='65680566';
         $message="Your booking has been confirmed for myshoots studio, Date: ".$booking_date.", Time:".$booking_time.",Id: ".$orderId;
         $message = str_replace(' ','+',$message);
		 $url = 'http://www.kwtsms.com/API/send/?username=ghaliah&password=Gh@li@h91&sender=MyShoots&mobile=965'.$mobile.'&lang=1&message='.$message;
		 //$url = 'http://www.kwtsms.com/API/send/?username=badertov&password=471990Bader&sender=MyShoots&mobile=965'.$mobile.'&lang=1&message='.$message;
		       $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_CUSTOMREQUEST => "GET",
                ));
                $response = curl_exec($curl);
                var_dump($response);
                
                $err = curl_error($curl);
				curl_close($curl);
				if ($err){
					echo 'err';
				}else{
				    $queryx = $obj->update_data($tbl_name,$data,$where);
		             $res = $obj->execute_query($conn,$queryx);
					echo 'ok';
				}
		    exit;
	    }
	}
		
?>
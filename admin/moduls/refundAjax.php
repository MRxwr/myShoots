<?php 
include('../../languages/lang_config.php');
include('../config/apply.php');

if (isset($_POST['type']) && isset($_POST['id']) && !empty($_POST['id'])) {
	$id = $_POST['id'];
	$tbl_name = 'tbl_booking';
	$where = "id='$id'";
	$data="
			refunded=1
		";
		$query = $obj->select_data($tbl_name,$where);
		$ress = $obj->execute_query($conn,$query);
		$count_rows = $obj->num_rows($ress);
		
	if($count_rows>0){
		 $row= mysqli_fetch_array($ress);
		 $invoiceid = $row['transaction_id'];
		 $amount ='30.500';
		 //$mobile = $row['mobile_number'];
		 $token = "hE-2B3TuAQ-ea717-mLkkfajc240Eh4PmRFLRugNAw3aQMTfsNaL9_IsHPKEYQ7P7Ov7AyXRk_JRTOEOP9aNt6KbOx5bWU7P60vqFEHyMSqGXMyTyFzR7knj9eJukd-fr2VKK0Ti0Xic2z7dmYeZAQ8gZd_LOmDHy8kMqBaL6Sgom0HRGJxNXy8dIqcyVe2vgJ5fjE40NzrTKktY9E5_3ELgTi5qFgAZTDk76WmblxT36oCZqAs2BxhBVD2-3uQbrEN3FtdQ8sladuRF5CX4znVQ7eSXZ1UyzcDiW2FqyNVbU2JasG9MC2u8Cz5xLKO1dU8PDXaETqeDJ-8DLxQ-1fed7NqJKSPnGOMwSrSRDIzCqRtqeXVVaqgngy0GDM88NRusZmBq73zqao577UfZcGjNGo-hlbPYS_0gYm-fAla0OkZeZjAJCgrDNTu0L1As0P27crSu2LUl6MNZn5iHkd1lUiCnRPwE7Ppky1C_t-l6lCuQcv-hkV9fv-EbcsIdnhBZhzG7_QG9jEZVjpj_FxcSTlv0EraCdI9O4rd0-pYesfbEEAE6YseARJ4iRXXVOYzy_lMLqGfu1kw_bOjJp1VPCMJA78N6uIh9PFdozgfBq6-UkDTCOEnozsRsILfO96buzhRRF0Czkde4NvBzt7jAPoqbEFcOn4mwzkLa_qDPOoVMOsQc12Vgcsb7klV0ktRJBA";
          $basURL = "https://api.myfatoorah.com";
            $allItems = array();
            //print_r($allItems);
            $postMethodLines = array(
            "KeyType" => "invoiceid",
            "Key"=>  "$invoiceid",
            "RefundChargeOnCustomer"=> false, 
            "ServiceChargeOnCustomer"=>false,
            "Amount"=> "$amount",
            "Comment"=> "amount refund",
            );
            
            
            //print_r($postMethodLines);die();
            ####### Execute Payment ######
            $curl = curl_init();
            // curl_setopt_array($curl, array(
            //   CURLOPT_URL => "$basURL/v2/MakeRefund",
            //   CURLOPT_CUSTOMREQUEST => "POST",
            //   CURLOPT_POSTFIELDS => json_encode($postMethodLines),
            //   CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
            // ));
            $appdata=array(
    	      'baseurl'=>$basURL,
    	      'postdata'=>$postMethodLines,
    	      'token'=>$token,
    	      'point'=>'MakeRefund',
    	      );
		   $curl = curl_init();
    		curl_setopt_array($curl, array(
    		CURLOPT_URL => "https://myfatoorah.tryq8flix.com/index.php",
    		CURLOPT_CUSTOMREQUEST => "POST",
    		CURLOPT_POSTFIELDS => json_encode($appdata),
    	
    		));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              $resultMY = json_decode($response, true);
              //print_r($resultMY);die();
              if($resultMY['IsSuccess']){
               	 $queryx = $obj->update_data($tbl_name,$data,$where);
		         $res = $obj->execute_query($conn,$queryx);
		         $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
	     $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
	     $phone = str_replace($arabic, $english, $row['mobile_number']);
	     $mobile = $phone;
	    // $mobile='65680566';
         $message="We are sorry to inform you that your reservation has been canceled, and refund will take place during the next 3 business days.";
         $message = str_replace(' ','+',$message);
		 $url = 'http://www.kwtsms.com/API/send/?username=ghaliah&password=Gh@li@h91&sender=MyShoots&mobile=965'.$mobile.'&lang=1&message='.$message;
		       $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_CUSTOMREQUEST => "GET",
                ));
                $response = curl_exec($curl);
                //var_dump($response);
                
                $err = curl_error($curl);
				curl_close($curl);
		         echo 'ok';
                //header("LOCATION: order-refund.php") ;
              }else{
                //header("LOCATION: product-orders.php") ;
                echo 'Err';
              }
              
            }
		//var_dump($row);
		$queryx = $obj->update_data($tbl_name,$data,$where);
		$res = $obj->execute_query($conn,$queryx);
		exit;
	  }
	}
		
?>


                        
  
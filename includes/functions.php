<?php 
include_once("../admin2/includes/config.php");
include_once("../admin2/includes/functions.php");
  function get_setting($set){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_settings';
	$where = " id=1 ";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
			$data = mysqli_fetch_array($res);
			if(isset($data[$set])){
				if($set=='open_date' || $set=='close_date'){
					$time = strtotime($data[$set]);
						if($set=='close_date'){
					        return $final = date("Y-m-d", strtotime("-1 month", $time));
						}else{
						    return $final = date("Y-m-d", strtotime("-1 month", $time));
						    //return $final = date("Y-m-d", strtotime("-0 month", $time));
						}
				}else{
					return $data[$set];
				}
				
			}else{
				return false;
			}
				
		}
		 
	}
  }
  // get all active banner
  function get_banners(){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_banners';
	$where = "is_active='Yes'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		}  
	}
	}

	 // get all active categories
	 function get_categories(){
		GLOBAL $obj,$conn;
		$tbl_name = 'tbl_categories';
		$where = "is_active='Yes'";
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true)
		{
			$count_rows = $obj->num_rows($res);
			if($count_rows>0){
					return $res;
			}  
		}
	}
	
	  // get  package details by package id
  function get_category_details($id){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_categories';
	$where = " id=".$id;
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
	  $count_rows = $obj->num_rows($res);
	  if($count_rows>0){
		//return $res -> fetch_row();
		return mysqli_fetch_array($res);
			  
	  }
	   
  }
}

  // get all active packages	
  function get_packages($cat=0){
	    GLOBAL $obj,$conn;
		$tbl_name = 'tbl_packages';
		if($cat>0){
			$where = "is_active='Yes' and category='$cat'";
		}else{
			$where = "is_active='Yes'";
		}
		
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true)
		{
			$count_rows = $obj->num_rows($res);
			if($count_rows>0){
					return $res;
			}
			
		}
  }
  
  // get  package details by package id
  function get_packages_details($id){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_packages';
	$where = "is_active='Yes' && id=".$id;
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
	  $count_rows = $obj->num_rows($res);
	  if($count_rows>0){
		//return $res -> fetch_row();
		return mysqli_fetch_array($res);
			  
	  }
	   
  }
}
// get  all galleries image by category id
function get_galleries($catid=0){
    
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_galleries';
	if($catid>0){
	   $where = "is_active='Yes' && category=".$catid; 
	}else{
	    $where = "is_active='Yes'";
	}
	//$where = "is_active='Yes' && category=".$catid;
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		}
		
	}
}

// get  all themes image by package id
function get_themes($pid){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_themes';
	$where = "is_active='Yes' && cat_id=".$pid;
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		}
		
	}
}

// get  all themes image by package id
function get_works($pid){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_works';
	$where = "is_active='Yes' && cat_id=".$pid;
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		}
		
	}
}
// get cms page details by page id
function get_page_details($id){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_pages';
	$where = "is_active='Yes' && id=".$id;
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
	  $count_rows = $obj->num_rows($res);
	  if($count_rows>0){
		//return $res -> fetch_row();
		return mysqli_fetch_array($res);	  
	  }   
  }
}

 // get all active packages	
  function get_bookingSearch($searchquery){
	    GLOBAL $obj,$conn;
		$tbl_name = 'tbl_booking';
		$where = "transaction_id =".$searchquery." OR mobile_number = ".$searchquery;
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true)
		{
			$count_rows = $obj->num_rows($res);
			if($count_rows>0){
					return $res;
			} 
			
		}
  }
  	// get  package details by package id
	  function get_booking_details($bookid){
		GLOBAL $obj,$conn;
		$tbl_name = 'tbl_booking';
		$where = "transaction_id=".$bookid;
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true)
		{
		  $count_rows = $obj->num_rows($res);
		  if($count_rows>0){
			//return $res -> fetch_row();
			return mysqli_fetch_array($res);		  
		  }
		   
	  }
	}
  
  //send booking sms
	function sendkwtsms($mobile,$message){
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
		$err = curl_error($curl);
		curl_close($curl);
		if ($err){
			return $err;
		}else{
				return $response;	
		}
	}
	
	//send booking email
	function sendkwtemail($email,$message){
		$message = $message;
		$email = $email;
        $subject = 'New Booking';
        $EmailTo = "info@myshootkw.net";
		$Body = "";
        // prepare email body text
        $Body .= $subject;
        $Body .= "\n";
        $Body .= $message;
        $Body .= "\n";
        // send email
        $success = mail($EmailTo, $subject, $Body, "From:".$email);
        // redirect to success page
        if ($success){
           echo "success";
        }else{
            echo "invalid";
        }
	}
	// get book time by select date
	function get_bookingTimeBydate($id,$date){
	    GLOBAL $obj,$conn;
		$tbl_name = 'tbl_booking';
		$where = " booking_date like '%".$date."%' AND status='Yes'";
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true)
		{
			$count_rows = $obj->num_rows($res);
			if($count_rows>0){
					return $res;
			} 
			
		}
	}

	function FullBookedDates(){
		GLOBAL $obj,$conn;
		$tbl_name = 'tbl_booking';
		$where = "`booking_time` != '' AND status='Yes'";
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true){
			$count_rows = $obj->num_rows($res);
			if($count_rows>0){
					$resp = $res->fetch_all(MYSQLI_ASSOC);
					$date=array();
					$booked=array();
					$booked2=array();
					foreach($resp as $res){
						if(!in_array($res['booking_date'],$date)){
							$date[]=$res['booking_date'];
							$booked[$res['booking_date']][] = $res['booking_time'] ;
						}else{
							$booked[$res['booking_date']][] = $res['booking_time'] ;
						}
					  	//echo $res['booking_date'];
					}
					foreach($booked as $key=>$dt){
						$tbl_name = 'tbl_timeslots';
                        $where = "is_active='Yes'";
                        $query = $obj->select_data($tbl_name,$where);
                        $res = $obj->execute_query($conn,$query);
						$timestat =0;
                        while ($row=$obj->fetch_data($res)) {
                                $slot = $row['slot']; 
                                if (!in_array($slot, $dt)){
									$timestat =1;
								}
						}
					if($timestat==0){
						$booked2[] = date("d-m-Y", strtotime($key)); 
					}	
			     }
				 return $booked2;
			}
		}
	}

	// get disabled date
	function get_disabledDate(){
			GLOBAL $obj,$conn;
			$tbl_name = 'tbl_disabled_date';
				$query = $obj->select_data($tbl_name);
			$res = $obj->execute_query($conn,$query);
			if($res == true)
			{
				$count_rows = $obj->num_rows($res);
				if($count_rows>0){
						return $res;
				}
				
			}
	  }


	    // get  package details by package id
  function get_coupon_details($code){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_coupons';
	date_default_timezone_set('Asia/Riyadh');
	$currentDate = date("Y-m-d");
	$where = "is_active='Yes' && coupon_validity >= '$currentDate' &&  coupon_code='$code'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
	  $count_rows = $obj->num_rows($res);
	  if($count_rows>0){
		//return $res -> fetch_row();
		return mysqli_fetch_array($res);
			  
	  }
	   
  }
}


	    // get  package details by package id
  function checkCoupon($code,$source){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_booking';
	date_default_timezone_set('Asia/Riyadh');
	$currentDate = date("Y-m-d");
	$where = "(status='Yes' || status='completed' ) &&  coupon_code='$code'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
	  $count_rows = $obj->num_rows($res);
	  if($source=='survey'){
    	  if($count_rows>0){
    		return false;
    	  }else{
    	    return true;
    	  }
	  }else{
	       return true; 
	  }
	   
  }
}


    // get  package details by package id
	function get_referral_details($code){
			GLOBAL $obj,$conn;
			$tbl_name = 'tbl_referrals';
			date_default_timezone_set('Asia/Riyadh');
			$currentDate = date("Y-m-d");
			$where = "is_active='Yes' &&  referral_code='$code'";
			$query = $obj->select_data($tbl_name,$where);
			$res = $obj->execute_query($conn,$query);
			if($res == true)
			{
			  $count_rows = $obj->num_rows($res);
			  if($count_rows>0){
				return mysqli_fetch_array($res);
			  }
			   
		  }
		}
		

     function check_bookingTimeAnddate($date,$time,$package_id){
	    GLOBAL $obj,$conn;
		$tbl_name = 'tbl_booking';
		
		///$where = " booking_date like '%".$date."%' AND booking_time like '%".$time."%'  AND package_id=".$package_id." AND status='Yes'";
		$where = " booking_date like '%".$date."%' AND booking_time like '%".$time."%'  AND status='Yes'";
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		//var_dump($res);
		if($res == true)
		{       
			 $count_rows = $obj->num_rows($res);
			if($count_rows>0){
					return true;
			}else{
			   $tbl_name = 'tbl_booking';
			    $where = " booking_date like '%".$date."%' AND booking_time like '%".$time."%' AND  status='No' AND created_at > now() - interval 30 MINUTE";
            		$query2nd = $obj->select_data($tbl_name,$where);
            		$ress = $obj->execute_query($conn,$query2nd);
            		if($ress == true)
            		{       
            		  $count_rowss = $obj->num_rows($ress);
            			if($count_rowss>0){
            			    return true;
            			}else{
            			    return false;
            			}
            		}
			} 
			
		}else{
		    $where2 = " booking_date like '%".$date."%' AND booking_time like '%".$time."%'   AND status='No' AND created_at > now() - interval 30 MINUTE";
            		$query2 = $obj->select_data($tbl_name,$where2);
            		$res2 = $obj->execute_query($conn,$query2);
            		if($res2 == true)
            		{       
            		  $count_rows = $obj->num_rows($res);
            			if($count_rows>0){
            			    return true;
            			}
            		}else{
            		   return false; 
            		}
		}
	}

  // get temp booking date time	
  function get_tempBookingDateTimeNotSession($date,$time,$session_id){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_temp_date_time';
	$where = " session_id != '".$session_id."' AND temp_booking_date ='".$date."' AND temp_booking_time = '".$time."'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		} 
		
	}
}
	   // get temp booking date time	
  function get_tempBookingDateTimeWithSession($date,$session_id){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_temp_date_time';
	$where = " session_id = '".$session_id."' AND temp_booking_date ='".$date."' ";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		} 
		
	}
}

	   // get temp booking data	
  function get_tempBookingDateTime(){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_temp_date_time';
	$where = "";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		} 
		
	}
}

	   // get  booking date time	
  function get_bookingByDateTime($temp_booking_date,$temp_booking_time){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_booking';
	$where = " booking_date ='".$temp_booking_date."' AND booking_time = '".$temp_booking_time."' AND status = 'Yes'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		} 
		
	}
}
// delete temp booking data	
  function delete_tempBookingDateTime($id){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_temp_date_time';
	$where = " id ='".$id."'";
	$query = $obj->delete_data($tbl_name, $where);
	$res = $obj->execute_query($conn,$query);

}
// delete temp booking data	
  function delete_tempBookingDateTimeBySession($session_id){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_temp_date_time';
	$where = " session_id ='".$session_id."'";
	$query = $obj->delete_data($tbl_name, $where);
	$res = $obj->execute_query($conn,$query);

}

function getDisableTime($date){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_disabled_datetime';
	$where = " disabled_date ='".$date."'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
			$row = $obj->fetch_data($res);
				return $row['disable_times'];
		} 
		
	}
}

function checkRamadanDate($date){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_settings';
	$where = " id=1 ";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
			$data = mysqli_fetch_array($res);
			$date=date('Y-m-d', strtotime($date));
			$open_date = $data['ramadan_open_date'];
			$open_date=date('Y-m-d', strtotime($open_date));
			$close_date = $data['ramadan_close_date'];
			$close_date=date('Y-m-d', strtotime($close_date));
			if(($date>=$open_date) && ($date <=$close_date)){
				return true;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
				
	}else{
		return false;
	}
}

// Function to get all the dates in given range 
function getDatesFromRange($start, $end, $format = 'd-m-Y') { 
      
  // Declare an empty array 
  $array = array(); 
    
  // Variable that store the date interval 
  // of period 1 day 
  $interval = new DateInterval('P1D'); 

  $realEnd = new DateTime($end); 
  $realEnd->add($interval); 

  $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 

  // Use loop to store date into array 
  foreach($period as $date) {                  
      $array[] = $date->format($format);  
  } 

  // Return the array elements 
  return $array; 
} 
// get  all themes image by package id
function get_ads(){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_ads';
	$where = "is_active='Yes' ";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if($res == true)
	{
		$count_rows = $obj->num_rows($res);
		if($count_rows>0){
				return $res;
		}
		
	}
}
// Compress image
function compressImage($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
	 // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Save image 
    imagejpeg($image, $destination, $quality); 
     
    // Return compressed image 
    return $destination; 
} 

	// get  package details by package id
	function get_booking($bookid){
		GLOBAL $obj,$conn;
		$tbl_name = 'tbl_booking';
		$where = "id=".$bookid;
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true)
		{
		  $count_rows = $obj->num_rows($res);
		  if($count_rows>0){
			//return $res -> fetch_row();
			return mysqli_fetch_array($res);		  
		  }
		   
	  }
	}

	// get  package details by package id
	function get_survey_questions(){
		GLOBAL $obj,$conn;
		$language = $_SESSION['lang'];
		$tbl_name = 'tbl_survey';
		$where = "is_active='Yes' AND language='".$language."'";
		$query = $obj->select_data($tbl_name,$where);
		$res = $obj->execute_query($conn,$query);
		if($res == true)
		{
		  $count_rows = $obj->num_rows($res);
		  if($count_rows>0){
			return $res;
			//return mysqli_fetch_array($res);		  
		  }
		   
	  }
	}

	// createapi payment
	function createAPI($BookingDetails){
		GLOBAL $obj,$conn;
		// build request body for payapi \\
		$postMethodLines = array(
			"endpoint" 				=> "PaymentRequestExcuteNew2024",
			"apikey" 				=> "CKW-1758573468-6280",
			"PaymentMethodId" 		=> "1",
			"CustomerName"			=> $BookingDetails['customer_name'],
			"DisplayCurrencyIso"	=> "KWD", 
			"MobileCountryCode"		=> "+965", 
			"CustomerMobile"		=> substr($BookingDetails['mobile_number'],0,11),
			"CustomerEmail"			=> $BookingDetails['customer_email'],
			"invoiceValue"			=> (float)$BookingDetails['booking_price'],
			"SourceInfo"			=> '',
			"CallBackUrl"			=> "https://myshootskw.net/index.php?page=booking-complete",
			"ErrorUrl"				=> "https://myshootskw.net/index.php?page=booking-faild",
			"invoiceItems" 			=> $BookingDetails['InvoiceItems'],
		);
		 //echo json_encode($postMethodLines);die();
		for( $i=0; $i < 10; $i++ ){
			$curl = curl_init();
			$headers  = [
						'Content-Type:application/json'
					];
			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://createapi.link/api/v3/index.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_POST => 1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($postMethodLines),
			CURLOPT_HTTPHEADER => $headers,
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$resultMY = json_decode($response, true);
			//echo json_encode($resultMY);die();
			if( isset($resultMY["data"]["InvoiceId"]) ){
				unset($BookingDetails['InvoiceItems']);
				unset($BookingDetails['customer_email']);
				$BookingDetails["transaction_id"] = $resultMY["data"]["InvoiceId"];
				$BookingDetails["payload"] = json_encode($postMethodLines);
				$BookingDetails["payloadResponse"] = json_encode($resultMY);
				$BookingDetails["gatewayLink"] = $resultMY["data"]["PaymentURL"];
				if( insertDB("tbl_booking", $BookingDetails) ){
					return $resultMY["data"]["PaymentURL"];
				}else{
					return 0;
				}
			}elseif( !isset($resultMY["data"]["InvoiceId"]) ){
			    return 0;
		    }
		}
	}

	// check createAPI payment
	function checkCreateAPI(){
		GLOBAL $_GET,$obj,$conn;
		if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) ){
			updateDB("tbl_booking", array("gatewayResponse" => json_encode($_GET)), "transaction_id = ".$_GET["requested_order_id"]);
			if( $_GET["result"] != "CAPTURED" ){
				return 0;
			}
			return $_GET["requested_order_id"];
		}else{
			return 0;
		}
	}
?>


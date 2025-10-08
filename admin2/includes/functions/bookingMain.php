<?php 
function get_setting($set){
	if( $data = selectDB("tbl_calendar_settings","`id` = '1'")[0] ){
		if( isset($data[$set]) ){
			if( $set == 'openDate' || $set == 'closeDate' ){
				$time = strtotime(substr($data[$set], 0, 10));
				if( $set == 'closeDate' ){
					return date("Y-m-d", strtotime("-1 month", $time));
				}else{
					return date("Y-m-d", strtotime("-1 month", strtotime(date("Y-m-d"))));
				}
			}elseif( $set == 'weekend' ){
				return $data[$set];
			}else{
				return $data[$set];
			}
		}else{
			return false;
		}	
	}else{
		return false;
	}
}
// get all active banner
function get_banners(){
	GLOBAL $obj,$conn;
	$tbl_name = 'tbl_banners';
	$where = "is_active='Yes'";
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	if( $res == true ){
		$count_rows = $obj->num_rows($res);
		if( $count_rows > 0 ){
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
if( $res = selectDBNew("tbl_packages",[$id],"`status` = '0' AND `hidden` = '1' AND `id` = ?","") ){
	if( count($res) > 0 ){
		return $res[0];
		}
	}
}
// get  all galleries image by category id
function get_galleries($cat=''){
	if( $res = selectDB("tbl_galleries","`status` = '0'") ){
		if( count($res) > 0 ){
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
	if($res = selectDBNew("tbl_pages",[$id],"`is_active` = 'Yes' AND `id` = ?","") ){
		if( count($res) > 0 ){
			return $res[0];
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
	if($res = selectDBNew("tbl_booking",[$bookid],"`transaction_id` = ?","") ){
		if( count($res) > 0 ){
			return $res[0];
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
	if( $res = selectDBNew("tbl_booking",[$date],"`booking_date` LIKE CONCAT('%',?,'%') AND `booking_date` NOT LIKE '%0000-00-00%' AND ( `status`= 'Yes' OR ( `status`= '' AND TIMESTAMPDIFF(MINUTE, `created_at`, CONVERT_TZ(NOW(), '+00:00', '+03:00')) < 10 ) )","")){
		if( count($res) > 0){
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
	GLOBAL $_GET;
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$id = intval($_GET['id']);
	}else{
		return array();
	}
	$openDate = get_setting('openDate');
	$closeDate = get_setting('closeDate');
	// Fetch all disabled date periods that overlap with the open/close window
	$res = selectDB(
		"tbl_disabled_date",
		"`packages` LIKE '%{$id}%' AND ((STR_TO_DATE(startBlock, '%Y-%m-%d') <= '{$openDate}' AND STR_TO_DATE(endBlock, '%Y-%m-%d') >= '{$closeDate}') OR (STR_TO_DATE(startBlock, '%Y-%m-%d') BETWEEN '{$openDate}' AND '{$closeDate}') OR (STR_TO_DATE(endBlock, '%Y-%m-%d') BETWEEN '{$openDate}' AND '{$closeDate}')) ORDER BY STR_TO_DATE(startBlock, '%Y-%m-%d') ASC",
	);
	$blockedDates = array();
	if ($res && count($res) > 0) {
		foreach ($res as $row) {
			$start = isset($row['startBlock']) ? substr($row['startBlock'], 0, 10) : null;
			$end = isset($row['endBlock']) ? substr($row['endBlock'], 0, 10) : null;
			if ($start && $end) {
				// Normalize to Y-m-d
				$startDate = date('Y-m-d', strtotime($start));
				$endDate = date('Y-m-d', strtotime($end));
				$dates = getDatesFromRange($startDate, $endDate, 'Y-m-d');
				$blockedDates = array_merge($blockedDates, $dates);
			} elseif ($start) {
				$blockedDates[] = date('Y-m-d', strtotime($start));
			}
		}
		// Remove duplicates
		$blockedDates = array_unique($blockedDates);
		sort($blockedDates);
		return $blockedDates;
	}
	return array();
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
	if($res = selectDBNew("tbl_booking",[$date,$time],"`booking_date` LIKE ? AND `booking_time` LIKE ? AND `status` = 'Yes'","")){       
		if( count($res) > 0 ){
				return true;
		}else{
			if($ress = selectDBNew("tbl_booking",[$date,$time],"`booking_date` LIKE ? AND `booking_time` LIKE ? AND `status` = 'No' AND TIMESTAMPDIFF(MINUTE, `created_at`, CONVERT_TZ(NOW(), '+00:00', '+03:00')) < 30","")){       
				if( count($ress) > 0 ){
					return true;
				}else{
					return false;
				}
			}
		} 
	}else{
		if( $res2 = selectDBNew("tbl_booking",[$date,$time],"`booking_date` LIKE ? AND `booking_time` LIKE ? AND `status` = 'No' AND TIMESTAMPDIFF(MINUTE, `created_at`, CONVERT_TZ(NOW(), '+00:00', '+03:00')) < 30","")){
			if( count($res2) > 0 ){
				return true;
			}else{
				return false; 
			}
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
	if($res == true){
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
	$array = array(); 
	$interval = new DateInterval('P1D'); 
	$realEnd = new DateTime($end); 
	$realEnd->add($interval); 
	$period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
	foreach($period as $date) {                  
		$array[] = $date->format($format);  
	} 
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
?>


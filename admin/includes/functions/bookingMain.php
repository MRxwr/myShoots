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

// get  package details by package id
function get_packages_details($id){
	if( $res = selectDBNew("tbl_packages",[$id],"`id` = ?","") ){
		if( count($res) > 0 ){
			return $res[0];
		}else{
			return array();
		}
	}else{
		return array();
	}
}

// get  all galleries image by category id
function get_galleries($cat=''){
	if( $res = selectDB("tbl_galleries","`status` = '0'") ){
		if( count($res) > 0 ){
			return $res;
		}else{
			return array();
		}
	}else{
		return array();
	}
}

// get cms page details by page id
function get_page_details($id){
	if($res = selectDBNew("tbl_pages",[$id],"`is_active` = 'Yes' AND `id` = ?","") ){
		if( count($res) > 0 ){
			return $res[0];
		}else{
			return array();
		}
	}else{
		return array();
	}
}

// get  package details by package id
function get_booking_details($bookid){
	if($res = selectDBNew("tbl_booking",[$bookid],"`transaction_id` = ?","") ){
		if( count($res) > 0 ){
			return $res[0];
		}else{
			return array();
		}
	}else{
		return array();
	}
}

// get book time by select date
function get_bookingTimeBydate($id,$date){
	if( $res = selectDBNew("tbl_booking",[$date],"`booking_date` LIKE CONCAT('%',?,'%') AND `booking_date` NOT LIKE '%0000-00-00%' AND ( `status`= 'Yes' OR ( `status`= '' AND TIMESTAMPDIFF(MINUTE, `created_at`, CONVERT_TZ(NOW(), '+00:00', '+03:00')) < 10 ) )","")){
		if( count($res) > 0){
			return $res;
		}else{
			return array();
		}
	}else{
		return array();
	}
}

// get all blocked time slots
function getBlockedTimeSlots($date){
	GLOBAL $_GET;
	if ( $res = selectDB("tbl_disabled_date"," STR_TO_DATE(startBlock, '%Y-%m-%d') <= '{$date}' AND STR_TO_DATE(endBlock, '%Y-%m-%d') >= '{$date}' AND `packages` LIKE '%{$_GET['id']}%' AND status = '0' AND hidden = '1' ") ){
		if( count($res) > 0 ){
			$blockedSlots = array();
			foreach($res as $row) {
				$timeSlots = json_decode($row['timeSlots'],true);
				if( is_array($timeSlots) && count($timeSlots) > 0 ){
					foreach( $timeSlots as $t ){
						if( !in_array($t, $blockedSlots) ){
							if( $time = selectDB("tbl_times","`id` = '{$t}' AND `hidden` = '1' AND `status` = '0'") ){
								$blockedSlots[] = "{$time[0]['startTime']} - {$time[0]['closeTime']}";
							}
						}
					}
				}
			}
			return $blockedSlots;
		}else{
			return array();
		}
	}else{
		return array();
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
	$timeIds = array();
	$openDate = get_setting('openDate');
	$closeDate = get_setting('closeDate');
	$closeAfter = get_setting('closeAfter');
	if( $packageDetails = selectDBNew("tbl_packages",[$id],"`hidden` = '1' AND `status` = '0' AND `id` = ?","") ){
		$times = json_decode($packageDetails[0]["time"],true);
		foreach($times as $t){
			if( $time = selectDB("tbl_times","`startTime` = '{$t["startDate"]}' AND `closeTime` = '{$t["endDate"]}'") ){
				$timeIds[] = " `timeSlots` LIKE '%{$time[0]["id"]}%' ";
				$timeConditions[] = " `booking_time` LIKE '%{$t["startDate"]} - {$t["endDate"]}%' ";
			}
		}
		$whereTime = implode(" AND ",$timeIds);
		if( empty($whereTime) ){
			return array();
		}
		$whereTime2 = implode(" OR ",$timeConditions);
		var_dump($whereTime2);die();
		if( empty($whereTime2) ){
			return array();
		}
	}else{
		return array();
	}
	// Fetch all disabled date periods that overlap with the open/close window
	$res = selectDB(
		"tbl_disabled_date",
		"`packages` LIKE '%{$id}%' AND {$whereTime} AND ((STR_TO_DATE(startBlock, '%Y-%m-%d') <= '{$openDate}' AND STR_TO_DATE(endBlock, '%Y-%m-%d') >= '{$closeDate}') OR (STR_TO_DATE(startBlock, '%Y-%m-%d') BETWEEN '{$openDate}' AND '{$closeDate}') OR (STR_TO_DATE(endBlock, '%Y-%m-%d') BETWEEN '{$openDate}' AND '{$closeDate}')) ORDER BY STR_TO_DATE(startBlock, '%Y-%m-%d') ASC",
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
	}
	if( $result = selectDB("tbl_booking","`booking_date` BETWEEN '{$openDate}' AND '{$closeDate}' AND ({$whereTime2}) AND `package_id` = '{$id}' AND `status` = 'Yes'") ){
		$numberOfTimeSlots = count($times);
		$bookedDates = array();
		if( count($result) > 0 ){
			foreach($result as $r){
				if( isset($bookedDates[$r['booking_date']]) ){
					$bookedDates[$r['booking_date']] += 1;
				}else{
					$bookedDates[$r['booking_date']] = 1;
				}
			}
			$booked2 = array();
			foreach($bookedDates as $date => $count){
				if( $count >= $numberOfTimeSlots ){
					$booked2[] = date("Y-m-d", strtotime($date));
				}
			}
			// Merge blocked dates and fully booked dates
			$finalDates = array_merge($blockedDates,$booked2);
			// Remove duplicates
			$finalDates = array_unique($finalDates);
			// Sort the dates
			sort($finalDates);
			$blockedDates = $finalDates;
		}
	}
	if( $closeAfter > 0 ){
		$futureDatesBlocked = array();
		for( $i=0; $i<=$closeAfter; $i++ ){
			$futureDate = date('Y-m-d', strtotime("+{$i} days"));
			$futureDatesBlocked[] = $futureDate;
		}
		// merge blocked dates and fully booked dates
		$blockedDates = array_merge($blockedDates,$futureDatesBlocked);
		// remove duplicates
		$blockedDates = array_unique($blockedDates);
		// sort the dates
		sort($blockedDates);
	}
	return $blockedDates;
}

// check booking date and time
function check_bookingTimeAndDate($date,$time,$package_id){
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
			}else{
				return false;
			}
		} 
	}else{
		if( $res2 = selectDBNew("tbl_booking",[$date,$time],"`booking_date` LIKE ? AND `booking_time` LIKE ? AND `status` = 'No' AND TIMESTAMPDIFF(MINUTE, `created_at`, CONVERT_TZ(NOW(), '+00:00', '+03:00')) < 30","")){
			if( count($res2) > 0 ){
				return true;
			}else{
				return false; 
			}
		}else{
			return false;
		}
	}
}

// get temp booking date time	
function get_tempBookingDateTimeNotSession($date,$time,$session_id){
	if($res = selectDB("tbl_temp_date_time"," `session_id` != '{$session_id}' AND `temp_booking_date` ='{$date}' AND `temp_booking_time` = '{$time}' ")){
		if(count($res) > 0){
			return $res;
		}else{
			return array();
		}
	}else{
		return array();
	}
}

// get temp booking date time	
function get_tempBookingDateTimeWithSession($date,$session_id){
	if($res = selectDB("tbl_temp_date_time"," `session_id` = '{$session_id}' AND `temp_booking_date` ='{$date}' ")){
		if(count($res) > 0){
			return $res;
		}else{
			return array();
		}
	}else{
		return array();
	}
}
// delete temp booking data	
function delete_tempBookingDateTimeBySession($session_id){
	if ( deleteDB("tbl_temp_date_time","`session_id` = '{$session_id}'") ){
		return true;
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
?>


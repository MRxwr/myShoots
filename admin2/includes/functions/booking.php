<?php
function checkBookingTime($date, $time, $package_id) {
    if( isset($date) && !empty($date) && isset($package_id) && !empty($package_id) ){
        $settings = selectDB("tbl_settings","`id`='1'");
        $openDate = $settings[0]["open_date"];
        $closeDate = $settings[0]["close_date"];
        $userDate = $date;
        $packageId = intval($package_id);
        $selectedDate = date('Y-m-d', strtotime(str_replace('/', '-', $userDate)));
        if( ($selectedDate >= $openDate) && ($selectedDate <= $closeDate) ){
            // Get available times from packages table
            $package = selectDB("tbl_packages", "`id`='{$packageId}'");
            if(!$package || !isset($package[0]["time"])){
                return false;
            }
            $availableTimes = json_decode($package[0]["time"], true);
            if(!is_array($availableTimes) || count($availableTimes) == 0){
                return false;
            }
            $where = "`booking_date`='{$selectedDate}' AND `booking_date` NOT LIKE '%0000-00-00%' AND `booking_time`='{$time}' AND ( `status`='Yes' OR ( `status`='' AND TIMESTAMPDIFF(MINUTE, `created_at`, CONVERT_TZ(NOW(), '+00:00', '+03:00')) < 10 ) )";
            if( selectDB("tbl_booking", $where) ){          
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}

?>
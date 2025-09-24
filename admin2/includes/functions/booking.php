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
                echo outputError(array("message"=>"Package not found or no times available."));die();
            }
            $availableTimes = json_decode($package[0]["time"], true);
            if(!is_array($availableTimes) || count($availableTimes) == 0){
                return outputError(array("message"=>"No available times for this package."));die();
            }
            if( selectDB("tbl_booking", "`booking_date`='{$selectedDate}' AND `booking_date` NOT LIKE '%0000-00-00%' AND `status`='Yes' AND `booking_time`='{$time}'") ){
                return true;
            }else{
                return outputData(array("message"=>"Time slot available."));die();
            }
        }else{
            return outputError(array("message"=>"Invalid date, Please select date within the allowed period."));die();
        }
    }else{
        return outputError(array("message"=>"Please provide a date and package_id."));die();
    }
}

?>
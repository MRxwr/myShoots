<?php

if( isset($_REQUEST["date"]) && !empty($_REQUEST["date"]) && isset($_REQUEST["package_id"]) && !empty($_REQUEST["package_id"]) ){
    $settings = selectDB("tbl_calendar_settings","`id`='1'");
    $openDate = substr($settings[0]["openDate"], 0, 10);
    $closeDate = substr($settings[0]["closeDate"], 0, 10);
    $userDate = $_REQUEST["date"];
    $packageId = intval($_REQUEST["package_id"]);
    $selectedDate = date('Y-m-d', strtotime(str_replace('/', '-', $userDate)));
    if( ($selectedDate >= $openDate) && ($selectedDate <= $closeDate) ){
        // Get available times from packages table
        $package = selectDB("tbl_packages", "`id`='{$packageId}'");
        if(!$package || !isset($package[0]["time"])){
            echo outputError(array("message"=>"Package not found or no times available."));
            exit;
        }
        $availableTimes = json_decode($package[0]["time"], true);
        if(!is_array($availableTimes) || count($availableTimes) == 0){
            echo outputError(array("message"=>"No available times for this package."));
            exit;
        }
        if( $bookingTable = selectDB("tbl_booking", "`booking_date`='{$selectedDate}' AND `status`='Yes'") ){
            $bookedTimes = array_map(function($booking) {
                return $booking['booking_time'];
            }, $bookingTable);
            $freeTimes = array_filter($availableTimes, function($slot) use ($bookedTimes) {
                $slotLabel = $slot['startDate'] . ' - ' . $slot['endDate'];
                return !in_array($slotLabel, $bookedTimes);
            });
            if(count($freeTimes) > 0){
                echo outputData(array("message"=>"Available times for this date..." . json_encode($freeTimes) . " ", "available_times"=>array_values($freeTimes)));
            }else{
                echo outputError(array("message"=>"No available times for this date."));
            }
        }else{
            echo outputData(array("message"=>"Available times for this date. " . json_encode($availableTimes) . " ", "available_times"=>array_values($availableTimes)));
        }
    }else{
        echo outputError(array("message"=>"Invalid date, Please select date within the allowed period."));
    }
}else{
    echo outputError(array("message"=>"Please provide a date and package."));
}
?>
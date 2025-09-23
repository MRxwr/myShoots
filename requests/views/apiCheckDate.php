<?php
if( isset($_REQUEST["date"]) && !empty($_REQUEST["date"]) ){
    $settings = selectDB("settings","`id`='1'");
    $openDate = $settings[0]["open_date"];
    $closeDate = $settings[0]["close_date"];
    $userDate = $_REQUEST["date"];
    $selectedDate = date('Y-m-d', strtotime(str_replace('/', '-', $userDate)));
    // Convert all dates to timestamps
    $selectedTimestamp = strtotime($selectedDate);
    $openTimestamp = strtotime($openDate);
    $closeTimestamp = strtotime($closeDate);
    if( ($selectedTimestamp >= $openTimestamp) && ($selectedTimestamp <= $closeTimestamp) ){
        echo outputData(array("message"=>"Valid date"));
    }else{
        echo outputError(array("message"=>"{$selectedDate} Invalid date, Please select date within the allowed period."));
    }
}else{
    echo outputError(array("message"=>"Please provide a date."));
}
?>
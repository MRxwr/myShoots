<?php
if( isset($_REQUEST["date"]) && !empty($_REQUEST["date"]) ){
    $settings = selectDB("tbl_settings","`id`='1'");
    $openDate = $settings[0]["open_date"];
    $closeDate = $settings[0]["close_date"];
    $userDate = $_REQUEST["date"];
    $selectedDate = date('Y-m-d', strtotime(str_replace('/', '-', $userDate)));
    if( ($selectedDate >= $openDate) && ($selectedDate <= $closeDate) ){
        echo outputData(array("message"=>"Valid date"));
    }else{
        echo outputError(array("message"=>"Invalid date, Please select date within the allowed period."));
    }
}else{
    echo outputError(array("message"=>"Please provide a date."));
}
?>
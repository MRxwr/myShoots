<?php
if( isset($_REQUEST["date"]) && !empty($_REQUEST["date"]) ){
    $settings = selectDB("settings","`id`='1'");
    $openDate = $settings[0]["open_date"];
    $closeDate = $settings[0]["close_date"];
    $selectedDate = $_REQUEST["date"];
    if( ($selectedDate >= $openDate) && ($selectedDate <= $closeDate) ){
        echo outputData(array("message"=>"Valid date"));
    }else{
        echo outputError(array("message"=>"{$selectedDate} Invalid date, Please select date whithin the allowed period."));
    }
}else{
    echo outputError(array("message"=>"Please provide a date."));
}
?>
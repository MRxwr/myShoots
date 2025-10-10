<?php
require_once("../admin2/includes/config.php");
require_once("../admin2/includes/functions.php");
require_once("../admin2/includes/translate.php");

if( $bookingSettings = selectDB('tbl_calendar_settings', "`id` = '1'") ){
    $bookingSettings = $bookingSettings[0];
}else{
    $bookingSettings = array();
}

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$subject = $_POST["subject"];
$message = $_POST["message"];
 
$EmailTo = ( isset($bookingSettings['email']) && !empty($bookingSettings['email']) ) ? $bookingSettings['email'] : 'nasserhatab@gmail.com';
 
// prepare email body text
$Body .= "Subject: ";
$Body .= $subject;
$Body .= "\n";

$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
 
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";

$Body .= "Phone: ";
$Body .= $phone;
$Body .= "\n";
 
$Body .= "Message: ";
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
 
?>
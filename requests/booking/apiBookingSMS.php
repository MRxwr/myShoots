<?php
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

// Select all needed columns
if ($booking = selectDBNew("tbl_booking", [$id] , "id = ?","")) {
    GLOBAL $settingsTitle;
    $settings = selectDB("tbl_calendar_settings", "`id` = '1'")[0];
    $smsSettings = json_decode($settings['smsNoti'], true);
    // Here you would integrate with your SMS API
    $booking_date = $booking[0]['booking_date'];
    $booking_time = $booking[0]['booking_time'];
    $orderId = $booking[0]['transaction_id'];
    $bookingPersonalInfo = json_decode($booking[0]['personal_info'], true);
    $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
    $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
    $phone = str_replace($arabic, $english, $bookingPersonalInfo[1]);
    $mobile = $phone;
    $message = "Your booking has been confirmed with {$settingsTitle}, Date: ".$booking_date.", Time:".$booking_time.", Booking#: ".$orderId;
    $message = str_replace(' ','+',$message);
    $url = "http://www.kwtsms.com/API/send/?username={$smsSettings["username"]}&password={$smsSettings["password"]}&sender={$smsSettings["sender"]}&mobile=965{$mobile}&lang=1&message={$message}";
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
        echo json_encode(['success' => false, 'message' => 'SMS sending failed - ' . $err]);
    }else{
        if (strpos($response, 'ERR') !== false) {
            echo json_encode(['success' => false, 'message' => 'Could not send SMS - ' . $response]);
        } else {
            if( updateDB("tbl_booking", ["sms" => 1], "id = $id") ) {
                echo json_encode(['success' => true, 'message' => 'SMS sent successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'SMS sent but failed to update status']);
            }
            
        }
    }
}else{
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
}
mysqli_close($dbconnect);
?>

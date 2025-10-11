<?php
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$messageType = isset($_POST['message_type']) ? $_POST['message_type'] : 'booking'; // 'booking' or 'payment'

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

// Select all needed columns
if ($booking = selectDBNew("tbl_booking", [$id] , "id = ?","")) {
    GLOBAL $settingsTitle, $settingsWebsite;
    $settings = selectDB("tbl_calendar_settings", "`id` = '1'")[0];
    $smsSettings = json_decode($settings['smsNoti'], true);
    if( empty($smsSettings) || $smsSettings["status"] != 1 ){
        echo json_encode(['success' => false, 'message' => 'SMS notifications are disabled in settings.']); exit();
    }else{
        // Get booking details
        $booking_date = $booking[0]['booking_date'];
        $booking_time = $booking[0]['booking_time'];
        $orderId = $booking[0]['transaction_id'];
        $bookingId = $booking[0]['id'];
        $paymentData = json_decode($booking[0]['payment'], true);
        $bookingPrice = $paymentData['booking_price'];
        $bookingPersonalInfo = json_decode($booking[0]['personal_info'], true);
        $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
        $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
        $phone = str_replace($arabic, $english, $bookingPersonalInfo[1]);
        $mobile = $phone;
        
        // Prepare message based on type
        if ($messageType === 'payment') {
            // Complete payment message - use transaction_id (orderId) in the URL
            $paymentLink = $settingsWebsite . "/?v=CompletePayment&booking_id=" . $orderId;
            $message = "Complete your payment for booking #{$orderId}. Amount: {$bookingPrice} KD. Click: {$paymentLink}";
        } else {
            // Default booking confirmation message
            $message = "Your booking has been confirmed with {$settingsTitle}, Date: ".$booking_date.", Time:".$booking_time.", Booking#: ".$orderId;
        }
        
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
            echo json_encode(['success' => false, 'message' => 'SMS sending failed - ' . $err]); exit();
        }else{
            if (strpos($response, 'ERR') !== false) {
                echo json_encode(['success' => false, 'message' => 'Could not send SMS - ' . $response]); exit();
            } else {
                if( updateDB("tbl_booking", ["sms" => 1], "id = $id") ) {
                    echo json_encode(['success' => true, 'message' => 'SMS sent successfully']); exit();
                }else{
                    echo json_encode(['success' => false, 'message' => 'SMS sent but failed to update status']); exit();
                }
                
            }
        }
    }
}else{
    echo json_encode(['success' => false, 'message' => 'Booking not found']);exit();
}

?>

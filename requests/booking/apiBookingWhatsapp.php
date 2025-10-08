<?php
function bookingWhatsappUltraMsg($order){
	GLOBAL $settingsTitle, $settingsLogo, $settingsWebsite;
	if( $settings = selectDB("tbl_calendar_settings","`id` = '1'") ){
		$whatsappNoti1 = json_decode($settings[0]["whatsappNoti"],true);
		if( $whatsappNoti1["status"] != 1 ){
            echo json_encode(['success' => false, 'message' => 'WhatsApp notifications are disabled.']);
            exit();
		}elseif( $booking = selectDB("tbl_booking","`id` = '{$order}'") ){
            $booking = $booking[0];
            $bookingPersonalInfo = json_decode($booking['personal_info'], true);
            $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
            $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
            $phone = str_replace($arabic, $english, $bookingPersonalInfo[1]);
            if ( substr($phone, 0, 1) === '0' ) {
                $phone = '965' . substr($phone, 1);
            } elseif (substr($phone, 0, 2) === '00') {
                $phone = '965' . substr($phone, 2);
            } elseif (substr($phone, 0, 3) !== '965') {
                $phone = '965' . $phone;
            }
            $message = urlencode("Your booking has been confirmed with {$settingsTitle}, Date: {$booking["booking_date"]}, Time: {$booking["booking_time"]}, Booking#: {$booking["transaction_id"]}.  \n\nThis is an automated message, Courtesy of createkuwait.com.");
            $params = array(
                "token" => $whatsappNoti1["ultraToken"],
                "to" => $phone,
                "caption" => $message,
                "image" => "{$settingsWebsite}/logos/{$settingslogo}",
            );
			$curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ultramsg.com/{$whatsappNoti1["instance"]}/messages/image",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
            ),
            ));
            $response = json_decode(curl_exec($curl), true);
			curl_close($curl);
            if( $response["sent"] == "true" ){
                echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
                exit();
            }else{
                echo json_encode(['success' => false, 'message' => 'Could not send message - ' . $response["message"]]);
                exit();
            }
		}else{
            echo json_encode(['success' => false, 'message' => 'Booking not found.']);
            exit();
        }
	}else{
        echo json_encode(['success' => false, 'message' => 'No functionality found.']);
        exit();
    }
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}
$response = bookingWhatsappUltraMsg($id);
?>
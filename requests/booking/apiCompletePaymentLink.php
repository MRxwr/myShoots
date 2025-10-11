<?php
require_once('../../admin/includes/functions/payment.php');

$booking_id = isset($_REQUEST['booking_id']) ? intval($_REQUEST['booking_id']) : 0;
$amount = isset($_REQUEST['amount']) ? floatval($_REQUEST['amount']) : 0;
$send_sms = isset($_REQUEST['send_sms']) ? intval($_REQUEST['send_sms']) : 0;
$send_whatsapp = isset($_REQUEST['send_whatsapp']) ? intval($_REQUEST['send_whatsapp']) : 0;

if ($booking_id <= 0 || $amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid booking ID or amount']);
    exit();
}

// Get the original booking details
if ( !$bookingResult = selectDB("tbl_booking", "id = '{$booking_id}'") ) {
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
    exit();
}

$originalBooking = $bookingResult[0];
$payment = json_decode($originalBooking['payment'], true);
$originalBookingPrice = floatval($originalBooking['booking_price']);

// Calculate the expected initial amount based on payment type
$expectedAmount = 0;
if ($payment && isset($payment['type'])) {
    if ($payment['type'] == '0') {
        // Type 0: Partial payment - remaining = booking_price - price
        $paidAmount = floatval($payment['price']);
        $expectedAmount = $originalBookingPrice - $paidAmount;
    } else if ($payment['type'] == '1') {
        // Type 1: Fully paid - any additional is extra
        $expectedAmount = 0;
    } else if ($payment['type'] == '2') {
        // Type 2: Cash - full booking_price
        $expectedAmount = $originalBookingPrice;
    }
} else {
    $expectedAmount = $originalBookingPrice;
}

// Check if amount was changed
$amountChanged = abs($amount - $expectedAmount) > 0.001; // Allow small floating point differences
$targetBookingId = $booking_id;

date_default_timezone_set('Asia/Riyadh');
$created_at = date('Y-m-d H:i:s');

// If amount changed, create a new booking
if ($amountChanged) {
    // Prepare new booking data (copy from original)
    $newBookingData = array(
        'package_id' => $originalBooking['package_id'],
        'booking_date' => $originalBooking['booking_date'],
        'booking_time' => $originalBooking['booking_time'],
        'is_filming' => $originalBooking['is_filming'],
        'extra_items' => $originalBooking['extra_items'],
        'booking_price' => $amount, // Use the new amount
        'customer_name' => $originalBooking['customer_name'],
        'mobile_number' => $originalBooking['mobile_number'],
        'personal_info' => $originalBooking['personal_info'],
        'status' => 'Pending',
        'created_at' => $created_at,
    );
    
    // Update payment JSON with completion info
    $newPayment = $payment;
    $newPayment['final_price'] = $amount;
    $newPayment['completion_status'] = 'pending';
    $newPayment['original_booking_id'] = $booking_id;
    
    // Prepare data for payment gateway
    $package = get_packages_details($originalBooking['package_id']);
    $package_title = $package[direction('en','ar').'Title'];
    
    $BookingDetails = array(
        'package_id' => $newBookingData['package_id'],
        'booking_date' => $newBookingData['booking_date'],
        'booking_time' => $newBookingData['booking_time'],
        'is_filming' => $newBookingData['is_filming'],
        'extra_items' => $newBookingData['extra_items'],
        'booking_price' => $amount,
        'customer_name' => "{$package_title}",
        'customer_email' => $originalBooking['customer_email'] ?? '',
        'mobile_number' => $newBookingData['mobile_number'],
        'personal_info' => $newBookingData['personal_info'],
        'status' => 'Pending',
        'created_at' => $created_at,
        "InvoiceItems" => array(
            array(
                "ItemName" => $package_title.' ['.$newBookingData['booking_date'].'] ['.$newBookingData['booking_time'].'] - '.direction('Completion Payment', 'إكمال الدفع'),
                "Quantity" => 1,
                "UnitPrice" => $amount,
            )
        )
    );
    
    // Create payment gateway request
    $paymentSettings = $newPayment;
    $paymentSettings['type'] = '1'; // Force type 1 for full payment
    
    if ( $response = createAPI($BookingDetails, $paymentSettings) ) {
        if ( !empty($response) && !empty($response["InvoiceId"]) ) {
            $targetBookingId = $response["InvoiceId"];
            $paymentLink = $response["PaymentURL"];
        } else {
            echo json_encode(['success' => false, 'message' => direction("Payment gateway connection error", "خطأ في الاتصال ببوابة الدفع")]);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => direction("Payment gateway connection error", "خطأ في الاتصال ببوابة الدفع")]);
        exit();
    }
    
} else {
    // Use existing booking - just update payment JSON with completion info
    $newPayment = $payment;
    $newPayment['final_price'] = $amount;
    $newPayment['completion_status'] = 'pending';
    
    // Update the existing booking
    updateDB("tbl_booking", array('payment' => json_encode($newPayment, JSON_UNESCAPED_UNICODE)), "id = '{$booking_id}'");
    
    // Get the payment link from the existing booking
    $paymentLink = $settingsWebsite . "/index.php?v=CompletePayment&booking_id=" . $booking_id;
}

// Send notifications
$personalInfo = json_decode($originalBooking['personal_info'], true);
$mobile = $originalBooking['mobile_number'];

// Prepare the completion payment link message
$package = get_packages_details($originalBooking['package_id']);
$package_title = $package[direction('en','ar').'Title'];

$completionMessage = direction(
    "Complete your payment for {$package_title}. Amount: {$amount} KD. Click here: {$paymentLink}",
    "أكمل دفعتك لـ {$package_title}. المبلغ: {$amount} د.ك. اضغط هنا: {$paymentLink}"
);

// Send SMS if requested
if ($send_sms) {
    $settings = selectDB("tbl_calendar_settings", "`id` = '1'")[0];
    $smsSettings = json_decode($settings['smsNoti'], true);
    
    if( !empty($smsSettings) && $smsSettings["status"] == 1 ){
        $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
        $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
        $phone = str_replace($arabic, $english, $personalInfo[1]);
        
        $smsMessage = str_replace(' ','+', $completionMessage);
        $url = "http://www.kwtsms.com/API/send/?username={$smsSettings["username"]}&password={$smsSettings["password"]}&sender={$smsSettings["sender"]}&mobile=965{$phone}&lang=1&message={$smsMessage}";
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}

// Send WhatsApp if requested
if ($send_whatsapp) {
    $settings = selectDB("tbl_calendar_settings", "`id` = '1'")[0];
    $whatsappNoti = json_decode($settings["whatsappNoti"],true);
    
    if( !empty($whatsappNoti) && $whatsappNoti["status"] == 1 ){
        $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
        $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
        $phone = str_replace($arabic, $english, $personalInfo[1]);
        
        if ( substr($phone, 0, 1) === '0' ) {
            $phone = '965' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) === '00') {
            $phone = '965' . substr($phone, 2);
        } elseif (substr($phone, 0, 3) !== '965') {
            $phone = '965' . $phone;
        }
        
        $waMessage = $completionMessage . "\n\nThis is an automated message, Courtesy of createkuwait.com.";
        
        $params = array(
            "token" => $whatsappNoti["ultraToken"],
            "to" => $phone,
            "caption" => $waMessage,
            "image" => "{$settingsWebsite}/logos/{$settingslogo}",
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/{$whatsappNoti["instance"]}/messages/image",
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
        $response = curl_exec($curl);
        curl_close($curl);
    }
}

echo json_encode([
    'success' => true, 
    'message' => direction("Payment link sent successfully", "تم إرسال رابط الدفع بنجاح"),
    'booking_id' => $targetBookingId,
    'payment_link' => $paymentLink
]);
?>

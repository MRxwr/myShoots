<?php
/**
 * CreateManualBooking Endpoint
 * Creates a booking manually by admin without payment
 */

if(!isset($_POST['package_id']) || !isset($_POST['booking_date']) || !isset($_POST['booking_time'])) {
    echo json_encode(['success' => false, 'message' => direction('Missing required fields', 'الحقول المطلوبة مفقودة')]);
    exit();
}

$packageId = intval($_POST['package_id']);
$bookingDate = $_POST['booking_date'];
$bookingTime = $_POST['booking_time'];
$bookingPrice = isset($_POST['booking_price']) ? floatval($_POST['booking_price']) : 0;

// Convert date from DD-MM-YYYY to YYYY-MM-DD
$date = explode('-', $bookingDate);
$bookingDateFormatted = $date[2].'-'.$date[1].'-'.$date[0];

// Check if time slot is already booked
if (check_bookingTimeAndDate($bookingDateFormatted, $bookingTime, $packageId)) {
    echo json_encode(['success' => false, 'message' => direction('This time slot is already booked', 'هذا الموعد محجوز بالفعل')]);
    exit();
}

// Get package details
$package = get_packages_details($packageId);
if (empty($package)) {
    echo json_encode(['success' => false, 'message' => direction('Package not found', 'الباقة غير موجودة')]);
    exit();
}

// Process extra items
$select_extra_item = isset($_POST['select_extra_item']) && is_array($_POST['select_extra_item']) ? $_POST['select_extra_item'] : array();
$extra_items_val = "";
$comm = "";
if (count($select_extra_item) > 0) {
    foreach ($select_extra_item as $item) {
        $item_arr = explode(",", $item);
        $arr = array('item' => $item_arr[0], 'price' => $item_arr[1]);
        $extra_items_val .= $comm . json_encode($arr, JSON_UNESCAPED_UNICODE);
        $comm = ",";
    }
}
$extra_items = "[{$extra_items_val}]";

// Get themes
$themes = isset($_POST['themes']) ? $_POST['themes'] : '[]';

// Get personal info
$personalInfo = isset($_POST['personalInfo']) && is_array($_POST['personalInfo']) ? $_POST['personalInfo'] : array();
$personalInfoJson = json_encode($personalInfo, JSON_UNESCAPED_UNICODE);

// Generate transaction ID in format: m-YYYYMMDD-timestamp
$transactionId = 'm-' . date('Ymd') . '-' . time();

// Create booking data
$bookingData = array(
    'transaction_id' => $transactionId,
    'package_id' => $packageId,
    'booking_date' => $bookingDateFormatted,
    'booking_time' => $bookingTime,
    'booking_price' => $bookingPrice,
    'extra_items' => $extra_items,
    'themes' => $themes,
    'personal_info' => $personalInfoJson,
    'status' => 'Yes', // Automatically approve admin bookings
    'is_filming' => 0,
    'created_at' => date('Y-m-d H:i:s'),
    'payload' => json_encode(array('source' => 'admin_manual'), JSON_UNESCAPED_UNICODE),
    'payloadResponse' => json_encode(array('source' => 'admin_manual', 'status' => 'approved'), JSON_UNESCAPED_UNICODE),
    'gatewayResponse' => json_encode(array('source' => 'admin_manual', 'result' => 'CAPTURED'), JSON_UNESCAPED_UNICODE),
    'gatewayLink' => '',
    'payment' => json_encode(array(
        'type' => '3', // Manual booking type
        'price' => $bookingPrice,
        'booking_price' => $bookingPrice,
        'date' => date('Y-m-d H:i:s')
    ), JSON_UNESCAPED_UNICODE),
    'parent_id' => 0
);

// Insert booking
if (insertDB("tbl_booking", $bookingData)) {
    // Send WhatsApp notification
    $whatsappApi = $settingsWebsite . "/requests/index.php?f=booking&endpoint=BookingWhatsapp";
    $lastInsertedId = selectDB("tbl_booking", "`transaction_id` = '{$transactionId}'");
    if ($lastInsertedId && count($lastInsertedId) > 0) {
        $bookingId = $lastInsertedId[0]['id'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $whatsappApi);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['id' => $bookingId]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);
        curl_close($ch);
    }
    
    echo json_encode([
        'success' => true,
        'message' => direction('Booking created successfully', 'تم إنشاء الحجز بنجاح'),
        'data' => ['transaction_id' => $transactionId]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => direction('Failed to create booking', 'فشل في إنشاء الحجز')]);
}
exit();
?>

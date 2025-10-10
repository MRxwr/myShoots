<?php
/**
 * BookingReschedule Endpoint
 * Handles rescheduling of bookings with the following process:
 * 1. Creates a new booking with status 'Yes' and the new date/time
 * 2. Updates the original booking status to 'Rescheduled'
 * 3. Copies all other details from the original booking
 */

// Check for required parameters
if(!isset($_POST['booking_id']) || !isset($_POST['new_date']) || !isset($_POST['new_time']) || !isset($_POST['package_id'])) {
    echo json_encode(['success' => false, 'message' => direction('Missing required parameters', 'معلمات مطلوبة مفقودة')]);
    exit();
}

$bookingId = intval($_POST['booking_id']);
$newDate = $_POST['new_date'];
$newTime = $_POST['new_time'];
$packageId = intval($_POST['package_id']);

// Format the date (assuming it's in dd-mm-yyyy format from the frontend)
$dateParts = explode('-', $newDate);
if(count($dateParts) === 3) {
    $formattedDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0]; // Convert to YYYY-MM-DD
} else {
    echo json_encode(['success' => false, 'message' => direction('Invalid date format', 'تنسيق تاريخ غير صالح')]);
    exit();
}

// First, check if the requested time slot is available
$bookedTimes = get_bookingTimeBydate($packageId, $formattedDate);
$blockedTimeSlots = getBlockedTimeSlots($formattedDate);

$bookedTimeSlots = [];
if(is_array($bookedTimes) && count($bookedTimes) > 0) {
    foreach($bookedTimes as $time) {
        $bookedTimeSlots[] = $time['booking_time'];
    }
}

// Combine booked and blocked time slots
$allUnavailableSlots = array_merge($bookedTimeSlots, $blockedTimeSlots);

// Check if requested time is available
if(in_array($newTime, $allUnavailableSlots)) {
    echo json_encode(['success' => false, 'message' => direction('Selected time is already booked', 'الوقت المحدد محجوز بالفعل')]);
    exit();
}

// Get the original booking details
$originalBooking = selectDB('tbl_booking', "`id` = '{$bookingId}'");
if(!$originalBooking) {
    echo json_encode(['success' => false, 'message' => direction('Original booking not found', 'الحجز الأصلي غير موجود')]);
    exit();
}
$originalBooking = $originalBooking[0];

// Get the original transaction ID and create new one with -R suffix
$originalTransactionId = $originalBooking['transaction_id'];
// Remove any existing -R suffix to get the base transaction ID
$baseTransactionId = preg_replace('/-R\d*$/', '', $originalTransactionId);
// Create new transaction ID with -R suffix
$newTransactionId = $baseTransactionId . '-R' . time();

// Create a new booking with all the same details but new date and time
$newBookingData = [
    'package_id' => $originalBooking['package_id'],
    'booking_date' => $formattedDate,
    'booking_time' => $newTime,
    'booking_price' => $originalBooking['booking_price'],
    'personal_info' => $originalBooking['personal_info'],
    'transaction_id' => $newTransactionId,
    'status' => 'Yes' // New booking is confirmed
];

// Add optional fields only if they exist and are not null
if (isset($originalBooking['is_filming']) && $originalBooking['is_filming'] !== null) {
    $newBookingData['is_filming'] = $originalBooking['is_filming'];
}
if (isset($originalBooking['extra_items']) && $originalBooking['extra_items'] !== null) {
    $newBookingData['extra_items'] = $originalBooking['extra_items'];
}
if (isset($originalBooking['payload']) && $originalBooking['payload'] !== null) {
    $newBookingData['payload'] = $originalBooking['payload'];
}

// Insert the new booking
try {
    $insertResult = insertDB('tbl_booking', $newBookingData);
    if(!$insertResult) {
        error_log("Failed to insert booking: " . print_r($newBookingData, true));
        echo json_encode(['success' => false, 'message' => direction('Failed to create new booking', 'فشل في إنشاء حجز جديد')]);
        exit();
    }
} catch (Exception $e) {
    error_log("Exception inserting booking: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => direction('Error creating new booking: ', 'خطأ في إنشاء حجز جديد: ') . $e->getMessage()]);
    exit();
}

// Update the status of the original booking to 'Rescheduled'
$updateData = [
    'status' => 'Rescheduled'
];

if(!updateDB('tbl_booking', $updateData, "`id` = '{$bookingId}'")) {
    error_log("Failed to update original booking: " . $bookingId);
    echo json_encode(['success' => false, 'message' => direction('Failed to update original booking', 'فشل في تحديث الحجز الأصلي')]);
    exit();
}

// Get the new booking ID
$newBookingId = mysqli_insert_id($GLOBALS['dbconnect'] ?? $dbconnect);

// Success response with both booking IDs
echo json_encode([
    'success' => true, 
    'message' => direction('Booking successfully rescheduled', 'تمت إعادة جدولة الحجز بنجاح'),
    'original_booking_id' => $bookingId,
    'new_booking_id' => $newBookingId
]);
exit();
?>
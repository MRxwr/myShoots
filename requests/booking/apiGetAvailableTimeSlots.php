<?php
/**
 * GetAvailableTimeSlots Endpoint
 * Returns available time slots for a specific package and date
 */

// Check for required parameters
if(!isset($_POST['package_id']) || !isset($_POST['date'])) {
    echo json_encode(['success' => false, 'message' => direction('Missing required parameters', 'معلمات مطلوبة مفقودة')]);
    exit();
}

$packageId = intval($_POST['package_id']);
$date = $_POST['date'];

// Format the date (assuming it's in dd-mm-yyyy format from the frontend)
$dateParts = explode('-', $date);
if(count($dateParts) === 3) {
    $formattedDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0]; // Convert to YYYY-MM-DD
} else {
    echo json_encode(['success' => false, 'message' => direction('Invalid date format', 'تنسيق تاريخ غير صالح')]);
    exit();
}

// Get the package details to get all possible time slots
$package = selectDB("tbl_packages", "`id` = '{$packageId}'");
if(!$package) {
    echo json_encode(['success' => false, 'message' => direction('Package not found', 'الباقة غير موجودة')]);
    exit();
}
$package = $package[0];
$times = json_decode($package['time'], true);

// Get booked time slots for the selected date and package
$bookedTimes = get_bookingTimeBydate($packageId, $formattedDate);
$blockedTimeSlots = getBlockedTimeSlots($formattedDate);

$bookedTimeArr = array(); 
if(is_array($bookedTimes) && count($bookedTimes) > 0) {
    foreach($bookedTimes as $booktime) {
        $bookedTimeArr[] = $booktime['booking_time'];
    }
}
$bookedTimeArr = array_merge($bookedTimeArr, $blockedTimeSlots);

// Filter out booked time slots
$availableTimeSlots = [];
foreach($times as $timeSlot) {
    $time = $timeSlot['startDate'] . " - " . $timeSlot['endDate'];
    if(!in_array($time, $bookedTimeArr)) {
        $availableTimeSlots[] = $time;
    }
}

echo json_encode([
    'success' => true,
    'data' => $availableTimeSlots
]);
exit();
?>
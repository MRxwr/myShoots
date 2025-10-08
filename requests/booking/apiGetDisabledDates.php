<?php
/**
 * GetDisabledDates Endpoint
 * Returns an array of disabled dates for the given package
 */

// Check for required parameters
if(!isset($_POST['package_id'])) {
    echo json_encode(['success' => false, 'message' => direction('Missing package ID', 'معرف الباقة مفقود')]);
    exit();
}

$packageId = intval($_POST['package_id']);

// Get disabled dates from the bookingMain function
$disabledDates = get_disabledDate();

// Format dates for datepicker (dd-mm-yyyy)
$formattedDates = [];
foreach($disabledDates as $date) {
    // Convert YYYY-MM-DD to DD-MM-YYYY for frontend datepicker
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    if($dateObj) {
        $formattedDates[] = $dateObj->format('d-m-Y');
    }
}

echo json_encode([
    'success' => true,
    'data' => $formattedDates
]);
exit();
?>
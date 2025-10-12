<?php
/**
 * GetDisabledDatesForAdmin Endpoint
 * Returns disabled dates for admin booking creation
 */

if(!isset($_POST['package_id'])) {
    echo json_encode(['success' => false, 'message' => direction('Missing package ID', 'معرف الباقة مفقود')]);
    exit();
}

$packageId = intval($_POST['package_id']);

// Temporarily set $_GET['id'] for get_disabledDate() function
$_GET['id'] = $packageId;

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

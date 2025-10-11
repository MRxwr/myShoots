<?php
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid booking ID']);
    exit();
}

if ( $result = selectDB("tbl_booking", "id = '{$id}'") ) {
    $row = $result[0];
    $payment = json_decode($row['payment'], true);
    $booking_price = floatval($row['booking_price']);
    
    echo json_encode([
        'success' => true, 
        'payment' => $payment,
        'booking_price' => $booking_price
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Booking not found']);
}
?>

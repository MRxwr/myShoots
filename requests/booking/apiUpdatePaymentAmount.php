<?php
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$newAmount = isset($_POST['new_amount']) ? floatval($_POST['new_amount']) : 0;

if (!$id || !$newAmount) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

// Get the booking
if ($booking = selectDBNew("tbl_booking", [$id], "id = ?", "")) {
    $booking = $booking[0];
    
    // Get current payment data
    $paymentData = json_decode($booking['payment'], true);
    
    if (!$paymentData) {
        echo json_encode(['success' => false, 'message' => 'Payment data not found']);
        exit();
    }
    
    // Get what was actually paid
    $actuallyPaid = isset($paymentData['price']) ? floatval($paymentData['price']) : 0;
    
    // Update payment JSON with new amount
    $updatedPaymentData = array(
        'type' => $paymentData['type'], // Keep the original payment type
        'price' => $actuallyPaid, // What was actually paid
        'booking_price' => $newAmount, // The new amount set by admin
        'remaining_amount' => $newAmount - $actuallyPaid, // Calculate remaining
        'date' => isset($paymentData['date']) ? $paymentData['date'] : date('Y-m-d H:i:s')
    );
    
    $updatedPaymentJson = json_encode($updatedPaymentData);
    
    // Update the booking
    if (updateDB("tbl_booking", ["payment" => $updatedPaymentJson], "id = $id")) {
        echo json_encode([
            'success' => true, 
            'message' => 'Payment amount updated successfully',
            'data' => [
                'new_amount' => $newAmount,
                'paid_amount' => $actuallyPaid,
                'remaining_amount' => $newAmount - $actuallyPaid
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update payment amount']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
}
?>

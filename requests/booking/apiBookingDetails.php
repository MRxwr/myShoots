<?php
// Add detailed logging for debugging
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

// Log the request
$logData = array(
    "type" => "API Request",
    "endpoint" => "BookingDetails",
    "requestData" => json_encode($_REQUEST),
    "timestamp" => date("Y-m-d H:i:s")
);
insertLogDB("api_logs", $logData);

if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid booking ID', 'request' => $id]);
    exit();
}

$joinData = array(
    "select" => ["t.*", ["t1." . direction("en","ar") . "Title as package_name"]],
    "join" => ["tbl_packages"],
    "on" => ["t.package_id = t1.id"],
);

// Add extra debugging query to check if the booking exists
$checkBooking = selectDB("tbl_booking", "WHERE id = {$id} LIMIT 1");
if (!$checkBooking) {
    // Log that the booking wasn't found
    $logData = array(
        "type" => "API Error",
        "endpoint" => "BookingDetails",
        "error" => "Booking not found in database",
        "bookingId" => $id,
        "timestamp" => date("Y-m-d H:i:s")
    );
    insertLogDB("api_logs", $logData);
}

if ($result = selectJoinDB("tbl_booking", $joinData, "WHERE t.id = {$id} LIMIT 1")) {
    $row = $result[0];
    $extra_items = '';
    if (!empty($row['extra_items'])) {
        $extra_items = array();
        $items = json_decode($row['extra_items']);
        if ($items && is_array($items)) {
            foreach ($items as $item) {
                $extra_items[] = '- ' . htmlspecialchars($item->item) . ' ' . htmlspecialchars($item->price) . ' KD.';
            }
        }
    }
    // Format status
    $status_text = '';
    if ($row['status'] == 'Yes') {
        $status_text = direction("Successful","ناجح");
    } else if ($row['status'] == 'No') {
        $status_text = direction("Failed","فاشل");
    } else if ($row['status'] == 'cancel') {
        $status_text = direction("Cancel","ملغي");
    } else {
        $status_text = $row['status'];
    }
    $data = array(
        'S.N.' => htmlspecialchars($row['id']),
        'Invoice Date' => htmlspecialchars($row['created_at']),
        'Transaction ID' => htmlspecialchars($row['transaction_id']),
        'Package Name' => htmlspecialchars($row['package_name'] ?? ''),
        'Booking Date' => htmlspecialchars($row['booking_date']),
        'Booking Time' => htmlspecialchars($row['booking_time']),
        'Extra Items' => !empty($extra_items) ? implode('<br>', $extra_items) : '',
        'Booking Price' => htmlspecialchars($row['booking_price']) . ' KD',
        'Status' => $status_text,
    );
    // Add dynamic customer info fields (personal_info)
    if (!empty($row['personal_info'])) {
        $personalInfo = json_decode($row['personal_info'], true);
        if ($personalInfo && is_array($personalInfo)) {
            // Fetch field titles from tbl_personal_info
            $fields = array();
            $fieldsResult = mysqli_query($dbconnect, "SELECT * FROM tbl_personal_info WHERE id != '0'");
            if ($fieldsResult = selectDB("tbl_personal_info", "WHERE id != '0'")) {
                foreach ($fieldsResult as $f) {
                    $fields[$f['id']] = (direction($f['enTitle'], $f['arTitle']));
                }
            }
            foreach ($personalInfo as $key => $value) {
                $title = isset($fields[$key]) ? $fields[$key] : $key;
                $data['Personal: '.htmlspecialchars($title)] = htmlspecialchars($value);
            }
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    // Return a more detailed error message
    echo json_encode([
        'success' => false, 
        'error' => 'Booking not found',
        'booking_id' => $id,
        'debug_info' => [
            'table' => 'tbl_booking',
            'check_result' => $checkBooking ? 'Found in direct query' : 'Not found in direct query',
            'join_query_failed' => true
        ]
    ]);
    
    // Log the error
    $logData = array(
        "type" => "API Error",
        "endpoint" => "BookingDetails",
        "error" => "Join query returned no results",
        "bookingId" => $id,
        "timestamp" => date("Y-m-d H:i:s")
    );
    insertLogDB("api_logs", $logData);
}
?>

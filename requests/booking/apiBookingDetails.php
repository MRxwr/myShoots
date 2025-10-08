<?php
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid booking ID']);
    exit();
}
$language = direction("en","ar");
$joinData = array(
    "select" => ["t.*", ["t1.{$language}Title as package_name"]],
    "join" => ["tbl_packages"],
    "on" => ["t.package_id = t1.id"],
);
if ($result = selectJoinDB("tbl_booking", $joinData, "t.id = '{$id}' LIMIT 1")) {
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
    echo json_encode(['success' => false, 'error' => 'Booking not found']);
}
?>

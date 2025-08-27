<?php
require_once("../includes/checksouthead.php");
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid booking ID']);
    exit();
}

$query = "SELECT b.*, p.title_" . $_SESSION['lang'] . " as package_name FROM tbl_booking b LEFT JOIN tbl_packages p ON b.package_id = p.id WHERE b.id = $id LIMIT 1";
$result = mysqli_query($dbconnect, $query);
if ($result && $row = mysqli_fetch_assoc($result)) {
    // Format extra items
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
        $status_text = $lang['yes'];
    } else if ($row['status'] == 'No') {
        $status_text = $lang['no'];
    } else if ($row['status'] == 'cancel') {
        $status_text = $lang['cancel'];
    } else {
        $status_text = $row['status'];
    }
    $data = array(
        'S.N.' => htmlspecialchars($row['id']),
        'Invoice Date' => htmlspecialchars($row['created_at']),
        'Transaction ID' => htmlspecialchars($row['transaction_id']),
        'Package Name' => htmlspecialchars($row['package_name'] ?? ''),
        'Customer Name' => htmlspecialchars($row['customer_name']),
        'Mobile Number' => htmlspecialchars($row['mobile_number']),
        'Baby Name' => htmlspecialchars($row['baby_name']),
        'Baby Age' => htmlspecialchars($row['baby_age']),
        'Instructions' => htmlspecialchars($row['instructions']),
        'Booking Date' => htmlspecialchars($row['booking_date']),
        'Booking Time' => htmlspecialchars($row['booking_time']),
        'Extra Items' => !empty($extra_items) ? implode('<br>', $extra_items) : '',
        'Booking Price' => htmlspecialchars($row['booking_price']) . ' KD',
        'Status' => $status_text,
    );
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'error' => 'Booking not found']);
}
mysqli_close($dbconnect);
?>

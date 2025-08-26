<?php
session_start();
include('../../languages/lang_config.php');
include('../../admin/config/database.php');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

$conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD, DBNAME);
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Get booking info
$query = "SELECT mobile_number, customer_name FROM tbl_booking WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $mobile = $row['mobile_number'];
    $name = $row['customer_name'];
    // Here you would integrate with your SMS API
    // For demo, just return success
    echo json_encode(['success' => true, 'message' => 'SMS sent to ' . $mobile]);
} else {
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
}

mysqli_close($conn);
?>

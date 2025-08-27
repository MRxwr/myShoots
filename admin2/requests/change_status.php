<?php
session_start();
include('../../languages/lang_config.php');
include('../../admin/config/database.php');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';

if (!$id || !in_array($status, ['Yes', 'No', 'Pending'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

$conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD, DBNAME);
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$query = "UPDATE tbl_booking SET status = '" . mysqli_real_escape_string($conn, $status) . "' WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
}

mysqli_close($conn);
?>

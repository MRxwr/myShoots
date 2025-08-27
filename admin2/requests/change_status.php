<?php
require_once("../includes/checksouthead.php");
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';

if (!$id || !in_array($status, ['Yes', 'No', 'Pending'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

$dbconnect = mysqli_connect(LOCALHOST, USERNAME, PASSWORD, DBNAME);
if (!$dbconnect) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$query = "UPDATE tbl_booking SET status = '" . mysqli_real_escape_string($dbconnect, $status) . "' WHERE id = $id";
$result = mysqli_query($dbconnect, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
}

mysqli_close($dbconnect);
?>

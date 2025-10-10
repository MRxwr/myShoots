<?php
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';

if (!$id || !in_array($status, ['Yes', 'No', 'Cancel', 'Rescheduled'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

if ( updateDB("tbl_booking", ["status" => $status], "id = $id") ) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
}

mysqli_close($dbconnect);
?>

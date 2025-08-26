<?php
// Turn off all error reporting to prevent any output that might corrupt the JSON
error_reporting(0);
ini_set('display_errors', 0);

// Start output buffering to catch any unwanted output
ob_start();

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files for database connection
require_once('../config/constants.php');
require_once('../config/database.php');
require_once('../config/functions.php');

// Initialize database object
$obj = new Functions();
$conn = $obj->db_connect();

// Prepare empty data array
$data = array();

try {
    // Basic query for booking data - no joins or complex processing
    $sql = "SELECT * FROM tbl_booking ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $sn = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Add data to array with minimal processing
            $data[] = array(
                "sn" => $sn++,
                "package_name" => "Package #" . $row['package_id'],
                "customer_name" => $row['customer_name'],
                "mobile_number" => $row['mobile_number'],
                "baby_name" => $row['baby_name'],
                "baby_age" => $row['baby_age'],
                "instructions" => $row['instructions'],
                "booking_date" => $row['booking_date'],
                "booking_time" => $row['booking_time'],
                "extra_items" => "",
                "booking_price" => $row['booking_price'] . ' KD',
                "transaction_id" => $row['transaction_id'],
                "is_active" => $row['status']
            );
        }
        mysqli_free_result($result);
    }
} catch (Exception $e) {
    // Just continue with empty data array
}

// Clear all previous output
ob_end_clean();

// Set proper JSON header
header('Content-Type: application/json');

// Return JSON response
echo json_encode(array("data" => $data));
exit;
?>

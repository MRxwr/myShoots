<?php
// Turn off output buffering
ob_start();

// Suppress errors from being displayed
ini_set('display_errors', 0);
error_reporting(0);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files for database connection
require_once('../config/constants.php');
require_once('../config/database.php');
require_once('../config/functions.php');

// Set content type to JSON
header('Content-Type: application/json');

// Initialize database object and data array
$data = array();

try {
    $obj = new Functions();
    $conn = $obj->db_connect();
    
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Fetch booking data
    $tbl_name = 'tbl_booking';
    $query = $obj->select_data($tbl_name);
    $res = $obj->execute_query($conn, $query);
    
    if (!$res) {
        throw new Exception("Query execution failed");
    }

    $count_rows = $obj->num_rows($res);
    if ($count_rows > 0) {
        $sn = 1;
        while ($row = $obj->fetch_data($res)) {
            $id = $row['id'];
            $package_id = $row['package_id'];
            $transaction_id = $row['transaction_id'];
            $customer_name = $row['customer_name'];
            $mobile_number = $row['mobile_number'];
            $baby_name = $row['baby_name'];
            $baby_age = $row['baby_age'];
            $instructions = $row['instructions'];
            $booking_date = $row['booking_date'];
            $booking_time = $row['booking_time'];
            $extra_items = $row['extra_items'];
            $booking_price = $row['booking_price'];
            $is_active = $row['status'];

            // Get package name - with error handling
            $package_name = '';
            try {
                if ($package_id) {
                    $tbl_name1 = 'tbl_packages';
                    $where = 'id=' . $package_id;
                    $query1 = $obj->select_data($tbl_name1, $where);
                    $res1 = $obj->execute_query($conn, $query1);
                    if ($res1) {
                        $row1 = $obj->fetch_data($res1);
                        $lang_key = 'title_' . (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en');
                        $package_name = isset($row1[$lang_key]) ? $row1[$lang_key] : '';
                    }
                }
            } catch (Exception $e) {
                // Just continue with empty package name
            }

            // Format extra items for display - with error handling
            $extra_items_html = '';
            if ($extra_items != "") {
                try {
                    $extra_items_html = '<ul class="list-unstyled">';
                    $rows_items = json_decode($extra_items);
                    if ($rows_items && is_array($rows_items)) {
                        foreach ($rows_items as $item) {
                            if (isset($item->item) && isset($item->price)) {
                                $extra_items_html .= "<li>- " . htmlspecialchars($item->item) . " " . $item->price . " KD.</li>";
                            }
                        }
                    }
                    $extra_items_html .= '</ul>';
                } catch (Exception $e) {
                    $extra_items_html = '';
                }
            }

            // Simple status display
            $status = ($is_active == 'Yes') ? 'Yes' : 'No';

            // Add data to array
            $data[] = array(
                "sn" => $sn++,
                "package_name" => $package_name,
                "customer_name" => $customer_name,
                "mobile_number" => $mobile_number,
                "baby_name" => $baby_name,
                "baby_age" => $baby_age,
                "instructions" => $instructions,
                "booking_date" => $booking_date,
                "booking_time" => $booking_time,
                "extra_items" => $extra_items_html,
                "booking_price" => $booking_price . ' KD',
                "transaction_id" => $transaction_id,
                "is_active" => $status
            );
        }
    }

} catch (Exception $e) {
    // If any error occurs, we'll return an empty data array with an error message
    $data = array();
}

// Clear any previous output
ob_end_clean();

// Set proper JSON header
header('Content-Type: application/json');

// Return JSON response - make sure it's properly encoded
$response = array("data" => $data);
$json = json_encode($response);

// Check for JSON encoding errors
if ($json === false) {
    // If there was a JSON encoding error, return an empty data array
    $json = json_encode(array("data" => array()));
}

echo $json;
exit; // Stop execution after sending response
?>

<?php
// Include necessary files for database connection
require_once('../config/constants.php');
require_once('../config/database.php');
require_once('../config/functions.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set content type to JSON
header('Content-Type: application/json');

// Initialize database object
$obj = new Functions();
$conn = $obj->db_connect();

// Get language file
include_once("../languages/".$_SESSION['lang'].".php");

// Fetch booking data
$tbl_name = 'tbl_booking';
$query = $obj->select_data($tbl_name);
$res = $obj->execute_query($conn, $query);

$data = array();

if ($res) {
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

            // Get package name
            $tbl_name1 = 'tbl_packages';
            $where = 'id=' . $package_id;
            $query1 = $obj->select_data($tbl_name1, $where);
            $res1 = $obj->execute_query($conn, $query1);
            $row1 = $obj->fetch_data($res1);
            $package_name = @$row1['title_' . $_SESSION['lang']];

            // Format extra items for display
            $extra_items_html = '';
            if ($extra_items != "") {
                $extra_items_html = '<ul class="list-unstyled">';
                $rows_items = json_decode($extra_items);
                if ($rows_items) {
                    foreach ($rows_items as $item) {
                        $extra_items_html .= "<li>- " . htmlspecialchars($item->item) . " " . $item->price . " KD.</li>";
                    }
                }
                $extra_items_html .= '</ul>';
            }

            // Format status
            $status = ($is_active == 'Yes') ? $lang['yes'] : $lang['no'];

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
}

// Return JSON response
echo json_encode(array("data" => $data));
?>

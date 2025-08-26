<?php
session_start();
include('../config/constants.php');
include('../config/database.php');
include('../config/functions.php');

// Check if user is logged in
if(!isset($_SESSION['admin_user']))
{
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

// Include language file
$language = $_SESSION['lang'];
include('../../languages/'.$language.'.php');

$obj = new functions();

// DataTables parameters
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$search_value = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

// Base query
$tbl_name = 'tbl_booking';
$where_clause = '';

// Add search functionality
if (!empty($search_value)) {
    $where_clause = "WHERE customer_name LIKE '%$search_value%' OR mobile_number LIKE '%$search_value%' OR baby_name LIKE '%$search_value%' OR transaction_id LIKE '%$search_value%'";
}

// Count total records
$count_query = "SELECT COUNT(*) as total FROM $tbl_name $where_clause";
$count_res = $obj->execute_query($conn, $count_query);
$total_records = $obj->fetch_data($count_res)['total'];

// Get filtered records with pagination
$query = "SELECT * FROM $tbl_name $where_clause ORDER BY id DESC LIMIT $start, $length";
$res = $obj->execute_query($conn, $query);

$data = array();
$sn = $start + 1;

if($res && $obj->num_rows($res) > 0)
{
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
        $where = 'id='.$package_id;
        $query1 = $obj->select_data($tbl_name1, $where);
        $res1 = $obj->execute_query($conn, $query1);
        $row1 = $obj->fetch_data($res1);
        $package_name = @$row1['title_'.$_SESSION['lang']];
        
        // Format extra items
        $extra_items_html = '';
        if($extra_items != "") {
            $extra_items_html = '<ul class="list-unstyled">';
            $items = json_decode($extra_items);
            if($items) {
                foreach($items as $item) {
                    $extra_items_html .= '<li>- '.$item->item.' '.$item->price.' KD.</li>';
                }
            }
            $extra_items_html .= '</ul>';
        }
        
        // Format status
        $status_text = '';
        if($is_active == 'Yes') {
            $status_text = $lang['yes'];
        } else if($is_active == 'No') {
            $status_text = $lang['no'];
        }
        
        $data[] = array(
            $sn++,
            $package_name,
            $customer_name,
            $mobile_number,
            $baby_name,
            $baby_age,
            $instructions,
            $booking_date,
            $booking_time,
            $extra_items_html,
            $booking_price . 'KD',
            $transaction_id,
            $status_text
        );
    }
}

// Prepare response
$response = array(
    "draw" => $draw,
    "recordsTotal" => $total_records,
    "recordsFiltered" => $total_records,
    "data" => $data
);

header('Content-Type: application/json');
echo json_encode($response);
?>

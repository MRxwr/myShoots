<?php
session_start();

// Include language configuration
include('../../languages/lang_config.php');

// Check if user is logged in
if(!isset($_SESSION['user'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

// Database connection constants
define('LOCALHOST', 'localhost');
define('USERNAME', 'u671249433_myshootDemoUR');
define('PASSWORD', 'N@b$90949089');
define('DBNAME', 'u671249433_myshootDemoDb');

// Direct MySQLi connection
$conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD, DBNAME);

if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

// DataTables server-side processing parameters
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$search_value = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

// Search WHERE clause
$search_query = '';
if (!empty($search_value)) {
    $search_value = mysqli_real_escape_string($conn, $search_value);
    $search_query = " WHERE customer_name LIKE '%$search_value%' 
                      OR mobile_number LIKE '%$search_value%' 
                      OR baby_name LIKE '%$search_value%' 
                      OR transaction_id LIKE '%$search_value%'";
}

// Count total records
$total_query = "SELECT COUNT(*) as total FROM tbl_booking";
$total_result = mysqli_query($conn, $total_query);
$total_records = mysqli_fetch_assoc($total_result)['total'];

// Count filtered records (with search)
$filtered_query = "SELECT COUNT(*) as total FROM tbl_booking" . $search_query;
$filtered_result = mysqli_query($conn, $filtered_query);
$filtered_records = mysqli_fetch_assoc($filtered_result)['total'];

// Get data with pagination
$data_query = "SELECT b.*, p.title_" . $_SESSION['lang'] . " as package_name 
               FROM tbl_booking b 
               LEFT JOIN tbl_packages p ON b.package_id = p.id" . 
               $search_query . 
               " ORDER BY b.id DESC 
               LIMIT $start, $length";

$data_result = mysqli_query($conn, $data_query);

$data = array();
$sn = $start + 1;

if ($data_result && mysqli_num_rows($data_result) > 0) {
    while ($row = mysqli_fetch_assoc($data_result)) {
        // Format extra items
        $extra_items_html = '';
        if (!empty($row['extra_items'])) {
            $extra_items_html = '<ul class="list-unstyled">';
            $items = json_decode($row['extra_items']);
            if ($items && is_array($items)) {
                foreach ($items as $item) {
                    $extra_items_html .= '<li>- ' . htmlspecialchars($item->item) . ' ' . htmlspecialchars($item->price) . ' KD.</li>';
                }
            }
            $extra_items_html .= '</ul>';
        }
        
        // Format status
        $status_text = '';
        if ($row['status'] == 'Yes') {
            $status_text = $lang['yes'];
        } else if ($row['status'] == 'No') {
            $status_text = $lang['no'];
        } else {
            $status_text = $row['status'];
        }
        
        $data[] = array(
            $sn++,
            htmlspecialchars($row['package_name'] ?? ''),
            htmlspecialchars($row['customer_name']),
            htmlspecialchars($row['mobile_number']),
            htmlspecialchars($row['baby_name']),
            htmlspecialchars($row['baby_age']),
            htmlspecialchars($row['instructions']),
            htmlspecialchars($row['booking_date']),
            htmlspecialchars($row['booking_time']),
            $extra_items_html,
            htmlspecialchars($row['booking_price']) . ' KD',
            htmlspecialchars($row['transaction_id']),
            $status_text
        );
    }
}

// Prepare JSON response
$response = array(
    "draw" => $draw,
    "recordsTotal" => intval($total_records),
    "recordsFiltered" => intval($filtered_records),
    "data" => $data
);

// Close database connection
mysqli_close($conn);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

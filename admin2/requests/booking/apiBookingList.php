<?php
// DataTables server-side processing parameters
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$search_value = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';
$status_filter = isset($_POST['status_filter']) ? $_POST['status_filter'] : 'all';
$_SESSION['lang'] = direction("en","ar");
// Status filter WHERE clause
$status_query = '';
if ($status_filter != 'all') {
    $status_filter = mysqli_real_escape_string($dbconnect, $status_filter);
    if ($status_filter == 'Yes') {
        $status_query = " AND b.status = 'Yes'";
    } else if ($status_filter == 'No') {
        $status_query = " AND b.status = 'No'";
    } else if ($status_filter == 'Cancel') {
        $status_query = " AND b.status = 'cancel'";
    }
}

// Search WHERE clause
$search_query = '';
$where_conditions = array();

// Always filter for non-empty transaction_id
$where_conditions[] = "transaction_id != ''";

// Add search conditions if search value exists
if (!empty($search_value)) {
    $search_value = mysqli_real_escape_string($dbconnect, $search_value);
    $where_conditions[] = "(customer_name LIKE '%$search_value%' 
                          OR mobile_number LIKE '%$search_value%' 
                          OR transaction_id LIKE '%$search_value%'
                          OR b.created_at LIKE '%$search_value%')";
}

// Add status filter if not 'all'
if (!empty($status_query)) {
    // Remove the leading ' AND ' from status_query
    $status_condition = ltrim($status_query, ' AND ');
    $where_conditions[] = $status_condition;
}

// Build the final WHERE clause
$search_query = " WHERE " . implode(' AND ', $where_conditions);

// Count total records
// Count total records (only with transaction_id)
$total_query = "SELECT COUNT(*) as total FROM tbl_booking b WHERE transaction_id != ''";
$total_result = mysqli_query($dbconnect, $total_query);
$total_records = mysqli_fetch_assoc($total_result)['total'];

// Count filtered records (with search)
$filtered_query = "SELECT COUNT(*) as total FROM tbl_booking b" . $search_query;
$filtered_result = mysqli_query($dbconnect, $filtered_query);
$filtered_records = mysqli_fetch_assoc($filtered_result)['total'];

// Get data with pagination
$data_query = "SELECT b.*, p.title_" . $_SESSION['lang'] . " as package_name 
               FROM tbl_booking b 
               LEFT JOIN tbl_packages p ON b.package_id = p.id" . 
               $search_query . 
               " ORDER BY b.id DESC 
               LIMIT $start, $length";

$data_result = mysqli_query($dbconnect, $data_query);

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
            $status_text = direction("Successful","ناجح");
        } else if ($row['status'] == 'No') {
            $status_text = direction("Failed","فاشل");
        } else if ($row['status'] == 'cancel') {
            $status_text = direction("Cancel","ملغي");
        } else {
            $status_text = $row['status'];
        }
        
        $data[] = array(
            $sn++,
            htmlspecialchars($row['created_at']),
            htmlspecialchars($row['transaction_id']),
            htmlspecialchars($row['customer_name']),
            htmlspecialchars($row['mobile_number']),
            $status_text,
            htmlspecialchars($row['id']),
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
mysqli_close($dbconnect);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

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
        $status_query = " AND b.status = 'Cancel'";
    }
}

// Search WHERE clause
$search_query = '';
if (!empty($search_value)) {
    $search_value = mysqli_real_escape_string($dbconnect, $search_value);
    $search_query = " WHERE (customer_name LIKE '%$search_value%' 
                      OR mobile_number LIKE '%$search_value%' 
                      OR transaction_id LIKE '%$search_value%'
                      OR b.created_at LIKE '%$search_value%')
                      AND transaction_id != ''" . $status_query;
} else {
    // If no search but has status filter
    if (!empty($status_query)) {
        $search_query = " WHERE transaction_id != ''" . $status_query;
    }
    // Always add transaction_id != '' for all types
    if (empty($search_query)) {
        $search_query = " WHERE transaction_id != ''";
    }
}

// Count total records
// Get total records (without filtering)
$count_query = "SELECT COUNT(*) as cnt FROM tbl_bookings WHERE transaction_id != ''";
$count_result = mysqli_query($dbconnect, $count_query);
$total_records = 0;
if ($count_result) {
    $row_count = mysqli_fetch_assoc($count_result);
    $total_records = $row_count['cnt'];
}

// Get total records with filtering
$filtered_query = "SELECT COUNT(*) as cnt FROM tbl_bookings b $search_query";
$filtered_result = mysqli_query($dbconnect, $filtered_query);
$filtered_records = 0;
if ($filtered_result) {
    $row_filtered = mysqli_fetch_assoc($filtered_result);
    $filtered_records = $row_filtered['cnt'];
}

// Main data query
$main_query = "SELECT * FROM tbl_bookings b $search_query ORDER BY b.created_at DESC LIMIT $start, $length";
$data_result = mysqli_query($dbconnect, $main_query);
        // Get all personal info fields summary
        $personalInfoSummary = '';
        if (!empty($row['personal_info'])) {
            $personalInfo = json_decode($row['personal_info'], true);
            if ($personalInfo && is_array($personalInfo)) {
                // Fetch field titles from tbl_personal_info
                $fields = array();
                $fieldsResult = mysqli_query($dbconnect, "SELECT * FROM tbl_personal_info WHERE id != '0'");
                if ($fieldsResult) {
                    while ($f = mysqli_fetch_assoc($fieldsResult)) {
                        $fields[$f['id']] = htmlspecialchars(direction($f['enTitle'],$f['arTitle']));
                    }
                }
                $personalInfoArr = array();
                foreach ($personalInfo as $key => $value) {
                    $title = isset($fields[$key]) ? $fields[$key] : $key;
                    $personalInfoArr[] = htmlspecialchars($title) . ': ' . htmlspecialchars($value);
                }
                $personalInfoSummary = implode('<br>', $personalInfoArr);
            }
$data = array();
$sn = $start + 1;

if ($data_result && mysqli_num_rows($data_result) > 0) {
    while ($row = mysqli_fetch_assoc($data_result)) {
        // Format extra items
        
        $extra_items_html = '';
        /*
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
        */
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
        // Get all personal info fields summary
        $personalInfoSummary = '';
        if (!empty($row['personal_info'])) {
            $personalInfo = json_decode($row['personal_info'], true);
            if ($personalInfo && is_array($personalInfo)) {
                // Fetch field titles from tbl_personal_info
                $fields = array();
                $fieldsResult = mysqli_query($dbconnect, "SELECT * FROM tbl_personal_info WHERE id != '0'");
                if ($fieldsResult) {
                    while ($f = mysqli_fetch_assoc($fieldsResult)) {
                        $fields[$f['id']] = direction($f['enTitle'],$f['arTitle']);
                    }
                }
                $personalInfoArr = array();
                foreach ($personalInfo as $key => $value) {
                    $title = isset($fields[$key]) ? $fields[$key] : $key;
                    $personalInfoArr[] = htmlspecialchars($title) . ': ' . htmlspecialchars($value);
                }
                $personalInfoSummary = implode('<br>', $personalInfoArr);
            }
        }
        $data[] = array(
            $sn++,
            htmlspecialchars($row['created_at']),
            htmlspecialchars($row['transaction_id']),
            htmlspecialchars($row['customer_name']),
            $personalInfoSummary ? $personalInfoSummary : htmlspecialchars($row['mobile_number']),
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
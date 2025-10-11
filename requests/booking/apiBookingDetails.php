<?php
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid booking ID']);
    exit();
}
$language = direction("en","ar");
$joinData = array(
    "select" => ["t.*", "t1.{$language}Title as package_name"],
    "join" => ["tbl_packages"],
    "on" => ["t.package_id = t1.id"],
);

if ( $result = selectJoinDB("tbl_booking", $joinData, "t.id = '{$id}'") ) {
    $row = $result[0];
    $extra_items = '';
    if (!empty($row['extra_items'])) {
        $extra_items = array();
        $items = json_decode($row['extra_items']);
        if ($items && is_array($items)) {
            foreach ($items as $item) {
                $extra_items[] = '- ' . htmlspecialchars($item->item) . ' ' . htmlspecialchars($item->price) . ' KD.';
            }
        }
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
    $data = array(
        'S.N.' => htmlspecialchars($row['id']),
        'Invoice Date' => htmlspecialchars($row['created_at']),
        'Transaction ID' => htmlspecialchars($row['transaction_id']),
        'Package Name' => htmlspecialchars($row['package_name'] ?? ''),
        'Package ID' => htmlspecialchars($row['package_id']),
        'Booking Date' => htmlspecialchars($row['booking_date']),
        'Booking Time' => htmlspecialchars($row['booking_time']),
    );
    
    // Add selected themes if available
    if (!empty($row['themes'])) {
        $themesHtml = '';
        $themes = json_decode($row['themes'], true);
        if ($themes && is_array($themes) && count($themes) > 0) {
            $themesHtml .= '<div class="row" style="margin-top:10px;">';
            foreach ($themes as $theme) {
                $themeName = isset($theme['enTitle']) ? htmlspecialchars($theme['enTitle']) : '';
                $themeImage = isset($theme['imageurl']) ? htmlspecialchars($theme['imageurl']) : '';
                $themesHtml .= '<div class="col-xs-6 col-sm-4" style="margin-bottom:15px; text-align:center;">';
                if (!empty($themeImage)) {
                    $themesHtml .= '<img src="../logos/themes/' . $themeImage . '" class="img-responsive" alt="' . $themeName . '" style="width:100%; height:100px; object-fit:cover; border-radius:5px; margin-bottom:5px;">';
                }
                $themesHtml .= '<p style="margin:0; font-size:12px; font-weight:600;">' . $themeName . '</p>';
                $themesHtml .= '</div>';
            }
            $themesHtml .= '</div>';
            $data['Selected Themes'] = $themesHtml;
        }
    }
    
    // Add extra items
    $data['Extra Items'] = !empty($extra_items) ? implode('<br>', $extra_items) : '';
    $data['Booking Price'] = htmlspecialchars($row['booking_price']) . ' KD';
    $data['Status'] = $status_text;
    // Add dynamic customer info fields (personal_info)
    if (!empty($row['personal_info'])) {
        $personalInfo = json_decode($row['personal_info'], true);
        if ($personalInfo && is_array($personalInfo)) {
            // Fetch field titles from tbl_personal_info
            $fields = array();
            if ($fieldsResult = selectDB("tbl_personal_info", "`id` != '0'")) {
                foreach ($fieldsResult as $f) {
                    $fields[$f['id']] = (direction($f['enTitle'], $f['arTitle']));
                }
            }
            foreach ($personalInfo as $key => $value) {
                $title = isset($fields[$key]) ? $fields[$key] : $key;
                $data['Personal: '.htmlspecialchars($title)] = htmlspecialchars($value);
            }
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'error' => 'Booking not found']);
}
?>

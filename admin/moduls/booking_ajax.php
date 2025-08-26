<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

include('../config/database.php');
include('../config/functions.php');

$obj = new Functions();
$conn = $obj->db_connect();
$obj->db_select($conn);

$tbl_name = 'tbl_booking';
$query = $obj->select_data($tbl_name);
$res = $obj->execute_query($conn,$query);
$data = array();
$sn = 1;

if($res)
{
    while($row = $obj->fetch_data($res))
    {
        $package_name = '';
        $package_id = $row['package_id'];
        if($package_id){
            $tbl_name1 = 'tbl_packages';
            $where = 'id='.$package_id;
            $query1 = $obj->select_data($tbl_name1,$where);
            $res1 = $obj->execute_query($conn,$query1);
            if($res1){
                $row1 = $obj->fetch_data($res1);
                $lang = isset($_SESSION['lang'])? $_SESSION['lang'] : 'en';
                $package_name = isset($row1['title_'.$lang]) ? $row1['title_'.$lang] : (isset($row1['title_en']) ? $row1['title_en'] : '');
            }
        }

        $extra_items_html = '';
        if(!empty($row['extra_items'])){
            $rows = json_decode($row['extra_items']);
            if($rows){
                $extra_items_html .= '<ul class="list-unstyled">';
                foreach($rows as $it){
                    $item = htmlspecialchars($it->item);
                    $price = htmlspecialchars($it->price);
                    $extra_items_html .= "<li>- $item $price KD.</li>";
                }
                $extra_items_html .= '</ul>';
            }
        }

        $is_active = ($row['status'] == 'Yes') ? 'Yes' : 'No';

        $data[] = array(
            'sn' => $sn++,
            'package_name' => htmlspecialchars($package_name),
            'customer_name' => htmlspecialchars($row['customer_name']),
            'mobile_number' => htmlspecialchars($row['mobile_number']),
            'baby_name' => htmlspecialchars($row['baby_name']),
            'baby_age' => htmlspecialchars($row['baby_age']),
            'instructions' => htmlspecialchars($row['instructions']),
            'booking_date' => htmlspecialchars($row['booking_date']),
            'booking_time' => htmlspecialchars($row['booking_time']),
            'extra_items' => $extra_items_html,
            'booking_price' => htmlspecialchars($row['booking_price']).'KD',
            'transaction_id' => htmlspecialchars($row['transaction_id']),
            'is_active' => $is_active
        );
    }
}

echo json_encode(array('data' => $data));

?>

<div class="row">
    <div class="panel panel-default card-view">
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>				
</div>


 <?php 
 // get curent month 
 $month = date('m');
if( $res = selectDB("tbl_booking","`status` = 'Yes' AND MONTH(booking_date) = '{$month}'") ){
    $events = array();
    if( count($res) > 0){
        foreach( $res as $row ) {
            $personalInfoArray = array();
            $id = $row['id'];
            $transaction_id = $row['transaction_id'];
            $personalInfo = json_decode($row['personal_info'],true);
            $payload = json_decode($row['payload'],true);    
            $package_name = $payload['CustomerName'];
            $keys = array_keys($personalInfo);
            foreach( $personalInfo as $key => $p ){
                if( $personalInfoDB = selectDB("tbl_personal_info","`id` = '{$key}'")[0] ){
                    $title = direction("enTitle","arTitle");
                    $personalInfoArray[] = "{$personalInfoDB[$title]}: {$p}";
                }
            }
            $personalInfoArray = implode("<br>",$personalInfoArray);
            $booking_date = substr($row['booking_date'],0,10);
            $booking_time = $row['booking_time'];
            $extra_items = $row['extra_items'];
            $booking_price = $row['booking_price'];
            $is_active = $row['status'];
            $tm = explode(' - ',$booking_time);
            $std = $booking_date.' '.$tm[0];
            $startdate = date("Y-m-d H:i:s", strtotime($std));
            $etd = $booking_date.' '.$tm[1];
            $enddate = date("Y-m-d H:i:s", strtotime($etd));
            $e = array();
            $e['id'] = $id;
            $e['title'] = "{$booking_time} - {$package_name} {$personalInfoArray}";
            $e['start'] = $startdate;
            $e['end']   = $enddate;
            $e['color'] = '#f9d8d9ff';
            $e['allDay'] = false;
            // Merge the event array into the return array
            array_push($events, $e);
        }
    }
}
?>
<div class="row">
    <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <a href="<?php echo SITEURL; ?>payment/booking-export.php?page=booking-calendar&export=excel" id="btnExportToExcel" class="btn btn-primary btn-sm">Export to excell</a>
                    <div class="calendar-wrap mt-40">
                        
                        <div id="calendar"></div>
                    </div>
            </div>
        </div>
    </div>				
</div>


 <?php 
$sn = 1;
if($res = selectDB("tbl_booking","`status` = 'Yes'") ){
    if( count($res) > 0){
        foreach($res as $row) {
            $id = $row['id'];
            $transaction_id = $row['transaction_id'];
            $customer_name = $row['customer_name'];
            $mobile_number = $row['mobile_number'];
            $booking_date = $row['booking_date'];
            $booking_time = $row['booking_time'];
            $extra_items = $row['extra_items'];
            $booking_price = $row['booking_price'];
            $is_active = $row['status'];
            $tm = explode('-',$booking_time);
            $std = $row['booking_date'].' '.$tm[0];
            $startdate = date("Y-m-d H:i:s", strtotime($std));
            $etd = $row['booking_date'].' '.$tm[0];
            $enddate = date("Y-m-d H:i:s", strtotime($etd));
            $e = array();
            $e['id'] = $id;
            $e['title'] = $booking_time .' <br> ('.$row['mobile_number'].')'.$row['customer_name'];
            $e['start'] = $startdate;
            $e['end']   = $enddate;
            $e['color'] = '#e7888c';
            $e['allDay'] = false;
            // Merge the event array into the return array
            array_push($events, $e);
        }
    }
}
?>
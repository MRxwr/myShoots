<?php
include('../languages/lang_config.php');
include('../admin/config/apply.php');
include('../includes/functions.php');

if(isset($_GET['export']) AND $_GET['export']=='excel'){
    // Excel file name for download 
   $filename = "booking_export_data-" . date('Ymd') . ".xls"; 
   
    $tbl_name = 'tbl_booking';
	$where = " status='Yes'";
	//$query = $obj->select_data($tbl_name);
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	$sn = 1;

	if($res)
	{
	    $data=array();
		$count_rows= $obj->num_rows($res);
		if($count_rows > 0)
		{
		    $columnHeader = '';  
            $columnHeader = "ID" . "\t" . "Booking ID" . "\t" . "Booking Date" . "\t". "Booking Time" . "\t". "Price" . "\t". "Full Title" . "\t";
		    $setData = '';
			while ($row=$obj->fetch_data($res)) {
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
        		$title =  $booking_time .' <br> ('.$row['mobile_number'].')'.$row['customer_name'];
        		$data = array();
				$data['ID'] = $id;
				$data['Booking ID'] = $transaction_id;
				$data['Booking Date'] = $booking_date;
				$data['Booking Time'] = $booking_time;
				$data['Price'] = $booking_price;
				$data['Title'] = $booking_time .'('.$row['mobile_number'].')'.$row['customer_name'];

                $rowData = ''; 
                foreach($data as $key=>$value) { 
                    
                    $value = '"' . $value . '"' . "\t";  
                    $rowData .= $value;
                } 
             $setData .= $rowData . "\n"; 
			}
           // header("Content-type: application/octet-stream");
            header('Content-Encoding: UTF-8');
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8"); 
            header("Content-Disposition: attachment; filename=\"$filename\""); 
            header("Pragma: no-cache");  
            echo ucwords($columnHeader) . "\n" . $setData . "\n"; 
			
		}
	}
	 exit;
}
?>

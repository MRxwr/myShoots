<?php
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit();
}

// Select all needed columns
$query = "SELECT id, booking_date, booking_time, transaction_id, mobile_number FROM tbl_booking WHERE id = $id";
$result = mysqli_query($dbconnect, $query);
$row = mysqli_fetch_assoc($result);
if ($row) {
    // Here you would integrate with your SMS API
    $booking_date = $row['booking_date'];
    $booking_time = $row['booking_time'];
    $orderId = $row['transaction_id'];
    $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
    $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
    $phone = str_replace($arabic, $english, $row['mobile_number']);
    $mobile = $phone;
    $message="Your booking has been confirmed with myshoots studio, Date: ".$booking_date.", Time:".$booking_time.",Id: ".$orderId;
    $message = str_replace(' ','+',$message);
    $url = 'http://www.kwtsms.com/API/send/?username=ghaliah&password=Gh@li@h91&sender=MyShoots&mobile=965'.$mobile.'&lang=1&message='.$message;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err){
        echo json_encode(['success' => false, 'message' => 'SMS sending failed - ' . $err]);
    }else{
        if (strpos($response, 'ERR') !== false) {
            echo json_encode(['success' => false, 'message' => 'Could not send SMS - ' . $response]);
        } else {
            $update = "UPDATE tbl_booking SET sms = 1 WHERE id = $id";
            mysqli_query($dbconnect, $update);
            echo json_encode(['success' => true, 'message' => 'SMS sent successfully']);
        }
    }
}else{
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
}
mysqli_close($dbconnect);
?>

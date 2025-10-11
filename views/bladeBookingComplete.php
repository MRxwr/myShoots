<?php
date_default_timezone_set('Asia/Riyadh');
$check = ["'",'"',")","(",";","?",">","<","~","!","#","$","%","^","&","*","-","_","=","+","/","|",":"];
if ( isset($_GET["booking_id"]) && !empty($_GET["booking_id"]) ){
  if( $bookingDetails = selectDBNew("tbl_booking",[$_GET["booking_id"]],"`parent_id` = ?","") ){
    $gatewayResponse = json_decode($bookingDetails[0]['gatewayResponse'],true);
    if( isset($gatewayResponse['result']) && $gatewayResponse['result'] != 'CAPTURED' ){
        $error = "Payment not captured, Please try again later.";
        echo "<script>
            alert('Payment not captured, Please try again later.');
            window.location.href = '?v=BookingFailed&error=".urlencode(base64_encode($error))."';
        </script>";die();
    }
    $booking = $bookingDetails[0];
    $orderId = str_pad($booking['id'], 6, "0", STR_PAD_LEFT);
    if( $packageDetails = selectDB("tbl_packages", "`id` = {$booking['package_id']}") ){
      $package = $packageDetails[0];
    } else {
      $error = "Invalid Package.";
      echo "<script>
          alert('Invalid Package.');
          window.location.href = '?v=Home&error=".urlencode(base64_encode($error))."';
      </script>";die();
    }
    $id = $package['id'];
    $price = $package['price'];
    $currency = $package['currency'];
    $post_title = $package[direction("en","ar").'Title'];
    $extra_items = json_decode($booking['extra_items'], true);
    $booking_date = $booking['booking_date'];
    $booking_time  = $booking['booking_time'];

    ///////////////// Check booking slot //////////////////////////////
    $booktimes = get_bookingTimeBydate('', $booking_date);
    $booktimeArr = array(); 
    if(@count($booktimes) != 0){
      foreach($booktimes as $key=>$booktime){		
          $booktimeArr[] = $booktime['booking_time'];
      }
    }
    $times = $package['time'];
    $rows = json_decode($times); 
    $timeSlotAvailable = 0;
    foreach($rows as $row ){
      $time = $row->startDate." - ".$row->endDate;
      if (!in_array($time, $booktimeArr)){
        $timeSlotAvailable = 1;
      } 
    }
  }elseif( $bookingDetails = selectDBNew("tbl_booking",[$_GET["booking_id"]],"`transaction_id` = ?","") ){
    $gatewayResponse = json_decode($bookingDetails[0]['gatewayResponse'],true);
    if( isset($gatewayResponse['result']) && $gatewayResponse['result'] != 'CAPTURED' ){
        $error = "Payment not captured, Please try again later.";
        echo "<script>
            alert('Payment not captured, Please try again later.');
            window.location.href = '?v=BookingFailed&error=".urlencode(base64_encode($error))."';
        </script>";die();
    }
    $booking = $bookingDetails[0];
    $orderId = str_pad($booking['id'], 6, "0", STR_PAD_LEFT);
    if( $packageDetails = selectDB("tbl_packages", "`id` = {$booking['package_id']}") ){
      $package = $packageDetails[0];
    } else {
      $error = "Invalid Package.";
      echo "<script>
          alert('Invalid Package.');
          window.location.href = '?v=Home&error=".urlencode(base64_encode($error))."';
      </script>";die();
    }
    $id = $package['id'];
    $price = $package['price'];
    $currency = $package['currency'];
    $post_title = $package[direction("en","ar").'Title'];
    $extra_items = json_decode($booking['extra_items'], true);
    $booking_date = $booking['booking_date'];
    $booking_time  = $booking['booking_time'];

    ///////////////// Check booking slot //////////////////////////////
    $booktimes = get_bookingTimeBydate('', $booking_date);
    $booktimeArr = array(); 
    if(@count($booktimes) != 0){
      foreach($booktimes as $key=>$booktime){		
          $booktimeArr[] = $booktime['booking_time'];
      }
    }
    $times = $package['time'];
    $rows = json_decode($times); 
    $timeSlotAvailable = 0;
    foreach($rows as $row ){
      $time = $row->startDate." - ".$row->endDate;
      if (!in_array($time, $booktimeArr)){
        $timeSlotAvailable = 1;
      } 
    }

    // Send WhatsApp notification using bookingWhatsapp API
    $whatsappApi = $settingsWebsite . "/requests/index.php?f=booking&endpoint=BookingWhatsapp";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $whatsappApi);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['id' => $booking['id']]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $waResponse = curl_exec($ch);
    curl_close($ch);
    // Optionally, handle $waResponse if needed

    // Send SMS notification using bookingSMS API
    $smsApi = $settingsWebsite . "/requests/index.php?f=booking&endpoint=BookingSMS";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $smsApi);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['id' => $booking['id']]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $smsResponse = curl_exec($ch);
    curl_close($ch);
    // Optionally, handle $smsResponse if needed
?>
<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="card-body p-5">
            <h2 class="shoots-Head2 mb-4 text-center" style="font-weight:700; color:#28a745; letter-spacing:1px;">
              <?php echo direction("Your reservation has been confirmed","تم تأكيد حجزك") ?>
              <span class="theme-bg ml-2" style="border-radius: 30px; color:#FFF; padding: 4px 7px; font-size: 24px;">
                <i class="fa fa-check"></i>
              </span>
            </h2>
            <div class="row">
              <div class="col-12 mb-4">
                <div class="personal-information">
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-secondary"><?php echo direction("Reservation ID","رقم الحجز") ?></label>
                    <input type="text" readonly class="form-control-plaintext" value="<?= $orderId ?>">
                  </div>
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-secondary"><?php echo direction("Package Choosen","الباقة المختارة") ?>:</label>
                    <input type="text" readonly class="form-control-plaintext" value="<?= $post_title ?>">
                  </div>
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-secondary"><?php echo direction("Date","التاريخ") ?>:</label>
                    <input type="text" readonly class="form-control-plaintext" value="<?= $booking_date; ?>">
                  </div>
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-secondary"><?php echo direction("Time","الوقت") ?>:</label>
                    <input type="text" readonly class="form-control-plaintext" value="<?= $booking_time; ?>">
                  </div>
                   <?php
                  // Show extra items if available
                  if (!empty($booking['extra_items'])) {
                    $extraItems = json_decode($booking['extra_items'], true);
                    if (is_array($extraItems) && count($extraItems) > 0) {
                      echo '<label class="font-weight-bold text-secondary">' . direction("Extra Items","الإضافات") . ':</label>';
                      foreach ($extraItems as $item) {
                        $itemName = isset($item['item']) ? htmlspecialchars($item['item']) : '';
                        $itemPrice = isset($item['price']) ? htmlspecialchars($item['price']) : '';
                        echo '<div><strong>' . $itemName . '</strong>';
                        if ($itemPrice !== '') {
                          echo ': ' . $itemPrice . "{$currency}";
                        }
                        echo '</div>';
                      }
                    }
                  }
                  
                  $personalInfo = json_decode($booking['personal_info'], true);
                  if ($personalInfo && is_array($personalInfo)) {
                      $fields = selectDB("tbl_personal_info", "`id` != ' 0'");
                      $titles = array();
                      foreach ($fields as $field) {
                          $titles[$field['id']] = direction('en', 'ar') == 'en' ? $field['enTitle'] : $field['arTitle'];
                      }
                      echo '<div class="form-group mb-3"><label class="font-weight-bold text-secondary">'.direction("Personal Info","معلومات العميل").':</label>';
                      foreach ($personalInfo as $key => $value) {
                          $title = isset($titles[$key]) ? $titles[$key] : $key;
                          echo '<div><strong>'.htmlspecialchars($title).':</strong> '.htmlspecialchars($value).'</div>';
                      }
                      echo '</div>';
                  }
                  ?>
                </div>
              </div>
              <div class="col-12 mb-4">
                <div class="form-group mb-3">
                  <label class="font-weight-bold text-secondary"><?php echo direction("Notes","ملاحظات") ?>:</label>
                  <ul class="list-unstyled h5">
                    <li>- <?php echo direction("You'll receive a WhatsApp message with your reservation details.","سوف تتلقى رسالة واتساب مع تفاصيل حجزك") ?></li>
                    <li>- <?php echo direction("10 days before the session you'll get a reminder WhatsApp message with the studio location.","قبل 10 أيام من الجلسة، ستتلقى رسالة تذكير بموقع الاستوديو على واتساب.") ?></li>
                    <li>- <?php echo direction("10 days before the session to reschedule your reservation.","قبل 10 أيام من الجلسة، يمكنك إعادة جدولة حجزك.") ?></li>
                  </ul>
                </div>
              </div>
              <div class="col-12 text-center">
                <a href="<?php echo $settingsWebsite; ?>" class="btn btn-lg btn-primary rounded-pill px-5 shadow-sm mt-4 w-100" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, <?php echo $websiteColors["button1"] ?> 0%, <?php echo $websiteColors["button2"] ?> 100%); border:none; color:#fff;">
                  <?php echo direction("Back to Home","الرجوع للرئيسية") ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php	
  }
}else{
  $error = "Invalid Booking ID.";
  header("LOCATION: ?v=Home&error=".urlencode(base64_encode($error)));die();
}
?>
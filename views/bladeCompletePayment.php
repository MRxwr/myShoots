<?php
date_default_timezone_set('Asia/Riyadh');

if ( isset($_GET["booking_id"]) && !empty($_GET["booking_id"]) ){
    $booking_id = intval($_GET["booking_id"]);
    
    if( $bookingDetails = selectDB("tbl_booking", "`transaction_id` = '{$booking_id}'") ){
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
        $booking_price = $booking['booking_price'];
        
        // Calculate payment details
        $paymentData = json_decode($booking['payment'], true);
        $paymentType = isset($paymentData['type']) ? $paymentData['type'] : '1'; // 0=partial, 1=full, 2=cash
        $paidAmount = isset($paymentData['amount']) ? floatval($paymentData['amount']) : 0;
        
        // Calculate total and remaining
        $totalAmount = floatval($booking_price);
        $remainingAmount = $totalAmount - $paidAmount;
        
        // Get payment settings for the payment gateway
        if( $bookingSettings = selectDB('tbl_calendar_settings', "`id` = '1'") ){
            $bookingSettings = $bookingSettings[0];
            $paymentSettings = json_decode($bookingSettings['payment'], true);
        }else{
            $bookingSettings = array();
            $paymentSettings = array('type' => '1');
        }
?>
<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="card-body p-5">
            <h2 class="shoots-Head2 mb-4 text-center" style="font-weight:700; color:#3498db; letter-spacing:1px;">
              <?php echo direction("Complete Your Payment","أكمل دفعتك") ?>
              <span class="ml-2" style="border-radius: 30px; background:#3498db; color:#FFF; padding: 4px 7px; font-size: 24px;">
                <i class="fa fa-credit-card"></i>
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
                  
                  <hr class="my-4">
                  
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-secondary"><?php echo direction("Total Booking Amount","المبلغ الإجمالي للحجز") ?>:</label>
                    <input type="text" readonly class="form-control-plaintext" style="font-size: 18px; color: #2c3e50; font-weight: bold;" value="<?= number_format($totalAmount, 3) ?> <?= $currency ?>">
                  </div>
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-secondary"><?php echo direction("Amount Already Paid","المبلغ المدفوع مسبقاً") ?>:</label>
                    <input type="text" readonly class="form-control-plaintext" style="font-size: 18px; color: #27ae60; font-weight: bold;" value="<?= number_format($paidAmount, 3) ?> <?= $currency ?>">
                  </div>
                  <div class="form-group mb-4">
                    <label class="font-weight-bold text-secondary"><?php echo direction("Remaining Amount to Pay","المبلغ المتبقي للدفع") ?>:</label>
                    <input type="text" readonly class="form-control-plaintext" style="font-size: 22px; color: #e74c3c; font-weight: bold;" value="<?= number_format($remainingAmount, 3) ?> <?= $currency ?>">
                  </div>
                   <?php
                  // Show extra items if available
                  if (!empty($booking['extra_items']) && $booking['extra_items'] != '[]') {
                    $extraItems = json_decode($booking['extra_items'], true);
                    if (is_array($extraItems) && count($extraItems) > 0) {
                      echo '<div class="form-group mb-3">';
                      echo '<label class="font-weight-bold text-secondary">' . direction("Extra Items","الإضافات") . ':</label>';
                      echo '<ul class="list-unstyled">';
                      foreach ($extraItems as $item) {
                        $itemName = isset($item['item']) ? htmlspecialchars($item['item']) : '';
                        $itemPrice = isset($item['price']) ? htmlspecialchars($item['price']) : '';
                        echo '<li><strong>' . $itemName . '</strong>';
                        if ($itemPrice !== '') {
                          echo ': ' . $itemPrice . " {$currency}";
                        }
                        echo '</li>';
                      }
                      echo '</ul>';
                      echo '</div>';
                    }
                  }
                  
                  // Show personal info
                  $personalInfo = json_decode($booking['personal_info'], true);
                  if ($personalInfo && is_array($personalInfo)) {
                      $fields = selectDB("tbl_personal_info", "`id` != '0'");
                      $titles = array();
                      foreach ($fields as $field) {
                          $titles[$field['id']] = direction('en', 'ar') == 'en' ? $field['enTitle'] : $field['arTitle'];
                      }
                      echo '<div class="form-group mb-3"><label class="font-weight-bold text-secondary">'.direction("Personal Info","معلومات العميل").':</label>';
                      echo '<ul class="list-unstyled">';
                      foreach ($personalInfo as $key => $value) {
                          $title = isset($titles[$key]) ? $titles[$key] : $key;
                          echo '<li><strong>'.htmlspecialchars($title).':</strong> '.htmlspecialchars($value).'</li>';
                      }
                      echo '</ul>';
                      echo '</div>';
                  }
                  ?>
                </div>
              </div>
              
              <div class="col-12 mb-4">
                <div class="alert alert-info" style="border-left: 4px solid #3498db;">
                  <i class="fa fa-info-circle"></i> 
                  <strong><?php echo direction("Note:","ملاحظة:") ?></strong>
                  <?php echo direction("Please click the button below to proceed to the payment gateway to complete your payment.","يرجى الضغط على الزر أدناه للانتقال إلى بوابة الدفع لإكمال دفعتك.") ?>
                </div>
              </div>
              
              <div class="col-12 text-center">
                <form action="<?php echo $settingsWebsite; ?>/payment/process.php" method="POST" id="payment-form">
                  <input type="hidden" name="id" value="<?= $id ?>">
                  <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                  <input type="hidden" name="is_completion_payment" value="1">
                  <input type="hidden" name="booking_date" value="<?= $booking_date ?>">
                  <input type="hidden" name="booking_time" value="<?= $booking_time ?>">
                  <input type="hidden" name="completion_amount" value="<?= $booking_price ?>">
                  <?php
                  // Pass personal info
                  if ($personalInfo && is_array($personalInfo)) {
                    foreach ($personalInfo as $key => $value) {
                      echo '<input type="hidden" name="personalInfo['.$key.']" value="'.htmlspecialchars($value).'">';
                    }
                  }
                  
                  // Pass extra items
                  if ($extra_items && is_array($extra_items) && count($extra_items) > 0) {
                    foreach ($extra_items as $idx => $item) {
                      $itemString = $item['item'] . ',' . $item['price'];
                      echo '<input type="hidden" name="select_extra_item[]" value="'.htmlspecialchars($itemString).'">';
                    }
                  }
                  ?>
                  <button type="submit" name="submit" class="btn btn-lg btn-primary rounded-pill px-5 shadow-sm mt-4 w-100" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, <?php echo $websiteColors["button1"] ?> 0%, <?php echo $websiteColors["button2"] ?> 100%); border:none; color:#fff;">
                    <i class="fa fa-credit-card mr-2"></i>
                    <?php echo direction("Proceed to Payment","متابعة إلى الدفع") ?>
                  </button>
                </form>
                
                <a href="<?php echo $settingsWebsite; ?>" class="btn btn-lg btn-outline-secondary rounded-pill px-5 shadow-sm mt-3 w-100" style="font-weight:600; letter-spacing:1px;">
                  <i class="fa fa-arrow-left mr-2"></i>
                  <?php echo direction("Back to Home","العودة للرئيسية") ?>
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
    }else{
        $error = "Invalid Booking ID.";
        echo "<script>
            alert('Invalid Booking ID.');
            window.location.href = '?v=Home&error=".urlencode(base64_encode($error))."';
        </script>";die();
    }
}else{
  $error = "Invalid Booking ID.";
  header("LOCATION: ?v=Home&error=".urlencode(base64_encode($error)));die();
}
?>

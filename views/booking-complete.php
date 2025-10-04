<?php
date_default_timezone_set('Asia/Riyadh');
$check = ["'",'"',")","(",";","?",">","<","~","!","#","$","%","^","&","*","-","_","=","+","/","|",":"];
if ( isset($_GET["booking_id"]) && !empty($_GET["booking_id"]) ){
  $orderId = $_GET["booking_id"];
  $booking = get_booking_details($orderId);
  $id = $booking['id'];
  var_dump("amHere2");
  if( $bookingDetails = selectDBNew("tbl_booking",[$_GET["booking_id"]],"`transaction_id` = ?","") ){
    $gatewayResponse = json_decode($bookingDetails[0]['gatewayResponse'],true);
    if( isset($gatewayResponse['result']) && $gatewayResponse['result'] != 'CAPTURED' ){
        header("LOCATION: ?page=booking-faild&error=notCaptured");die();
    } 
    $package = get_packages_details($booking['package_id']);
    $id = $package['id'];
    $price = $package['price'];
    $currency = $package['currency'];
    $post_title = $package[direction("en","ar").'Title'];
    $post_description = $package[direction("en","ar").'Details'];
    $image_url = $package['imageurl'];
    $created_at = $package['created_at'];
    $is_extra = $package['is_extra']; 
    $extra_items = $package['extra_items'];
    $booking_date = $booking['booking_date'];
    $booking_time  = $booking['booking_time'];
    $message="Your booking has been confirmed for myshoots studio, Date: ".$booking_date.", Time:".$booking_time.",Id: ".$orderId;
    sendkwtsms($mobile,$message);
    ///////////////// Check booking slot //////////////////////////////
    $booktimes = get_bookingTimeBydate('', $booking_date);
    $booktimeArr=array(); 
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
      ///////////////////////// Update tbl_disabled_date table /////////////////////
      if( $timeSlotAvailable == 0 ){
        $date = explode('-',$booking_date);
        $booking_date_format = $date[1].'/'.$date[2].'/'.$date[0];
        insertDB("tbl_disabled_date", array("disabled_date" => $booking_date_format) );
      }
?>
   <section>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head2"><?php echo direction("Your reservation has been confirmed","تم تأكيد حجزك") ?>
            <span class="theme-bg ml-2" style="border-radius: 30px; color:#FFF; padding: 4px 7px; font-size: 24px;">
              <i class="fa fa-check"></i>
            </span>
          </h2>
        </div>
        <div class="col-md-10 col-sm-10">
          <div class="personal-information">
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Reservation ID","رقم الحجز") ?></label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?= $orderId ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Package Choosen","الباقة المختارة") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?= $post_title ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Date","التاريخ") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?= $booking_date; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Time","الوقت") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?= $booking_time; ?>">
              </div>
            </div>
            <?php
            // Show client personal info with field titles from tbl_personal_info
            $personalInfo = json_decode($booking['personal_info'], true);
            if ($personalInfo && is_array($personalInfo)) {
                $fields = selectDB("tbl_personal_info", "`id` != ' 0'");
                $titles = array();
                foreach ($fields as $field) {
                    $titles[$field['id']] = direction('en', 'ar') == 'en' ? $field['enTitle'] : $field['arTitle'];
                }
                echo '<div class="form-group row"><label class="col-sm-5 col-md-4 col-form-label">'.direction("Personal Info","معلومات العميل").':</label><div class="col-sm-7 col-md-8">';
                foreach ($personalInfo as $key => $value) {
                    $title = isset($titles[$key]) ? $titles[$key] : $key;
                    echo '<div><strong>'.htmlspecialchars($title).':</strong> '.htmlspecialchars($value).'</div>';
                }
                echo '</div></div>';
            }
            ?>
          </div>
          <div class="form-group row">
            <label for="" class="col-12 col-form-label"><?php echo direction("Notes","ملاحظات") ?>:</label>
            <div class="col-12">
              <ul class="list-unstyled h5">
                <li>- <?php echo direction("You'll receive an SMS with you reservation details.","سوف تتلقى رسالة SMS مع تفاصيل حجزك") ?></li>
                <li>- <?php echo direction("10 days before the session you'll get a remainder SMS with the studio location.","قبل 10 أيام من الجلسة، ستتلقى رسالة تذكير بموقع الاستوديو.") ?></li>
                <li>- <?php echo direction("10 days before the session to reschedule your reservation.","قبل 10 أيام من الجلسة، يمكنك إعادة جدولة حجزك.") ?></li>
              </ul>
            </div>
          </div>
          <div class="row pt-4">
            <div class="col-sm-7 col-md-6">
              <a href="<?php echo $settingsWebsite; ?>" class="btn btn-lg btn-outline-primary btn-block btn-rounded"><?php echo direction("Back to Home","الرجوع للرئيسية") ?></a>
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
  header("LOCATION: ?v=home&error=".urlencode(base64_encode($error)));die();
}
?>
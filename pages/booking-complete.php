<?php
date_default_timezone_set('Asia/Riyadh');
$check = ["'",'"',")","(",";","?",">","<","~","!","#","$","%","^","&","*","-","_","=","+","/","|",":"];
if ( isset($_GET["booking_id"]) && !empty($_GET["booking_id"]) ){
  $orderId = $_GET["booking_id"];
  $booking = get_booking_details($orderId);
  $id = $booking['id'];
  $query = "UPDATE `tbl_booking` SET `status` = 'Yes' WHERE `id` = {$id}";
  $res = $obj->execute_query($conn,$query);
  if( $booking = selectDBNew("tbl_booking",[$id],"`id` = ?","") ){
    $gatewayResponse = json_decode($booking['gatewayResponse'],true);
    if( isset($gatewayResponse['result']) && $gatewayResponse['result'] != 'CAPTURED' ){
        header("LOCATION: ?page=booking-faild&error=notCaptured");die();
    }
    $package = get_packages_details($booking['package_id']);
    $id = $package['id'];
    $price = $package['price'];
    $currency = $package['currency'];
    $post_title = $package['title_'.$_SESSION['lang']];
    $post_description = $package['description_'.$_SESSION['lang']];
    $image_url =$package['image_url'];
    $created_at = $package['created_at'];
    $is_extra = $package['is_extra']; 
    $extra_items = $package['extra_items'];
    $booking_date = $booking['booking_date'];
    $booking_time  = $booking['booking_time'];
    $mobile = $booking['mobile_number'];
    $customer_name = $booking['customer_name'];
    $arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
    $english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
    $phone = str_replace($arabic, $english, $booking['mobile_number']);
    $mobile = $phone;
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
        $data="disabled_date='$booking_date_format'";
        $tbl_name='tbl_disabled_date';
        $query = $obj->insert_data($tbl_name,$data);
        $res = $obj->execute_query($conn,$query);
      }
?>
   <section>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head2"><?php echo $lang['reservation_complete'] ?>
            <span class="theme-bg ml-2" style="border-radius: 30px; color:#FFF; padding: 4px 7px; font-size: 24px;">
              <i class="fa fa-check"></i>
            </span>
          </h2>
        </div>
        <div class="col-md-10 col-sm-10">
          <div class="personal-information">
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['reservation_number'] ?></label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$orderId?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['package_choosen'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$post_title?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['date'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$booking_date;?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['preffered_time'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$booking_time;?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['customer_name'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$booking['customer_name'];?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['mobile_number'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$booking['mobile_number'];?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['baby_name'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$booking['baby_name'];?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['baby_age'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$booking['baby_age'];?> Years">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo $lang['instructions'] ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$booking['instructions'];?>">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="" class="col-12 col-form-label">Note:</label>
            <div class="col-12">
              <ul class="list-unstyled h5">
                <li>- You'll receive an SMS with you reservation details.</li>
                <li>- 10 days before the session you'll get a remainder SMS with the studio location.</li>
                <li>- 10 days before the session to reschedule your reservation.</li>
              </ul>
            </div>
          </div>
          <div class="row pt-4">
            <div class="col-sm-7 col-md-6">
              <a href="<?php echo SITEURL; ?>" class="btn btn-lg btn-outline-primary btn-block btn-rounded"><?php echo $lang['goto_home'] ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>   
<?php	
  }
}
?>
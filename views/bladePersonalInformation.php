<?php 

if( isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) ){ 
  if( $package = selectDBNew("tbl_packages",[$_GET['id']],"`id` = ? AND `status` = '0' AND `hidden` = '1'","") ){
    $package = $package[0];
    $id = $package['id'];
    $price = $package['price'];
    $currency = $package['currency'];
    $post_title = $package[direction("en","ar").'Title'];
    $post_description = $package[direction("en","ar").'Details'];
    $image_url =$package['imageurl'];
    $created_at = $package['created_at'];
    $is_extra = $package['is_extra']; 
    $extra_items = $package['extra_items'];
    $times = $package['time'];
    $personalInfoFields = json_decode($package['personalInfo'], true);
  }else{
    echo "
    <script>
      window.location.href='?v=Home&error=".urlencode(base64_encode(direction("Package not found","الباقة غير موجودة")))."';
    </script>
    ";
    die();
  }
}else{
  echo "
    <script>
      window.location.href='?v=Home&error=".urlencode(base64_encode(direction("package not found","الباقة غير موجودة")))."';
    </script>
    ";
    die();
}
  // Date formate			
  if( isset($_GET['date']) && !empty($_GET['date']) ) {
    $settings = selectDB("tbl_calendar_settings","`id`='1'");
    $openDate = substr($settings[0]["openDate"], 0, 10);
    $closeDate = substr($settings[0]["closeDate"], 0, 10);
    $userDate = $_REQUEST["date"];
    $selectedDate = date('Y-m-d', strtotime(str_replace('/', '-', $userDate)));
    if( ($selectedDate >= $openDate) && ($selectedDate <= $closeDate) ){
      $date = explode('-',$_GET['date']);
      $booking_date = $date[2].'-'.$date[1].'-'.$date[0];	
    } else {
      echo "
      <script>
        window.location.href='?v=Home&error=".urlencode(base64_encode(direction("Selected date is not available","التاريخ المحدد غير متوفر")))."';
      </script>
      ";
      die();
    }			
  } else {
    echo "
    <script>
      window.location.href='?v=Home&error=".urlencode(base64_encode(direction("No date selected","لم يتم تحديد تاريخ")))."';
    </script>
    ";
    die();
  }

  // Get booked time slots for the selected date and package
  $booktimes = get_bookingTimeBydate($_GET['id'],$booking_date);
  $blockedTimeSlots = getBlockedTimeSlots($booking_date);
  $booktimeArr = array(); 
  if( @count($booktimes) != 0 ){
    foreach( $booktimes as $key=>$booktime ){		
      $booktimeArr[] = $booktime['booking_time'];
    }
  }
  array_push($booktimeArr, ...$blockedTimeSlots);
  // end booked time slots for the selected date and package
		  		
?>

<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="row no-gutters align-items-center">
            <div class="col-md-12 p-4 text-center">
              <img src="logos/<?= $image_url ?>" class="img-fluid rounded-4 shadow-sm mb-3" style="max-height:340px; object-fit:cover;">
            </div>
            <div class="col-md-12 p-4">
              <h2 class="shoots-Head2 mb-3" style="font-weight:700; color:#333; letter-spacing:1px;">
                <?php echo direction("Personal Information","معلومات شخصية") ?>
              </h2>
              <form class="personal-information" method="post" action="payment/process.php">
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" id="booking_price" name="booking_price" value="<?php echo $price; ?>" />
                <input type="hidden" id="hid_extra_items" name="hid_extra_items" value='<?php echo $extra_items; ?>' />
                <div class="form-group row mb-3">
                  <label for="" class="col-sm-5 col-md-4 col-form-label font-weight-bold text-secondary"><?php echo direction("Package Choosen","الباقة المختارة") ?>:</label>
                  <div class="col-sm-7 col-md-8">
                    <input type="text" readonly class="form-control-plaintext" id="" value="<?=$post_title?>">
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="" class="col-sm-5 col-md-4 col-form-label font-weight-bold text-secondary"><?php echo direction("Date","التاريخ") ?>:</label>
                  <div class="col-sm-7 col-md-8">
                    <input type="text" readonly class="form-control-plaintext" name="booking_date" id="booking_date" value="<?php if(isset($_GET['date'])){echo $_GET['date']; } ?>">
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="" class="col-sm-5 col-md-4 col-form-label font-weight-bold text-secondary"><?php echo direction("Preferred Time","الوقت المفضل") ?>:</label>
                  <div class="col-sm-7 col-md-8">
                    <select class="form-control form-control-lg rounded-3" id="booking_time" name="booking_time" style="max-width: 300px;" required>
                      <option value = ""  selected disabled><?php echo direction("Select Time","اختر الوقت") ?></option>
                      <?php 
                        $rows = json_decode($times); 
                        foreach($rows as $row ){
                          $time = $row->startDate." - ".$row->endDate;
                          if (!in_array($time, $booktimeArr)) {
                            echo "<option value='".$row->startDate." - ".$row->endDate."'>".$row->startDate." - ".$row->endDate."</option> ";
                          } 
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="" class="col-sm-5 col-md-4 col-form-label font-weight-bold text-secondary"><?php echo direction("Extra","اضافي") ?>:</label>
                  <div class="col-sm-7 col-md-8">
                    <?php 
                      $extra_items_rows = json_decode($extra_items); 
                      $item = "item_".direction("en","ar");
                      foreach($extra_items_rows as $extra_items_row ){
                    ?>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="<?php echo $extra_items_row->$item.",".$extra_items_row->price; ?>" name="select_extra_item[]">
                        <label class="form-check-label" for="defaultCheck1">
                          <span class="form-control-plaintext text-muted"><?php echo $extra_items_row->$item." <span style='color:#ff6b9d;font-weight:600;'>".$extra_items_row->price." KD</span>"; ?></span>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                </div>

                <!-- personal info dynamic fields -->
                <?php
                if (is_array($personalInfoFields)) {
                  foreach ($personalInfoFields as $field) {
                    $label = isset($field[direction('en','ar').'Title']) ? $field[direction('en','ar').'Title'] : (isset($field['enTitle']) ? $field['enTitle'] : $field['arTitle']);
                    $type = isset($field['type']) ? intval($field['type']) : 1;
                    $id = isset($field['id']) ? $field['id'] : '';
                    $name = "personalInfo[$id]";
                    echo '<div class="form-group row mb-3">';
                    echo '<label class="col-sm-5 col-md-4 col-form-label font-weight-bold text-secondary">'.htmlspecialchars($label).':</label>';
                    echo '<div class="col-sm-7 col-md-8">';
                    switch($type) {
                      case 1: // text field
                        echo '<input type="text" class="form-control form-control-lg rounded-3" name="'.$name.'" required >';
                        break;
                      case 2: // textarea
                        echo '<textarea class="form-control form-control-lg rounded-3" name="'.$name.'" required></textarea>';
                        break;
                      case 3: // numbers only
                        echo '<input type="number" class="form-control form-control-lg rounded-3" name="'.$name.'" required >';
                        break;
                      case 4: // email
                        echo '<input type="email" class="form-control form-control-lg rounded-3" name="'.$name.'" required >';
                        break;
                      case 5: // date
                        echo '<input type="date" class="form-control form-control-lg rounded-3" name="'.$name.'" required >';
                        break;
                      case 6: // time
                        echo '<input type="time" class="form-control form-control-lg rounded-3" name="'.$name.'" required >';
                        break;
                      case 7: // phone number (11 digits, English only)
                        echo '<input type="tel" class="form-control form-control-lg rounded-3" name="'.$name.'" pattern="[0-9]{11}" inputmode="numeric" maxlength="11" minlength="11" required placeholder="XXXXXXXXXXX" oninput="this.value=this.value.replace(/[^0-9]/g,\'\');">';
                        break;
                      default:
                        echo '<input type="text" class="form-control form-control-lg rounded-3" name="'.$name.'" required >';
                    }
                    echo '</div>';
                    echo '</div>';
                  }
                }
                ?>
                <!-- end personal info dynamic fields -->
                <div class="form-group row mb-3">
                  <label for="" class="col-sm-5 col-md-4 col-form-label"></label>
                  <div class="col-sm-12 col-md-8">
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="" name="termsandcondition" required>
                      <label class="form-check-label" for="defaultCheck1">
                        <span class="form-control-plaintext"> <?php echo direction("I agree","أوافق") ?> <a href="<?php echo "?v=terms-and-condition"; ?>" target="_blank"><?php echo direction("Terms and Conditions","الشروط والأحكام") ?></a> </span>
                      </label>
                    </div>
                    <div class="reservation">
                      <h5 class="theme-color mt-4">
                        <span><?php echo direction("Deposit","عربون") ?>:</span> <span>30.500 KD</span>
                      </h5>
                      <p class="theme-color mb-1 pl-2">
                        <?php echo direction("Deposit are not refundable.","العربون غير قابل للاسترداد.") ?>
                      </p>
                      <p class="theme-color pl-2">
                        <?php echo direction("0.500 is the payment gateway transaction fees.","0.500 هي رسوم معاملات بوابة الدفع.") ?>
                      </p>
                    </div> 
                  </div>
                </div>
                <div class="row pt-4">
                  <div class="col-sm-5 col-md-4">&nbsp;</div>
                  <div class="col-sm-7 col-md-8">
                    <button type="submit"  name="submit"  class="btn btn-lg btn-primary btn-block rounded-pill shadow-sm" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%); border:none; color:#fff;">
                      <?php echo direction("Continue to Payment","المتابعة إلى الدفع") ?>
                    </button>
                  </div>  
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  
 
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
  }else{
    echo "
    <script>
      window.location.href='?v=home&error=".urlencode(base64_encode(direction("Package not found","الباقة غير موجودة")))."';
    </script>
    ";
    die();
  }
}else{
  echo "
    <script>
      window.location.href='?v=home&error=".urlencode(base64_encode(direction("package not found","الباقة غير موجودة")))."';
    </script>
    ";
    die();
}
  // Date formate			
  if( isset($_GET['date']) && !empty($_GET['date']) ) {
    $settings = selectDB("tbl_settings","`id`='1'");
    $openDate = $settings[0]["open_date"];
    $closeDate = $settings[0]["close_date"];
    $userDate = $_REQUEST["date"];
    $selectedDate = date('Y-m-d', strtotime(str_replace('/', '-', $userDate)));
    if( ($selectedDate >= $openDate) && ($selectedDate <= $closeDate) ){
      $date = explode('-',$_GET['date']);
      $booking_date = $date[2].'-'.$date[1].'-'.$date[0];	
    } else {
      echo "
      <script>
        window.location.href='?v=home&error=".urlencode(base64_encode(direction("Selected date is not available","التاريخ المحدد غير متوفر")))."';
      </script>
      ";
      die();
    }			
  } else {
    echo "
    <script>
      window.location.href='?v=home&error=".urlencode(base64_encode(direction("No date selected","لم يتم تحديد تاريخ")))."';
    </script>
    ";
    die();
  }
  // Get booked time slots for the selected date and package
  $booktimes = get_bookingTimeBydate($_GET['id'],$booking_date);
  $booktimeArr = array(); 
  if( @count($booktimes) != 0 ){
    foreach( $booktimes as $key=>$booktime ){		
      $booktimeArr[] = $booktime['booking_time'];
    }
  }
					
?>

<section>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head2"><?php echo direction("Personal Information","معلومات شخصية") ?></h2>
        </div>
        <div class="col-md-8 col-sm-10">
          <form class="personal-information" method="post" action="payment/process.php">
            
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" id="booking_price" name="booking_price" value="<?php echo $price; ?>" />
            <input type="hidden" id="hid_extra_items" name="hid_extra_items" value='<?php echo $extra_items; ?>' />
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Package Choosen","الباقة المختارة") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" id="" value="<?=$post_title?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Date","التاريخ") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" readonly class="form-control-plaintext" name="booking_date" id="booking_date" value="<?php if(isset($_GET['date'])){echo $_GET['date']; } ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Preferred Time","الوقت المفضل") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <select class="form-control form-control-lg" id="booking_time" name="booking_time" style="max-width: 300px;" required>
                <option value=""  ><?php echo direction("Select Time","اختر الوقت") ?></option>
                <?php 
                    $rows = json_decode($times); 
                    
                     // start slots as per packages
                     
                        foreach($rows as $row ){
							            $time = $row->startDate." - ".$row->endDate;
                            if (!in_array($time, $booktimeArr))
                            {
                            echo "<option value='".$row->startDate." - ".$row->endDate."'>".$row->startDate." - ".$row->endDate."</option> ";
                            } 
                        }
                   ?>
                </select>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Extra","اضافي") ?>:</label>
              <div class="col-sm-7 col-md-8">
               <!-- <label class="form-check-label" for="defaultCheck1">
                	<span class="form-control-plaintext"><?php //echo $lang['filming'] ?></span>
                </label> -->
                
               <?php 
                        $extra_items_rows = json_decode($extra_items); 
						//print_r($extra_items_rows);
						$item = "item_".direction("en","ar");
              foreach($extra_items_rows as $extra_items_row ){
				        ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="<?php echo $extra_items_row->$item.",".$extra_items_row->price; ?>" name="select_extra_item[]">
                  <label class="form-check-label" for="defaultCheck1">
                    <span class="form-control-plaintext"><?php echo $extra_items_row->$item." ".$extra_items_row->price." KD."; ?></span>
                  </label>
                </div>
                <?php
				         }
                ?>
                
              </div>
            </div>

            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Name","الاسم") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" class="form-control form-control-lg" id="customer_name" name="customer_name" required >
              </div>
            </div>

            <div class="form-group row" style="display:none">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Email","البريد الإلكتروني") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="email" class="form-control form-control-lg" id="customer_email" name="customer_email" value="Hello@myshootskw.com" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Mobile Number","رقم الهاتف") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" class="form-control form-control-lg" id="mobile_number" name="mobile_number" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Baby Name","اسم الطفل") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" class="form-control form-control-lg" id="baby_name" name="baby_name">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Baby Age","عمر الطفل") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <input type="text" class="form-control form-control-lg" id="baby_age" name="baby_age">
              </div>
            </div>

            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"><?php echo direction("Instructions","تعليمات") ?>:</label>
              <div class="col-sm-7 col-md-8">
                <textarea name="instructions" id="instructions" class="form-control form-control-lg"  rows="4" placeholder=""></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label for="" class="col-sm-5 col-md-4 col-form-label"></label>
              <div class="col-sm-12 col-md-8">
                  <div class="form-check">
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
                <button type="submit"  name="submit"  class="btn btn-lg btn-outline-primary btn-block btn-rounded"><?php echo direction("Continue to Payment","المتابعة إلى الدفع") ?></button>
              </div>  
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  
 
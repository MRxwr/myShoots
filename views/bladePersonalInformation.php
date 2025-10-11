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
    $themes = json_decode($package['themes'], true);
    $themes_count = isset($package['themes_count']) && !empty($package['themes_count']) ? intval($package['themes_count']) : 1;
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
                
                <!-- Theme Selection Section -->
                <?php if (!empty($themes) && is_array($themes) && count($themes) > 0): ?>
                <div class="form-group row mb-3">
                  <label for="" class="col-sm-5 col-md-4 col-form-label font-weight-bold text-secondary"><?php echo direction("Select Theme","اختر الموضوع") ?>:</label>
                  <div class="col-sm-7 col-md-8">
                    <input type="hidden" id="selected_themes" name="selected_themes" value="" required>
                    <input type="hidden" id="max_themes_count" value="<?php echo $themes_count; ?>">
                    <button type="button" class="btn btn-outline-primary btn-lg rounded-3" id="selectThemesBtn" style="border-width:2px;">
                      <i class="fa fa-image"></i> <?php echo direction("Select Theme(s)","اختر الموضوع/المواضيع") ?>
                      <span id="selectedThemesCount" class="badge badge-primary ml-2" style="display:none;">0</span>
                    </button>
                    <div id="selectedThemesPreview" class="mt-3" style="display:none;">
                      <!-- Selected themes will be displayed here -->
                    </div>
                  </div>
                </div>
                <?php endif; ?>
                <!-- End Theme Selection Section -->
                
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
                          <span class="form-control-plaintext text-muted"><?php echo $extra_items_row->$item." <span style='color:{$websiteColors["button1"]};font-weight:600;'>".$extra_items_row->price." KD</span>"; ?></span>
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
                    <?php 
                    $paymentSettings = json_decode($mainSettings['payment'], true);
                    if( $paymentSettings['type'] == '0' ){
                    ?>
                    <div class="reservation">
                      <h5 class="theme-color mt-4">
                        <span><?php echo direction("Deposit","عربون") ?>:</span> <span><?php echo $paymentSettings['price'] ?>KD</span>
                      </h5>
                    </div> 
                    <?php 
                    }else{
                    ?>
                    <div class="reservation">
                      <h5 class="theme-color mt-4">
                        <span><?php echo direction("Price","السعر") ?>:</span> <span><?php echo $price; ?>KD</span>
                      </h5>
                    </div> 
                    <?php 
                    } 
                    ?>
                  </div>
                </div>
                <div class="row pt-4">
                  <div class="col-sm-5 col-md-4">&nbsp;</div>
                  <div class="col-sm-7 col-md-8">
                    <button type="submit"  name="submit"  class="btn btn-lg btn-primary btn-block rounded-pill shadow-sm" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, <?php echo $websiteColors["button1"] ?> 0%, <?php echo $websiteColors["button2"] ?> 100%); border:none; color:#fff;">
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

<!-- Theme Selection Modal -->
<div class="modal fade" id="themesModal" tabindex="-1" role="dialog" aria-labelledby="themesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(90deg, <?php echo $websiteColors["button1"] ?> 0%, <?php echo $websiteColors["button2"] ?> 100%); color:#fff;">
        <h5 class="modal-title" id="themesModalLabel">
          <?php echo direction("Select Themes","اختر المواضيع") ?>
          <span id="themeSelectionCount" class="badge badge-light ml-2">0 / <?php echo $themes_count; ?></span>
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row" id="themesContainer">
          <?php 
          if (!empty($themes) && is_array($themes)) {
            foreach ($themes as $themeCategory) {
              // Get all themes for this category
              $categoryId = isset($themeCategory['id']) ? $themeCategory['id'] : 0;
              $categoryTitle = isset($themeCategory[direction('en','ar').'Title']) ? $themeCategory[direction('en','ar').'Title'] : '';
              
              if ($categoryId > 0) {
                $themesInCategory = selectDB("tbl_themes", "`category` = '{$categoryId}' AND `status` = '0'");
                
                if ($themesInCategory) {
                  echo '<div class="col-12 mb-3"><h6 class="font-weight-bold text-secondary border-bottom pb-2">'.$categoryTitle.'</h6></div>';
                  
                  foreach ($themesInCategory as $theme) {
                    $themeId = $theme['id'];
                    $themeTitle = $theme[direction('en','ar').'Title'];
                    $themeImage = $theme['image'];
                    ?>
                    <div class="col-md-4 col-sm-6 mb-3">
                      <div class="card theme-card h-100" data-theme-id="<?php echo $themeId; ?>" data-theme-title="<?php echo htmlspecialchars($themeTitle); ?>" data-theme-image="<?php echo htmlspecialchars($themeImage); ?>" style="cursor:pointer; transition: all 0.3s;">
                        <img src="logos/themes/<?php echo $themeImage; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($themeTitle); ?>" style="height:200px; object-fit:cover;">
                        <div class="card-body text-center p-2">
                          <p class="card-text mb-0" style="font-size:14px; font-weight:600;"><?php echo $themeTitle; ?></p>
                          <div class="theme-check-icon" style="display:none; position:absolute; top:10px; right:10px; background:#fff; border-radius:50%; padding:5px;">
                            <i class="fa fa-check-circle" style="color:<?php echo $websiteColors["button1"]; ?>; font-size:24px;"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                }
              }
            }
          }
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo direction("Cancel","إلغاء") ?></button>
        <button type="button" class="btn btn-primary" id="confirmThemesBtn" style="background: linear-gradient(90deg, <?php echo $websiteColors["button1"] ?> 0%, <?php echo $websiteColors["button2"] ?> 100%); border:none;">
          <?php echo direction("Confirm Selection","تأكيد الاختيار") ?>
        </button>
      </div>
    </div>
  </div>
</div>

<style>
.theme-card {
  border: 2px solid transparent;
  position: relative;
}
.theme-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.theme-card.selected {
  border-color: <?php echo $websiteColors["button1"]; ?>;
  box-shadow: 0 0 15px rgba(0,0,0,0.3);
}
</style>
  
 
<?php 
if( isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) ){
  if( $package = selectDBNew("tbl_packages",[$_GET['id']],"`status` = '0' AND `hidden` = '1' AND `id` = ?","") ){
    $package = $package[0];
    $id = $package['id'];
    $price = $package['price'];
    $currency = $package['currency'];
    $post_title = $package[direction("en","ar").'Title'];
    $post_description = $package[direction("en","ar").'Details'];
    $image_url = $package['imageurl'];
    $created_at = $package['created_at'];
    $is_extra = $package['is_extra']; 
    $extra_items = $package['extra_items'];
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
    window.location.href='?v=Home&error=".urlencode(base64_encode(direction("Package not found","الباقة غير موجودة")))."';
  </script>
  ";
  die();
}

?>

<style> 
.legend-available {
  color: #7e97a3ff !important; /* green */
  font-weight: 600;
}
.legend-reserved {
  color: #c4c4c4ff !important; /* red */
  font-weight: 600;
}
/* Reserved (disabled) dates */
.datepicker table tr td.disabled, 
.datepicker table tr td.disabled:hover {
    color: #c4c4c4ff !important;        /* red text */
    opacity: 0.5 !important;
}

/* Available dates (not disabled, not today, not selected, not weekend) */
.datepicker table tr td.day:not(.disabled):not(.active):not(.today):not(.range):not(.weekend) {
    color: #7e97a3ff !important;        /* green text */
}
</style>

<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="row no-gutters align-items-center">
            <div class="col-md-6 p-4">
              <h2 class="shoots-Head mb-3" style="font-weight:700; color:#333; letter-spacing:1px;"><?= $post_title ?></h2>
              <div class="mb-3" style="color:#555; line-height:1.7; font-size:1.1rem;">
                <?= $post_description ?>
              </div>
              <?php if( $is_extra == 1 ){ ?>
                <h5 class="mt-4" style="font-weight:600; color:#ff6b9d;"><?php echo direction("Extra Items","إضافات") ?></h5>
                <ul class="list-unstyled mb-3">
                  <?php 
                  $item = "item_".direction("en","ar");
                  $rows = json_decode($extra_items); 
                  foreach($rows as $row ){
                    echo "<li class='mb-2' style='color:#6c757d;'>• ".$row->$item." <span style='color:#ff6b9d;font-weight:600;'>".$row->price." KD</span></li>";
                  }
                  ?>
                </ul>
              <?php } ?>
            </div>
            <div class="col-md-6 p-4 text-center">
              <img src="logos/<?= $image_url ?>" class="img-fluid rounded-4 shadow-sm mb-3" style="max-height:340px; object-fit:cover;">
            </div>
          </div>
        </div>
        <div class="card shadow-sm border-0 rounded-4 p-4">
          <h5 class="shoots-Head mb-3" style="font-weight:600; color:#333; letter-spacing:1px;"><?php echo direction("Session Reservation","حجز الجلسة") ?></h5>
          <div class="row align-items-end">
            <div class="col-md-8 mb-3 mb-md-0">
              <div class="form-group">
                <input class="form-control form-control-lg rounded-3" id="date" name="date" placeholder="MM/DD/YYYY" type="text" disabled />
                <div id="bookingdate"></div>
              </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
              <ul class="list-inline mb-0">
                <li class="list-inline-item px-2 legend-available"><i class="fas fa-check-circle"></i> <?php echo direction("Available","متاح") ?></li>
                <li class="list-inline-item px-2 legend-reserved"><i class="fas fa-times-circle"></i> <?php echo direction("Reserved","محجوز") ?></li>
              </ul>
            </div>
            <div class="col-md-4 text-md-right">
              <a href="#" class="btn btn-lg btn-primary rounded-pill px-5 shadow-sm" id="booknow" style="font-weight:600; letter-spacing:1px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%); border:none; color:#fff;">
                <?php echo direction("Book Now","احجز الآن") ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

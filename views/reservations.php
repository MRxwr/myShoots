<?php 
if( isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) ){
  if( $package = selectDBNew("tbl_packages",[$_GET['id']],"`status` = '0' AND `hidden` = '1' AND `id` = ?","") ){
    $package = $package[0];
    $id = $package['id'];
    $price = $package['price'];
    $currency = $package['currency'];
    $post_title = $package[direction("en","ar").'title'];
    $post_description = $package[direction("en","ar").'description'];
    $image_url = $package['imageurl'];
    $created_at = $package['created_at'];
    $is_extra = $package['is_extra']; 
    $extra_items = $package['extra_items'];
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
    window.location.href='?v=home&error=".urlencode(base64_encode(direction("Package not found","الباقة غير موجودة")))."';
  </script>
  ";
  die();
}

?>
  <section>
    <div class="container">
      <div class="row">

        <div class="col-12">
          <h2 class="shoots-Head"><?= $post_title ?></h2>
        </div>

        <div class="col-md-6 reservation">
        <?= $post_description ?>
            <?php 
              if( $is_extra == 1 ){ 
              ?>
                <h5><?php echo direction("Extra Items","إضافات") ?></h5>
                <ul class="list-unstyled">
              <?php 
                $item = "item_".direction("en","ar");
                $rows = json_decode($extra_items); 
                foreach($rows as $row ){
                echo "<li>- ".$row->$item." ".$row->price." KD.</li>";
                }
              ?>
                </ul>
            <?php
              } 
            ?>
        </div>

        <div class="col-md-6">
          <img src="logos/<?= $image_url ?>" class="img-rounded img-fluid d-block mx-auto mb-md-0 mb-3">
        </div>

        <div class="col-12 mt-4 reservation-calender-btn">
          <h5 class="shoots-Head"><?php echo direction("Session Reservation","حجز الجلسة") ?></h5>
          <div class="row d-md-flex align-items-end">

            <div class="col-md-8">
              <div class="form-group"> <!-- Date input -->
                <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text" disabled />
                <div id="bookingdate"></div>
              </div>
            </div>
            
            <div class="col-md-4">
              <ul>
                <li style="color: #7d807d;"><?php echo direction("Available","متاح") ?></li>
                <li style="color: #ea9990;"><?php echo direction("Reserved","محجوز") ?></li>
              </ul>
            </div>

            <div class="col-md-4">
              <a href="#" class="btn btn-lg btn-outline-primary btn-rounded px-4" id="booknow"><?php echo direction("Book Now","احجز الآن") ?></a>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>
<!-- Packages Section -->
<section class="py-5">
  <div class="container" style="max-width: 1340px;">
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h2 class="shoots-Head" style="position: relative; display: inline-block; padding-bottom: 15px;">
          <?php echo direction("Packages","الباقات") ?>
          <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);"></span>
        </h2>
      </div>
    </div>
    <div class="row">
    <?php 
      if ( $packages = selectDB("tbl_packages","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ) {
        for( $i = 0; $i < sizeof($packages); $i++ ){
          $package = $packages[$i];
          ?>
          <!-- Package Div Start -->
          <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <a href="<?php echo "?v=reservations&id={$package["id"]}"; ?>" style="text-decoration: none;">
            <div class="package-card card h-100 shadow-sm border-0" style="transition: all 0.3s ease; overflow: hidden; border-radius: 15px;">
              <div class="card-body p-4">
                <div class="row align-items-center">
                  <div class="col-lg-7 col-md-7 col-12 order-md-1 order-2">
                    <h5 class="package-head mb-3" style="font-weight: 600; color: #333;"><?= $package[direction('en','ar')."Title"] ?></h5>
                    <div style="color: #666; line-height: 1.8; margin-bottom: 20px;"><?= $package[direction('en','ar')."Details"] ?></div>
                    <div class="theme-color package-price-tag d-flex align-items-center" style="font-size: 1.2rem; font-weight: 600;">
                      <span style="color: #999; font-size: 0.9rem; margin-right: 8px;"><?php echo direction("Price","القيمة") ?>:</span>
                      <span style="background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $package["price"] ?> <?= $package["currency"] ?></span>
                    </div>
                  </div>
                  <div class="col-lg-5 col-md-5 col-12 order-md-2 order-1 mb-md-0 mb-3">
                    <div style="position: relative; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                      <img src="logos/<?= $package["imageurl"] ?>" class="img-rounded img-fluid d-block mx-auto" style="border-radius: 12px;">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <!-- Package Div End -->
      <?php 
        }
      }
      ?>
    </div>
  </div>
</section>
<!--Package End-->

<style>
.package-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
</style>

<?php 
if( $about = selectDB("tbl_pages","`id` = '7' AND `status` = '0' AND `hidden` = '1'") ){
  $about = $about[0];
}else{
  $about[direction("en","ar")."Details"] = "";
  $about[direction("en","ar")."Title"] = "";
}
?>

<section class="pb-0">
  <div class="container" style="max-width: 1340px;">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="shoots-Head" style="position: relative; display: inline-block; padding-bottom: 15px;">
          <?php echo $about[direction("en","ar")."Title"] ?>
          <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);"></span>
        </h2>
      </div>
    </div>
  </div>
  <div class="container-fluid p-0 bg-light">
    <div class="row no-gutters align-items-center">
      <div class="col-md-7">
        <img src="assets/img/shoots-about.png" class="img-fluid d-block mx-auto">
      </div>
      <div class="col-md-5 p-3 p-md-5">
        <p class="about-para"><?php echo urldecode($about[direction("en","ar")."Details"]); ?></p>
        <a href="?v=galleries" class="btn btn-lg btn-outline-secondary px-5 mt-5"><?php echo direction("Gallery","الصور") ?></a>
      </div>
    </div>
  </div>
</section>

<section class="pb-0">
  <div class="container" style="max-width: 1340px;">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="shoots-Head" style="position: relative; display: inline-block; padding-bottom: 15px;">
          <?php echo direction("Gallery","الصور") ?>
          <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);"></span>
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <?php
        $images = selectDB("tbl_galleries", "`status` = '0' ORDER BY RAND() LIMIT 10");
        if ($images && count($images) > 0) {
        ?>
        <div class="owl-carousel gallery-carousel">
          <?php foreach ($images as $img) { ?>
            <div class="item">
              <img src="logos/<?php echo $img['imageurl']; ?>" class="img-fluid w-100" style="max-height:300px;object-fit:cover;" alt="Gallery Image">
            </div>
          <?php } ?>
        </div>
        <?php } else { ?>
          <p class="text-center text-muted">No images found.</p>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
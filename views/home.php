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

<!-- Gallery Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
  <div class="container" style="max-width: 1340px;">
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h2 class="shoots-Head" style="position: relative; display: inline-block; padding-bottom: 15px; color: #333;">
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
        <div class="owl-carousel gallery-carousel" style="position: relative;">
          <?php foreach ($images as $img) { ?>
            <div class="item" style="padding: 10px;">
              <div style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                <img src="logos/<?php echo $img['imageurl']; ?>" class="img-fluid w-100" style="max-height:350px; object-fit:cover; border-radius: 15px;" alt="Gallery Image">
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.3) 100%); opacity: 0; transition: opacity 0.3s ease;"></div>
              </div>
            </div>
          <?php } ?>
        </div>
        <?php } else { ?>
          <p class="text-center text-muted" style="font-size: 1.1rem; padding: 40px 0;">No images found.</p>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<style>
.gallery-carousel .item > div:hover {
  transform: scale(1.02);
  box-shadow: 0 12px 35px rgba(0,0,0,0.2) !important;
}
.gallery-carousel .item > div:hover > div {
  opacity: 1;
}
.owl-carousel .owl-nav button.owl-prev,
.owl-carousel .owl-nav button.owl-next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: white !important;
  color: #333 !important;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  box-shadow: 0 4px 15px rgba(0,0,0,0.15);
  transition: all 0.3s ease;
}
.owl-carousel .owl-nav button.owl-prev:hover,
.owl-carousel .owl-nav button.owl-next:hover {
  background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%) !important;
  color: white !important;
}
.owl-carousel .owl-nav button.owl-prev {
  left: -25px;
}
.owl-carousel .owl-nav button.owl-next {
  right: -25px;
}
.owl-carousel .owl-dots {
  margin-top: 30px;
}
.owl-carousel .owl-dot span {
  background: #ddd;
  width: 12px;
  height: 12px;
  margin: 5px 7px;
  transition: all 0.3s ease;
}
.owl-carousel .owl-dot.active span {
  background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);
  width: 30px;
  border-radius: 6px;
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

<!-- About Section -->
<section class="py-5">
  <div class="container" style="max-width: 1340px;">
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h2 class="shoots-Head" style="position: relative; display: inline-block; padding-bottom: 15px;">
          <?php echo $about[direction("en","ar")."Title"] ?>
          <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);"></span>
        </h2>
      </div>
    </div>
  </div>
  <div class="container-fluid p-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 0;">
    <div class="row no-gutters align-items-center">
      <div class="col-lg-7 col-md-6 p-0">
        <div style="position: relative; overflow: hidden;">
          <img src="assets/img/shoots-about.png" class="img-fluid d-block mx-auto" style="width: 100%; height: auto;">
        </div>
      </div>
      <div class="col-lg-5 col-md-6 p-5" style="background: white;">
        <div class="about-para" style="color: #555; line-height: 2; font-size: 1.05rem; margin-bottom: 30px;">
          <?php echo urldecode($about[direction("en","ar")."Details"]); ?>
        </div>
        <a href="?v=galleries" class="btn btn-lg px-5 mt-3" style="background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%); color: white; border: none; border-radius: 50px; font-weight: 500; box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3); transition: all 0.3s ease;">
          <?php echo direction("Gallery","الصور") ?>
        </a>
      </div>
    </div>
  </div>
</section>

<style>
.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4) !important;
}
</style>
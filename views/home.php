
<section>
  <div class="container" style="max-width: 1340px;">
    <div class="row">
      <div class="col-12">
        <h2 class="shoots-Head"><?php echo direction("Packages","الباقات") ?></h2>
      </div>
    </div>
    <div class="row no-gutters">
    <?php 
      if ( $packages = selectDB("tbl_packages","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ) {
        for( $i = 0; $i < sizeof($packages); $i++ ){
          $package = $packages[$i];
          ?>
          <!-- Package Div Start -->
          <div class="col-md-6 col-sm-6 col-12">
            <a href="<?php echo "?v=reservations&id={$package["id"]}"; ?>">
            <div class="package-card card m-2">
              <div class="card-body p-2">
                <div class="row align-items-center no-gutters">
                
                  <div class="col-lg-7 col-md-8 col-sm-12 order-lg-1 order-md-1 order-sm-2 order-2">
                  <h5 class="package-head"><?= $package[direction('en','ar')."Title"] ?></h5>
                    <?= $package[direction('en','ar')."Details"] ?>
                    <p class="theme-color package-price-tag text-right">
                      <span><?php echo direction("Price","القيمة") ?>:</span><span class="ml-2"><?= $package["price"] ?> <?= $package["currency"] ?></span></p>
                  </div>
                  <div class="col-lg-5 col-md-4 order-lg-3 order-md-2 order-sm-1 order-1">
                    <img src="logos/<?= $package["imageurl"] ?>" class="img-rounded img-fluid d-block mx-auto mb-md-0 mb-3">
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

<section class="pb-0">
  <div class="container" style="max-width: 1340px;">
    <div class="row">
      <div class="col-12">
        <h2 class="shoots-Head"><?php echo direction("Gallery","الصور") ?></h2>
      </div>
    </div>
  </div>
</section>

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
      <div class="col-12">
        <h2 class="shoots-Head"><?php echo $about[direction("en","ar")."Title"] ?></h2>
      </div>
    </div>
  </div>
  <div class="container-fluid p-0 bg-light">
    <div class="row no-gutters align-items-center">
      <div class="col-md-7">
        <img src="assets/img/shoots-about.png" class="img-fluid d-block mx-auto">
      </div>
      <div class="col-md-5 p-3 p-md-5">
        <h2 class="mb-5"><?php echo direction("Photography","تصوير") ?></h2>
        <h5 class="mb-4"><?php echo direction("Creative Photography Theme","ثيمة تصوير إبداعية") ?></h5>
        <p class="about-para"><?php echo urldecode($about[direction("en","ar")."Details"]); ?></p>
        <a href="?v=galleries" class="btn btn-lg btn-outline-secondary px-5 mt-5"><?php echo direction("Gallery","الصور") ?></a>
      </div>
    </div>
  </div>
</section>
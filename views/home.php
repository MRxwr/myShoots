
  <section>
    <div class="container" style="max-width: 1340px;">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head"><?php echo $lang['our_packages'] ?></h2>
        </div>
      </div>
      <div class="row no-gutters">
      <?php 
  $packages=get_packages();
  foreach($packages as $key=>$package){
          $id = $package['id'];
          $price = $package['price'];
          $currency = $package['currency'];
					$post_title = $package['title_'.$_SESSION['lang']];
          $post_description = $package['description_'.$_SESSION['lang']];
          $image_url =$package['image_url'];
					$created_at = $package['created_at'];
					$is_extra = $package['is_extra']; 
					$extra_items = $package['extra_items'];
     ?>
        <!-- Package Div Start -->
           <div class="col-md-6 col-sm-6 col-12">
              <a href="<?php echo "{$settingsWebsite}/index.php?page=reservations&id={$id}"; ?>">
              <div class="package-card card m-2">
                <div class="card-body p-2">
                  <div class="row align-items-center no-gutters">
                  
                    <div class="col-lg-7 col-md-8 col-sm-12 order-lg-1 order-md-1 order-sm-2 order-2">
                    <h5 class="package-head"><?=$post_title?></h5>
                      <?=$post_description?>
                      <!-- <?php if($is_extra == 1) { ?>
                      <h5><?php //echo $lang['extra_charges'] ?></h5>
                      <ul class="list-unstyled">
						             <?php 
                        // $rows = json_decode($extra_items); 
                        // foreach($rows as $row ){
                        // echo "<li>- ".$row->item." ".$row->price." KD.</li>";
                        //}
                        ?>
                      </ul>
                      <?php } ?> -->
                      <p class="theme-color package-price-tag text-right"><span>Price:</span><span class="ml-2"><?=$price?> <?=$currency?></span></p>
                    </div>
                    <div class="col-lg-5 col-md-4 order-lg-3 order-md-2 order-sm-1 order-1">
                      <img src="<?php echo SITEURL; ?>uploads/images/<?=$image_url?>" class="img-rounded img-fluid d-block mx-auto mb-md-0 mb-3">
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
        <!-- Package Div End -->
  <?php } ?>
        
      </div>
    </div>
  </section>
  <!--Package End-->
  <section class="pb-0">
    <div class="container" style="max-width: 1340px;">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head"><?php echo $lang['follow_us'] ?></h2>
        </div>
      </div>
    </div>
  </section>
  <iframe name="frame" style="width:100%; min-height:350px;" id="frame" src="<?php echo SITEURL; ?>pages/insta.php" allowtransparency="true" frameborder="0"></iframe>

  <section class="pb-0">
    <div class="container" style="max-width: 1340px;">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head"><?php echo $lang['about_us'] ?></h2>
        </div>
      </div>
    </div>
    <div class="container-fluid p-0 bg-light">
      <div class="row no-gutters align-items-center">
        <div class="col-md-7">
          <img src="<?php echo SITEURL; ?>assets/img/shoots-about.png" class="img-fluid d-block mx-auto">
        </div>
        <div class="col-md-5 p-3 p-md-5">
          <h2 class="mb-5">Photography</h2>
          <h5 class="mb-4">Creative Photography Theme</h5>
                <?php 
               $about=get_page_details(7);
               ?>
          <p class="about-para"><?php echo $about['description_'.$_SESSION['lang']]; ?></p>
          <a href="<?php echo SITEURL; ?>index.php?page=galleries" class="btn btn-lg btn-outline-secondary px-5 mt-5">Gallery</a>
        </div>
      </div>
    </div>
  </section>
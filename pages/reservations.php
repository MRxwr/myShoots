<?php 
if( isset($_GET['error']) && !empty($_GET['error']) ){
    $error = $_GET['error'];
    $error = base64_decode(urldecode($error));
    echo "
    <script>
        alert('".$error."');
    </script>
    ";
}
if(isset($_GET['id'])){
  $package = get_packages_details($_GET['id']);
}else{
  $package = get_packages_details(6);
}
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
  <section>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head"><?=$post_title?></h2>
        </div>
        <div class="col-md-6 reservation">
        <?=$post_description?>
           <?php if($is_extra == 1) { ?>
                      <h5><?php echo $lang['extra_charges'] ?></h5>
                      <ul class="list-unstyled">
						<?php 
						$item = "item_".$_SESSION['lang'];
                        $rows = json_decode($extra_items); 
                        foreach($rows as $row ){
                        echo "<li>- ".$row->$item." ".$row->price." KD.</li>";
                        }
                        ?>
                      </ul>
                      <?php } ?>
        </div>
        <div class="col-md-6">
        <img src="<?php echo SITEURL; ?>uploads/images/<?=$image_url?>" class="img-rounded img-fluid d-block mx-auto mb-md-0 mb-3">
         
        </div>

        <div class="col-12 mt-4 reservation-calender-btn">
          <h5 class="shoots-Head"><?php echo $lang['session_reservation'] ?></h5>
          <div class="row d-md-flex align-items-end">
            <div class="col-md-8">
              <div class="form-group"> <!-- Date input -->
                <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text" disabled />
                <div id="bookingdate"></div>
              </div>
            </div>
            <div class="col-md-4">
                        <ul>
      <li style="
    COLOR: #7d807d;
"><?php echo $lang['Available_text'] ?></li>
      <li style="
    color: #ea9990;
"><?php echo $lang['Reserved_text'] ?></li>

      
    </ul>
                  </div>
            <div class="col-md-4">
              <a href="#" class="btn btn-lg btn-outline-primary btn-rounded px-4" id="booknow"><?php echo $lang['book_now'] ?></a>
            </div>
          </div>

        </div>

        <!-- <div class="col-12 mt-4">
          
        </div> -->

      </div>
    </div>
  </section>
  <!--Package End-->
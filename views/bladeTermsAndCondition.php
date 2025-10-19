<?php
if ( $terms = selectDB("tbl_pages", "`id` = '9'") ){
    $terms = $terms[0];
}else{
    $terms = array(
        direction("en","ar")."Details" => '',
        direction("en","ar")."Title" => '',
    );
}
?>
<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="card-body p-5">
            <h2 class="shoots-Head mb-4 text-center" style="font-weight:700; color:#333; letter-spacing:1px;">
              <?php echo $terms[direction("en","ar")."Title"] ?>
            </h2>
            <div class="mb-3" style="font-size:1.1rem; color:#555; line-height:1.7;">
              <?php echo "<p>".urldecode($terms[direction("en","ar")."Details"])."</p>";?>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
if ( $terms = get_page_details(9) ){
}else{
    $terms = array(
        direction("en","ar")."Details" => '',
        direction("ar","en")."Title" => '',
    );
}
?>
<section>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="shoots-Head"><?php echo $terms[direction("ar","en")]."Title" ?></h2>
      </div>
      <div class="col-lg-12">
        <?php echo "<p>{$terms[direction("en","ar")."Details"]}</p>";?>
      </div>
    </div>
  </div>
</section>
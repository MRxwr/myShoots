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
<section>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="shoots-Head"><?php echo $terms[direction("en","ar")."Title"] ?></h2>
      </div>
      <div class="col-lg-12">
        <?php echo "<p>".urldecode($terms[direction("en","ar")."Details"])."</p>";?>
      </div>
    </div>
  </div>
</section>
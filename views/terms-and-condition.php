<section>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="shoots-Head"><?php echo direction("Terms and Conditions","الشروط والاحكام") ?></h2>
        </div>
        <div class="col-lg-12">
          <p>
                <?php 
              $tearm=get_page_details(9);
			        echo $tearm['description_'.direction("en","ar")];
               ?>
               
               </p>
        </div>
        
      </div>
    </div>
  </section>
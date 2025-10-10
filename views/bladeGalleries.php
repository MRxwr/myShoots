<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-12 text-center">
                
              </div>
            </div>
            <div class="row gallery-grid justify-content-center">
              <?php $galleries = get_galleries(''); ?>
              <?php for($col=1;$col<=4;$col++){ ?>
                <div class="col-md-3 col-sm-6 mb-4">
                  <div class="gallery-col">
                    <?php generateGalleryCols($col,$galleries) ?>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  <?php
  function generateGalleryCols($cols,$galleries){
    $cols1 = array(0,4,12,16,20,24);
    $cols2 = array(1,5,8,9,13,17,21,25);
    $cols3 = array(2,6,10,14,18,22,26);
    $cols4 = array(3,7,11,16,19,23,27);
    foreach( $galleries as $key => $gallery ){
      $title = $gallery[direction("en","ar").'Title'];
      $imageurl = $gallery['imageurl'];
      if($cols == 1 && in_array($key,$cols1)){ ?>
        <a class="example-image-link d-block mb-3" img-id="gm-<?php echo $key; ?>" href="logos/<?= $imageurl ?>" data-lightbox="example-set" data-title="<?php echo $title; ?>">
          <img src="logos/<?= $imageurl ?>" class="img-fluid rounded-3 shadow-sm" style="width:100%; object-fit:cover;">
        </a>
      <?php
      }else if($cols == 2 && in_array($key,$cols2)){ ?>
        <a class="example-image-link d-block mb-3" img-id="gm-<?php echo $key; ?>" href="logos/<?= $imageurl ?>" data-lightbox="example-set" data-title="<?php echo $title; ?>">
          <img src="logos/<?= $imageurl ?>" class="img-fluid rounded-3 shadow-sm" style="width:100%; object-fit:cover;">
        </a>
      <?php
      }else if($cols == 3 && in_array($key,$cols3)){ ?>
        <a class="example-image-link d-block mb-3" img-id="gm-<?php echo $key; ?>" href="logos/<?= $imageurl ?>" data-lightbox="example-set" data-title="<?php echo $title; ?>">
          <img src="logos/<?= $imageurl ?>" class="img-fluid rounded-3 shadow-sm" style="width:100%; object-fit:cover;">
        </a>
      <?php
      }else if($cols == 4 && in_array($key,$cols4)){ ?>
        <a class="example-image-link d-block mb-3" img-id="gm-<?php echo $key; ?>" href="logos/<?= $imageurl ?>" data-lightbox="example-set" data-title="<?php echo $title; ?>">
          <img src="logos/<?= $imageurl ?>" class="img-fluid rounded-3 shadow-sm" style="width:100%; object-fit:cover;">
        </a>
      <?php  } 
       } 
  }
  ?>
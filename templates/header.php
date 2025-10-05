<?php 
if( $bookingSettings = selectDB("tbl_settings", "`id` = '1'") ){
    if( is_array($bookingSettings) && sizeof($bookingSettings) > 0 ){
        $bookingSettings = $bookingSettings[0];
    }else{
        $bookingSettings = array();
    }
}
?>
<!DOCTYPE html>
<html <?php echo direction("lang='en'","dir='rtl' lang='ar'") ?> >
<head>
  <meta charset="utf8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta title="description" content="<?php echo $settingsOgDescription ?>">
	<meta title="keywords" content="<?php echo "" ?>">
	<meta title="Author" content="<?php echo "" ?>">
  <title><?php echo $settingsTitle ?></title>
  <!-- Bootstrap core CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <?php if( $directionHTML == 'rtl' ){ ?>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style-nrtl.css?az=2">
  <?php } ?>
  <!--Owl Carousel CSS-->
  <link rel="stylesheet" href="assets/vendor/owlcarousel/owl.carousel.css">
  <link rel="stylesheet" href="assets/vendor/owlcarousel/owl.theme.default.css">
  <!--Lightbox gallery-->
  <link rel="stylesheet" href="assets/css/lightbox.min.css">
  <!-- Custom styles for this template -->
  <link href="assets/css/landing-page.css?y=2" rel="stylesheet">
  <!-- Data table CSS -->
	<link href="admin/assets/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>	
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/> 
  <style>
    .datepicker-inline{
      width: 100%;
    }
    .datepicker table {
      margin: 0;
      width: 100%;
    }
    td.disabled.day {
    color: #e7888c!important; 
    }
    td.today.disabled {
    color: #000!important; 
    }
    html, body {
      max-width: 100%;
      overflow-x: hidden;
    }
    
    /* Modern Navigation Styles */
    .navbar {
      background: rgba(255, 255, 255, 0.98) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      padding: 0.8rem 0;
    }
    
    .navbar-brand img {
      transition: transform 0.3s ease;
    }
    
    .navbar-brand:hover img {
      transform: scale(1.05);
    }
    
    .navbar-nav .nav-item {
      margin: 0 8px;
    }
    
    .navbar-nav .nav-link {
      color: #333 !important;
      font-weight: 500;
      padding: 0.8rem 1.2rem !important;
      position: relative;
      transition: all 0.3s ease;
      border-radius: 8px;
    }
    
    .navbar-nav .nav-link:after {
      content: '';
      position: absolute;
      bottom: 8px;
      left: 50%;
      transform: translateX(-50%) scaleX(0);
      width: 70%;
      height: 2px;
      background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);
      transition: transform 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover:after,
    .navbar-nav .nav-item.active .nav-link:after {
      transform: translateX(-50%) scaleX(1);
    }
    
    .navbar-nav .nav-link:hover {
      background: rgba(255, 107, 157, 0.05);
      color: #ff6b9d !important;
    }
    
    .navbar-nav .dropdown-toggle::after {
      vertical-align: 0.15em;
    }
    
    .dropdown-menu {
      border: none;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
      border-radius: 12px;
      padding: 0.5rem;
      margin-top: 0.5rem;
    }
    
    .dropdown-item {
      border-radius: 8px;
      padding: 0.6rem 1.2rem;
      transition: all 0.3s ease;
      color: #333;
    }
    
    .dropdown-item:hover {
      background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);
      color: white !important;
      transform: translateX(5px);
    }
    
    .navbar-toggler {
      border: 2px solid #ff6b9d;
      border-radius: 8px;
      padding: 0.5rem 0.8rem;
      transition: all 0.3s ease;
    }
    
    .navbar-toggler:hover {
      background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);
      border-color: transparent;
    }
    
    .navbar-toggler:hover .navbar-toggler-icon {
      filter: brightness(0) invert(1);
    }
    
    .navbar-toggler:focus {
      box-shadow: 0 0 0 0.2rem rgba(255, 107, 157, 0.25);
    }
    
    /* Modern Header/Masthead Styles */
    .masthead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 2rem 0;
      position: relative;
      overflow: hidden;
    }
    
    .masthead::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
      background-size: cover;
      opacity: 0.3;
    }
    
    .masthead .container-fluid {
      position: relative;
      z-index: 1;
    }
    
    .masthead .logo-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 200px;
      position: relative;
    }
    
    .masthead .logo-container::after {
      content: '';
      position: absolute;
      top: 50%;
      right: 0;
      width: 1px;
      height: 60%;
      background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.3), transparent);
      transform: translateY(-50%);
    }
    
    .masthead .logo-container img {
      filter: drop-shadow(0 4px 15px rgba(0,0,0,0.15));
      transition: all 0.3s ease;
    }
    
    .masthead .logo-container a:hover img {
      transform: scale(1.05);
    }
    
    .carousel-inner {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    .carousel-item img {
      border-radius: 20px;
      object-fit: cover;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
      width: 50px;
      height: 50px;
      background: rgba(255, 255, 255, 0.9) !important;
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
      opacity: 0.8;
      transition: all 0.3s ease;
    }
    
    .carousel-control-prev {
      left: 20px;
    }
    
    .carousel-control-next {
      right: 20px;
    }
    
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
      opacity: 1;
      background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%) !important;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      width: 24px;
      height: 24px;
    }
    
    .carousel-control-prev:hover .carousel-control-prev-icon,
    .carousel-control-next:hover .carousel-control-next-icon {
      filter: brightness(0) invert(1);
    }
    
    .carousel-indicators {
      bottom: -40px;
    }
    
    .carousel-indicators li {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.5);
      border: none;
      margin: 0 5px;
      transition: all 0.3s ease;
    }
    
    .carousel-indicators li.active {
      width: 30px;
      border-radius: 6px;
      background: linear-gradient(90deg, #ff6b9d 0%, #c471ed 100%);
    }
    
    @media (max-width: 767px) {
      .navbar-nav .nav-item {
        margin: 0;
      }
      
      .navbar-nav .nav-link:after {
        display: none;
      }
      
      .carousel-control-prev,
      .carousel-control-next {
        width: 40px;
        height: 40px;
      }
      
      .carousel-control-prev {
        left: 10px;
      }
      
      .carousel-control-next {
        right: 10px;
      }
      
      .masthead {
        padding: 1rem 0;
      }
      
      .masthead .logo-container {
        min-height: 150px;
      }
    }
 </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white"> 
    <div class="container">

    <a class="navbar-brand d-lg-none" href="<?php echo $settingsWebsite; ?>"><img src="assets/img/logo.png" width="168"></a>
    <button class="<?php echo direction('mr-auto','ml-auto') ?> mr-3 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav <?php echo direction('mr-auto','ml-auto') ?> mx-md-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo $settingsWebsite; ?>"><?php echo direction("Home","الرئيسية") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $settingsWebsite; ?>/?v=galleries"><?php echo direction("Gallery","المعرض") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $settingsWebsite; ?>/?v=reservations-check"><?php echo direction("Reservation","الحجز") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $settingsWebsite; ?>/?v=contact-us"><?php echo direction("Contact Us","تواصل معنا") ?></a>
        </li>
        <li class="nav-item dropdown d-block d-lg-none">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo direction("Language","اللغة") ?></a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php echo $settingsWebsite; ?>/?lang=AR"><?php echo direction("Arabic","العربية") ?></a>
          <a class="dropdown-item" href="<?php echo $settingsWebsite; ?>/?lang=ENG"><?php echo direction("English","English") ?></a>
          </div>
        </li>
      </ul>
    </div>
    
    <div class="d-none d-lg-block">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo direction("Language","اللغة") ?></a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item ar" id="lang_ar" href="<?php echo $settingsWebsite; ?>/?lang=AR"><?php echo direction("Arabic","العربية") ?></a>
          <a class="dropdown-item en" id="lang_en" href="<?php echo $settingsWebsite; ?>/?lang=ENG"><?php echo direction("English","English") ?></a>
          </div>
        </li>
      </ul>
    </div>

    </div>
  </nav>
  
  <?php
  if ( $banners = selectDB("tbl_banners","`status` = '0' AND `hidden` = '1' AND `type` = '1' ORDER BY `rank` ASC") ) {
    $bannersCount = count($banners);
  }else{
    $bannersCount = 0;
  }
  ?>

  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="container-fluid p-0">
      <div class="row no-gutters align-items-center">

        <div class="<?php echo ( $bannersCount > 0 ) ? "col-md-5" : "col-md-12" ?> d-none d-md-block">
          <a href="<?php echo $settingsWebsite; ?>"><img src="assets/img/logo.png" class="w-75 img-fluid .d-sm-none .d-md-block mx-auto py-4"></a>
        </div>

        <div class="col-md-7" <?php echo ( $bannersCount > 0 ) ? "" : "style='display:none'" ?>>
          <div id="demo" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ul class="carousel-indicators">
            <?php 
            for( $i = 0; $i < sizeof($banners); $i++ ){
            ?>
              <li data-target="#demo" data-slide-to="<?php echo $i; ?>" <?php echo $active = ( $i == 0 ) ? "class='active'" : ""; ?>></li>
            <?php
            } 
            ?>
            </ul>
          
            <!-- The slideshow -->
            <div class="carousel-inner">
			      <?php 
            for( $i = 0; $i < sizeof($banners); $i++ ){ 
            ?>
              <div class="carousel-item <?php echo $active = ( $i == 0 ) ? "active" : ""; ?>">
                <img src="<?php echo "logos/".$banners[$i]['image']; ?>" class="img-fluid d-block mx-auto" alt="" style="height:250px;width:100%">
              </div>
            <?php 
			      }
            ?>
            </div>
          
            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
              <span class="carousel-control-next-icon"></span>
            </a>
          
          </div>
        </div>

      </div>
    </div>
  </header>

  
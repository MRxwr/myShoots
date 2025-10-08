<?php 
$platforms = ['instagram','twitter','facebook','snapchat','tiktok','whatsapp'];
$platformsIcons = ['instagram'=>'fab fa-instagram','twitter'=>'fab fa-twitter','facebook'=>'fab fa-facebook','snapchat'=>'fab fa-snapchat-ghost','tiktok'=>'fab fa-tiktok','whatsapp'=>'fab fa-whatsapp'];
$platformURL = ['instagram'=>'https://www.instagram.com/','twitter'=>'https://twitter.com/','facebook'=>'https://www.facebook.com/','snapchat'=>'https://www.snapchat.com/add/','tiktok'=>'https://www.tiktok.com/@','whatsapp'=>'https://wa.me/'];
if( $socialMedia = selectDB("s_media","`id` = '1'")){
  $socialMedia = $socialMedia[0];
}else{
  $socialMedia["instagram"] = "#";
  $socialMedia["twitter"] = "#";
  $socialMedia["facebook"] = "#";
  $socialMedia["snapchat"] = "#";
  $socialMedia["tiktok"] = "#";
  $socialMedia["whatsapp"] = "#";
}
?>

<!-- Footer -->
  <footer class="footer" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0 30px; color: white;">
    <div class="container">
      <div class="row">
        <!-- Sitemap Section -->
        <div class="col-md-6 mb-4 mb-md-0 <?php echo direction('','text-right') ?>">
          <h4 class="mb-4" style="font-weight: 600; color: white;"><?php echo direction("Sitemap","خريطة الموقع") ?></h4>
          <ul class="list-unstyled" style="line-height: 2.2;">
            <li><a href="<?php echo $settingsWebsite; ?>" style="color: rgba(255,255,255,0.9); text-decoration: none; transition: all 0.3s ease;"><i class="fas fa-home <?php echo direction('mr-2','ml-2') ?>"></i><?php echo direction("Home","الرئيسية") ?></a></li>
            <li><a href="<?php echo $settingsWebsite; ?>/?v=galleries" style="color: rgba(255,255,255,0.9); text-decoration: none; transition: all 0.3s ease;"><i class="fas fa-images <?php echo direction('mr-2','ml-2') ?>"></i><?php echo direction("Gallery","المعرض") ?></a></li>
            <li><a href="<?php echo $settingsWebsite; ?>/?v=reservations-check" style="color: rgba(255,255,255,0.9); text-decoration: none; transition: all 0.3s ease;"><i class="fas fa-calendar-check <?php echo direction('mr-2','ml-2') ?>"></i><?php echo direction("Reservation","الحجز") ?></a></li>
            <li><a href="<?php echo $settingsWebsite; ?>/?v=contact-us" style="color: rgba(255,255,255,0.9); text-decoration: none; transition: all 0.3s ease;"><i class="fas fa-envelope <?php echo direction('mr-2','ml-2') ?>"></i><?php echo direction("Contact Us","تواصل معنا") ?></a></li>
          </ul>
        </div>

        <!-- Social Media Section -->
        <div class="col-md-6 <?php echo direction('text-md-right','text-md-right') ?>">
          <h4 class="mb-4" style="font-weight: 600; color: white;"><?php echo direction("Follow Us","تابعنا") ?></h4>
          <ul class="list-inline mb-4" style="display: flex; flex-wrap: wrap; justify-content: <?php echo direction('flex-end','flex-start') ?>;">
            <?php foreach ($platforms as $platform): ?>
              <?php if( empty($socialMedia[$platform]) || $socialMedia[$platform] == "#" ) continue; ?>
              <li class="list-inline-item mb-2" style="margin: 0 8px;">
                <a href="<?php echo $platformURL[$platform].$socialMedia[$platform]; ?>" target="_blank" style="display: inline-block; width: 32px; height: 32px; line-height: 32px; text-align: center; background: rgba(255,255,255,0.2); border-radius: 50%; color: white; transition: all 0.3s ease; text-decoration: none;">
                  <i class="<?php echo $platformsIcons[$platform]; ?>" style="font-size: 1.1rem;"></i>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <hr style="border-color: rgba(255,255,255,0.2); margin: 40px 0 20px;">

      <!-- Copyright Section -->
      <div class="row">
        <div class="col-12 text-center">
          <p class="mb-2" style="color: rgba(255,255,255,0.8); font-size: 0.9rem; justify-self: center;">COPYRIGHT 2020 - <?php echo date('Y'); ?> © <?php echo $settingsTitle ?></p>
          <p class="mb-0" style="color: rgba(255,255,255,0.7); font-size: 0.85rem; justify-self: center;">Powered by <a href="http://www.createkuwait.com/" target="_blank" style="color: white; text-decoration: none; font-weight: 500;">Createkuwait.com</a></p>
        </div>
      </div>
    </div>
  </footer>

  <style>
  .footer a:hover {
    color: white !important;
  }
  <?php if(direction('en','ar') == 'en'){ ?>
  .footer a:hover {
    transform: translateX(5px);
  }
  <?php }else{ ?>
  .footer a:hover {
    transform: translateX(-5px);
  }
  <?php } ?>
  .footer .list-inline-item a:hover {
    background: rgba(255,255,255,0.3) !important;
    transform: scale(1.1) !important;
  }
  </style>
  
  <!-- Bootstrap core JavaScript -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/js/lightbox-plus-jquery.min.js"></script>
    <!-- Bootstrap Date-Picker Plugin -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
  <!-- Data table JavaScript -->
  <script src="assets/vendor/js/jquery.payform.min.js"></script>
  <script src="assets/vendor/js/script.js"></script>
  <script src="assets/vendor/owlcarousel/owl.carousel.js"></script>
	<script src="admin/assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="admin/assets/style/dist/js/dataTables-data.js"></script>

  <?php
  $id = ( isset($_GET['id']) && !empty($_GET['id']) ) ? intval($_GET['id']) : 0;
  var_dump(get_disabledDate());
  $disabledDates = get_disabledDate();
  $openDate = date('Y-m-d'); // Use today's date as lower bound
  $closeDate = get_setting('closeDate');
  // Only include dates between today and closeDate (inclusive)
  $filteredDates = array_filter($disabledDates, function($d) use ($openDate, $closeDate) {
    return ($d >= $openDate && $d <= $closeDate);
  });
  // Convert to d-m-Y for the datepicker
  $blocked_date = json_encode(array_map(function($d){ return date('d-m-Y', strtotime($d)); }, $filteredDates));
  ?>
<script>
$(document).ready(function(){
  // var activeMonth = new Date().getMonth() + 1; // Not used
    var date_input=$('#bookingdate'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
      format: "dd-mm-yyyy",
      inline: true,
      sideBySide: true,
      container: container,
      todayHighlight: true,
      daysOfWeekDisabled: <?= get_setting('weekend') ?>,
      datesDisabled: <?= $blocked_date ?>,
      autoclose: true,
      startDate: new Date( <?= (get_setting('openDate')!='')?str_replace('-',',',get_setting('openDate')):'' ?> ),
      endDate: new Date( <?= (get_setting('closeDate')!='')?str_replace('-',',',get_setting('closeDate')):'' ?> ),
      icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
      },
    };
    date_input.datepicker(options).on('changeDate', showTestDate);

    // When the date is changed, update the hidden input field
    function showTestDate(){
      var value = $('#bookingdate').datepicker('getFormattedDate');
      $("#date").val(value);
    }
    


    // Prevent the right-click menu from appearing
    $("body").on("contextmenu", function (e) {
        e.preventDefault(); 
    });

    // When the "Book Now" button is clicked
    $('#booknow').click(function(){
      var date = $("#date").val();
      if( date != "" ){
        var redirectUrl = "<?php echo $settingsWebsite; ?>/?v=personal-information&id=<?php echo $id; ?>&date=" + date;
        checkDateAndRedirect(date, redirectUrl);
      } else {
        alert("Please select date!"); 
        return false;
      }
    });

    // Owl Carousel
    $('.instagram-carousel').owlCarousel({
      loop: true,
      autoplay: true,
      margin: 10,
      nav: false,
      dots: false,
      responsiveClass: true,
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 4
        },
        1000: {
          items: 6
        }
      }
    });

    // Gallery Carousel
    if ($('.gallery-carousel').length) {
      $('.gallery-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:true,
        responsive:{
          0:{ items:1 },
          768:{ items:2 },
          992:{ items:4 }
        }
      });
    }

    // Search Booking
    $('#book-btn').click(function(){
      var searchquery = $("input#bookingid").val();
      var dataString = 'searchquery='+searchquery;
      if( searchquery != '' ){
        $('#bars1').show();
        $.ajax({
          type:'POST',
          url:'views/getBookingDetailsAjax.php',
          data: dataString,
          success:function(html){
            setTimeout(() => {
              $('#bars1').hide();
              $('#bookingDataDiv').html(html);
              $('#datable_1').DataTable({
                "bFilter": true,
                "bLengthChange": false,
                "bPaginate": true,
                "bInfo": false,
                });
              }, 1000);
          }   
        }); 
      }else{
        alert("Please enter reservation number!");
        return false;
      }
    });

    // Check Booking Date and Time
  $("#booking_time").change(function(){
    var date = $("#booking_date").val();
    var time = this.value;
    var dataString = 'time='+time+'&date='+date;
    $.ajax({
      type:'POST',
      url:'views/checkBookingDateTimeAjax.php',
      data: dataString,
      success:function(result){
        if( result == 1 ){
          $('#continue_to_payment').prop('disabled', true);
          $('#booking_time').prop('selectedIndex',0);
          alert("Please select other time!");
        }else{
          $('#continue_to_payment').prop('disabled', false);
        }
      }
    }); 
    function fetchdata(){
      $.ajax({
        type:'POST',
        url:'views/sessionOutAjax.php',
        data: dataString,
        success:function(result){
          if(result == 1){
            alert("Session Out!!!");
            window.location.href = '<?php echo $settingsWebsite; ?>/v?=reservations&id=<?php echo $id; ?>';
          }
        }
      }); 
    }
    setInterval(fetchdata,900000); // 15 minutes
  });

  // Contact Form
  $("#contactForm").submit(function(event){
    event.preventDefault();
    submitForm();
  });

  // For booking-faild page auto refresh and session out
  <?php
  if(isset($_GET['v'] ) && $_GET['v'] == "booking-faild"){
  ?>
    $(document).ready(function(){
      function fetchdata(){
        $.ajax({
          type:'POST',
          url:'views/sessionOutAjax.php',
          data: '',
          success:function(result){}
        }); 
      }
      setInterval(fetchdata,1000);   
    });
    <?php
  }
  ?> 
});

function truncateDate(date) {
  return new Date(date.getFullYear(), date.getMonth(), date.getDate());
}

// contact form
function submitForm(){
    var name = $("#name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var subject = $("#subject").val();
    var message = $("#message").val();
  $('#bars1').show();
  $.ajax({
    type: "POST",
    url: "views/contactFormAjax.php",
    data: "name=" + name + "&email=" + email + "&phone=" + phone + "&subject=" + subject + "&message=" + message,
    success : function(text){
      if ( text == "success" ){
        formSuccess();
        setTimeout(() => {
          $('#bars1').hide();
          formSuccess();
          }, 1000);
          
      }
    }
  });
}

// Form submission success
function formSuccess(){
    $( "#msgSubmit" ).removeClass( "hidden" );
}

// To reset form on page refresh
window.addEventListener("pageshow", function (event) {
  if ( event.persisted ) {
    document.getElementById("personalInformation").reset();
  }
});

function checkDateAndRedirect(date, redirectUrl) {
  fetch('requests/index.php?f=views&endpoint=CheckDate', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'package_id=' + encodeURIComponent(<?php echo $_GET["id"]; ?>) + '&date=' + encodeURIComponent(date)
  })
  .then(response => response.json())
  .then(data => {
    if (data.ok === true) {
      window.location.href = redirectUrl;
    }else{
      alert((data.data && data.data.message) ? data.data.message : 'Invalid date.');
    }
  })
  .catch(() => {
    alert('Error connecting to server.');
  });
}
</script>   


</body>
</html>

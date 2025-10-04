<?php 
$platforms = ['instagram','twitter','facebook','snapchat','tiktok','whatsapp'];
$platformsIcons = ['instagram'=>'fab fa-instagram','twitter'=>'fab fa-x-square','facebook'=>'fab fa-facebook','snapchat'=>'fab fa-snapchat-ghost','tiktok'=>'fab fa-tiktok','whatsapp'=>'fab fa-whatsapp'];
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
  <footer class="footer text-center " >
    <div class="container">
      <div class="row">
        <div class="col-12 h-100 text-center my-auto">
          <ul class="list-inline mb-5">
            <?php foreach ($platforms as $platform): ?>
              <?php if( empty($socialMedia[$platform]) || $socialMedia[$platform] == "#" ) continue; ?>
              <li class="list-inline-item mr-3">
                <a href="<?php echo $platformURL[$platform].$socialMedia[$platform]; ?>" target="_blank">
                  <i class="<?php echo $platformsIcons[$platform]; ?> fa-fw fa-2x"></i>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>

          <p class="mb-3 text-center" style="text-align: center !important;"><a href="#"><i class="far fa-envelope mr-1"></i> <?php echo strtoupper($bookingSettings['email']) ?></a></p>
          <p class="text-muted mb-5 text-uppercase text-center" style="text-align: center !important;">COPYRIGHT 2020 - <?php echo $settingsTitle ?></p>
          <p class="theme-color text-center" style="text-align: center !important;">Powered by <a href="http://www.createkuwait.com/" target="_blank" class="text-muted">Createkuwait.com</a></p>

        </div>
        

        
      </div>
    </div>
  </footer>
  
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
  $disabledDates = get_disabledDate();
  foreach( $disabledDates as $key => $disabledDate ){
    $disabledDateArr[] = date("d-m-Y", strtotime($disabledDate['disabled_date']));
  }
  // Function call with passing the start date and end date 
  $daterange = getDatesFromRange('2021-06-01', '2021-12-31');
  $allthursdays = getDatesFromRange('2021-01-01', '2021-04-1');
  $blocked_dates_array = array_merge($disabledDateArr,$daterange);
  $blocked_dates_array1 = array_merge($disabledDateArr,$allthursdays);
  $apidatep = array('7-4-2022','13-4-2022','17-4-2022','18-4-2022','19-4-2022','20-4-2022','21-4-2022','24-4-2022','25-4-2022','26-4-2022','27-4-2022','28-4-2022');
  $blocked_dates_array2 = array_merge($blocked_dates_array1,$apidatep);
  $blocked_date = stripslashes(json_encode($blocked_dates_array2));
  ?>
<script>
var dates = ["25/03/2023","1/04/2023","8/04/2023","15/04/2023"];
// Get the elements with class="column"
var elements = document.getElementsByClassName("column");
// Declare a loop variable
var i;

$(document).ready(function(){
    var activeMonth = new Date().getMonth() + 1;
    var date_input=$('#bookingdate'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
      format: "dd-mm-yyyy",
      inline:true,
      sideBySide: true,
      container: container,
      todayHighlight: true,
      daysOfWeekDisabled: [5,6],
      datesDisabled: <?=$blocked_date?>,
      autoclose: true,
      startDate: new Date( <?= (get_setting('open_date')!='')?str_replace('-',',',get_setting('open_date')):'' ?> ),
      endDate: new Date( <?= (get_setting('close_date')!='')?str_replace('-',',',get_setting('close_date')):'' ?> ),
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
    
    // Disable Saturday and Sunday selection
    function disableDates(date) {
      let shouldDisable = false;
      if ( date.getDay() == 5 || date.getDay() == 6 ) {
        shouldDisable = true;
      }
      return [ !shouldDisable || dates.indexOf(date) != -1];
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


function daysOfWeekDisabled(date){
  var year = date.getFullYear();
  var month = date.getMonth();
  var day = date.getDate();
  var dateCheck = day+'/'+month+'/'+year;
  var dateFrom = "23/03/2023";
  var dateTo = "15/04/2023";
  var d1 = dateFrom.split("/");
  var d2 = dateTo.split("/");
  var c = dateCheck.split("/");
  var from = new Date(d1[2], parseInt(d1[1])-1, d1[0]);  // -1 because months are from 0 to 11
  var to   = new Date(d2[2], parseInt(d2[1])-1, d2[0]);
  var check = new Date(c[2], parseInt(c[1])-1, c[0]);
  if (check > from && check < to) {
    return '[6]';
  }else{
    return '[5,6]';
  }
}
  
// Full-width images
function one() {
    for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "100%";  // IE10
    elements[i].style.flex = "100%";
  }
}

// Two images side by side
function two() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "50%";  // IE10
    elements[i].style.flex = "50%";
  }
}

// Four images side by side
function four() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "25%";  // IE10
    elements[i].style.flex = "25%";
  }
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

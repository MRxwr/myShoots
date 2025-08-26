        
        
        <!-- Footer -->
        <footer class="footer text-center " >
        <div class="container">
        <div class="row">
        <div class="col-12 h-100 text-center my-auto">
          <ul class="list-inline mb-5">
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-instagram fa-fw fa-2x"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-twitter-square fa-fw fa-2x"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-facebook fa-fw fa-2x"></i>
              </a>
            </li>
            
          </ul>
        
          <p class="mb-3 text-center" style="text-align: center !important;"><a href="#"><i class="far fa-envelope mr-1"></i> Hello@myshootskw.net</a></p>
          
          <p class="text-muted mb-5 text-uppercase text-center" style="text-align: center !important;">COPYRIGHT 2020 - MYSHOOTS - KUWAIT</p>
          <p class="theme-color text-center" style="text-align: center !important;">Powered by <a href="http://www.create-kw.com/" target="_blank" class="text-muted">Create-kw.com</a></p>
        
        </div>
        
        
        
        </div>
        </div>
        </footer>
        <?php if(!isset($id)){
        $id=0;
        }
        ;?>
        
        <!-- Bootstrap core JavaScript -->
        <script src="<?php echo SITEURL; ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo SITEURL; ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo SITEURL; ?>assets/vendor/js/lightbox-plus-jquery.min.js"></script>
        <!-- Bootstrap Date-Picker Plugin -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/> 
        <style>
        .datepicker-inline{
        width: 100%;
        }
        .datepicker table {
        margin: 0;
        
        width: 100%;
        }
        </style>
        <?php
        $disabledDates = get_disabledDate();
        
        foreach($disabledDates as $key=>$disabledDate){
           $disabledDateArr[] =date("d-m-Y", strtotime($disabledDate['disabled_date'])); ;	
        
        }
        // Function call with passing the start date and end date 
        
        $daterange = getDatesFromRange('2021-06-01', '2021-12-31');
        $allthursdays=getDatesFromRange('2021-01-01', '2021-04-1');
        $blocked_dates_array = array_merge($disabledDateArr,$daterange);
        $blocked_dates_array1 = array_merge($disabledDateArr,$allthursdays);
        //var_dump($blocked_dates_array1);
        $apidatep=array('7-4-2022','13-4-2022','17-4-2022','18-4-2022','19-4-2022','20-4-2022','21-4-2022','24-4-2022','25-4-2022','26-4-2022','27-4-2022','28-4-2022');
        $blocked_dates_array2 = array_merge($blocked_dates_array1,$apidatep);
        $blocked_date=stripslashes(json_encode($blocked_dates_array2));
        //$disabledDate = implode(',', $disabledDateArr);
        ?>
        <script>
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
        //daysOfWeekDisabled: [5], //ramadan days
        daysOfWeekDisabled: [5,6], // normal days
        datesDisabled: <?=$blocked_date?>,
        //beforeShowDay: disableDates,
        autoclose: true,
        //startDate: truncateDate(new Date()),
        startDate: new Date(<?=(get_setting('open_date')!='')?str_replace('-',',',get_setting('open_date')):''?>),
        endDate: new Date(<?=(get_setting('close_date')!='')?str_replace('-',',',get_setting('close_date')):''?>),
        icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
               
                
        
        };
        date_input.datepicker(options).on('changeDate', showTestDate);
        function showTestDate(){
        var value = $('#bookingdate').datepicker('getFormattedDate');
          $("#date").val(value);
        }
        function disableDates(date) {
            let shouldDisable = false;
            if(date.getDay() == 5 || date.getDay() == 6){
              shouldDisable = true;
            }
            //var string = date_input.datepicker.formatDate('dd/mm/yy', date);
            return [ !shouldDisable || dates.indexOf(date) != -1];
        }
        })
        function truncateDate(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }
        var dates = ["25/03/2023","1/04/2023","8/04/2023","15/04/2023"];
        
        
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
            } else {
               return '[5,6]';
            }
        
        
        //return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }
        $(document).ready(function(){
          $('#booknow').click(function(){
         var date = $("#date").val();
         if(date != ""){
          window.location.href = "<?php echo SITEURL; ?>index.php?page=personal-information&id=<?php echo $id; ?>&date="+date;
         } else{
        	alert("Please select date!"); 
        	return false;
         }
        });
        })
        </script>
        
        <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
        
        $(document).ready(function () {
        $("#datepicker").datepicker({
        	dateFormat: 'mm-dd-yy',
            onSelect: function (dateText, inst) {
                var date = $(this).val();
        		$('#date').val(date);
            }
        });
        });
        </script> -->
        <script src="<?php echo SITEURL; ?>assets/vendor/js/jquery.payform.min.js"></script>
        <script src="<?php echo SITEURL; ?>assets/vendor/js/script.js"></script>
        <script src="<?php echo SITEURL; ?>assets/vendor/owlcarousel/owl.carousel.js"></script>
        <script>
        $(document).ready(function() {
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
        })
        })
        </script>
        
        <script>
        // Get the elements with class="column"
        var elements = document.getElementsByClassName("column");
        
        // Declare a loop variable
        var i;
        
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
        
        // Add active class to the current button (highlight it)
        // var header = document.getElementById("myHeader");
        // var btns = header.getElementsByClassName("btn");
        // for (var i = 0; i < btns.length; i++) {
        //   btns[i].addEventListener("click", function() {
        //     var current = document.getElementsByClassName("active");
        //     current[0].className = current[0].className.replace(" active", "");
        //     this.className += " active";
        //   });
        // }
        
        </script>
        	<!-- Data table JavaScript -->
        <script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo SITEURL; ?>admin/assets/style/dist/js/dataTables-data.js"></script>
        
        <script>
        $(document).ready(function(){
        
        $('#book-btn').click(function(){
        
        var searchquery = $("input#bookingid").val();
        var dataString = 'searchquery='+searchquery;
        
        if(searchquery != ''){
        $('#bars1').show();
        $.ajax({
        		type:'POST',
        		url:'pages/getBookingDetailsAjax.php',
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
        } else {
        	alert("Please enter reservation number!");
        	return false;
        }
        });
        
        $("#booking_time").change(function(){
        
        var date = $("#booking_date").val();
        var time = this.value;
        var dataString = 'time='+time+'&date='+date;
        $.ajax({
        		type:'POST',
        		url:'pages/checkBookingDateTimeAjax.php',
        		data: dataString,
        		success:function(result){
        			if(result == 1){
                         $('#continue_to_payment').prop('disabled', true);
                         $('#booking_time').prop('selectedIndex',0);
        				 alert("Please select other time!");
        			} else{
        				$('#continue_to_payment').prop('disabled', false);
                    }
                
        		}
        	}); 
        	
        	function fetchdata(){
        		$.ajax({
        		type:'POST',
        		url:'pages/sessionOutAjax.php',
        		data: dataString,
        		success:function(result){
        			if(result == 1){
        				 alert("Session Out!!!");
        				 window.location.href = '<?php echo SITEURL; ?>index.php?page=reservations&id=<?php echo $id; ?>';
        			}
        		   }
        		}); 
        	}
        	setInterval(fetchdata, 1800000); // 15 minutes
        
        });
        // onsubmit personalInformation
          $("#personalInformation").on("submit", function(e) {
                e.preventDefault(); // Prevent default submission
                
                var date = $("#booking_date").val();
                var time = $("#booking_time").val();
                var dataString = 'time=' + time + '&date=' + date;
        
                $.ajax({
                    type: 'POST',
                    url: 'pages/checkBookingExitsAjax.php',
                    data: dataString,
                    success: function(result) {
                        if (result.trim() === 1) { // Trim to remove spaces/newlines
                            alert("Booking Exists! Please select another date/time.");
                             e.preventDefault(); // Prevent default submission
                        } else {
                            $("#personalInformation")[0].submit(); // Submit form
                        }
                    },
                    error: function() {
                         e.preventDefault(); // Prevent default submission
                    }
                });
            });
        
         $("body").on("contextmenu", function (e) {
            //e.preventDefault(); // Prevent the right-click menu from appearing
         });
        
        });
        
        $("#contactForm").submit(function(event){
            // cancels the form submission
            event.preventDefault();
             submitForm();
        });
        function submitForm(){
            var name = $("#name").val();
             var email = $("#email").val();
            var phone = $("#phone").val();
            var subject = $("#subject").val();
            var message = $("#message").val();
            $('#bars1').show();
            $.ajax({
                type: "POST",
                url: "pages/contactFormAjax.php",
                data: "name=" + name + "&email=" + email + "&phone=" + phone + "&subject=" + subject + "&message=" + message,
                success : function(text){
                    if (text == "success"){
                        formSuccess();
                        setTimeout(() => {
                          $('#bars1').hide();
                          formSuccess();
                          }, 1000);
                        
                    }
                }
            });
        }
        function formSuccess(){
            $( "#msgSubmit" ).removeClass( "hidden" );
        }
        
         window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
              document.getElementById("personalInformation").reset();
            }
          });
        
        </script>   

        <?php
        if(isset($_GET['page'] ) && $_GET['page'] == "booking-faild"){
        ?>
        <script>
        $(document).ready(function(){
        
        function fetchdata(){
        		$.ajax({
        		type:'POST',
        		url:'pages/sessionOutAjax.php',
        		data: '',
        		success:function(result){
        			if(result == 1){
        				// alert("Session Out!!!");
        				
        			}
        		   }
        		}); 
        	}
        	//setInterval(fetchdata,1000);   
        });
        </script>	
        <?php } ?>
        </body>
        
        </html>

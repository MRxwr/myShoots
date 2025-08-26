
</div>
    <!-- /#wrapper -->
	
	<!-- JavaScript -->
	
    <!-- jQuery -->
    <script src="assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- wysuhtml5 Plugin JavaScript -->
	<script src="assets/vendors/bower_components/wysihtml5x/dist/wysihtml5x.min.js"></script>
	
  <script src="assets/vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js"></script>
  
  <script src="assets/vendors/bower_components/moment/min/moment.min.js"></script>
	<script src="assets/vendors/jquery-ui.min.js"></script>
  <script src="assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <?php 
	$tbl_name = 'tbl_booking';
	$where = " status='Yes'";
	//$query = $obj->select_data($tbl_name);
	$query = $obj->select_data($tbl_name,$where);
	$res = $obj->execute_query($conn,$query);
	$sn = 1;

	if($res)
	{
		$count_rows= $obj->num_rows($res);
		if($count_rows > 0)
		{
			while ($row=$obj->fetch_data($res)) {
				$id = $row['id'];
				$transaction_id = $row['transaction_id'];
				$customer_name = $row['customer_name'];
				$mobile_number = $row['mobile_number'];
				$booking_date = $row['booking_date'];
				$booking_time = $row['booking_time'];
				$extra_items = $row['extra_items'];
				$booking_price = $row['booking_price'];
        $is_active = $row['status'];
        $tm = explode('-',$booking_time);
        $std = $row['booking_date'].' '.$tm[0];
        $startdate = date("Y-m-d H:i:s", strtotime($std));
        $etd = $row['booking_date'].' '.$tm[0];
        $enddate = date("Y-m-d H:i:s", strtotime($etd));
				$e = array();
				$e['id'] = $id;
				$e['title'] = $booking_time .' <br> ('.$row['mobile_number'].')'.$row['customer_name'];
				$e['start'] = $startdate;
        $e['end']   = $enddate;
        $e['color'] = '#e7888c';
				$e['allDay'] = false;
				// Merge the event array into the return array
				array_push($events, $e);
			}
		}
	}
	
  ?>
	<script>
    /*FullCalendar Init*/
$(document).ready(function() {
	'use strict';
	
    var drag =  function() {
        $('.calendar-event').each(function() {

        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim($(this).text()), // use the element's text as the event title
            stick: true // maintain when user navigates (see docs on the renderEvent method)
        });

        
    });
    };
    
    var removeEvent =  function() {
		$(document).on('click','.remove-calendar-event',function(e) {
			$(this).closest('.calendar-event').fadeOut();
        return false;
    });
    };
    
    $(".add-event").keypress(function (e) {
        if ((e.which == 13)&&(!$(this).val().length == 0)) {
            $('<div class="btn btn-success calendar-event">' + $(this).val() + '<a href="javascript:void(0);" class="remove-calendar-event"><i class="ti-close"></i></a></div>').insertBefore(".add-event");
            $(this).val('');
        } else if(e.which == 13) {
            alert('Please enter event name');
        }
        drag();
        removeEvent();
    });
    
    
    drag();
    removeEvent();
    
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth();
    var year = date.getFullYear();
    
    $('#calendar').fullCalendar({
       
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            eventLimit: false, // allow "more" link when too many events
            timeFormat: 'H:mm',
        	
        eventMouseover: function (data, event, view) {
			var tooltip = '<div class="tooltiptopicevent tooltip tooltip-inner" style="width:auto;height:auto;position:absolute;z-index:10001;">' + data.title + '</div>';
			$("body").append(tooltip);
            $(this).mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltiptopicevent').fadeIn('500');
                $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltiptopicevent').css('top', e.pageY + 10);
                $('.tooltiptopicevent').css('left', e.pageX + 20);
            });
        },
        eventRender: function( event, element, view ) {
        var title = element.find('.fc-title, .fc-list-item-title');          
        title.html(title.text());
        },
        dayClick: function () {
            tooltip.hide()
        },
        eventResizeStart: function () {
            tooltip.hide()
        },
        eventDragStart: function () {
            tooltip.hide()
        },
        viewDisplay: function () {
            tooltip.hide()
        },
			events: <?php echo json_encode($events)?>
		});
 
});

  </script>
	
	<!-- Fancy Dropdown JS -->
	<script src="assets/style/dist/js/dropdown-bootstrap-extended.js"></script>
	
	<!-- Bootstrap Wysuhtml5 Init JavaScript -->
	<script src="assets/style/dist/js/bootstrap-wysuhtml5-data.js"></script>
	
	<!-- Slimscroll JavaScript -->
  <script src="assets/style/dist/js/jquery.slimscroll.js"></script>
  
  <!-- Progressbar Animation JavaScript -->
	<script src="assets/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="assets/vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="assets/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Switchery JavaScript -->
	<script src="assets/vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	<!-- Init JavaScript -->
	<script src="assets/style/dist/js/init.js"></script>
    
    <!-- Bootstrap Daterangepicker JavaScript -->
		<script src="assets/vendors/bower_components/dropify/dist/js/dropify.min.js"></script>
	
    <!-- Form Flie Upload Data JavaScript -->
		<script src="assets/style/dist/js/form-file-upload-data.js"></script>
        
        	<!-- Data table JavaScript -->
	<script src="assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="assets/style/dist/js/dataTables-data.js"></script>
     <script src="assets/js/custom.js"></script>   
     
     
      <!-- Bootstrap Date-Picker Plugin -->
<script type= "text/javascript" src= "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel= "stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script type="text/javascript">
$(document).ready(function(){
    $("#datepicker").datepicker();
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
    });
});
</script>
   
<script src="assets/js/mdtimepicker.js"></script>
<script>
  $(document).ready(function(){
    $('.timepicker').mdtimepicker(); //Initializes the time picker
	$('.timepicker1').mdtimepicker();
  });
</script>  

   <script type="text/javascript">//<![CDATA[


var i = 0;

$(document).on('click','.delete', function(e) {
   $(this).closest('.form-group-delete').remove();//remove
	--i;
	console.log('removed');
});

$(document).on('click','.timepicker', function(e) {
   $(this).closest('.timepicker').mdtimepicker();//remove
});

$('#comm').click(function(){
if (i <=3){	
$('<div class="row form-group-delete" ><div class="col-sm-4"><label class="control-label mb-10 text-left"><?php echo $lang['start_time'] ?></label><div class="form-group"><div class="input-group"><input type="text" class="form-control timepicker" name="sDate" data-name="startDate" value="" autocomplete="off"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div></div></div><div class="col-sm-4"><label class="control-label mb-10 text-left"><?php echo $lang['end_time'] ?></label><div class="form-group"><div class="input-group"><input type="text" class="form-control timepicker" name="eDate"  data-name="endDate" value="" autocomplete="off"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div></div></div><div class="col-sm-4"><button type="button" class="btn-primary btn-sm delete" id="minusButton"><?php echo $lang['delete'] ?></button></div></div>').appendTo('#email');
i++; }

});

$(function () { 
    $(document).on('click', '#submit', function (e) {
		
        var dataGroup = [];
        $('.form-group-delete').each(function () {
            var emailData = {};
            $(this).find(':input[data-name]').each(function () {
                emailData[$(this).data('name')] = $(this).val();
				//console.log($(this).val());
				//console.log(emailData);
            });
            dataGroup.push(emailData);
        });      
       // console.log(dataGroup);
               $('#alltime').val(JSON.stringify(dataGroup))
    });
   

})

  //]]>
  
  var bookingCancel = function(id){
      var r = confirm("<?=$lang['cancel_confirm']?>");
      if (r == true) {
        //var id = this.id;
        //var cancel_url = "index.php?page=booking-success&type=cancel&id="+ id;
        //window.location.href = cancel_url;
        $.ajax({
				type:'POST',
				url:'moduls/cancelAjax.php',
				data: {id:id,type:'cancel'},
				success:function(res){
         if(res=='ok'){
          var cancel_url = "index.php?page=booking-cancel";
          window.location.href = cancel_url;
         }
				}
			 }); 
      } 
    } 
     var bookingRefund = function(id){
      var r = confirm("<?=$lang['refund_confirm']?>");
      if (r == true) {
       
        $.ajax({
				type:'POST',
				url:'moduls/refundAjax.php',
				data: {id:id,type:'refund'},
				success:function(res){
         if(res=='ok'){
          var cancel_url = "index.php?page=booking-cancel";
          window.location.href = cancel_url;
         }
				}
			 }); 
      } 
    } 
     var sendSms = function(id){
     var r = confirm("<?=$lang['sms_confirm']?>");
      if (r == true) {
           $.ajax({
				type:'POST',
				url:'moduls/smsAjax.php',
				data: {id:id},
				success:function(res){
                if(res=='ok'){
                    alert("<?=$lang['sms_success']?>");
                 var cancel_url = "index.php?page=booking-success";
                  window.location.href = cancel_url;
                 }
				}
			 }); 
      } 
    }
  </script>   
</body>

</html>

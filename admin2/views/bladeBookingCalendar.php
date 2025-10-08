<div class="row">
		<div class="panel panel-default card-view">
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<a href="<?php echo SITEURL; ?>payment/booking-export.php?page=booking-calendar&export=excel" id="btnExportToExcel" class="btn btn-primary btn-sm">Export to excell</a>
						<div class="calendar-wrap mt-40">
							
							<div id="calendar"></div>
						</div>
				</div>
			</div>
		</div>				
	</div>

<script src="assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
 <?php 
$sn = 1;
if($res = selectDB("tbl_booking","`status` = 'Yes'") ){
    if( count($res) > 0){
        foreach($res as $row) {
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
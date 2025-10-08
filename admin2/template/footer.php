</div>
	<footer class="footer container-fluid pl-30 pr-30">
		<div class="row">
			<div class="col-sm-12">
				<p>2020 &copy; Createkuwait.com - E-Commerce System</p>
			</div>
		</div>
	</footer>
	</div>
        <!-- /Main Content -->
    </div>

	<!-- Tinymce JavaScript -->
	<script src="../vendors/bower_components/tinymce/tinymce.min.js"></script>
						
	<!-- Tinymce Wysuhtml5 Init JavaScript -->
	<script src="dist/js/tinymce-data.js"></script>
    <!-- jQuery -->
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Data table JavaScript -->
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="dist/js/productorders-data.js"></script>
	<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
	<script src="../vendors/bower_components/pdfmake/build/pdfmake.min.js"></script>
	<script src="../vendors/bower_components/pdfmake/build/vfs_fonts.js"></script>

	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="dist/js/export-table-data.js"></script>

	<!-- Slimscroll JavaScript -->
	<script src="dist/js/jquery.slimscroll.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>

	<!-- Bootstrap Select JavaScript -->
	<script src="../vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	
	<!-- Select2 JavaScript -->
	<script src="../vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
	
	<!-- Sweet-Alert  -->
	<script src="../vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
	<script src="dist/js/sweetalert-data.js"></script>
	
	<!-- Moment.js (required for bootstrap-datetimepicker and fullCalendar) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

	<!-- Bootstrap Datetimepicker JavaScript -->
	<script type="text/javascript" src="../vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Switchery JavaScript -->
	<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="dist/js/dropdown-bootstrap-extended.js"></script> 
		
	<!-- Init JavaScript -->
	<script src="dist/js/init.js?x=1"></script>
	<script src="../vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
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
    
    var now = moment();
    var startOfMonth = now.clone().startOf('month');
    var endOfMonth = now.clone().endOf('month');
    $('#calendar').fullCalendar({
       
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            defaultDate: startOfMonth,
            height: 'auto',
            fixedWeekCount: false,
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
			defaultDate: now.format('YYYY-MM-DD'),
			validRange: {
				start: startOfMonth.format('YYYY-MM-DD'),
				end: endOfMonth.format('YYYY-MM-DD')
			},
			events: <?php echo json_encode($events)?>
		});
 
});
</script>
</body>
</html>
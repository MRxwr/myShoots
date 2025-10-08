<div class="row heading-bg">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h5 class="txt-dark"><?php echo direction("Bookings", "الحجوزات") ?></h5>
    </div>
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <!-- Loading Spinner Container -->
                        <div id="loading-spinner" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; display: none;">
                            <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite;" role="status">
                            </div>
                        </div>
                        <style>
                            @keyframes spin {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                            
                            /* Fix for pagination in mobile view */
                            @media (max-width: 767px) {
                                .dataTables_wrapper .dataTables_paginate {
                                    margin-bottom: 60px !important; /* Add bottom margin for footer clearance */
                                    padding-bottom: 20px !important;
                                    float: none !important;
                                    text-align: center !important;
                                    clear: both !important;
                                }
                                
                                .dataTables_info {
                                    margin-bottom: 15px !important;
                                    text-align: center !important;
                                    width: 100% !important;
                                }
                            }
                        </style>
                        <!-- Status Filter Buttons -->
                        <div class="mb-20" style="margin-bottom: 20px;">
                            <div class="btn-group" role="group" aria-label="Status Filters" style="gap: 10px;">
                                <button type="button" class="btn btn-default status-filter active" data-status="all" style="margin-right:10px;"><?php echo direction("All", "الكل") ?></button>
                                <button type="button" class="btn btn-success status-filter" data-status="Yes" style="margin-right:10px;"><?php echo direction("Success", "ناجح") ?></button>
                                <button type="button" class="btn btn-danger status-filter" data-status="No" style="margin-right:10px;"><?php echo direction("Failed", "فاشل") ?></button>
                                <button type="button" class="btn btn-warning status-filter" data-status="Cancel"><?php echo direction("Cancelled", "ملغي") ?></button>
                            </div>
                        </div>
                        <div class="table-wrap">
                            <div class="table-responsive" id="data-table-container">
                                <table id="datable_1" class="table table-hover display  pb-30" >
                                    <thead>
                                        <tr>
                                            <th><?php echo direction("#","#") ?></th>
                                            <th><?php echo direction("Invoice Date", "تاريخ الفاتورة") ?></th>
                                            <th><?php echo direction("Transaction ID", "رقم المعاملة") ?></th>
                                            <th><?php echo direction("Package", "الباقة") ?></th>
                                            <th><?php echo direction("Personal Info", "معلومات العميل") ?></th>
                                            <th><?php echo direction("Is Active", "مفعل") ?></th>
                                            <th><?php echo direction("Actions", "الإجراءات") ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
<!-- /Row -->
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="detailsModalLabel"><?php echo direction("Booking Details", "تفاصيل الحجز") ?></h4>
            </div>
            <div class="modal-body">
                <!-- Details will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo direction("Close", "إغلاق") ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rescheduleModalLabel"><?php echo direction("Reschedule Booking", "إعادة جدولة الحجز") ?></h4>
            </div>
            <div class="modal-body">
                <form id="reschedule-form">
                    <input type="hidden" id="reschedule-booking-id" name="booking_id">
                    <input type="hidden" id="package-id" name="package_id">
                    
                    <div class="form-group">
                        <label for="current-booking-date"><?php echo direction("Current Date", "التاريخ الحالي") ?></label>
                        <input type="text" class="form-control" id="current-booking-date" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="current-booking-time"><?php echo direction("Current Time", "الوقت الحالي") ?></label>
                        <input type="text" class="form-control" id="current-booking-time" readonly>
                    </div>
                    
                    <hr>
                    
                    <div class="form-group">
                        <label for="reschedule-date"><?php echo direction("New Date", "التاريخ الجديد") ?></label>
                        <input type="text" class="form-control" id="reschedule-date" name="new_date" placeholder="Select a date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="reschedule-time"><?php echo direction("New Time", "الوقت الجديد") ?></label>
                        <select class="form-control" id="reschedule-time" name="new_time" required>
                            <option value="" selected disabled><?php echo direction("Select date first", "اختر التاريخ أولا") ?></option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo direction("Cancel", "إلغاء") ?></button>
                <button type="button" class="btn btn-primary" id="reschedule-submit"><?php echo direction("Reschedule", "إعادة جدولة") ?></button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Show loading spinner and dim the table
    function showLoading() {
        $('#loading-spinner').css('display', 'block');
        $('#data-table-container').css('opacity', '0.5');
    }
    // Hide loading spinner and restore table opacity
    function hideLoading() {
        $('#loading-spinner').css('display', 'none');
        $('#data-table-container').css('opacity', '1');
    }
    // Show spinner before DataTable initialization
    showLoading();
    // Current active status filter
    var currentStatus = 'all';
    var successBooking = '<?php echo direction("Successful","ناجح"); ?>';
    var failedBooking = '<?php echo direction("Failed","فاشل"); ?>';
    var cancelBooking = '<?php echo direction("Cancelled","ملغي"); ?>';
    // Initialize DataTable
    var dataTable = $('#datable_1').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../requests/index.php?f=booking&endpoint=BookingList",
            "type": "POST",
            "data": function(d) {
            d.status_filter = currentStatus;
            },
            "beforeSend": function() {
                showLoading();
            },
            "complete": function() {
                // Add a small delay to make sure the spinner is visible
                setTimeout(function() {
                    hideLoading();
                }, 500); 
            },
            "error": function(xhr, error, code) {
                hideLoading();
                console.log('AJAX Error:', xhr.responseText);
                alert('Error loading data: ' + error);
            }
        },
        "columns": [
            { "data": 0, "orderable": false, "searchable": false },
            { "data": 1, "orderable": true, "searchable": true },
            { "data": 2, "orderable": false, "searchable": true },
            { "data": 3, "orderable": false, "searchable": true },
            { 
                "data": null, 
                "orderable": false, 
                "searchable": true, 
                "render": function(data, type, row) {
                    // row[7] is expected to be the booking id, but we need to fetch personal_info
                    // The server-side BookingList endpoint must be updated to include a summary of personal_info as a column (e.g., first field)
                    // For now, fallback to mobile number if not available
                    if (row.length > 7 && row[7]) {
                        return row[7]; // This should be the personal info summary
                    } else if (row[4]) {
                        return row[4]; // fallback to mobile number
                    } else {
                        return '';
                    }
                }
            },
            { "data": 5, "orderable": true, "searchable": false },
            {
            "data": null,
            "orderable": false,
            "searchable": false,
            "render": function(data, type, row) {
                var id = row[6]; // booking id
                return `<div class='dropdown action-dropdown' style='position:relative;'>
                    <button class='btn btn-primary btn-xs dropdown-toggle' type='button' data-toggle='dropdown'>Actions <span class='caret'></span></button>
                    <ul class='dropdown-menu' style='min-width:120px; padding:0;'>
                        <li><a href='#' class='show-status-options' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>Change Status</a></li>
                        <li><a href='#' class='reschedule-booking' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>Reschedule</a></li>
                        <li><a href='#' class='send-sms' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>Send SMS</a></li>
                        <li><a href='#' class='send-whatsapp' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>Send WhatsApp</a></li>
                        <li><a href='#' class='show-details' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>More details</a></li>
                    </ul>
                    <div class='status-options' style='display:none; position:absolute; right:100%; top:0; background:#fff; border:1px solid #ddd; z-index:99999; min-width:120px; box-shadow:0 2px 8px rgba(0,0,0,0.15);'>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='Yes' style='display:block; padding:8px 16px; background:#27ae60; color:#fff; font-size:13px; margin-bottom:5px; border-radius:3px;'>${successBooking}</a>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='No' style='display:block; padding:8px 16px; background:#e74c3c; color:#fff; font-size:13px; border-radius:3px; margin-bottom:5px;'>${failedBooking}</a>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='Cancel' style='display:block; padding:8px 16px; background:#f39c12; color:#fff; font-size:13px; border-radius:3px;'>${cancelBooking}</a>
                    </div>
                </div>`;
            }
            }
        ],
        "order": [[ 1, "desc" ]], // Order by Invoice Date descending
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "language": {
            "processing": "<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>",
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _TOTAL_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            },
            "emptyTable": "No booking data available",
            "zeroRecords": "No matching records found"
        },
        "responsive": true,
        "autoWidth": false,
        "stateSave": false,
        "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "drawCallback": function(settings) {
            // Add extra bottom padding to ensure pagination doesn't get covered
            $(".dataTables_wrapper").css("padding-bottom", "30px");
        }
    });

    // Status filter button click handler
    $('.status-filter').on('click', function() {
        var status = $(this).data('status');
        currentStatus = status;
        $('.status-filter').removeClass('active');
        $(this).addClass('active');
        dataTable.ajax.reload();
    });

    $('#datable_1 tbody').on('click', '.change-status', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var id = $btn.data('id');
        var newStatus = $btn.data('status');
        $('.status-options').hide();
        if (confirm('Are you sure you want to change the status to ' + newStatus + '?')) {
            $.post('../requests/index.php?f=booking&endpoint=BookingStatus', {id: id, status: newStatus}, function(res) {
                alert(res.message || 'Status updated!');
                // Find the row and update the status cell
                    var $row = $btn.closest('tr');
                    // The status cell is the 6th column (zero-based index 5)
                    var statusText = '';
                    if (newStatus === 'Yes') {
                        statusText = successBooking;
                    } else if (newStatus === 'No') {
                        statusText = failedBooking;
                    } else if (newStatus === 'Cancel') {
                        statusText = cancelBooking;
                    } else {
                        statusText = newStatus;
                    }
                    $row.find('td').eq(5).html(statusText);
            }, 'json');
        }
    });
    // Show status options inline when 'Change Status' is clicked
    $('#datable_1 tbody').on('click', '.show-status-options', function(e) {
        e.preventDefault();
        $('.status-options').hide(); // Hide any open status options
        $(this).closest('.action-dropdown').find('.status-options').show();
    });

    // Hide status options when clicking elsewhere
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.action-dropdown').length) {
            $('.status-options').hide();
        }
    });
    $('#datable_1 tbody').on('click', '.send-sms', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to send SMS?')) {
            $.ajax({
            url: '../requests/index.php?f=booking&endpoint=BookingSMS',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(res) {
                alert(res.message || 'SMS sent!');
                //dataTable.ajax.reload();
            },
            error: function(xhr) {
                var msg = 'Error sending SMS.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    msg = xhr.responseText;
                }
                alert(msg);
            }
            });
        }
    });

    $('#datable_1 tbody').on('click', '.send-whatsapp', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to send WhatsApp message?')) {
            $.ajax({
            url: '../requests/index.php?f=booking&endpoint=BookingWhatsapp',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(res) {
                alert(res.message || 'WhatsApp message sent!');
                //dataTable.ajax.reload();
            },
            error: function(xhr) {
                var msg = 'Error sending WhatsApp message.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    msg = xhr.responseText;
                }
                alert(msg);
            }
            });
        }
    });
    // Show details modal via AJAX
    $('#datable_1 tbody').on('click', '.show-details', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        showLoading();
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=BookingDetails',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(res) {
                hideLoading();
                $('#detailsModal').modal('show');
                if (res.success && res.data){
                    var details = res.data;
                    var html = '<table class="table table-bordered">';
                    for (var key in details) {
                        html += '<tr><th>' + key + '</th><td>' + details[key] + '</td></tr>';
                    }
                    html += '</table>';
                    $('#detailsModal .modal-body').html(html);
                }else{
                    $('#detailsModal .modal-body').html('<div class="text-danger" style="text-align:center;padding:40px 0;">Could not load booking details.</div>');
                }
            },
            error: function() {
                hideLoading();
                $('#detailsModal').modal('show');
                $('#detailsModal .modal-body').html('<div class="text-danger" style="text-align:center;padding:40px 0;">Error loading booking details.</div>');
            }
        });
    });
    
    // Reschedule booking handler
    $('#datable_1 tbody').on('click', '.reschedule-booking', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        showLoading();
        
        // First, get booking details to populate the form
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=BookingDetails',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(res) {
                hideLoading();
                if (res.success && res.data) {
                    var bookingData = res.data;
                    $('#rescheduleModal').modal('show');
                    $('#reschedule-booking-id').val(id);
                    
                    // Format the date as needed for the datepicker
                    var bookingDate = bookingData['Booking Date'];
                    $('#current-booking-date').val(bookingDate);
                    $('#current-booking-time').val(bookingData['Booking Time']);
                    
                    // Extract package ID from the data
                    var packageId;
                    if (bookingData['Package ID']) {
                        packageId = bookingData['Package ID'];
                    } else {
                        // If Package ID is not directly available, try to extract from S.N. or use a fallback
                        packageId = bookingData['S.N.'];
                    }
                    $('#package-id').val(packageId);
                    
                    // Initialize the datepicker after modal is shown
                    initRescheduleDatepicker(packageId);
                } else {
                    alert('Could not load booking details.');
                }
            },
            error: function() {
                hideLoading();
                alert('Error loading booking details.');
            }
        });
    });
    
    // Initialize datepicker for reschedule modal
    function initRescheduleDatepicker(packageId) {
        // Clear any previous datepicker
        if ($('#reschedule-date').data('datepicker')) {
            $('#reschedule-date').datepicker('destroy');
        }
        
        // Initialize the datepicker
        $('#reschedule-date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            startDate: '+1d',
            todayHighlight: true
        }).on('changeDate', function(e) {
            // When date is selected, load available time slots
            var selectedDate = $(this).val();
            loadAvailableTimeSlots(packageId, selectedDate);
        });
        
        // Get disabled dates from the server
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetDisabledDates',
            type: 'POST',
            data: {package_id: packageId},
            dataType: 'json',
            success: function(res) {
                if (res.success && res.data) {
                    var disabledDates = res.data;
                    
                    // Update the datepicker to disable these dates
                    $('#reschedule-date').datepicker('setDatesDisabled', disabledDates);
                }
            }
        });
    }
    
    // Load available time slots for selected date
    function loadAvailableTimeSlots(packageId, selectedDate) {
        $('#reschedule-time').html('<option value="" selected disabled>Loading...</option>');
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetAvailableTimeSlots',
            type: 'POST',
            data: {package_id: packageId, date: selectedDate},
            dataType: 'json',
            success: function(res) {
                var options = '<option value="" selected disabled>' + '<?php echo direction("Select Time", "اختر الوقت") ?>' + '</option>';
                
                if (res.success && res.data) {
                    var timeSlots = res.data;
                    for (var i = 0; i < timeSlots.length; i++) {
                        options += '<option value="' + timeSlots[i] + '">' + timeSlots[i] + '</option>';
                    }
                }
                
                $('#reschedule-time').html(options);
            },
            error: function() {
                $('#reschedule-time').html('<option value="" selected disabled>' + '<?php echo direction("Error loading time slots", "خطأ في تحميل المواعيد المتاحة") ?>' + '</option>');
            }
        });
    }
    
    // Handle reschedule form submission
    $('#reschedule-submit').on('click', function() {
        if (!$('#reschedule-date').val() || !$('#reschedule-time').val()) {
            alert('<?php echo direction("Please select both date and time", "الرجاء اختيار التاريخ والوقت") ?>');
            return;
        }
        
        showLoading();
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=RescheduleBooking',
            type: 'POST',
            data: $('#reschedule-form').serialize(),
            dataType: 'json',
            success: function(res) {
                hideLoading();
                if (res.success) {
                    alert('<?php echo direction("Booking successfully rescheduled", "تمت إعادة جدولة الحجز بنجاح") ?>');
                    $('#rescheduleModal').modal('hide');
                    dataTable.ajax.reload();
                } else {
                    alert(res.message || '<?php echo direction("Failed to reschedule booking", "فشل في إعادة جدولة الحجز") ?>');
                }
            },
            error: function() {
                hideLoading();
                alert('<?php echo direction("Error rescheduling booking", "خطأ في إعادة جدولة الحجز") ?>');
            }
        });
    });
});
</script>
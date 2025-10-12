<div class="row heading-bg">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h5 class="txt-dark"><?php echo direction("Bookings", "الحجوزات") ?></h5>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 text-right">
        <button type="button" class="btn btn-success btn-icon-anim btn-circle" id="create-new-booking-btn">
            <i class="fa fa-plus"></i> <?php echo direction("Create New Booking", "إنشاء حجز جديد") ?>
        </button>
    </div>
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
                            
                            .theme-item {
                                position: relative;
                                transition: all 0.3s ease;
                            }
                            
                            .theme-item:hover {
                                transform: translateY(-3px);
                                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                            }
                            
                            .mb-15 {
                                margin-bottom: 15px;
                            }
                            
                            .mb-20 {
                                margin-bottom: 20px;
                            }
                        </style>
                        <!-- Status Filter Buttons -->
                        <div class="mb-20" style="margin-bottom: 20px;">
                            <div class="btn-group" role="group" aria-label="Status Filters" style="gap: 10px;">
                                <button type="button" class="btn btn-default status-filter active" data-status="all" style="margin-right:10px;"><?php echo direction("All", "الكل") ?></button>
                                <button type="button" class="btn btn-success status-filter" data-status="Yes" style="margin-right:10px;"><?php echo direction("Success", "ناجح") ?></button>
                                <button type="button" class="btn btn-danger status-filter" data-status="No" style="margin-right:10px;"><?php echo direction("Failed", "فاشل") ?></button>
                                <button type="button" class="btn btn-warning status-filter" data-status="Cancel" style="margin-right:10px;"><?php echo direction("Cancelled", "ملغي") ?></button>
                                <button type="button" class="btn btn-info status-filter" data-status="Rescheduled" style="margin-right:10px;"><?php echo direction("Rescheduled", "معاد جدولته") ?></button>
                                <button type="button" class="btn btn-primary status-filter" data-status="Completed"><?php echo direction("Completed", "مكتمل") ?></button>
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
                        <input type="text" class="form-control" id="reschedule-date" name="new_date" placeholder="Select a date" autocomplete="off" required>
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

<!-- Complete Payment Modal -->
<div class="modal fade" id="completePaymentModal" tabindex="-1" role="dialog" aria-labelledby="completePaymentModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="completePaymentModalLabel"><?php echo direction("Complete Payment", "إكمال الدفع") ?></h4>
            </div>
            <div class="modal-body">
                <form id="complete-payment-form">
                    <input type="hidden" id="complete-payment-booking-id" name="booking_id">
                    
                    <div class="form-group">
                        <label><?php echo direction("Booking Details", "تفاصيل الحجز") ?></label>
                        <div id="complete-payment-booking-details" style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                            <div class="text-center">
                                <i class="fa fa-spinner fa-spin"></i> <?php echo direction("Loading...", "جاري التحميل...") ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="complete-payment-amount"><?php echo direction("Amount to Complete (KD)", "المبلغ المطلوب (د.ك)") ?></label>
                        <input type="number" class="form-control" id="complete-payment-amount" name="amount" step="0.001" min="0" required>
                        <small class="form-text text-muted" id="payment-type-info"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="send-method"><?php echo direction("Send Link Via", "إرسال الرابط عبر") ?></label>
                        <select class="form-control" id="send-method" name="send_method" required>
                            <option value="whatsapp" selected><?php echo direction("WhatsApp", "واتساب") ?></option>
                            <option value="sms"><?php echo direction("SMS", "رسالة نصية") ?></option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo direction("Cancel", "إلغاء") ?></button>
                <button type="button" class="btn btn-primary" id="complete-payment-send-link"><?php echo direction("Send Payment Link", "إرسال رابط الدفع") ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Create New Booking Modal -->
<div class="modal fade" id="createBookingModal" tabindex="-1" role="dialog" aria-labelledby="createBookingModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="createBookingModalLabel"><?php echo direction("Create New Booking", "إنشاء حجز جديد") ?></h4>
            </div>
            <div class="modal-body">
                <form id="create-booking-form">
                    <!-- Step 1: Package Selection -->
                    <div id="step-1" class="booking-step">
                        <h5 class="mb-20"><?php echo direction("Step 1: Select Package", "الخطوة 1: اختر الباقة") ?></h5>
                        <div class="form-group">
                            <label for="new-booking-package"><?php echo direction("Package", "الباقة") ?></label>
                            <select class="form-control" id="new-booking-package" name="package_id" required>
                                <option value=""><?php echo direction("Select Package", "اختر الباقة") ?></option>
                                <?php
                                $packages = selectDB("tbl_packages", "`status` = '0' AND `hidden` = '1'");
                                foreach($packages as $pkg) {
                                    echo '<option value="'.$pkg['id'].'" data-price="'.$pkg['price'].'">'.$pkg[direction('en','ar').'Title'].' - '.$pkg['price'].' KD</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="goto-step-2"><?php echo direction("Next", "التالي") ?></button>
                        </div>
                    </div>

                    <!-- Step 2: Date & Time Selection -->
                    <div id="step-2" class="booking-step" style="display:none;">
                        <h5 class="mb-20"><?php echo direction("Step 2: Select Date & Time", "الخطوة 2: اختر التاريخ والوقت") ?></h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new-booking-date"><?php echo direction("Date", "التاريخ") ?></label>
                                    <input type="text" class="form-control" id="new-booking-date" name="booking_date" placeholder="<?php echo direction("Select Date", "اختر التاريخ") ?>" required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new-booking-time"><?php echo direction("Time", "الوقت") ?></label>
                                    <select class="form-control" id="new-booking-time" name="booking_time" required>
                                        <option value=""><?php echo direction("Select date first", "اختر التاريخ أولاً") ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-default" id="goto-step-1"><?php echo direction("Back", "رجوع") ?></button>
                            <button type="button" class="btn btn-primary" id="goto-step-3"><?php echo direction("Next", "التالي") ?></button>
                        </div>
                    </div>

                    <!-- Step 3: Personal Info & Extras -->
                    <div id="step-3" class="booking-step" style="display:none;">
                        <h5 class="mb-20"><?php echo direction("Step 3: Personal Information & Extras", "الخطوة 3: المعلومات الشخصية والإضافات") ?></h5>
                        
                        <!-- Dynamic Personal Info Fields -->
                        <div id="personal-info-fields"></div>
                        
                        <!-- Themes Selection -->
                        <div id="themes-selection-container" style="display:none;">
                            <hr>
                            <h6><?php echo direction("Select Themes", "اختر المواضيع") ?></h6>
                            <input type="hidden" id="new-booking-themes" name="themes" value="[]">
                            <div id="themes-list" class="row"></div>
                        </div>

                        <!-- Extra Items -->
                        <div id="extra-items-container" style="display:none;">
                            <hr>
                            <h6><?php echo direction("Extra Items", "الإضافات") ?></h6>
                            <div id="extra-items-list"></div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <label><?php echo direction("Total Price", "السعر الإجمالي") ?>: <span id="total-price-display">0</span> KD</label>
                            <input type="hidden" id="total-booking-price" name="booking_price" value="0">
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-default" id="goto-step-2-back"><?php echo direction("Back", "رجوع") ?></button>
                            <button type="submit" class="btn btn-success" id="create-booking-submit">
                                <i class="fa fa-check"></i> <?php echo direction("Create Booking", "إنشاء الحجز") ?>
                            </button>
                        </div>
                    </div>
                </form>
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
    var rescheduledBooking = '<?php echo direction("Rescheduled","معاد جدولته"); ?>';
    var completedBooking = '<?php echo direction("Completed","مكتمل"); ?>';
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
                        <li><a href='#' class='complete-payment' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>Complete Payment</a></li>
                        <li><a href='#' class='send-sms' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>Send SMS</a></li>
                        <li><a href='#' class='send-whatsapp' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>Send WhatsApp</a></li>
                        <li><a href='#' class='show-details' data-id='${id}' style='padding:8px 16px; color:#333; font-size:13px;'>More details</a></li>
                    </ul>
                    <div class='status-options' style='display:none; position:absolute; right:100%; top:0; background:#fff; border:1px solid #ddd; z-index:99999; min-width:120px; box-shadow:0 2px 8px rgba(0,0,0,0.15);'>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='Yes' style='display:block; padding:8px 16px; background:#27ae60; color:#fff; font-size:13px; margin-bottom:5px; border-radius:3px;'>${successBooking}</a>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='No' style='display:block; padding:8px 16px; background:#e74c3c; color:#fff; font-size:13px; border-radius:3px; margin-bottom:5px;'>${failedBooking}</a>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='Cancel' style='display:block; padding:8px 16px; background:#f39c12; color:#fff; font-size:13px; border-radius:3px; margin-bottom:5px;'>${cancelBooking}</a>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='Rescheduled' style='display:block; padding:8px 16px; background:#3498db; color:#fff; font-size:13px; border-radius:3px; margin-bottom:5px;'>${rescheduledBooking}</a>
                        <a href='#' class='change-status btn' data-id='${id}' data-status='Completed' style='display:block; padding:8px 16px; background:#8e44ad; color:#fff; font-size:13px; border-radius:3px;'>${completedBooking}</a>
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
                    } else if (newStatus === 'Rescheduled') {
                        statusText = rescheduledBooking;
                    } else if (newStatus === 'Completed') {
                        statusText = completedBooking;
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
        // Clear any previous datetimepicker
        if ($('#reschedule-date').data('DateTimePicker')) {
            $('#reschedule-date').data('DateTimePicker').destroy();
        }
        
        // Get disabled dates from the server first
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetDisabledDates',
            type: 'POST',
            data: {package_id: packageId},
            dataType: 'json',
            success: function(res) {
                var disabledDates = [];
                if (res.success && res.data) {
                    disabledDates = res.data;
                }
                
                // Initialize the datetimepicker using bootstrap-datetimepicker (eonasdan)
                $('#reschedule-date').datetimepicker({
                    format: 'DD-MM-YYYY',
                    minDate: moment().add(1, 'days'),
                    disabledDates: disabledDates.map(function(d) { return moment(d, 'DD-MM-YYYY'); }),
                    showClear: true,
                    showClose: true,
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down",
                        previous: "fa fa-chevron-left",
                        next: "fa fa-chevron-right",
                        today: "fa fa-calendar-check-o",
                        clear: "fa fa-trash",
                        close: "fa fa-times"
                    }
                }).on('dp.change', function(e) {
                    // When date is selected, load available time slots
                    if (e.date) {
                        var selectedDate = e.date.format('DD-MM-YYYY');
                        loadAvailableTimeSlots(packageId, selectedDate);
                    }
                });
            },
            error: function() {
                // Initialize without disabled dates if request fails
                $('#reschedule-date').datetimepicker({
                    format: 'DD-MM-YYYY',
                    minDate: moment().add(1, 'days'),
                    showClear: true,
                    showClose: true,
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down",
                        previous: "fa fa-chevron-left",
                        next: "fa fa-chevron-right",
                        today: "fa fa-calendar-check-o",
                        clear: "fa fa-trash",
                        close: "fa fa-times"
                    }
                }).on('dp.change', function(e) {
                    // When date is selected, load available time slots
                    if (e.date) {
                        var selectedDate = e.date.format('DD-MM-YYYY');
                        loadAvailableTimeSlots(packageId, selectedDate);
                    }
                });
            }
        });
    }
    
    // Load available time slots for selected date
    function loadAvailableTimeSlots(packageId, selectedDate) {
        console.log('Loading time slots for package:', packageId, 'date:', selectedDate);
        $('#reschedule-time').html('<option value="" selected disabled>Loading...</option>');
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetAvailableTimeSlots',
            type: 'POST',
            data: {package_id: packageId, date: selectedDate},
            dataType: 'json',
            success: function(res) {
                console.log('Time slots response:', res);
                var options = '<option value="" selected disabled>' + '<?php echo direction("Select Time", "اختر الوقت") ?>' + '</option>';
                
                if (res.success && res.data) {
                    var timeSlots = res.data;
                    console.log('Available time slots:', timeSlots);
                    if (timeSlots.length === 0) {
                        options = '<option value="" selected disabled>' + '<?php echo direction("No available times", "لا توجد أوقات متاحة") ?>' + '</option>';
                    } else {
                        for (var i = 0; i < timeSlots.length; i++) {
                            options += '<option value="' + timeSlots[i] + '">' + timeSlots[i] + '</option>';
                        }
                    }
                } else {
                    console.error('Failed to load time slots:', res.message);
                    options = '<option value="" selected disabled>' + (res.message || '<?php echo direction("No times available", "لا توجد أوقات متاحة") ?>') + '</option>';
                }
                
                $('#reschedule-time').html(options);
            },
            error: function(xhr, status, error) {
                console.error('Error loading time slots:', status, error, xhr.responseText);
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
        
        // The date is already in DD-MM-YYYY format from the datepicker, which is what the backend expects
        var formData = {
            booking_id: $('#reschedule-booking-id').val(),
            package_id: $('#package-id').val(),
            new_date: $('#reschedule-date').val(),
            new_time: $('#reschedule-time').val()
        };
        
        console.log('Submitting reschedule with data:', formData);
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=RescheduleBooking',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                hideLoading();
                console.log('Reschedule response:', res);
                if (res.success) {
                    alert('<?php echo direction("Booking successfully rescheduled", "تمت إعادة جدولة الحجز بنجاح") ?>');
                    $('#rescheduleModal').modal('hide');
                    dataTable.ajax.reload();
                } else {
                    alert(res.message || '<?php echo direction("Failed to reschedule booking", "فشل في إعادة جدولة الحجز") ?>');
                }
            },
            error: function(xhr, status, error) {
                hideLoading();
                console.error('Error rescheduling:', status, error, xhr.responseText);
                alert('<?php echo direction("Error rescheduling booking", "خطأ في إعادة جدولة الحجز") ?>');
            }
        });
    });
    
    // Complete Payment handler
    $('#datable_1 tbody').on('click', '.complete-payment', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        // Reset modal
        $('#complete-payment-booking-id').val(id);
        $('#complete-payment-amount').val('');
        $('#payment-type-info').text('');
        $('#complete-payment-booking-details').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> <?php echo direction("Loading...", "جاري التحميل...") ?></div>');
        
        // Show modal immediately
        $('#completePaymentModal').modal('show');
        
        // Fetch booking details
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=BookingDetails',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(res) {
                if (res.success && res.data) {
                    var data = res.data;
                    
                    // Display booking details
                    var detailsHtml = '<div style="font-size: 13px;">';
                    detailsHtml += '<p style="margin: 5px 0;"><strong><?php echo direction("Booking ID", "رقم الحجز") ?>:</strong> ' + data['S.N.'] + '</p>';
                    detailsHtml += '<p style="margin: 5px 0;"><strong><?php echo direction("Package", "الباقة") ?>:</strong> ' + data['Package Name'] + '</p>';
                    detailsHtml += '<p style="margin: 5px 0;"><strong><?php echo direction("Date", "التاريخ") ?>:</strong> ' + data['Booking Date'] + '</p>';
                    detailsHtml += '<p style="margin: 5px 0;"><strong><?php echo direction("Time", "الوقت") ?>:</strong> ' + data['Booking Time'] + '</p>';
                    detailsHtml += '<p style="margin: 5px 0;"><strong><?php echo direction("Total Price", "السعر الإجمالي") ?>:</strong> ' + data['Booking Price'] + '</p>';
                    detailsHtml += '</div>';
                    $('#complete-payment-booking-details').html(detailsHtml);
                    
                    // Set initial amount (for now, just use booking price)
                    // We'll add the payment type calculation in the next step
                    var bookingPrice = parseFloat(data['Booking Price'].replace(/[^\d.]/g, ''));
                    $('#complete-payment-amount').val(bookingPrice.toFixed(3));
                    $('#payment-type-info').text('<?php echo direction("Default: Full booking amount", "افتراضي: المبلغ الكامل للحجز") ?>');
                    
                } else {
                    $('#complete-payment-booking-details').html('<div class="alert alert-danger"><?php echo direction("Failed to load booking details", "فشل في تحميل تفاصيل الحجز") ?></div>');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                $('#complete-payment-booking-details').html('<div class="alert alert-danger"><?php echo direction("Error loading booking details", "خطأ في تحميل تفاصيل الحجز") ?></div>');
            }
        });
    });
    
    // Handle send payment link button
    $('#complete-payment-send-link').on('click', function() {
        var amount = parseFloat($('#complete-payment-amount').val());
        var bookingId = $('#complete-payment-booking-id').val();
        var sendMethod = $('#send-method').val();
        
        if (!amount || amount <= 0) {
            alert('<?php echo direction("Please enter a valid amount", "الرجاء إدخال مبلغ صحيح") ?>');
            return;
        }
        
        // Disable button and show loading
        var $btn = $(this);
        $btn.prop('disabled', true).text('<?php echo direction("Sending...", "جاري الإرسال...") ?>');
        
        // First, update the booking payment amount
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=UpdatePaymentAmount',
            type: 'POST',
            data: {
                id: bookingId,
                new_amount: amount
            },
            dataType: 'json',
            success: function(updateResponse) {
                if (updateResponse.success) {
                    // After updating, send the payment link
                    var endpoint = sendMethod === 'sms' ? 'BookingSMS' : 'BookingWhatsapp';
                    
                    $.ajax({
                        url: '../requests/index.php?f=booking&endpoint=' + endpoint,
                        type: 'POST',
                        data: {
                            id: bookingId,
                            message_type: 'payment'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert('<?php echo direction("Payment link sent successfully!", "تم إرسال رابط الدفع بنجاح!") ?>');
                                $('#completePaymentModal').modal('hide');
                                dataTable.ajax.reload();
                            } else {
                                alert('<?php echo direction("Error: ", "خطأ: ") ?>' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('<?php echo direction("Failed to send payment link. Please try again.", "فشل إرسال رابط الدفع. الرجاء المحاولة مرة أخرى.") ?>');
                            console.error('Error:', error);
                        },
                        complete: function() {
                            $btn.prop('disabled', false).text('<?php echo direction("Send Payment Link", "إرسال رابط الدفع") ?>');
                        }
                    });
                } else {
                    alert('<?php echo direction("Error updating amount: ", "خطأ في تحديث المبلغ: ") ?>' + updateResponse.message);
                    $btn.prop('disabled', false).text('<?php echo direction("Send Payment Link", "إرسال رابط الدفع") ?>');
                }
            },
            error: function(xhr, status, error) {
                alert('<?php echo direction("Failed to update payment amount. Please try again.", "فشل تحديث مبلغ الدفع. الرجاء المحاولة مرة أخرى.") ?>');
                console.error('Error:', error);
                $btn.prop('disabled', false).text('<?php echo direction("Send Payment Link", "إرسال رابط الدفع") ?>');
            }
        });
    });
    
    // ============= CREATE NEW BOOKING FUNCTIONALITY =============
    var selectedPackageData = null;
    var selectedThemes = [];
    var maxThemes = 1;
    
    // Open Create Booking Modal
    $('#create-new-booking-btn').on('click', function() {
        $('#createBookingModal').modal('show');
        resetBookingForm();
    });
    
    function resetBookingForm() {
        $('#create-booking-form')[0].reset();
        $('.booking-step').hide();
        $('#step-1').show();
        selectedPackageData = null;
        selectedThemes = [];
        $('#total-price-display').text('0');
        $('#total-booking-price').val('0');
    }
    
    // Step Navigation
    $('#goto-step-2').on('click', function() {
        var packageId = $('#new-booking-package').val();
        if (!packageId) {
            alert('<?php echo direction("Please select a package", "الرجاء اختيار الباقة") ?>');
            return;
        }
        loadPackageData(packageId);
    });
    
    $('#goto-step-1').on('click', function() {
        $('#step-2').hide();
        $('#step-1').show();
    });
    
    $('#goto-step-2-back').on('click', function() {
        $('#step-3').hide();
        $('#step-2').show();
    });
    
    $('#goto-step-3').on('click', function() {
        var date = $('#new-booking-date').val();
        var time = $('#new-booking-time').val();
        if (!date || !time) {
            alert('<?php echo direction("Please select date and time", "الرجاء اختيار التاريخ والوقت") ?>');
            return;
        }
        loadPersonalInfoFields();
    });
    
    // Load Package Data
    function loadPackageData(packageId) {
        showLoading();
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetPackageForBooking',
            type: 'POST',
            data: {package_id: packageId},
            dataType: 'json',
            success: function(res) {
                hideLoading();
                if (res.success && res.data) {
                    selectedPackageData = res.data;
                    initDatePicker(packageId);
                    $('#step-1').hide();
                    $('#step-2').show();
                } else {
                    alert(res.message || '<?php echo direction("Failed to load package data", "فشل في تحميل بيانات الباقة") ?>');
                }
            },
            error: function() {
                hideLoading();
                alert('<?php echo direction("Error loading package data", "خطأ في تحميل بيانات الباقة") ?>');
            }
        });
    }
    
    // Initialize Date Picker
    function initDatePicker(packageId) {
        if ($('#new-booking-date').data('DateTimePicker')) {
            $('#new-booking-date').data('DateTimePicker').destroy();
        }
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetDisabledDatesForAdmin',
            type: 'POST',
            data: {package_id: packageId},
            dataType: 'json',
            success: function(res) {
                var disabledDates = [];
                if (res.success && res.data) {
                    disabledDates = res.data.map(function(d) { return moment(d, 'DD-MM-YYYY'); });
                }
                
                $('#new-booking-date').datetimepicker({
                    format: 'DD-MM-YYYY',
                    minDate: moment(),
                    disabledDates: disabledDates,
                    showClear: true,
                    showClose: true,
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down",
                        previous: "fa fa-chevron-left",
                        next: "fa fa-chevron-right",
                        today: "fa fa-calendar-check-o",
                        clear: "fa fa-trash",
                        close: "fa fa-times"
                    }
                }).on('dp.change', function(e) {
                    if (e.date) {
                        var selectedDate = e.date.format('DD-MM-YYYY');
                        loadAvailableTimeSlotsForBooking(packageId, selectedDate);
                    }
                });
            }
        });
    }
    
    // Load Available Time Slots
    function loadAvailableTimeSlotsForBooking(packageId, selectedDate) {
        $('#new-booking-time').html('<option value="">Loading...</option>');
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetAvailableTimeSlots',
            type: 'POST',
            data: {package_id: packageId, date: selectedDate},
            dataType: 'json',
            success: function(res) {
                var options = '<option value=""><?php echo direction("Select Time", "اختر الوقت") ?></option>';
                if (res.success && res.data && res.data.length > 0) {
                    for (var i = 0; i < res.data.length; i++) {
                        options += '<option value="' + res.data[i] + '">' + res.data[i] + '</option>';
                    }
                } else {
                    options = '<option value=""><?php echo direction("No available times", "لا توجد أوقات متاحة") ?></option>';
                }
                $('#new-booking-time').html(options);
            },
            error: function() {
                $('#new-booking-time').html('<option value=""><?php echo direction("Error loading time slots", "خطأ في تحميل المواعيد") ?></option>');
            }
        });
    }
    
    // Load Personal Info Fields
    function loadPersonalInfoFields() {
        var packageId = $('#new-booking-package').val();
        showLoading();
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=GetPersonalInfoFields',
            type: 'POST',
            data: {package_id: packageId},
            dataType: 'json',
            success: function(res) {
                hideLoading();
                if (res.success && res.data) {
                    renderPersonalInfoFields(res.data.personalInfo);
                    renderThemes(res.data.themes, res.data.themes_count);
                    renderExtraItems(res.data.extra_items);
                    updateTotalPrice();
                    $('#step-2').hide();
                    $('#step-3').show();
                } else {
                    alert(res.message || '<?php echo direction("Failed to load form fields", "فشل في تحميل حقول النموذج") ?>');
                }
            },
            error: function() {
                hideLoading();
                alert('<?php echo direction("Error loading form fields", "خطأ في تحميل حقول النموذج") ?>');
            }
        });
    }
    
    // Render Personal Info Fields
    function renderPersonalInfoFields(fields) {
        var html = '';
        if (fields && fields.length > 0) {
            fields.forEach(function(field) {
                var fieldName = 'personalInfo[' + field.id + ']';
                var label = field.title;
                html += '<div class="form-group">';
                html += '<label>' + label + '</label>';
                
                switch(parseInt(field.type)) {
                    case 1: // text
                        html += '<input type="text" class="form-control" name="' + fieldName + '" required>';
                        break;
                    case 2: // textarea
                        html += '<textarea class="form-control" name="' + fieldName + '" required></textarea>';
                        break;
                    case 3: // number
                        html += '<input type="number" class="form-control" name="' + fieldName + '" required>';
                        break;
                    case 4: // email
                        html += '<input type="email" class="form-control" name="' + fieldName + '" required>';
                        break;
                    case 5: // date
                        html += '<input type="date" class="form-control" name="' + fieldName + '" required>';
                        break;
                    case 6: // time
                        html += '<input type="time" class="form-control" name="' + fieldName + '" required>';
                        break;
                    case 7: // phone
                        html += '<input type="tel" class="form-control" name="' + fieldName + '" pattern="[0-9]{11}" maxlength="11" required>';
                        break;
                    default:
                        html += '<input type="text" class="form-control" name="' + fieldName + '" required>';
                }
                html += '</div>';
            });
        }
        $('#personal-info-fields').html(html);
    }
    
    // Render Themes
    function renderThemes(themes, themesCount) {
        if (!themes || themes.length === 0) {
            $('#themes-selection-container').hide();
            return;
        }
        
        maxThemes = parseInt(themesCount) || 1;
        selectedThemes = [];
        $('#themes-selection-container').show();
        
        var html = '';
        themes.forEach(function(category) {
            html += '<div class="col-xs-12"><h6>' + category.title + '</h6></div>';
            if (category.themes && category.themes.length > 0) {
                category.themes.forEach(function(theme) {
                    html += '<div class="col-xs-6 col-sm-4 col-md-3 mb-15">';
                    html += '<div class="theme-item" data-theme-id="' + theme.id + '" data-theme-title="' + theme.title + '" data-theme-image="' + theme.imageurl + '" style="cursor:pointer; border:2px solid transparent; padding:10px; text-align:center; border-radius:5px;">';
                    html += '<img src="../logos/themes/' + theme.imageurl + '" style="width:100%; height:100px; object-fit:cover; border-radius:5px; margin-bottom:5px;">';
                    html += '<p style="margin:0; font-size:12px;">' + theme.title + '</p>';
                    html += '<i class="fa fa-check-circle theme-check" style="display:none; color:#4CAF50; font-size:24px; position:absolute; top:5px; right:5px;"></i>';
                    html += '</div>';
                    html += '</div>';
                });
            }
        });
        $('#themes-list').html(html);
        
        // Theme click handler
        $(document).on('click', '.theme-item', function() {
            var themeId = $(this).data('theme-id');
            var themeTitle = $(this).data('theme-title');
            var themeImage = $(this).data('theme-image');
            
            var index = selectedThemes.findIndex(function(t) { return t.id === themeId; });
            
            if (index > -1) {
                selectedThemes.splice(index, 1);
                $(this).css('border-color', 'transparent');
                $(this).find('.theme-check').hide();
            } else {
                if (selectedThemes.length >= maxThemes) {
                    alert('<?php echo direction("Maximum themes selected", "تم اختيار الحد الأقصى من المواضيع") ?>: ' + maxThemes);
                    return;
                }
                selectedThemes.push({id: themeId, enTitle: themeTitle, imageurl: themeImage});
                $(this).css('border-color', '#4CAF50');
                $(this).find('.theme-check').show();
            }
            
            $('#new-booking-themes').val(JSON.stringify(selectedThemes));
        });
    }
    
    // Render Extra Items
    function renderExtraItems(extraItems) {
        if (!extraItems || extraItems.length === 0) {
            $('#extra-items-container').hide();
            return;
        }
        
        $('#extra-items-container').show();
        var html = '';
        extraItems.forEach(function(item) {
            html += '<div class="checkbox">';
            html += '<label>';
            html += '<input type="checkbox" class="extra-item-checkbox" name="select_extra_item[]" value="' + item.item + ',' + item.price + '" data-price="' + item.price + '">';
            html += ' ' + item.item + ' - ' + item.price + ' KD';
            html += '</label>';
            html += '</div>';
        });
        $('#extra-items-list').html(html);
        
        // Extra items change handler
        $(document).on('change', '.extra-item-checkbox', function() {
            updateTotalPrice();
        });
    }
    
    // Update Total Price
    function updateTotalPrice() {
        var basePrice = parseFloat($('#new-booking-package option:selected').data('price')) || 0;
        var extraPrice = 0;
        
        $('.extra-item-checkbox:checked').each(function() {
            extraPrice += parseFloat($(this).data('price')) || 0;
        });
        
        var totalPrice = basePrice + extraPrice;
        $('#total-price-display').text(totalPrice.toFixed(3));
        $('#total-booking-price').val(totalPrice.toFixed(3));
    }
    
    // Submit Create Booking Form
    $('#create-booking-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        showLoading();
        
        $.ajax({
            url: '../requests/index.php?f=booking&endpoint=CreateManualBooking',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                hideLoading();
                if (res.success) {
                    alert('<?php echo direction("Booking created successfully!", "تم إنشاء الحجز بنجاح!") ?>');
                    $('#createBookingModal').modal('hide');
                    dataTable.ajax.reload();
                } else {
                    alert(res.message || '<?php echo direction("Failed to create booking", "فشل في إنشاء الحجز") ?>');
                }
            },
            error: function(xhr) {
                hideLoading();
                console.error('Error:', xhr.responseText);
                alert('<?php echo direction("Error creating booking", "خطأ في إنشاء الحجز") ?>');
            }
        });
    });
});
</script>
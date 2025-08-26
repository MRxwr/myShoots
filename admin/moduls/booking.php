	
    
    	<!-- Title -->
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark"><?php echo $lang['booking'] ?></h5>
					</div>


	<?php 
		if(isset($_SESSION['add']))
		{
			echo $_SESSION['add'];
			unset($_SESSION['add']);
		}
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}
		if(isset($_SESSION['delete']))
		{
			echo $_SESSION['delete'];
			unset($_SESSION['delete']);
		}
	?>
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
                                            <button type="button" class="btn btn-default status-filter active" data-status="all" style="margin-right:10px;">All</button>
                                            <button type="button" class="btn btn-success status-filter" data-status="Yes" style="margin-right:10px;">Success</button>
                                            <button type="button" class="btn btn-danger status-filter" data-status="No">Cancelled</button>
                                        </div>
									</div>
									<div class="table-wrap">
										<div class="table-responsive" id="data-table-container">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
														<th><?php echo $lang['Invoice_Date'] ?></th>
														<th><?php echo $lang['transaction_id'] ?></th>
                                                        <th><?php echo $lang['package_name'] ?></th>
                                                        <th><?php echo $lang['customer_name'] ?></th>
                                                        <th><?php echo $lang['mobile_number'] ?></th>
                                                        <th><?php echo $lang['baby_name'] ?></th>
                                                        <th><?php echo $lang['baby_age'] ?></th>
                                                        <th><?php echo $lang['instructions'] ?></th>
                                                        <th><?php echo $lang['booking_date'] ?></th>
                                                        <th><?php echo $lang['booking_time'] ?></th>
                                                        <th><?php echo $lang['extra_items'] ?></th>
                                                        <th><?php echo $lang['booking_price'] ?></th>
                                                        <th><?php echo $lang['is_active'] ?></th>
                                                        <th>Actions</th>
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

<script>
$(document).ready(function() {
    // Show loading spinner and dim the table
    function showLoading() {
        $('#loading-spinner').css('display', 'block');
        $('#data-table-container').css('opacity', '0.5');
        console.log('Loading spinner shown');
    }
    
    // Hide loading spinner and restore table opacity
    function hideLoading() {
        $('#loading-spinner').css('display', 'none');
        $('#data-table-container').css('opacity', '1');
        console.log('Loading spinner hidden');
    }
    
    // Show spinner before DataTable initialization
    showLoading();
    
    // Current active status filter
    var currentStatus = 'all';
    
    // Initialize DataTable
    var dataTable = $('#datable_1').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "moduls/booking_ajax.php",
            "type": "POST",
            "data": function(d) {
                d.status_filter = currentStatus;
            },
            "beforeSend": function() {
                showLoading();
            },
            "complete": function() {
                setTimeout(function() {
                    hideLoading();
                }, 500); // Add a small delay to make sure the spinner is visible
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
            { "data": 2, "orderable": true, "searchable": false },
            { "data": 3, "orderable": true, "searchable": false },
            { "data": 4, "orderable": true, "searchable": true },
            { "data": 5, "orderable": true, "searchable": true },
            { "data": 6, "orderable": false, "searchable": false },
            { "data": 7, "orderable": true, "searchable": false },
            { "data": 8, "orderable": true, "searchable": false },
            { "data": 9, "orderable": false, "searchable": true },
            { "data": 10, "orderable": true, "searchable": true },
            { "data": 11, "orderable": true, "searchable": false },
            { "data": 12, "orderable": false, "searchable": false},
            { "data": 13, "orderable": false, "searchable": false },
            {
                "data": null,
                "orderable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    var id = row[14]; // assuming booking id is sent as 14th column
                        return `<div class='dropdown action-dropdown' style='position:relative;'>
                        <button class='btn btn-primary btn-xs dropdown-toggle' type='button' data-toggle='dropdown'>Actions <span class='caret'></span></button>
                        <ul class='dropdown-menu'>
                                <li><a href='#' class='show-status-options' data-id='${id}'>Change Status</a></li>
                                <li><a href='#' class='send-sms' data-id='${id}'>Send SMS</a></li>
                            </ul>
                            <div class='status-options' style='display:none; position:absolute; left:0; top:100%; background:#fff; border:1px solid #ddd; z-index:99999; min-width:140px; box-shadow:0 2px 8px rgba(0,0,0,0.15);'>
                                <a href='#' class='change-status btn btn-success' data-id='${id}' data-status='Yes' style='display:block; padding:10px 16px; color:#fff; margin-bottom:5px;'>Success</a>
                                <a href='#' class='change-status btn btn-danger' data-id='${id}' data-status='No' style='display:block; padding:10px 16px; color:#fff;'>Cancelled</a>
                            </div>
                        </ul>
                    </div>`;
                }
            }
        ],
        "order": [[ 7, "desc" ]], // Order by booking date descending
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
                $.post('moduls/change_status.php', {id: id, status: newStatus}, function(res) {
                    alert(res.message || 'Status updated!');
                    // Find the row and update the status cell
                    var $row = $btn.closest('tr');
                    // The status cell is the 14th column (zero-based index 13)
                    var statusText = newStatus === 'Yes' ? 'نعم' : 'لا';
                    $row.find('td').eq(13).html(statusText);
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
                url: 'moduls/send_sms.php',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(res) {
                    alert(res.message || 'SMS sent!');
                    //dataTable.ajax.reload();
                },
                error: function(xhr) {
                    var msg = 'Error sending SMS.';
                    alert(responseJSON);
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
});
</script>
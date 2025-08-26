	
    
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
										<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
											<span class="sr-only">Loading...</span>
										</div>
									</div>
									<div class="table-wrap">
										<div class="table-responsive" id="data-table-container">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
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
                                                        <th><?php echo $lang['transaction_id'] ?></th>
                                                        <th><?php echo $lang['is_active'] ?></th>
													</tr>
												</thead>
												<tfoot>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
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
                                                        <th><?php echo $lang['transaction_id'] ?></th>
                                                        <th><?php echo $lang['is_active'] ?></th>
													</tr>
												</tfoot>
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
        $('#loading-spinner').show();
        $('#data-table-container').css('opacity', '0.5');
    }
    
    // Hide loading spinner and restore table opacity
    function hideLoading() {
        $('#loading-spinner').hide();
        $('#data-table-container').css('opacity', '1');
    }
    
    // Show spinner before DataTable initialization
    showLoading();
    
    $('#datable_1').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "moduls/booking_ajax.php",
            "type": "POST",
            "beforeSend": function() {
                showLoading();
            },
            "complete": function() {
                hideLoading();
            },
            "error": function(xhr, error, code) {
                hideLoading();
                console.log('AJAX Error:', xhr.responseText);
                alert('Error loading data: ' + error);
            }
        },
        "columns": [
            { "data": 0, "orderable": false, "searchable": false },
            { "data": 1, "orderable": true },
            { "data": 2, "orderable": true },
            { "data": 3, "orderable": true },
            { "data": 4, "orderable": true },
            { "data": 5, "orderable": true },
            { "data": 6, "orderable": false },
            { "data": 7, "orderable": true },
            { "data": 8, "orderable": true },
            { "data": 9, "orderable": false, "searchable": false },
            { "data": 10, "orderable": true },
            { "data": 11, "orderable": true },
            { "data": 12, "orderable": false, "searchable": false }
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
        "stateSave": false
    });
});
</script>
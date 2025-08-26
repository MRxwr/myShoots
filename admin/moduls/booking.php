	
    
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
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display pb-30">
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

<!-- Add custom JavaScript for DataTable AJAX loading -->
<script>
// Initialize AJAX DataTable with a slight delay to ensure it overrides the default initialization
$(document).ready(function() {
    // Wait for the default initialization to complete
    setTimeout(function() {
        // Destroy the existing DataTable instance
        if ($.fn.DataTable.isDataTable('#datable_1')) {
            $('#datable_1').DataTable().destroy();
        }
        
        // Initialize the new AJAX-powered DataTable
        $('#datable_1').DataTable({
            "processing": true,
            "language": {
                "processing": "<div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div>"
            },
            "serverSide": false,
            "ajax": {
                "url": "moduls/get_bookings_simple.php",
                "type": "POST",
                "dataSrc": "data",
                "error": function(xhr, error, thrown) {
                    // Display error message in console for debugging
                    console.error("AJAX error:", error, thrown);
                    
                    // Show a more user-friendly error message
                    $('#datable_1_wrapper').prepend(
                        '<div class="alert alert-danger">' +
                        '<strong>Error loading data:</strong> There was a problem retrieving the booking data. ' +
                        'Please refresh the page or contact support.' +
                        '</div>'
                    );
                }
            },
            "columns": [
                { "data": "sn" },
                { "data": "package_name" },
                { "data": "customer_name" },
                { "data": "mobile_number" },
                { "data": "baby_name" },
                { "data": "baby_age" },
                { "data": "instructions" },
                { "data": "booking_date" },
                { "data": "booking_time" },
                { "data": "extra_items", "render": function(data) { return data; } },
                { "data": "booking_price" },
                { "data": "transaction_id" },
                { "data": "is_active" }
            ],
            "pageLength": 25,
            "responsive": true
        });
    }, 300); // Increased delay to 300ms to ensure all scripts are loaded
});
</script>
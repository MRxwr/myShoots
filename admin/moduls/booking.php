	
    
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
											<table id="datable_1" class="table table-hover display pb-30" >
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
    $('#datable_1').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "moduls/booking_ajax.php",
            "type": "POST"
        },
        "columns": [
            { "data": 0, "orderable": false },
            { "data": 1 },
            { "data": 2 },
            { "data": 3 },
            { "data": 4 },
            { "data": 5 },
            { "data": 6 },
            { "data": 7 },
            { "data": 8 },
            { "data": 9, "orderable": false },
            { "data": 10 },
            { "data": 11 },
            { "data": 12, "orderable": false }
        ],
        "order": [[ 7, "desc" ]], // Order by booking date descending
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "language": {
            "processing": "Loading...",
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
            "emptyTable": "No booking data available" 
        },
        "responsive": true,
        "autoWidth": false
    });
});
</script>
<?php 
require_once("../admin2/includes/config.php");
require_once("../admin2/includes/functions.php");

if( isset($_POST['searchquery']) && !empty($_POST['searchquery']) && $booking = selectDBNew("tbl_booking", [$_POST['searchquery']], "`transaction_id` = ?","") ){
	$booking = $booking[0];
}else{
	echo "<table><tr><td colspan='11' class='error'>No Search Data Found.</td></tr></table>";die();
}	
?>

<?php
$status = ($booking['status'] === 'Yes') ? direction('Successful Booking','حجز ناجح') : direction('Failed Booking','حجز فاشل');
$statusColor = ($booking['status'] === 'Yes') ? 'green' : 'red';
$package = get_packages_details($booking['package_id']);
$post_title = $package[direction('en','ar').'Title'];
$booking_date = $booking['booking_date'];
$booking_time = $booking['booking_time'];
$personalInfo = json_decode($booking['personal_info'], true);
$fields = selectDB('tbl_personal_info', "`id` != '0'");
$titles = array();
foreach ($fields as $field) {
	$titles[$field['id']] = direction('en', 'ar') == 'en' ? $field['enTitle'] : $field['arTitle'];
}
?>
<div class="panel panel-default card-view">
	<div class="panel-heading">
		<div class="pull-left">
			<h2 class="shoots-Head"><?php echo direction("Search Result","نتيجة البحث") ?></h2>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-wrapper">
		<div class="panel-body">
			<div class="table-wrap">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<td colspan="2" style="color:<?php echo $statusColor; ?>;font-weight:bold;font-size:18px;text-align:center;">
								<?php echo $status; ?>
							</td>
						</tr>
						<tr>
							<th><?php echo direction("Reservation ID","رقم الحجز") ?></th>
							<td><?php echo htmlspecialchars($booking['transaction_id']); ?></td>
						</tr>
						<tr>
							<th><?php echo direction("Package Choosen","الباقة المختارة") ?>:</th>
							<td><?php echo htmlspecialchars($post_title); ?></td>
						</tr>
						<tr>
							<th><?php echo direction("Date","التاريخ") ?>:</th>
							<td><?php echo htmlspecialchars($booking_date); ?></td>
						</tr>
						<tr>
							<th><?php echo direction("Time","الوقت") ?>:</th>
							<td><?php echo htmlspecialchars($booking_time); ?></td>
						</tr>
						<?php
						if ($personalInfo && is_array($personalInfo)) {
							echo '<tr><th>'.direction("Personal Info","معلومات العميل").':</th><td>';
							foreach ($personalInfo as $key => $value) {
								$title = isset($titles[$key]) ? $titles[$key] : $key;
								echo '<div><strong>'.htmlspecialchars($title).':</strong> '.htmlspecialchars($value).'</div>';
							}
							echo '</td></tr>';
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
                        
  
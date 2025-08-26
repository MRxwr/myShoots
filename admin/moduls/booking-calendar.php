<div class="body">
	<?php if(isset($_SESSION['login']))
		{
			//echo $_SESSION['login'];
			//unset($_SESSION['login']);
		}
	?>
	<h2><?php //echo $lang['welcome'] ?></h2>
	<br>
	<p>
		<?php //echo $lang['welcome_message'] ?>
	</p>
</div>
<div class="container-fluid pt-25">
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
	<!-- Row -->
</div>

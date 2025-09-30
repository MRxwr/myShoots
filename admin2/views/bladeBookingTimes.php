<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB("tbl_times",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=BookingTimes");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB("tbl_times",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=BookingTimes");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB("tbl_times",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=BookingTimes");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("tbl_times",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=BookingTimes");
}

if( isset($_POST["startTime"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	
	// Convert 24-hour times to AM/PM format
	if(isset($_POST["startTime"]) && !empty($_POST["startTime"])) {
		// Handle various time formats
		$timeParts = explode(':', $_POST["startTime"]);
		if(count($timeParts) >= 2) {
			$hours = intval($timeParts[0]);
			$minutes = intval($timeParts[1]);
			
			$ampm = ($hours >= 12) ? 'PM' : 'AM';
			$hours = $hours % 12;
			$hours = $hours ? $hours : 12; // Convert 0 to 12
			
			$_POST["startTime"] = sprintf("%d:%02d %s", $hours, $minutes, $ampm);
		}
	}
	
	if(isset($_POST["closeTime"]) && !empty($_POST["closeTime"])) {
		// Handle various time formats
		$timeParts = explode(':', $_POST["closeTime"]);
		if(count($timeParts) >= 2) {
			$hours = intval($timeParts[0]);
			$minutes = intval($timeParts[1]);
			
			$ampm = ($hours >= 12) ? 'PM' : 'AM';
			$hours = $hours % 12;
			$hours = $hours ? $hours : 12; // Convert 0 to 12
			
			$_POST["closeTime"] = sprintf("%d:%02d %s", $hours, $minutes, $ampm);
		}
	}
	
	if ( $id == 0 ){
		if( insertDB("tbl_times", $_POST) ){
			header("LOCATION: ?v=BookingTimes");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("tbl_times", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=BookingTimes");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Booking Time Details","تفاصيل وقت الحجز") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-4">
			<label><?php echo direction("Start Time","وقت البدء") ?></label>
			<input type="time" name="startTime" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Close Time","وقت الإغلاق") ?></label>
			<input type="time" name="closeTime" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Hide Category","أخفي القسم") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">No</option>
				<option value="2">Yes</option>
			</select>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("Booking Times List","قائمة أوقات الحجز") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary">
<?php echo direction("Submit rank","أرسل الترتيب") ?>
</button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Start Time","وقت البدء") ?></th>
		<th><?php echo direction("Close Time","وقت الإغلاق") ?></th>
		<th class="text-nowrap"><?php echo direction("Action","الإجراء") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $times = selectDB("tbl_times","`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($times); $i++ ){
				$counter = $i + 1;
			if ( $times[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$times[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$times[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
			?>
			<tr>
			<td>
			<input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter, 2, '0', STR_PAD_LEFT) ?>">
			<input name="id[]" class="form-control" type="hidden" value="<?php echo $times[$i]["id"] ?>">
			</td>
			<td id="startTime<?php echo $times[$i]["id"]?>" ><?php echo $times[$i]["startTime"] ?></td>
			<td id="closeTime<?php echo $times[$i]["id"]?>" ><?php echo $times[$i]["closeTime"] ?></td>
			<td class="text-nowrap">
                <a id="<?php echo $times[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="btn btn-warning btn-circle fa fa-pencil text-inverse m-r-10" style="align-content: center;"></i>
                </a>
                <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="btn btn-default btn-circle <?php echo $icon ?> text-inverse m-r-10" style="align-content: center;"></i>
                </a>
                <a href="<?php echo "?v={$_GET["v"]}&delId={$times[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="btn btn-danger btn-circle fa fa-close" style="align-content: center;"></i>
                </a>
			</td>
			</tr>
			<?php
			}
		}
		?>
		</tbody>
		
	</table>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
<script>
$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);

		// Convert AM/PM format back to 24-hour format for HTML time input
		var startTimeAMPM = $("#startTime"+id).html();
		var closeTimeAMPM = $("#closeTime"+id).html();
		
		// Convert AM/PM to 24-hour format
		function convertTo24Hour(time12h) {
			if (!time12h) return '';
			
			// Handle case when time12h might not have AM/PM
			if (time12h.indexOf(' ') === -1) {
				return time12h; // Already might be in 24-hour format
			}
			
			const parts = time12h.split(' ');
			const time = parts[0];
			const modifier = parts[1];
			
			if (!time || !modifier) return time12h;
			
			let [hours, minutes] = time.split(':');
			hours = parseInt(hours, 10);
			
			if (modifier.toUpperCase() === 'PM' && hours < 12) {
				hours = hours + 12;
			}
			
			if (modifier.toUpperCase() === 'AM' && hours === 12) {
				hours = 0;
			}
			
			return `${hours.toString().padStart(2, '0')}:${minutes}`;
		}
		
		$("input[name=startTime]").val(convertTo24Hour(startTimeAMPM)).focus();
		$("input[name=closeTime]").val(convertTo24Hour(closeTimeAMPM));
})
</script>
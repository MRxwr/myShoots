<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB("tbl_disabled_date",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=BookingBlockingDates");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB("tbl_disabled_date",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=BookingBlockingDates");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB("tbl_disabled_date",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=BookingBlockingDates");
	}
}

if( isset($_POST["startBlock"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	$_POST["timeSlots"] = isset($_POST["timeSlots"]) ? json_encode($_POST["timeSlots"]) : json_encode([]);
	$_POST["packages"] = isset($_POST["packages"]) ? json_encode($_POST["packages"]) : json_encode([]);
	// if packages empty then add all packages ids to the json array
	if( empty($_POST["packages"]) ){
		if( $allPackages = selectDB("tbl_packages","`hidden` = '1' AND `status` = '0'") ){
			$packageIds = array();
			foreach($allPackages as $pkg){
				$packageIds[] = $pkg["id"];
			}
			$_POST["packages"] = json_encode($packageIds);
		}
	}
	// same thing for time slots
	if( empty($_POST["timeSlots"]) ){
		if( $allTimes = selectDB("tbl_times","`hidden` = '1' AND `status` = '0'") ){
			$timeIds = array();
			foreach($allTimes as $time){
				$timeIds[] = $time["id"];
			}
			$_POST["timeSlots"] = json_encode($timeIds);
		}
	}
	if ( $id == 0 ){
		if( insertDB("tbl_disabled_date", $_POST) ){
			header("LOCATION: ?v=BookingBlockingDates");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("tbl_disabled_date", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=BookingBlockingDates");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Blocking Date Details","تفاصيل تاريخ الحجز") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-4">
			<label><?php echo direction("Start Date","تاريخ البدء") ?></label>
			<input type="date" name="startBlock" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("End Date","تاريخ الانتهاء") ?></label>
			<input type="date" name="endBlock" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Hide","أخفي") ?></label>
			<select name="hidden" class="form-control">
				<option value="1"><?php echo direction("No","لا") ?></option>
				<option value="2"><?php echo direction("Yes","نعم") ?></option>
			</select>
			</div>

			<div class="col-md-12" style="margin-top:10px">
			<label><?php echo direction("Packages","الباقات") ?></label>
			<select name="packages[]" class="form-control" multiple>
			<?php
			if( $packages = selectDB("tbl_packages","`hidden` = '1' AND `status` = '0' ORDER BY `id` ASC") ){
				foreach($packages as $i=>$package){
					?>
					<option value="<?php echo $package["id"] ?>"><?php echo direction($package["enTitle"],$package["arTitle"]) ?></option>
					<?php
				}
			}
			?>
			</select>
			</div>

			<div class="col-md-12" style="margin-top:10px">
			<label><?php echo direction("Time Slots","وقت المواعيد") ?></label>
			<select name="timeSlots[]" class="form-control" multiple>
			<?php
			if( $times = selectDB("tbl_times","`hidden` = '1' AND `status` = '0' ORDER BY `id` ASC") ){
				foreach($times as $i=>$time){
					?>
					<option value="<?php echo $time["id"] ?>"><?php echo $time["startTime"]." - ".$time["closeTime"] ?></option>
					<?php
				}
			}
			?>
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
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("Blocking Dates List","قائمة تواريخ الحجز") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body"> 
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Start Date","تاريخ البدء") ?></th>
		<th><?php echo direction("End Date","تاريخ الانتهاء") ?></th>
		<th class="text-nowrap"><?php echo direction("Action","الإجراء") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $blocking = selectDB("tbl_disabled_date","`status` = '0' ORDER BY `id` ASC") ){
			for( $i = 0; $i < sizeof($blocking); $i++ ){
				$counter = $i + 1;
			if ( $blocking[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$blocking[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$blocking[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
			?>
			<tr>
			<td><?php echo str_pad($counter, 4, '0', STR_PAD_LEFT) ?></td>
			<td id="startBlock<?php echo $blocking[$i]["id"]?>" ><?php echo substr($blocking[$i]["startBlock"],0,10) ?></td>
			<td id="endBlock<?php echo $blocking[$i]["id"]?>" ><?php echo substr($blocking[$i]["endBlock"],0,10) ?></td>
			<td class="text-nowrap">
                <a id="<?php echo $blocking[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="btn btn-warning btn-circle fa fa-pencil text-inverse m-r-10" style="align-content: center;"></i>
                </a>
                <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="btn btn-default btn-circle <?php echo $icon ?> text-inverse m-r-10" style="align-content: center;"></i>
                </a>
                <a href="<?php echo "?v={$_GET["v"]}&delId={$blocking[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="btn btn-danger btn-circle fa fa-close" style="align-content: center;"></i>
                </a>
				<div style="display: none">
                	<label id="hidden<?php echo $blocking[$i]["id"]?>"><?php echo $blocking[$i]["hidden"] ?></label>
                	<label id="timeSlots<?php echo $blocking[$i]["id"]?>"><?php echo $blocking[$i]["timeSlots"] ?></label>
                	<label id="packages<?php echo $blocking[$i]["id"]?>"><?php echo $blocking[$i]["packages"] ?></label>
            	</div>
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
</div>
<script>
$(document).on("click", ".edit", function(){
	var id = $(this).attr("id");
	$("input[name=update]").val(id);

	$("input[name=startBlock]").val($("#startBlock"+id).html()).focus();
	$("input[name=endBlock]").val($("#endBlock"+id).html());
	// Pre-select time slots in the multi-select
	var slotsLabel = document.getElementById("timeSlots"+id);
	var select = document.querySelector("select[name='timeSlots[]']");
	if (slotsLabel && select) {
		try {
			var slots = JSON.parse(slotsLabel.textContent || slotsLabel.innerText);
			for (var i = 0; i < select.options.length; i++) {
				select.options[i].selected = slots.includes(select.options[i].value);
			}
		} catch(e) {}
	}
	// Pre-select packages in the multi-select
	var packagesLabel = document.getElementById("packages"+id);
	var select = document.querySelector("select[name='packages[]']");
	if (packagesLabel && select) {
		try {
			var packages = JSON.parse(packagesLabel.textContent || packagesLabel.innerText);
			for (var i = 0; i < select.options.length; i++) {
				select.options[i].selected = packages.includes(select.options[i].value);
			}
		} catch(e) {}
	}
	$("select[name=hidden]").val($("#hidden"+id).html());
});
</script>
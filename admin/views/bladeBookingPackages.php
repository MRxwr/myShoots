<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB("tbl_packages",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=BookingPackages");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB("tbl_packages",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=BookingPackages");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB("tbl_packages",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=BookingPackages");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("tbl_packages",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=BookingPackages");
}

if( isset($_POST["arTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);

	// Convert array of time slots to JSON string
	if(isset($_POST["time"]) && is_array($_POST["time"])) {
		$parsedTimeArray = [];
		foreach($_POST["time"] as $timeEntry) {
			if(is_string($timeEntry)) {
				$decodedTime = json_decode($timeEntry, true);
				if(is_array($decodedTime) && isset($decodedTime['startDate']) && isset($decodedTime['endDate'])) {
					$parsedTimeArray[] = $decodedTime;
				}
			}
		}
		$_POST["time"] = json_encode($parsedTimeArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	} else {
		$_POST["time"] = "[]";
	}

	// Convert array of extras to JSON string
	if(isset($_POST["extra_items"]) && is_array($_POST["extra_items"])) {
		$parsedExtraArray = [];
		foreach($_POST["extra_items"] as $extraEntry) {
			if(is_string($extraEntry)) {
				$decodedExtra = json_decode($extraEntry, true);
				if(is_array($decodedExtra) && isset($decodedExtra['item']) && isset($decodedExtra['price'])) {
					$parsedExtraArray[] = $decodedExtra;
				}
			}
		}
		$_POST["extra_items"] = json_encode($parsedExtraArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	} else {
		$_POST["extra_items"] = "[]";
	}

	// Convert array of personal info to JSON string
	if(isset($_POST["personal_info"]) && is_array($_POST["personal_info"])) {
		$parsedPersonalInfoArray = [];
		foreach($_POST["personal_info"] as $infoEntry) {
			if(is_string($infoEntry)) {
				$decodedInfo = json_decode($infoEntry, true);
				if(is_array($decodedInfo) && isset($decodedInfo['id']) && isset($decodedInfo['enTitle'])) {
					$parsedPersonalInfoArray[] = $decodedInfo;
				}
			}
		}
		$_POST["personalInfo"] = json_encode($parsedPersonalInfoArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	} else {
		$_POST["personalInfo"] = "[]";
	}
	unset($_POST["personal_info"]);

	// Convert array of themes to JSON string
	if(isset($_POST["themes"]) && is_array($_POST["themes"])) {
		$parsedThemesArray = [];
		foreach($_POST["themes"] as $themeEntry) {
			if(is_string($themeEntry)) {
				$decodedTheme = json_decode($themeEntry, true);
				if(is_array($decodedTheme) && isset($decodedTheme['id']) && isset($decodedTheme['enTitle'])) {
					$parsedThemesArray[] = $decodedTheme;
				}
			}
		}
		$_POST["themes"] = json_encode($parsedThemesArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	} else {
		$_POST["themes"] = "[]";
	}

	if ( $id == 0 ){
		if (is_uploaded_file($_FILES['imageurl']['tmp_name'])) {
			$_POST["imageurl"] = uploadImageBannerFreeImageHost($_FILES['imageurl']['tmp_name']);
		} else {
			$_POST["imageurl"] = "";
		}
		if( insertDB("tbl_packages", $_POST) ){
			header("LOCATION: ?v=BookingPackages");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if (is_uploaded_file($_FILES['imageurl']['tmp_name'])) {
			$_POST["imageurl"] = uploadImageBannerFreeImageHost($_FILES['imageurl']['tmp_name']);
		} else {
			$imageurl = selectDB("tbl_packages", "`id` = '{$id}'");
			$_POST["imageurl"] = $imageurl[0]["imageurl"];
		}
		if( updateDB("tbl_packages", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=BookingPackages");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Package Details","تفاصيل الباقة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-3">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Price","السعر") ?></label>
			<input type="number" step="any" name="price" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Hide","أخفي") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">No</option>
				<option value="2">Yes</option>
			</select>
			</div>
			
			<div class="col-md-12">
			<label><?php echo direction("Available Times","الأوقات المتاحة") ?></label>
			<select name="time[]" class="form-control" required multiple style="height: 150px;">
				<?php 
				if($times = selectDB("tbl_times", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
					foreach($times as $time){
						$timeObj = array(
							'startDate' => $time["startTime"],
							'endDate' => $time["closeTime"]
						);
						// Use JSON_UNESCAPED_UNICODE to avoid Unicode escaping
						$timeData = json_encode($timeObj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
						// Make sure to properly escape the value attribute
						echo '<option value="' . htmlspecialchars($timeData, ENT_QUOTES, 'UTF-8') . '">' . 
							$time["startTime"] . ' - ' . $time["closeTime"] . '</option>';
					}
				}
				?>
			</select>
			<small class="text-muted"><?php echo direction("Hold Ctrl/Cmd key to select multiple times","اضغط مع الاستمرار على مفتاح Ctrl/Cmd لتحديد أوقات متعددة") ?></small>
			</div>
			
			<div class="col-md-12">
			<label><?php echo direction("Available Extras","الإضافات المتاحة") ?></label>
			<select name="extra_items[]" class="form-control" multiple style="height: 150px;">
				<?php 
				if($extras = selectDB("tbl_extras", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
					foreach($extras as $extra){
						$extraObj = array(
							'item' => $extra["enTitle"],
							'item_en' => $extra["enTitle"],
							'item_ar' => $extra["arTitle"],
							'price' => $extra["price"]
						);
						$extraData = json_encode($extraObj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
						echo '<option value="' . htmlspecialchars($extraData, ENT_QUOTES, 'UTF-8') . '">' . 
							$extra["enTitle"] . ' / ' . $extra["arTitle"] . ' - ' . $extra["price"] . '</option>';
					}
				}
				?>
			</select>
			<small class="text-muted"><?php echo direction("Hold Ctrl/Cmd key to select multiple extras","اضغط مع الاستمرار على مفتاح Ctrl/Cmd لتحديد إضافات متعددة") ?></small>
			</div>

			<div class="col-md-12">
			<label><?php echo direction("Available Personal Info","المعلومات الشخصية المتاحة") ?></label>
			<select name="personal_info[]" class="form-control" multiple style="height: 150px;">
				<?php 
				if($personalInfos = selectDB("tbl_personal_info", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
					foreach($personalInfos as $info){
						$infoObj = array(
							'id' => $info["id"],
							'enTitle' => $info["enTitle"],
							'arTitle' => $info["arTitle"],
							'type' => $info["type"]
						);
						$infoData = json_encode($infoObj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
						echo '<option value="' . htmlspecialchars($infoData, ENT_QUOTES, 'UTF-8') . '">' . 
							$info["enTitle"] . ' / ' . $info["arTitle"] . '</option>';
					}
				}
				?>
			</select>
			<small class="text-muted"><?php echo direction("Hold Ctrl/Cmd key to select multiple personal info fields","اضغط مع الاستمرار على مفتاح Ctrl/Cmd لتحديد معلومات شخصية متعددة") ?></small>
			</div>

			<div class="col-md-12">
			<label><?php echo direction("Available Theme Categories","فئات المواضيع المتاحة") ?></label>
			<select name="themes[]" class="form-control" multiple style="height: 150px;">
				<?php 
				if($themeCategories = selectDB("tbl_themes_categories", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
					foreach($themeCategories as $themeCategory){
						$themeCategoryObj = array(
							'id' => $themeCategory["id"],
							'enTitle' => $themeCategory["enTitle"],
							'arTitle' => $themeCategory["arTitle"]
						);
						$themeCategoryData = json_encode($themeCategoryObj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
						echo '<option value="' . htmlspecialchars($themeCategoryData, ENT_QUOTES, 'UTF-8') . '">' . 
							$themeCategory["enTitle"] . ' / ' . $themeCategory["arTitle"] . '</option>';
					}
				}
				?>
			</select>
			<small class="text-muted"><?php echo direction("Hold Ctrl/Cmd key to select multiple theme categories","اضغط مع الاستمرار على مفتاح Ctrl/Cmd لتحديد فئات متعددة") ?></small>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></label>
			<textarea name="enDetails" class="tinymce"></textarea>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>
			<textarea name="arDetails" class="tinymce"></textarea>
			</div>
			
			<div class="col-md-12">
			<label><?php echo direction("Logo","الشعار") ?></label>
			<input type="file" name="imageurl" class="form-control" required>
			</div>
			
			<div id="images" style="margin-top: 10px; display:none">
				<div class="col-md-12">
				<img id="logoImg" src="" style="width:250px;height:250px">
				</div>
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
<h6 class="panel-title txt-dark"><?php echo direction("List Of Packages","قائمة الباقات") ?></h6>
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
		<th><?php echo direction("Rank","الترتيب") ?></th>
		<th><?php echo direction("Logo","الشعار") ?></th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th><?php echo direction("Price","السعر") ?></th>
		<?php /* <th><?php echo direction("Time","الوقت") ?></th> */ ?>
		<th class="text-nowrap"><?php echo direction("Action","الإجراء") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $packages = selectDB("tbl_packages","`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($packages); $i++ ){
				$counter = $i + 1;
			if ( $packages[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$packages[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$packages[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
			?>
			<tr>
			<td>
			<input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter, 2, '0', STR_PAD_LEFT) ?>" style="width: 100px;">
			<input name="id[]" class="form-control" type="hidden" value="<?php echo $packages[$i]["id"] ?>">
			</td>
			<td><img src="../logos/<?php echo $packages[$i]["imageurl"] ?>" style="width:100px;height:100px"></td>
			<td id="enTitle<?php echo $packages[$i]["id"]?>" ><?php echo $packages[$i]["enTitle"] ?></td>
			<td id="arTitle<?php echo $packages[$i]["id"]?>" ><?php echo $packages[$i]["arTitle"] ?></td>
			<td id="price<?php echo $packages[$i]["id"]?>" ><?php echo $packages[$i]["price"] ?></td>
			<td class="text-nowrap">
			
			<a id="<?php echo $packages[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="btn btn-warning btn-circle fa fa-pencil text-inverse m-r-10" style="align-content: center;"></i>
			</a>
			<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="btn btn-default btn-circle <?php echo $icon ?> text-inverse m-r-10" style="align-content: center;"></i>
			</a>
			<a href="<?php echo "?v={$_GET["v"]}&delId={$packages[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="btn btn-danger btn-circle fa fa-close" style="align-content: center;"></i>
			</a>
			<div style="display:none"><label id="hidden<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["hidden"] ?></label></div>
			<div style="display:none"><label id="enDetails<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["enDetails"] ?></label></div>
			<div style="display:none"><label id="arDetails<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["arDetails"] ?></label></div>
			<div style="display:none"><label id="price<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["price"] ?></label></div>
			<div style="display:none"><label id="logo<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["imageurl"] ?></label></div>
			<div style="display:none"><label id="time<?php echo $packages[$i]["id"]?>"><?php echo htmlspecialchars($packages[$i]["time"]) ?></label></div>
			<div style="display:none"><label id="extras<?php echo $packages[$i]["id"]?>"><?php echo htmlspecialchars($packages[$i]["extra_items"]) ?></label></div>
			<div style="display:none"><label id="personalInfo<?php echo $packages[$i]["id"]?>"><?php echo htmlspecialchars($packages[$i]["personalInfo"]) ?></label></div>
			<div style="display:none"><label id="themes<?php echo $packages[$i]["id"]?>"><?php echo htmlspecialchars($packages[$i]["themes"]) ?></label></div>
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

	$("input[name=arTitle]").val($("#arTitle"+id).html()).focus();
	$("input[name=enTitle]").val($("#enTitle"+id).html());
	tinymce.get('enDetails').setContent($("#enDetails"+id).html());
	tinymce.get('arDetails').setContent($("#arDetails"+id).html());
	$("select[name=hidden]").val($("#hidden"+id).html());
	$("select[name='time[]']").val(null);
	$("select[name='extras[]']").val(null);
	$("select[name='personal_info[]']").val(null);
	$("select[name='themes[]']").val(null);
	$("input[name=price]").val($("#price"+id).html());

	// Set multiple time selections
	if($("#time"+id).html() && $("#time"+id).html() !== ""){
		try {
			var timeContent = $("#time"+id).html();
			var timeData;
			try {
				timeData = JSON.parse(timeContent);
			} catch (e) {
				if (timeContent.startsWith('[') && timeContent.endsWith(']')) {
					try {
						timeContent = timeContent.replace(/\\\\/g, "\\").replace(/\\"/g, '"');
						timeData = JSON.parse(timeContent);
					} catch (innerE) {
						console.error("Could not parse time data even after cleanup:", innerE);
						timeData = [];
					}
				} else {
					console.error("Time data is not in expected format:", e);
					timeData = [];
				}
			}
			var timeSelect = $("select[name='time[]']");
			timeSelect.val(null);
			if (Array.isArray(timeData)) {
				timeData.forEach(function(timeItem) {
					timeSelect.find("option").each(function() {
						var optionVal = $(this).val();
						var optionData;
						try {
							optionData = JSON.parse(optionVal);
						} catch (e) {
							return;
						}
						if (timeItem.startDate && timeItem.endDate && 
							optionData.startDate && optionData.endDate &&
							timeItem.startDate === optionData.startDate && 
							timeItem.endDate === optionData.endDate) {
							$(this).prop('selected', true);
						}
					});
				});
			}
		} catch(e) {
			console.error("Error handling time data:", e);
		}
	}

	// Set multiple extras selections
	if($("#extras"+id).html() && $("#extras"+id).html() !== ""){
		try {
			var extrasContent = $("#extras"+id).html();
			var extrasData;
			try {
				extrasData = JSON.parse(extrasContent);
			} catch (e) {
				if (extrasContent.startsWith('[') && extrasContent.endsWith(']')) {
					try {
						extrasContent = extrasContent.replace(/\\\\/g, "\\").replace(/\\"/g, '"');
						extrasData = JSON.parse(extrasContent);
					} catch (innerE) {
						console.error("Could not parse extras data even after cleanup:", innerE);
						extrasData = [];
					}
				} else {
					console.error("Extras data is not in expected format:", e);
					extrasData = [];
				}
			}
			var extrasSelect = $("select[name='extra_items[]']");
			extrasSelect.val(null);
			if (Array.isArray(extrasData)) {
				extrasData.forEach(function(extraItem) {
					extrasSelect.find("option").each(function() {
						var optionVal = $(this).val();
						var optionData;
						try {
							optionData = JSON.parse(optionVal);
						} catch (e) {
							return;
						}
						if (extraItem.item && optionData.item &&
							extraItem.price && optionData.price &&
							extraItem.item === optionData.item &&
							extraItem.price == optionData.price) {
							$(this).prop('selected', true);
						}
					});
				});
			}
		} catch(e) {
			console.error("Error handling extras data:", e);
		}
	}

	// Set multiple personal info selections
	if($("#personalInfo"+id).html() && $("#personalInfo"+id).html() !== ""){
		try {
			var personalInfoContent = $("#personalInfo"+id).html();
			var personalInfoData;
			try {
				personalInfoData = JSON.parse(personalInfoContent);
			} catch (e) {
				if (personalInfoContent.startsWith('[') && personalInfoContent.endsWith(']')) {
					try {
						personalInfoContent = personalInfoContent.replace(/\\\\/g, "\\").replace(/\\"/g, '"');
						personalInfoData = JSON.parse(personalInfoContent);
					} catch (innerE) {
						console.error("Could not parse personal info data even after cleanup:", innerE);
						personalInfoData = [];
					}
				} else {
					console.error("Personal info data is not in expected format:", e);
					personalInfoData = [];
				}
			}
			var personalInfoSelect = $("select[name='personal_info[]']");
			personalInfoSelect.val(null);
			if (Array.isArray(personalInfoData)) {
				personalInfoData.forEach(function(infoItem) {
					personalInfoSelect.find("option").each(function() {
						var optionVal = $(this).val();
						var optionData;
						try {
							optionData = JSON.parse(optionVal);
						} catch (e) {
							return;
						}
						if (infoItem.id && optionData.id &&
							infoItem.id == optionData.id) {
							$(this).prop('selected', true);
						}
					});
				});
			}
		} catch(e) {
			console.error("Error handling personal info data:", e);
		}
	}

	// Set multiple themes selections
	if($("#themes"+id).html() && $("#themes"+id).html() !== ""){
		try {
			var themesContent = $("#themes"+id).html();
			var themesData;
			try {
				themesData = JSON.parse(themesContent);
			} catch (e) {
				if (themesContent.startsWith('[') && themesContent.endsWith(']')) {
					try {
						themesContent = themesContent.replace(/\\\\/g, "\\").replace(/\\"/g, '"');
						themesData = JSON.parse(themesContent);
					} catch (innerE) {
						console.error("Could not parse themes data even after cleanup:", innerE);
						themesData = [];
					}
				} else {
					console.error("Themes data is not in expected format:", e);
					themesData = [];
				}
			}
			var themesSelect = $("select[name='themes[]']");
			themesSelect.val(null);
			if (Array.isArray(themesData)) {
				themesData.forEach(function(themeItem) {
					themesSelect.find("option").each(function() {
						var optionVal = $(this).val();
						var optionData;
						try {
							optionData = JSON.parse(optionVal);
						} catch (e) {
							return;
						}
						if (themeItem.id && optionData.id &&
							themeItem.id == optionData.id) {
							$(this).prop('selected', true);
						}
					});
				});
			}
		} catch(e) {
			console.error("Error handling themes data:", e);
		}
	}

	$("input[type=file]").prop("required",false);
	$("#logoImg").attr("src","../logos/"+$("#logo"+id).html());
	$("#images").attr("style","margin-top:10px;display:block");
})
</script>
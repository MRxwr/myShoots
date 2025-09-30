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
		// Parse each time entry to make sure it's a proper JSON object
		$parsedTimeArray = [];
		foreach($_POST["time"] as $timeEntry) {
			if(is_string($timeEntry)) {
				// Decode and re-encode to ensure consistent format
				$decodedTime = json_decode($timeEntry, true);
				if(is_array($decodedTime) && isset($decodedTime['startDate']) && isset($decodedTime['endDate'])) {
					$parsedTimeArray[] = $decodedTime;
				}
			}
		}
		// Use JSON_UNESCAPED_UNICODE to avoid Unicode escaping and ensure readability
		$_POST["time"] = json_encode($parsedTimeArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	} else {
		$_POST["time"] = "[]";
	}
	
	// Convert array of extras to JSON string
	if(isset($_POST["extra_items"]) && is_array($_POST["extra_items"])) {
		// Parse each extra entry to make sure it's a proper JSON object
		$parsedExtraArray = [];
		foreach($_POST["extra_items"] as $extraEntry) {
			if(is_string($extraEntry)) {
				// Decode and re-encode to ensure consistent format
				$decodedExtra = json_decode($extraEntry, true);
				if(is_array($decodedExtra) && isset($decodedExtra['item']) && isset($decodedExtra['price'])) {
					$parsedExtraArray[] = $decodedExtra;
				}
			}
		}
		// Use JSON_UNESCAPED_UNICODE to avoid Unicode escaping and ensure readability
		$_POST["extra_items"] = json_encode($parsedExtraArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	} else {
		$_POST["extra_items"] = "[]";
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
	<h6 class="panel-title txt-dark"><?php echo direction("Category Details","تفاصيل القسم") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-4">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Hide Category","أخفي القسم") ?></label>
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
						// Use JSON_UNESCAPED_UNICODE to avoid Unicode escaping
						$extraData = json_encode($extraObj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
						// Make sure to properly escape the value attribute
						echo '<option value="' . htmlspecialchars($extraData, ENT_QUOTES, 'UTF-8') . '">' . 
							$extra["enTitle"] . ' / ' . $extra["arTitle"] . ' - ' . $extra["price"] . '</option>';
					}
				}
				?>
			</select>
			<small class="text-muted"><?php echo direction("Hold Ctrl/Cmd key to select multiple extras","اضغط مع الاستمرار على مفتاح Ctrl/Cmd لتحديد إضافات متعددة") ?></small>
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
<h6 class="panel-title txt-dark"><?php echo $List_of_Categories ?></h6>
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
		<th><?php echo direction("Logo","الشعار") ?></th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th><?php echo direction("Time","الوقت") ?></th>
		<th class="text-nowrap"><?php echo direction("Action","الإجراء") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $categories = selectDB("tbl_packages","`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($categories); $i++ ){
				$counter = $i + 1;
			if ( $categories[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$categories[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$categories[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
			?>
			<tr>
			<td>
			<input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter, 2, '0', STR_PAD_LEFT) ?>">
			<input name="id[]" class="form-control" type="hidden" value="<?php echo $categories[$i]["id"] ?>">
			</td>
			<td><img src="../logos/<?php echo $categories[$i]["imageurl"] ?>" style="width:100px;height:100px"></td>
			<td id="enTitle<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["enTitle"] ?></td>
			<td id="arTitle<?php echo $categories[$i]["id"]?>" ><?php echo $categories[$i]["arTitle"] ?></td>
			<td>
				<?php 
					if(!empty($categories[$i]["time"])) {
						// First try normal JSON decode
						$timeArray = json_decode($categories[$i]["time"], true);
						
						// If that fails, try to clean the string and decode again
						if(!is_array($timeArray)) {
							$cleanTime = str_replace('\\', '', $categories[$i]["time"]);
							$timeArray = json_decode($cleanTime, true);
						}
						
						// If still not an array, try one more method - could be a JSON string with escaped quotes
						if(!is_array($timeArray)) {
							// Remove surrounding quotes if present
							$tempTime = trim($categories[$i]["time"]);
							if(substr($tempTime, 0, 1) === '"' && substr($tempTime, -1) === '"') {
								$tempTime = substr($tempTime, 1, -1);
							}
							// Replace escaped backslashes and quotes
							$tempTime = str_replace('\\"', '"', $tempTime);
							$tempTime = str_replace('\\\\', '\\', $tempTime);
							
							$timeArray = json_decode($tempTime, true);
						}
						
						if(is_array($timeArray) && count($timeArray) > 0) {
							echo "<ul style='padding-left: 15px; margin-bottom: 0;'>";
							foreach($timeArray as $timeItem) {
								$timeData = is_string($timeItem) ? json_decode($timeItem, true) : $timeItem;
								if(isset($timeData['startDate']) && isset($timeData['endDate'])) {
									echo "<li>" . $timeData['startDate'] . " - " . $timeData['endDate'] . "</li>";
								}
							}
							echo "</ul>";
						} else {
							echo direction("No time set", "لا يوجد وقت محدد");
						}
					} else {
						echo direction("No time set", "لا يوجد وقت محدد");
					}
				?>
			</td>
			<td class="text-nowrap">
			
			<a id="<?php echo $categories[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="btn btn-warning btn-circle fa fa-pencil text-inverse m-r-10" style="align-content: center;"></i>
			</a>
			<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="btn btn-default btn-circle <?php echo $icon ?> text-inverse m-r-10" style="align-content: center;"></i>
			</a>
			<a href="<?php echo "?v={$_GET["v"]}&delId={$categories[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="btn btn-danger btn-circle fa fa-close" style="align-content: center;"></i>
			</a>
			<div style="display:none"><label id="hidden<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["hidden"] ?></label></div>
			<div style="display:none"><label id="enDetails<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["enDetails"] ?></label></div>
			<div style="display:none"><label id="arDetails<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["arDetails"] ?></label></div>
			<div style="display:none"><label id="logo<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["imageurl"] ?></label></div>
			<div style="display:none"><label id="time<?php echo $categories[$i]["id"]?>"><?php echo htmlspecialchars($categories[$i]["time"]) ?></label></div>
			<div style="display:none"><label id="extras<?php echo $categories[$i]["id"]?>"><?php echo htmlspecialchars($categories[$i]["extra_items"]) ?></label></div>
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
		
		// Set multiple time selections
		if($("#time"+id).html() && $("#time"+id).html() !== ""){
			try {
				// Handle the array or string format
				var timeContent = $("#time"+id).html();
				var timeData;
				// First try parsing as array
				try {
					timeData = JSON.parse(timeContent);
				} catch (e) {
					// If it failed, it might be a string containing the entire array with escaped quotes
					// Let's try to clean it up
					if (timeContent.startsWith('[') && timeContent.endsWith(']')) {
						try {
							// Replace escaped backslashes and quotes appropriately
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
				timeSelect.val(null); // Clear any previous selections				
				// Select each time in the timeData array
				if (Array.isArray(timeData)) {
					timeData.forEach(function(timeItem) {
						// Find the option that matches this time
						timeSelect.find("option").each(function() {
							var optionVal = $(this).val();
							var optionData;
							try {
								optionData = JSON.parse(optionVal);
							} catch (e) {
								return; // Skip this option if it's not valid JSON
							}
							// Compare startDate and endDate
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
                // Try parsing as array
                try {
                    extrasData = JSON.parse(extrasContent);
                } catch (e) {
                    // Try to clean up if needed
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
                extrasSelect.val(null); // Clear previous selections
                // Select each extra in the extrasData array
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
                            // Compare item and price
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
		
		$("input[type=file]").prop("required",false);
		$("#logoImg").attr("src","../logos/"+$("#logo"+id).html());
		$("#images").attr("style","margin-top:10px;display:block");
})
</script>
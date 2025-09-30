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
			
			<div id="time-select" class="col-md-12">
			<label><?php echo direction("Available Times","الأوقات المتاحة") ?></label>
			<select name="time[]" class="form-control" required multiple>
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
			<small class="text-muted"><?php echo direction("Click on the dropdown to select times","انقر على القائمة المنسدلة لتحديد الأوقات") ?></small>
			</div>
			
			<div id="extras-select" class="col-md-12">
			<label><?php echo direction("Available Extras","الإضافات المتاحة") ?></label>
			<select name="extra_items[]" class="form-control" multiple>
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
			<small class="text-muted"><?php echo direction("Click on the dropdown to select extras","انقر على القائمة المنسدلة لتحديد الإضافات") ?></small>
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
		<th><?php echo direction("Extras","الإضافات") ?></th>
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
			<td>
				<?php 
					if(!empty($categories[$i]["extra_items"])) {
						// First try normal JSON decode
						$extraArray = json_decode($categories[$i]["extra_items"], true);
						
						// If that fails, try to clean the string and decode again
						if(!is_array($extraArray)) {
							$cleanExtra = str_replace('\\', '', $categories[$i]["extra_items"]);
							$extraArray = json_decode($cleanExtra, true);
						}
						
						// If still not an array, try one more method - could be a JSON string with escaped quotes
						if(!is_array($extraArray)) {
							// Remove surrounding quotes if present
							$tempExtra = trim($categories[$i]["extra_items"]);
							if(substr($tempExtra, 0, 1) === '"' && substr($tempExtra, -1) === '"') {
								$tempExtra = substr($tempExtra, 1, -1);
							}
							// Replace escaped backslashes and quotes
							$tempExtra = str_replace('\\"', '"', $tempExtra);
							$tempExtra = str_replace('\\\\', '\\', $tempExtra);
							
							$extraArray = json_decode($tempExtra, true);
						}
						
						if(is_array($extraArray) && count($extraArray) > 0) {
							echo "<ul style='padding-left: 15px; margin-bottom: 0;'>";
							foreach($extraArray as $extraItem) {
								$extraData = is_string($extraItem) ? json_decode($extraItem, true) : $extraItem;
								if(isset($extraData['item']) && isset($extraData['price'])) {
									echo "<li>" . $extraData['item_en'] . " / " . $extraData['item_ar'] . " - " . $extraData['price'] . "</li>";
								}
							}
							echo "</ul>";
						} else {
							echo direction("No extras set", "لا يوجد إضافات");
						}
					} else {
						echo direction("No extras set", "لا يوجد إضافات");
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
			<div style="display:none"><label id="extra_items<?php echo $categories[$i]["id"]?>"><?php echo htmlspecialchars($categories[$i]["extra_items"]) ?></label></div>
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
$(document).ready(function() {
    // Convert select dropdowns to checkbox-style multi-select
    createMultiSelectWithCheckboxes('time-select');
    createMultiSelectWithCheckboxes('extras-select');
    
    // Style fixes for RTL support
    if ($('html').attr('dir') === 'rtl') {
        $('.checkbox-item label').css('margin-right', '5px');
        $('.checkbox-item label').css('margin-left', '0');
    }
});

function createMultiSelectWithCheckboxes(containerId) {
    // Get the select element and its options
    var $select = $('#' + containerId + ' select');
    var selectName = $select.attr('name');
    var isRequired = $select.attr('required') !== undefined;
    
    // Get appropriate labels based on the container
    var selectAllText = containerId === 'time-select' ? 
        '<?php echo direction("Select All Times", "حدد كل الأوقات") ?>' : 
        '<?php echo direction("Select All Extras", "حدد كل الإضافات") ?>';
    
    var placeholderText = containerId === 'time-select' ? 
        '<?php echo direction("Select Times", "حدد الأوقات") ?>' : 
        '<?php echo direction("Select Extras", "حدد الإضافات") ?>';
    
    // Create the dropdown container
    var $container = $('<div class="checkbox-dropdown-container"></div>');
    var $dropdownHeader = $('<div class="dropdown-header"></div>');
    var $dropdownText = $('<div class="dropdown-text">' + placeholderText + '</div>');
    var $dropdownList = $('<div class="dropdown-list" style="display:none;"></div>');
    
    // Add select all checkbox
    var selectAllId = 'select_all_' + containerId;
    var $selectAllItem = $('<div class="checkbox-item select-all-item"></div>');
    $selectAllItem.append('<input type="checkbox" id="' + selectAllId + '">');
    $selectAllItem.append('<label for="' + selectAllId + '">' + selectAllText + '</label>');
    $dropdownList.append($selectAllItem);
    
    // Add search input if there are many options
    if ($select.find('option').length > 5) {
        var searchPlaceholder = containerId === 'time-select' ? 
            '<?php echo direction("Search times...", "البحث عن الأوقات...") ?>' : 
            '<?php echo direction("Search extras...", "البحث عن الإضافات...") ?>';
        
        var $searchContainer = $('<div class="search-container"></div>');
        var $searchInput = $('<input type="text" class="search-input" placeholder="' + searchPlaceholder + '">');
        $searchContainer.append($searchInput);
        $dropdownList.append($searchContainer);
        
        // Handle search functionality
        $searchInput.on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            $('.checkbox-item:not(.select-all-item)', $dropdownList).each(function() {
                var itemText = $('label', this).text().toLowerCase();
                if (itemText.indexOf(searchText) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Stop propagation when typing in search box
        $searchInput.on('click', function(e) {
            e.stopPropagation();
        });
    }
    
    $dropdownHeader.append($dropdownText);
    $container.append($dropdownHeader);
    $container.append($dropdownList);
    
    // Convert options to checkboxes
    $select.find('option').each(function() {
        var value = $(this).val();
        var text = $(this).text();
        var id = 'chk_' + containerId + '_' + Math.floor(Math.random() * 1000000);
        
        var $checkbox = $('<div class="checkbox-item"></div>');
        $checkbox.append('<input type="checkbox" id="' + id + '" value="' + value + '" data-name="' + selectName + '">');
        $checkbox.append('<label for="' + id + '">' + text + '</label>');
        
        $dropdownList.append($checkbox);
    });
    
    // Replace the select with our custom dropdown
    $select.hide();
    $select.after($container);
    
    // Handle select all checkbox
    $('#' + selectAllId).on('change', function() {
        var isChecked = $(this).prop('checked');
        $dropdownList.find('input[type="checkbox"]:not(#' + selectAllId + ')').prop('checked', isChecked);
        updateSelectFromCheckboxes(containerId);
    });
    
    // Handle dropdown toggling with arrow rotation
    $dropdownHeader.on('click', function() {
        var isOpen = $dropdownList.is(':visible');
        
        // Close any other open dropdowns
        $('.dropdown-list').hide();
        $('.dropdown-header:after').css('transform', 'rotate(0deg)');
        
        if (isOpen) {
            $dropdownList.hide();
            $(this).find(':after').css('transform', 'rotate(0deg)');
        } else {
            $dropdownList.show();
            $(this).find(':after').css('transform', 'rotate(180deg)');
            
            // Focus search input if it exists
            $dropdownList.find('.search-input').focus();
        }
    });
    
    // Handle checkbox changes
    $dropdownList.find('input[type="checkbox"]').on('change', function() {
        if ($(this).attr('id') !== selectAllId) {
            // Update "Select All" checkbox based on other checkboxes
            var allChecked = $dropdownList.find('input[type="checkbox"]:not(#' + selectAllId + ')').length === 
                            $dropdownList.find('input[type="checkbox"]:not(#' + selectAllId + '):checked').length;
            
            $('#' + selectAllId).prop('checked', allChecked);
        }
        
        updateSelectFromCheckboxes(containerId);
    });
    
    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#' + containerId + ' .checkbox-dropdown-container').length) {
            $dropdownList.hide();
        }
    });
    
    // Stop propagation for checkboxes to prevent dropdown from closing
    $dropdownList.on('click', function(e) {
        e.stopPropagation();
    });
}

function updateSelectFromCheckboxes(containerId) {
    var $select = $('#' + containerId + ' select');
    var $checkboxes = $('#' + containerId + ' .checkbox-item:not(.select-all-item) input[type="checkbox"]:checked');
    
    // Clear all selected options
    $select.find('option:selected').prop('selected', false);
    
    // Select options based on checked checkboxes
    $checkboxes.each(function() {
        var value = $(this).val();
        $select.find('option').each(function() {
            if ($(this).val() === value) {
                $(this).prop('selected', true);
            }
        });
    });
    
    // Update the dropdown text to show selected count
    var selectedCount = $checkboxes.length;
    var $dropdownText = $('#' + containerId + ' .dropdown-text');
    var totalOptions = $('#' + containerId + ' .checkbox-item:not(.select-all-item)').length;
    
    if (containerId === 'time-select') {
        if (selectedCount === 0) {
            $dropdownText.text('<?php echo direction("Select Times", "حدد الأوقات") ?>');
        } else if (selectedCount === totalOptions) {
            $dropdownText.text('<?php echo direction("All Times Selected", "تم تحديد جميع الأوقات") ?>');
        } else {
            $dropdownText.text(selectedCount + ' <?php echo direction("Times Selected", "تم تحديد الأوقات") ?>');
        }
    } else {
        if (selectedCount === 0) {
            $dropdownText.text('<?php echo direction("Select Extras", "حدد الإضافات") ?>');
        } else if (selectedCount === totalOptions) {
            $dropdownText.text('<?php echo direction("All Extras Selected", "تم تحديد جميع الإضافات") ?>');
        } else {
            $dropdownText.text(selectedCount + ' <?php echo direction("Extras Selected", "تم تحديد الإضافات") ?>');
        }
    }
}

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
				
				// Clear previous selections
				$('#time-select input[type="checkbox"]').prop('checked', false);
				
				// Select each time in the timeData array
				if (Array.isArray(timeData)) {
					timeData.forEach(function(timeItem) {
						// Find the checkbox that matches this time
						$('#time-select .checkbox-item:not(.select-all-item) input[type="checkbox"]').each(function() {
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
								$(this).prop('checked', true);
							}
						});
					});
					
					// Check if all times are selected to update "Select All" checkbox
					var allTimesSelected = $('#time-select .checkbox-item:not(.select-all-item) input[type="checkbox"]').length === 
						$('#time-select .checkbox-item:not(.select-all-item) input[type="checkbox"]:checked').length;
					
					$('#select_all_time-select').prop('checked', allTimesSelected);
					
					// Update select from checkboxes
					updateSelectFromCheckboxes('time-select');
				}
			} catch(e) {
				console.error("Error handling time data:", e);
			}
		}
		
		// Set multiple extras selections
		if($("#extra_items"+id).html() && $("#extra_items"+id).html() !== ""){
			try {
				// Handle the array or string format
				var extraContent = $("#extra_items"+id).html();
				var extraData;
				
				// First try parsing as array
				try {
					extraData = JSON.parse(extraContent);
				} catch (e) {
					// If it failed, it might be a string containing the entire array with escaped quotes
					// Let's try to clean it up
					if (extraContent.startsWith('[') && extraContent.endsWith(']')) {
						try {
							// Replace escaped backslashes and quotes appropriately
							extraContent = extraContent.replace(/\\\\/g, "\\").replace(/\\"/g, '"');
							extraData = JSON.parse(extraContent);
						} catch (innerE) {
							console.error("Could not parse extra data even after cleanup:", innerE);
							extraData = [];
						}
					} else {
						console.error("Extra data is not in expected format:", e);
						extraData = [];
					}
				}
				
				// Clear previous selections
				$('#extras-select input[type="checkbox"]').prop('checked', false);
				
				// Select each extra in the extraData array
				if (Array.isArray(extraData)) {
					extraData.forEach(function(extraItem) {
						// Find the checkbox that matches this extra
						$('#extras-select .checkbox-item:not(.select-all-item) input[type="checkbox"]').each(function() {
							var optionVal = $(this).val();
							var optionData;
							
							try {
								optionData = JSON.parse(optionVal);
							} catch (e) {
								return; // Skip this option if it's not valid JSON
							}
							
							// Compare item and price
							if (extraItem.item && extraItem.price && 
								optionData.item && optionData.price &&
								extraItem.item === optionData.item && 
								extraItem.price === optionData.price) {
								$(this).prop('checked', true);
							}
						});
					});
					
					// Check if all extras are selected to update "Select All" checkbox
					var allExtrasSelected = $('#extras-select .checkbox-item:not(.select-all-item) input[type="checkbox"]').length === 
						$('#extras-select .checkbox-item:not(.select-all-item) input[type="checkbox"]:checked').length;
					
					$('#select_all_extras-select').prop('checked', allExtrasSelected);
					
					// Update select from checkboxes
					updateSelectFromCheckboxes('extras-select');
				}
			} catch(e) {
				console.error("Error handling extra data:", e);
			}
		}
		
		$("input[type=file]").prop("required",false);
		$("#logoImg").attr("src","../logos/"+$("#logo"+id).html());
		$("#images").attr("style","margin-top:10px;display:block");
})
</script>

<style>
.checkbox-dropdown-container {
    position: relative;
    width: 100%;
    margin-bottom: 15px;
    font-family: inherit;
}

.dropdown-header {
    border: 1px solid #e2e2e2;
    padding: 10px 15px;
    cursor: pointer;
    background-color: #ffffff;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.dropdown-header:hover {
    background-color: #f8f8f8;
    border-color: #d8d8d8;
}

.dropdown-header:after {
    content: '▼';
    font-size: 10px;
    color: #666;
    transition: transform 0.2s ease;
}

.dropdown-list {
    position: absolute;
    width: 100%;
    border: 1px solid #d8d8d8;
    border-top: none;
    max-height: 250px;
    overflow-y: auto;
    background-color: white;
    z-index: 1000;
    border-radius: 0 0 4px 4px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-top: -1px;
}

.checkbox-item {
    padding: 10px 15px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s ease;
}

.checkbox-item:last-child {
    border-bottom: none;
}

.checkbox-item:hover {
    background-color: #f5f5f5;
}

.checkbox-item label {
    margin-left: 8px;
    cursor: pointer;
    flex: 1;
    font-weight: normal;
    color: #333;
}

.checkbox-item input[type="checkbox"] {
    cursor: pointer;
    width: 16px;
    height: 16px;
}

/* For RTL support */
html[dir="rtl"] .dropdown-header:after {
    margin-right: 10px;
    margin-left: 0;
}

html[dir="rtl"] .checkbox-item label {
    margin-right: 8px;
    margin-left: 0;
}

/* Search input styling */
.search-container {
    padding: 10px;
    border-bottom: 1px solid #e2e2e2;
    background-color: #f9f9f9;
}

.search-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.2s;
}

.search-input:focus {
    border-color: #999;
}

/* Select All styling */
.select-all-item {
    background-color: #f9f9f9;
    border-bottom: 2px solid #e2e2e2;
    font-weight: bold;
}

/* Active dropdown styling */
.dropdown-header.active:after {
    transform: rotate(180deg);
}
</style>
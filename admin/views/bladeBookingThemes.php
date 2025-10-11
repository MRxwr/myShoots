<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
    if( updateDB("tbl_themes_categories",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=BookingThemes");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
    if( updateDB("tbl_themes_categories",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=BookingThemes");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
    if( updateDB("tbl_themes_categories",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=BookingThemes");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
        updateDB("tbl_themes_categories",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=BookingThemes");
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
    if( insertDB("tbl_themes_categories", $_POST) ){
			header("LOCATION: ?v=BookingThemes");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
    if( updateDB("tbl_themes_categories", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=BookingThemes");
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
			<label><?php echo direction("Hide","أخفي") ?></label>
			<select name="hidden" class="form-control">
				<option value="1"><?php echo direction("No","لا") ?></option>
				<option value="2"><?php echo direction("Yes","نعم") ?></option>
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
<h6 class="panel-title txt-dark"><?php echo direction("Categories List","قائمة الأقسام") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body"> 
<button class="btn btn-primary"><?php echo direction("Submit rank","أرسل الترتيب") ?></button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
        <th><?php echo direction("Rank","الترتيب") ?></th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th class="text-nowrap"><?php echo direction("Action","الإجراء") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
    if( $themes = selectDB("tbl_themes_categories","`status` = '0' ORDER BY `id` ASC") ){
			for( $i = 0; $i < sizeof($themes); $i++ ){
				$counter = $i + 1;
			if ( $themes[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$themes[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$themes[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
			?>
			<tr>
            <td>
			<input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter, 2, '0', STR_PAD_LEFT) ?>" style="width: 100px;">
			<input name="id[]" class="form-control" type="hidden" value="<?php echo $extras[$i]["id"] ?>">
			</td>   
			<td id="enTitle<?php echo $themes[$i]["id"]?>" ><?php echo $themes[$i]["enTitle"] ?></td>
			<td id="arTitle<?php echo $themes[$i]["id"]?>" ><?php echo $themes[$i]["arTitle"] ?></td>
			<td class="text-nowrap">
                <a id="<?php echo $themes[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="btn btn-warning btn-circle fa fa-pencil text-inverse m-r-10" style="align-content: center;"></i></a>
                <a id="<?php echo $themes[$i]["id"] ?>" class="mr-25 photos" data-toggle="tooltip" data-original-title="<?php echo direction("Photos","صور") ?>"> <i class="btn btn-success btn-circle fa fa-image text-inverse m-r-10" style="align-content: center;"></i></a>
                <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="btn btn-default btn-circle <?php echo $icon ?> text-inverse m-r-10" style="align-content: center;"></i></a>
                <a href="<?php echo "?v={$_GET["v"]}&delId={$themes[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="btn btn-danger btn-circle fa fa-close" style="align-content: center;"></i></a>
			</td>
            <div style="display: none">
                <label id="hidden<?php echo $themes[$i]["id"]?>"><?php echo $themes[$i]["hidden"] ?></label>
            </div>
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

<!-- Gallery Images Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo direction("Gallery Photos","صور المعرض") ?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="current_category_id" value="">
                
                <!-- Add New Images Section -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5><?php echo direction("Add New Images","إضافة صور جديدة") ?></h5>
                    </div>
                    <div class="panel-body">
                        <div id="image-upload-container">
                            <div class="image-upload-row mb-3 panel panel-default" style="padding:15px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
                                        <input type="text" class="form-control enTitle-input" placeholder="<?php echo direction("English Title","العنوان بالإنجليزي") ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
                                        <input type="text" class="form-control arTitle-input" placeholder="<?php echo direction("Arabic Title","العنوان بالعربي") ?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></label>
                                        <textarea class="form-control enDetails-input" rows="2" placeholder="<?php echo direction("English Details","التفاصيل بالإنجليزي") ?>"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>
                                        <textarea class="form-control arDetails-input" rows="2" placeholder="<?php echo direction("Arabic Details","التفاصيل بالعربي") ?>"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-8">
                                        <label><?php echo direction("Image","الصورة") ?></label>
                                        <input type="file" class="form-control image-input" accept="image/*">
                                    </div>
                                    <div class="col-md-4" style="padding-top:25px;">
                                        <button type="button" class="btn btn-primary upload-single-btn"><?php echo direction("Upload","رفع") ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="add-more-images"><?php echo direction("Add More","إضافة المزيد") ?></button>
                    </div>
                </div>

                <!-- Existing Images Section -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5><?php echo direction("Current Images","الصور الحالية") ?></h5>
                    </div>
                    <div class="panel-body">
                        <div id="existing-images-container" class="row">
                            <!-- Images will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo direction("Close","إغلاق") ?></button>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-image-item {
    position: relative;
    display: inline-block;
    margin: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #f9f9f9;
}
.gallery-image-item img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 2px solid #ddd;
    border-radius: 5px;
}
.gallery-image-info {
    margin-top: 10px;
    font-size: 12px;
}
.gallery-image-info strong {
    display: block;
    margin-bottom: 5px;
}
.delete-image-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-weight: bold;
    font-size: 18px;
    line-height: 1;
}
.delete-image-btn:hover {
    background: darkred;
}
</style>

<script>
// Open photos modal
$(document).on("click",".photos", function(){
    var categoryId = $(this).attr("id");
    $("#current_category_id").val(categoryId);
    loadThemesImages(categoryId);
    $("#galleryModal").modal("show");
});

// Load existing gallery images
function loadThemesImages(categoryId) {
    $("#existing-images-container").html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
    
    $.ajax({
        url: '../requests/index.php?f=booking&endpoint=BookingThemesImages',
        type: 'POST',
        data: { themes_category_id: categoryId, action: 'load' },
        success: function(response) {
            $("#existing-images-container").html(response);
        },
        error: function(xhr, status, error) {
            var debugMsg = 'Error loading images: ' + error + '\nStatus: ' + status + '\nResponse: ' + (xhr && xhr.responseText ? xhr.responseText : 'No response');
            $("#existing-images-container").html('<p class="text-danger">' + debugMsg + '</p>');
            console.error(debugMsg);
        }
    });
}

// Add more image upload fields
$(document).on("click", "#add-more-images", function(){
    var newRow = '<div class="image-upload-row mb-3 panel panel-default" style="padding:15px;">' +
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>' +
        '<input type="text" class="form-control enTitle-input" placeholder="<?php echo direction("English Title","العنوان بالإنجليزي") ?>">' +
        '</div>' +
        '<div class="col-md-6">' +
        '<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>' +
        '<input type="text" class="form-control arTitle-input" placeholder="<?php echo direction("Arabic Title","العنوان بالعربي") ?>">' +
        '</div>' +
        '</div>' +
        '<div class="row mt-2">' +
        '<div class="col-md-6">' +
        '<label><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></label>' +
        '<textarea class="form-control enDetails-input" rows="2" placeholder="<?php echo direction("English Details","التفاصيل بالإنجليزي") ?>"></textarea>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>' +
        '<textarea class="form-control arDetails-input" rows="2" placeholder="<?php echo direction("Arabic Details","التفاصيل بالعربي") ?>"></textarea>' +
        '</div>' +
        '</div>' +
        '<div class="row mt-2">' +
        '<div class="col-md-8">' +
        '<label><?php echo direction("Image","الصورة") ?></label>' +
        '<input type="file" class="form-control image-input" accept="image/*">' +
        '</div>' +
        '<div class="col-md-2" style="padding-top:25px;">' +
        '<button type="button" class="btn btn-primary upload-single-btn"><?php echo direction("Upload","رفع") ?></button>' +
        '</div>' +
        '<div class="col-md-2" style="padding-top:25px;">' +
        '<button type="button" class="btn btn-danger remove-upload-row">X</button>' +
        '</div>' +
        '</div>' +
        '</div>';
    $("#image-upload-container").append(newRow);
});

// Remove upload row
$(document).on("click", ".remove-upload-row", function(){
    $(this).closest(".image-upload-row").remove();
});

// Upload single image
$(document).on("click", ".upload-single-btn", function(){
    var btn = $(this);
    var row = btn.closest('.image-upload-row');
    var fileInput = row.find('.image-input')[0];
    var enTitle = row.find('.enTitle-input').val();
    var arTitle = row.find('.arTitle-input').val();
    var enDetails = row.find('.enDetails-input').val();
    var arDetails = row.find('.arDetails-input').val();
    var categoryId = $("#current_category_id").val();
    
    if (fileInput.files.length === 0) {
        alert('<?php echo direction("Please select an image","الرجاء اختيار صورة") ?>');
        return;
    }
    
    if (!enTitle || !arTitle) {
        alert('<?php echo direction("Please enter both English and Arabic titles","الرجاء إدخال العنوان بالإنجليزي والعربي") ?>');
        return;
    }
    
    var formData = new FormData();
    formData.append('image', fileInput.files[0]);
    formData.append('themes_category_id', categoryId);
    formData.append('enTitle', enTitle);
    formData.append('arTitle', arTitle);
    formData.append('enDetails', enDetails);
    formData.append('arDetails', arDetails);
    formData.append('action', 'upload');
    
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
    
    $.ajax({
        url: '../requests/index.php?f=booking&endpoint=BookingThemesImages',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            btn.prop('disabled', false).html('<?php echo direction("Upload","رفع") ?>');
            var result = JSON.parse(response);
            if (result.success) {
                alert('<?php echo direction("Image uploaded successfully","تم رفع الصورة بنجاح") ?>');
                loadThemesImages(categoryId);
                row.find('.enTitle-input').val('');
                row.find('.arTitle-input').val('');
                row.find('.enDetails-input').val('');
                row.find('.arDetails-input').val('');
                fileInput.value = '';
            } else {
                alert('<?php echo direction("Error uploading image","خطأ في رفع الصورة") ?>: ' + result.error);
            }
        },
        error: function(xhr, status, error) {
            btn.prop('disabled', false).html('<?php echo direction("Upload","رفع") ?>');
            var debugMsg = 'Error uploading image: ' + error + '\nStatus: ' + status + '\nResponse: ' + (xhr && xhr.responseText ? xhr.responseText : 'No response');
            alert(debugMsg);
            console.error(debugMsg);
        }
    });
});

// Delete image
$(document).on("click", ".delete-image-btn", function(){
    if (!confirm('<?php echo direction("Are you sure you want to delete this image?","هل أنت متأكد من حذف هذه الصورة؟") ?>')) {
        return;
    }
    
    var imageId = $(this).data('id');
    var categoryId = $("#current_category_id").val();
    var imageItem = $(this).closest('.gallery-image-item');
    
    $.ajax({
        url: '../requests/index.php?f=booking&endpoint=BookingThemesImages',
        type: 'POST',
        data: { image_id: imageId, action: 'delete' },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.success) {
                imageItem.fadeOut(300, function() {
                    $(this).remove();
                });
            } else {
                alert('<?php echo direction("Error deleting image","خطأ في حذف الصورة") ?>');
            }
        },
        error: function() {
            alert('<?php echo direction("Error deleting image","خطأ في حذف الصورة") ?>');
        }
    });
});

// Edit category
$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		
		$("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
		$("input[name=arTitle]").val($("#arTitle"+id).html());
        $("select[name=hidden]").val($("#hidden"+id).html());
})
</script>
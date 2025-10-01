<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB("tbl_personal_info",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=BookingPersonalInfo");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB("tbl_personal_info",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=BookingPersonalInfo");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB("tbl_personal_info",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=BookingPersonalInfo");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("tbl_personal_info",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=BookingPersonalInfo");
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("tbl_personal_info", $_POST) ){
			header("LOCATION: ?v=BookingPersonalInfo");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("tbl_personal_info", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=BookingPersonalInfo");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Personal Info Details","تفاصيل المعلومات الشخصية") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("English Placeholder","النص التعليمي بالإنجليزي") ?></label>
			<input type="text" name="enPlaceholder" class="form-control" >
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Arabic Placeholder","النص التعليمي بالعربي") ?></label>
			<input type="text" name="arPlaceholder" class="form-control" >
			</div>

            <div class="col-md-4">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="type" class="form-control">
				<option value="1"><?php echo direction("Text field","حقل نصي") ?></option>
				<option value="2"><?php echo direction("Text area","منطقة نص") ?></option>
                <option value="3"><?php echo direction("Number","رقم") ?></option>
                <option value="4"><?php echo direction("Email","البريد الإلكتروني") ?></option>
                <option value="5"><?php echo direction("Date","تاريخ") ?></option>
                <option value="6"><?php echo direction("Time","وقت") ?></option>
                <option value="7"><?php echo direction("Phone Number","رقم الهاتف") ?></option>
			</select>
			</div>

            <div class="col-md-4">
			<label><?php echo direction("Required?","هل هو مطلوب؟") ?></label>
			<select name="isRequired" class="form-control">
				<option value="1"><?php echo direction("Yes","نعم") ?></option>
				<option value="2"><?php echo direction("No","لا") ?></option>
			</select>
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
<h6 class="panel-title txt-dark"><?php echo direction("Personal Info List","قائمة المعلومات الشخصية") ?></h6>
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
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th><?php echo direction("Type","النوع") ?></th>
        <th><?php echo direction("Required?","هل هو مطلوب؟") ?></th>
		<th class="text-nowrap"><?php echo direction("Action","الإجراء") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $personalInfo = selectDB("tbl_personal_info","`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($personalInfo); $i++ ){
				$counter = $i + 1;
			if ( $personalInfo[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$personalInfo[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$personalInfo[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
            $type = ( $personalInfo[$i]["type"] == 1 ) ? direction("Text field","حقل نصي") : ( ($personalInfo[$i]["type"] == 2) ? direction("Text area","منطقة نص") : ( ($personalInfo[$i]["type"] == 3) ? direction("Number","رقم") : ( ($personalInfo[$i]["type"] == 4) ? direction("Email","البريد الإلكتروني") : ( ($personalInfo[$i]["type"] == 5) ? direction("Date","تاريخ") : ( ($personalInfo[$i]["type"] == 6) ? direction("Time","وقت") : direction("Phone Number","رقم الهاتف") ) ) ) ) );
            $isRequired = ( $personalInfo[$i]["isRequired"] == 1 ) ? direction("Yes","نعم") : direction("No","لا");
			?>
			<tr>
			<td>
			<input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter, 2, '0', STR_PAD_LEFT) ?>">
			<input name="id[]" class="form-control" type="hidden" value="<?php echo $personalInfo[$i]["id"] ?>">
			</td>
			<td id="enTitle<?php echo $personalInfo[$i]["id"]?>" ><?php echo $personalInfo[$i]["enTitle"] ?></td>
			<td id="arTitle<?php echo $personalInfo[$i]["id"]?>" ><?php echo $personalInfo[$i]["arTitle"] ?></td>
			<td><?php echo $type ?></td>
			<td><?php echo $isRequired ?></td>
			<td class="text-nowrap">
                <a id="<?php echo $personalInfo[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="btn btn-warning btn-circle fa fa-pencil text-inverse m-r-10" style="align-content: center;"></i>
                </a>
                <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="btn btn-default btn-circle <?php echo $icon ?> text-inverse m-r-10" style="align-content: center;"></i>
                </a>
                <a href="<?php echo "?v={$_GET["v"]}&delId={$personalInfo[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="btn btn-danger btn-circle fa fa-close" style="align-content: center;"></i>
                </a>
			</td>
            <div style="display: none">
                <label id="hidden<?php echo $personalInfo[$i]["id"]?>"><?php echo $personalInfo[$i]["hidden"] ?></label>
                <label id="isRequired<?php echo $personalInfo[$i]["id"]?>"><?php echo $personalInfo[$i]["isRequired"] ?></label>
                <label id="enPlaceholder<?php echo $personalInfo[$i]["id"]?>"><?php echo $personalInfo[$i]["enPlaceholder"] ?></label>
                <label id="arPlaceholder<?php echo $personalInfo[$i]["id"]?>"><?php echo $personalInfo[$i]["arPlaceholder"] ?></label>
                <label id="type<?php echo $personalInfo[$i]["id"]?>"><?php echo $personalInfo[$i]["type"] ?></label>
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
<script>
$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		
		$("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
		$("input[name=arTitle]").val($("#arTitle"+id).html());
        $("input[name=enPlaceholder]").val($("#enPlaceholder"+id).html());
        $("input[name=arPlaceholder]").val($("#arPlaceholder"+id).html());
        $("select[name=isRequired]").val($("#isRequired"+id).html());
        $("select[name=type]").val($("#type"+id).html());
        $("select[name=hidden]").val($("#hidden"+id).html());
})
</script>
<?php 
if( isset($_POST["open_date"]) ){
    unset($_POST["update"]);
    if( updateDB("tbl_settings", $_POST, "`id` = '1'") ){
        header("LOCATION: ?v=BookingSettings");
    }else{
    ?>
    <script>
        alert("Could not process your request, Please try again.");
    </script>
    <?php
    }
}else{
    $settings = selectDB("tbl_settings", "`id` = '1'");
    if( $settings && is_array($settings) ){
        $settings = $settings[0];
    }else{
        $settings = array();
    }
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Booking Settings","إعدادات الحجز") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-6">
			<label><?php echo direction("Open Date","تاريخ الفتح") ?></label>
			<input type="date" name="open_date" class="form-control" <?php if( $settings["open_date"] ): ?>value="<?php echo $settings["open_date"] ?>"<?php endif; ?> required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Close Date","تاريخ الإغلاق") ?></label>
			<input type="date" name="close_date" class="form-control" <?php if( $settings["close_date"] ): ?>value="<?php echo $settings["close_date"] ?>"<?php endif; ?>>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Number of days after today to block","أغلق عدد أيام بعد اليوم") ?></label>
			<input type="number" step="1" min="0" max="6" name="closeAfter" class="form-control" <?php if( $settings["closeAfter"] ): ?>value="<?php echo $settings["closeAfter"] ?>"<?php endif; ?>>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Maintenance Mode","وضع الصيانة") ?></label>
			<select name="is_maintenance" class="form-control">
				<option value="0" <?php if( $settings["is_maintenance"] == 0 ): ?>selected<?php endif; ?>><?php echo direction("No","لا") ?></option>
				<option value="1" <?php if( $settings["is_maintenance"] == 1 ): ?>selected<?php endif; ?>><?php echo direction("Yes","نعم") ?></option>
			</select>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Email","البريد الإلكتروني") ?></label>
			<input type="email" name="email" class="form-control" <?php if( $settings["email"] ): ?>value="<?php echo $settings["email"] ?>"<?php endif; ?> required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Phone Number","رقم الهاتف") ?></label>
			<input type="text" name="phone" maxlength="8" step="1" pattern="[0-9]+" class="form-control" <?php if( $settings["phone"] ): ?>value="<?php echo $settings["phone"] ?>"<?php endif; ?> required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Address","العنوان") ?></label>
			<input type="text" name="address" class="form-control" <?php if( $settings["address"] ): ?>value="<?php echo $settings["address"] ?>"<?php endif; ?> required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Address Link","رابط العنوان") ?></label>
			<input type="text" name="address_link" class="form-control" <?php if( $settings["address_link"] ): ?>value="<?php echo $settings["address_link"] ?>"<?php endif; ?> required>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="1">
			</div>

		</div>
	</form>
</div>
</div>
</div>
</div>
</div>
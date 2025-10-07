<?php 
if( isset($_POST["openDate"]) ){
    $_POST["weekend"] = isset($_POST["weekend"]) ? json_encode($_POST["weekend"]) : json_encode([]);
    $_POST["whatsappNoti"] = isset($_POST["whatsappNoti"]) ? json_encode($_POST["whatsappNoti"]) : json_encode([]);
    $_POST["smsNoti"] = isset($_POST["smsNoti"]) ? json_encode($_POST["smsNoti"]) : json_encode([]);
    var_dump($_POST);
	if( updateDB("tbl_calendar_settings", $_POST, "`id` = '1'") ){
        header("LOCATION: ?v=BookingCalendarSettings");
    }else{
    ?>
    <script>
        alert("Could not process your request, Please try again.");
    </script>
    <?php
    }
}else{
    $settings = selectDB("tbl_calendar_settings","*","`id` = '1'")[0];
    $whatsappNoti = json_decode($settings["whatsappNoti"],true);
    $smsNoti = json_decode($settings["smsNoti"],true);
    $weekends = json_decode($settings["weekend"],true);
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Page Details","تفاصيل الصفحة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

			<div class="col-md-4">
			<label><?php echo direction("Open Calendar","تاريخ الافتتاح") ?></label>
			<input type="date" name="openDate" class="form-control" required value="<?php echo isset($settings["openDate"]) ? $settings["openDate"] : "" ?>">
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Close Calendar","تاريخ الإغلاق") ?></label>
			<input type="date" name="closeDate" class="form-control" required value="<?php echo isset($settings["closeDate"]) ? $settings["closeDate"] : "" ?>">
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Weekend","عطلة نهاية الاسبوع") ?></label>
			<select name="weekend[]" class="form-control" multiple>
                <?php 
                $weekends = json_decode($settings["weekend"], true);
                if( !is_array($weekends) ) $weekends = array();
                    for( $i = 0; $i < 7; $i++ ){
                        $selected = in_array($i, $weekends) ? "selected" : "";
                        echo "<option value='{$i}' {$selected}>".direction(date("l", strtotime("Sunday +{$i} days")),date("l", strtotime("الاحد +{$i} days")))."</option>";
                    }
                ?>
			</select>
			</div>

            <div class="col-md-12">
                <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><?php echo direction("Whatsapp Notification", "إشعار الواتساب") ?></h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <!-- whatsapp Details -->
                    <div class="col-md-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-heading">
                                <div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("Details","التفاصيل") ?></h6></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="col-md-6" style="margin-bottom:5px;">
                                <div class="text">
                                <select class="form-control" name="whatsappNoti[status]" >
                                    <?php 
                                    $wStatus = [0,1];
                                    $wTitle = [direction("No","لا"),direction("Yes","نعم")];
                                    for( $i = 0; $i < sizeof($wStatus); $i++){
                                        $wSelected = (isset($whatsappNoti["status"]) && $whatsappNoti["status"] == $wStatus[$i]) ? "selected" : "";
                                        echo "<option value='{$wStatus[$i]}' {$wSelected}>{$wTitle[$i]}</option>";
                                    }
                                    ?>
                                </select>
                                </div>
                                </div>

                                <div class="col-md-6" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="whatsappNoti[ultraToken]" value="<?php echo $whatsappToken = isset($whatsappToken) ? "{$whatsappToken}" : "" ?>" placeholder="<?php echo direction("Ultra Msg Token","رمز Ultra Msg") ?>">
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><?php echo direction("SMS Notification", "إشعار الرسائل النصية") ?></h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <!-- whatsapp Details -->
                    <div class="col-md-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-heading">
                                <div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("Details","التفاصيل") ?></h6></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="col-md-12" style="margin-bottom:5px;">
                                <div class="text">
                                <select class="form-control" name="smsNoti[status]" >
                                    <?php 
                                    $wStatus = [0,1];
                                    $wTitle = [direction("No","لا"),direction("Yes","نعم")];
                                    for( $i = 0; $i < sizeof($wStatus); $i++){
                                        $wSelected = (isset($smsNoti["status"]) && $smsNoti["status"] == $wStatus[$i]) ? "selected" : "";
                                        echo "<option value='{$wStatus[$i]}' {$wSelected}>{$wTitle[$i]}</option>";
                                    }
                                    ?>
                                </select>
                                </div>
                                </div>

                                <div class="col-md-3" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="smsNoti[username]" value="<?php echo $smsUsername = isset($smsUsername) ? "{$smsUsername}" : "" ?>" placeholder="<?php echo direction("username","اسم المستخدم") ?>">
                                </div>
                                </div>

                                <div class="col-md-3" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="smsNoti[password]" value="<?php echo $smsPassword = isset($smsPassword) ? "{$smsPassword}" : "" ?>" placeholder="<?php echo direction("password","كلمة المرور") ?>">
                                </div>
                                </div>

                                <div class="col-md-3" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="smsNoti[sender]" value="<?php echo $smsSender = isset($smsSender) ? "{$smsSender}" : "" ?>" placeholder="<?php echo direction("sender","المرسل") ?>">
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
            </div>

			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
</div>
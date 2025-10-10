<?php 
if( isset($_POST["openDate"]) ){
    $_POST["weekend"] = isset($_POST["weekend"]) ? json_encode($_POST["weekend"]) : json_encode([]);
    $_POST["whatsappNoti"] = isset($_POST["whatsappNoti"]) ? json_encode($_POST["whatsappNoti"]) : json_encode([]);
    $_POST["smsNoti"] = isset($_POST["smsNoti"]) ? json_encode($_POST["smsNoti"]) : json_encode([]);
    $_POST["websiteColors"] = isset($_POST["websiteColors"]) ? json_encode($_POST["websiteColors"]) : json_encode([]);
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
    $settings = selectDB("tbl_calendar_settings","`id` = '1'")[0];
    $whatsappNoti = json_decode($settings["whatsappNoti"],true);
    $smsNoti = json_decode($settings["smsNoti"],true);
    $weekends = json_decode($settings["weekend"],true);
    $websiteColors = json_decode($settings["websiteColors"],true);
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Booking Sysytem Settings","إعدادات نظام الحجز") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

            <div class="col-md-12">
			<label><?php echo direction("Maintenance Mode","وضع الصيانة") ?></label>
			<select name="is_maintenance" class="form-control">
				<option value="0" <?php if( $settings["is_maintenance"] == 0 ): ?>selected<?php endif; ?>><?php echo direction("No","لا") ?></option>
				<option value="1" <?php if( $settings["is_maintenance"] == 1 ): ?>selected<?php endif; ?>><?php echo direction("Yes","نعم") ?></option>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Open Calendar","تاريخ الافتتاح") ?></label>
			<input type="date" name="openDate" class="form-control" required value="<?php echo isset($settings["openDate"]) ? substr($settings["openDate"], 0, 10) : "" ?>">
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Close Calendar","تاريخ الإغلاق") ?></label>
			<input type="date" name="closeDate" class="form-control" required value="<?php echo isset($settings["closeDate"]) ? substr($settings["closeDate"], 0, 10) : "" ?>">
			</div>

            <div class="col-md-3">
			<label><?php echo direction("Number of days after today to block","أغلق عدد أيام بعد اليوم") ?></label>
			<input type="number" step="1" min="0" max="6" name="closeAfter" class="form-control" <?php if( $settings["closeAfter"] ): ?>value="<?php echo $settings["closeAfter"] ?>"<?php endif; ?>>
			</div>

            <div class="col-md-3">
			<label><?php echo direction("Email","البريد الإلكتروني") ?></label>
			<input type="email" name="email" class="form-control" <?php if( $settings["email"] ): ?>value="<?php echo $settings["email"] ?>"<?php endif; ?>>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Weekend","عطلة نهاية الاسبوع") ?></label>
			<select name="weekend[]" class="form-control" multiple>
                <?php 
                $weekends = json_decode($settings["weekend"], true);
                if( !is_array($weekends) ) $weekends = array();
                    for( $i = 0; $i < 7; $i++ ){
                        $selected = in_array($i, $weekends) ? "selected" : "";
                        echo "<option value='{$i}' {$selected}>".direction(date("l", strtotime("Sunday +{$i} days")),date("l", strtotime("Sunday +{$i} days")))."</option>";
                    }
                ?>
			</select>
			</div>

            <div class="col-md-6" style="height: 90px;">
			<label><?php echo direction("Google Map Embed Code","كود تضمين خريطة جوجل") ?></label>
			<textarea name="googleMap" class="form-control"><?php echo $settings["googleMap"] ?></textarea>
			</div>

            <div class="col-md-12" style="padding-top: 5px;" >
                <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark"><?php echo direction("Website Theme", "ثيم الموقع") ?></h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <!-- whatsapp Details -->
                    <div class="col-md-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-heading">
                                <div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("Main Website Colors","الوان الموقع الرئيسية") ?></h6></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="col-md-6" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" type="color" name="websiteColors[main1]" value="<?php echo $main1 = isset($websiteColors["main1"]) ? "{$websiteColors["main1"]}" : "" ?>">
                                </div>
                                </div>

                                <div class="col-md-6" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" type="color" name="websiteColors[main2]" value="<?php echo $main2 = isset($websiteColors["main2"]) ? "{$websiteColors["main2"]}" : "" ?>">
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="panel-heading">
                                <div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("Button Colors","الوان الأزرار") ?></h6></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="col-md-6" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" type="color" name="websiteColors[button1]" value="<?php echo $button1 = isset($websiteColors["button1"]) ? "{$websiteColors["button1"]}" : "" ?>">
                                </div>
                                </div>

                                <div class="col-md-6" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" type="color" name="websiteColors[button2]" value="<?php echo $button2 = isset($websiteColors["button2"]) ? "{$websiteColors["button2"]}" : "" ?>">
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="panel-heading">
                                <div class="pull-left"><h6 class="panel-title txt-dark"><?php echo direction("Footer Colors","الوان الفوتر") ?></h6></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="col-md-6" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" type="color" name="websiteColors[footer1]" value="<?php echo $footer1 = isset($websiteColors["footer1"]) ? "{$websiteColors["footer1"]}" : "" ?>">
                                </div>
                                </div>

                                <div class="col-md-6" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" type="color" name="websiteColors[footer2]" value="<?php echo $footer2 = isset($websiteColors["footer2"]) ? "{$websiteColors["footer2"]}" : "" ?>">
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

            <div class="col-md-12" style="padding-top: 5px;" >
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
                                <div class="col-md-4" style="margin-bottom:5px;">
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

                                <div class="col-md-4" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="whatsappNoti[ultraToken]" value="<?php echo $whatsappToken = isset($whatsappNoti["ultraToken"]) ? "{$whatsappNoti["ultraToken"]}" : "" ?>" placeholder="<?php echo direction("Ultra Msg Token","رمز Ultra Msg") ?>">
                                </div>
                                </div>

                                <div class="col-md-4" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="whatsappNoti[instance]" value="<?php echo $whatsappToken = isset($whatsappNoti["instance"]) ? "{$whatsappNoti["instance"]}" : "" ?>" placeholder="<?php echo direction("Ultra Msg Instance","موقع Ultra Msg") ?>">
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
                                <input class="form-control" name="smsNoti[username]" value="<?php echo (isset($smsNoti["username"]) ? "{$smsNoti["username"]}" : "") ?>" placeholder="<?php echo direction("username","اسم المستخدم") ?>">
                                </div>
                                </div>

                                <div class="col-md-3" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="smsNoti[password]" value="<?php echo (isset($smsNoti["password"]) ? "{$smsNoti["password"]}" : "") ?>" placeholder="<?php echo direction("password","كلمة المرور") ?>">
                                </div>
                                </div>

                                <div class="col-md-3" style="padding-bottom: 5px;">
                                <div class="text">
                                <input class="form-control" name="smsNoti[sender]" value="<?php echo (isset($smsNoti["sender"]) ? "{$smsNoti["sender"]}" : "") ?>" placeholder="<?php echo direction("sender","المرسل") ?>">
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
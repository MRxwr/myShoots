<?php 
if( isset($_POST["openDate"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if( updateDB("tbl_calendar_settings", $_POST, "`id` = '{$id}'") ){
        header("LOCATION: ?v=BookingCalendarSettings");
    }else{
    ?>
    <script>
        alert("Could not process your request, Please try again.");
    </script>
    <?php
    }
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
			<input type="text" name="openDate" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Close Calendar","تاريخ الإغلاق") ?></label>
			<input type="text" name="closeDate" class="form-control" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Weekend","عطلة نهاية الاسبوع") ?></label>
			<select name="weekend[]" class="form-control" multiple>
                <option value="0"><?php echo direction("Sunday","الاحد") ?></option>
                <option value="1"><?php echo direction("Monday","الاثنين") ?></option>
                <option value="2"><?php echo direction("Tuesday","الثلاثاء") ?></option>
                <option value="3"><?php echo direction("Wednesday","الأربعاء") ?></option>
                <option value="4"><?php echo direction("Thursday","الخميس") ?></option>
                <option value="5"><?php echo direction("Friday","الجمعة") ?></option>
                <option value="6"><?php echo direction("Saturday","السبت") ?></option>
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
                                <div class="col-md-3">
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

                                <div class="col-md-3">
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
                                <div class="col-md-3">
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

                                <div class="col-md-3">
                                <div class="text">
                                <input class="form-control" name="smsNoti[username]" value="<?php echo $smsUsername = isset($smsUsername) ? "{$smsUsername}" : "" ?>" placeholder="<?php echo direction("username","اسم المستخدم") ?>">
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="text">
                                <input class="form-control" name="smsNoti[password]" value="<?php echo $smsPassword = isset($smsPassword) ? "{$smsPassword}" : "" ?>" placeholder="<?php echo direction("password","كلمة المرور") ?>">
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="text">
                                <input class="form-control" name="smsNoti[sender]" value="<?php echo $smsSender = isset($smsSender) ? "{$smsSender}" : "" ?>" placeholder="<?php echo direction("sender","المرسل") ?>">
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="text">
                                <input class="form-control" name="smsNoti[mobile]" value="<?php echo $smsMobile = isset($smsMobile) ? "{$smsMobile}" : "" ?>" placeholder="<?php echo direction("mobile","رقم الجوال") ?>">
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
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
</div>
<?php 
if ( isset($_GET["update"]) AND $_GET["update"] = 1 && updateDB("s_media",$_POST,"`id` = '1'") ){
	$sMedia = selectDB("s_media","`id` = '1'");
	header("LOCATION: ?v={$_GET["v"]}");die();
}else{
	$sMedia = selectDB("s_media","`id` = '1'");
}
?>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<form action="?v=<?php echo $_GET["v"] ?>&update=1" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $sMediaText ?>
</h6>
<hr class="light-grey-hr"/>
	<div class="row">

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">Whatsapp</label>
	<input type="text" name="whatsapp" class="form-control" value="<?php echo $sMedia[0]["whatsapp"] ?>"  >
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">twitter</label>
	<input type="text" name="twitter" class="form-control" value="<?php echo $sMedia[0]["twitter"] ?>"  >
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">facebook</label>
	<input type="text" name="facebook" class="form-control" value="<?php echo $sMedia[0]["facebook"] ?>"  >
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">Snapchat</label>
	<input type="text" name="snapchat" class="form-control" value="<?php echo $sMedia[0]["snapchat"] ?>"  >
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">Instagram</label><br>
	<input type="text" name="instagram" class="form-control" value="<?php echo $sMedia[0]["instagram"] ?>"  >
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">TikTok</label><br>
	<input type="text" name="tiktok" class="form-control" value="<?php echo $sMedia[0]["tiktok"] ?>"  >
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">Email</label><br>
	<input type="text" name="email" class="form-control" value="<?php echo $sMedia ?>"  >
	</div>
	</div>

	<div class="col-md-6">
	<div class="form-group">
	<label class="control-label mb-10">Location</label><br>
	<input type="text" name="location" class="form-control" value="<?php echo $sMedia[0]["location"] ?>"  >
	</div>
	</div>

	</div>

</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"><?php echo $save ?></button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>		
</div>
</div>
	<?php 
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}

		if (isset($_GET['id']) && !empty($_GET['id'])) {
			$id = $_GET['id'];
			$tbl_name = 'tbl_packages';
			$where = "id='$id'";

			$query = $obj->select_data($tbl_name,$where);
			$res = $obj->execute_query($conn,$query);

			if($res==true)
			{
				$count_rows = $obj->num_rows($res);
				if($count_rows==1)
				{
					$row = $obj->fetch_data($res);
					$title_en = $row['title_en'];
					$title_ar = $row['title_ar'];
					$price = $row['price'];
					$extra_items = $row['extra_items'];
					$is_extra = $row['is_extra'];
					$currency = $row['currency'];
					$time = $row['time'];
					$description_en = $row['description_en'];
					$description_ar = $row['description_ar'];
					$is_active = $row['is_active'];
					$image = "../uploads/images/".$row['image_url'];
				}
			}
		}
		else
		{
			header('location:'.SITEURL.'admin/index.php?page=galleries');
		}
	?>
	<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['edit_package'] ?></h5>

						</div>
					</div>
					<!-- /Title -->
    
    <!-- Row -->
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default card-view">
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<div class="form-wrap">
											<form method="post" action=""  enctype='multipart/form-data'>
                                            <div   ng-app="shanidkvApp">
												<div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['english'] ?>)</label>
													<input type="text" name="title_en" class="form-control" value="<?php echo $title_en; ?>">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['arabic'] ?>)</label>
													<input type="text" name="title_ar" class="form-control" value="<?php echo $title_ar; ?>">
												</div>
												 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['package_price'] ?></label>
													<input type="text" name="p_price" class="form-control" value="<?php echo $price; ?>">
												</div>
                                               
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Do you want to extra items?</label>
                                                    <div>
                                                        <input id="is_extra"  name="is_extra" type="checkbox"  class="bs-switch" value="1" <?php if($is_extra == 1){ ?> checked="checked" <?php } ?>>
                                                        <label>Yes</label>
                                                    </div>	
                                                </div>
                                                 <div class="form-group" id="extra_items_div" <?php if($is_extra == 1){ ?> style="display:block;" <?php } else { ?> style="display:none;"<?php } ?> >
                                                 <div ng-app="angularjs-starter" ng-controller="MainCtrl">
                                                         <div class="row" data-ng-repeat="choice in choices">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10 text-left"><?php echo $lang['extra_items'] ?> (<?php echo $lang['english'] ?>)</label>
                                                                    <input type="text" name="item_en" class="form-control"  ng-model="choice.item_en" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10 text-left"><?php echo $lang['extra_items'] ?> (<?php echo $lang['arabic'] ?>)</label>
                                                                    <input type="text" name="item_ar" class="form-control"  ng-model="choice.item_ar" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10 text-left"><?php echo $lang['extra_price'] ?></label>
                                                                     <input type="text" name="price" class="form-control"   ng-model="choice.price">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                     <button class="remove" ng-show="$last" ng-click="removeChoice()">-</button>
                                                                </div>
                                                            </div>
                                                      </div>
                                                      <input type="button" class="btn-primary btn-sm" ng-click="addNewChoice()" value="Add fields">
                                                      <input type="hidden" id="extra_items" name="extra_items" class="form-control" value="{{ choices }}">
                                                            
                                                 </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                 <label class="control-label mb-10 text-left"><?php echo $lang['preffered_time'] ?></label>
                                                         <div ng-app="angularjs-starter" ng-controller="userCtrl">
                                                                 <div class="row" data-ng-repeat="user in users">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label mb-10 text-left"><?php echo $lang['start_time'] ?></label>
                                                                            <input type="time" name="starttime" class="form-control"  ng-model="user.starttime" >
                                                                        </div>
                                                                    </div>
                                                                     <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label mb-10 text-left"><?php echo $lang['end_time'] ?></label>
                                                                            <input type="time" name="endtime" class="form-control"  ng-model="user.endtime" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                             <button class="remove" ng-show="$last" ng-click="removeUser()">-</button>
                                                                        </div>
                                                                    </div>
                                                              </div>
                                                              <input type="button" class="btn-primary btn-sm" ng-click="addNewUser()" value="Add fields">
                                                              <input type="hidden" id="alltime" name="alltime" class="form-control" value="{{ users }}">
                                                                    
                                                         </div>
                                                         
                                                         </div>
                                                         
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['currency'] ?></label>
													<input type="text" name="currency" class="form-control" value="<?php echo $currency; ?>">
												</div>												
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['upload_image'] ?></label>
													<input type="file" id="input-file-max-fs" name="image_url" class="dropify"  data-default-file="<?php echo $image; ?>"/>
                                                    <input type="hidden" name="image_url_hid" value="<?php echo $row['image_url']; ?>" />
												</div>
												<div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['description'] ?> (<?php echo $lang['english'] ?>)</label>
													<textarea class="textarea_editor form-control" rows="15" name="description_en" ><?php echo $description_en; ?></textarea>
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['description'] ?> (<?php echo $lang['arabic'] ?>)</label>
													<textarea class="textarea_editor form-control" rows="15" name="description_ar" ><?php echo $description_ar; ?></textarea>
												</div>

                                                
                                                <div class="form-group">
															<label class="control-label mb-10"><?php echo $lang['is_active'] ?></label>
															<div>
																<div class="radio">
																	<input type="radio" name="is_active" id="radio_1" value="Yes" <?php if($is_active=='Yes'){echo"checked='checked'";} ?>>
																	<label for="radio_1">
																	<?php echo $lang['yes'] ?>
																	</label>
																</div>
																<div class="radio">
																	<input type="radio" name="is_active" id="radio_2" value="No" <?php if($is_active=='No'){echo"checked='checked'";} ?> >
																	<label for="radio_2">
																	<?php echo $lang['no'] ?>
																	</label>
																</div>
															</div>
														</div>
												<div class="form-group">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <input class="btn-primary btn-sm" type="submit" name="submit" value="<?php echo $lang['edit_package'] ?>">
                                                </div>
												
												
											</div>	
											</form>
										</div>
									</div>
								</div>

	<?php 
		if(isset($_POST['submit']))
		{
			//var_dump($_POST);
					//echo "Clicked";
			//echo $id = $_POST['id'];
			//exit;
			$title_en = $obj->sanitize($conn,$_POST['title_en']);
			$title_ar = $obj->sanitize($conn,$_POST['title_ar']);
			$p_price = $obj->sanitize($conn,$_POST['p_price']);
			
			$is_extra = $obj->sanitize($conn,$_POST['is_extra']);
			if($_POST['extra_items'] == '{{ choices }}'){
				$extra_items = '[{}]';	
			} else {
				$extra_items = $_POST['extra_items'];
			}
			$currency = $obj->sanitize($conn,$_POST['currency']);
			if($_POST['alltime'] == '{{ users }}'){
				$alltime = '[{}]';	
			} else {
				$alltime = $_POST['alltime'];
			}
			$description_en = $obj->sanitize($conn,$_POST['description_en']);
			$description_ar = $obj->sanitize($conn,$_POST['description_ar']);
			$url = strtolower(str_replace(' ', '-', $title_en));
			$is_active = $_POST['is_active'];

			if($_FILES["image_url"][ "name" ] != ""){
			$upload_image=mt_rand(100000,999999)."-".$_FILES["image_url"][ "name" ];
			$folder="../uploads/images/";
			if (move_uploaded_file($_FILES["image_url"]["tmp_name"], "$folder".$upload_image))  {
			unlink($image); 
			}
			} else {
				$upload_image = $obj->sanitize($conn,$_POST['image_url_hid']);
			}

				$data="
				title_en='$title_en',
				title_ar='$title_ar',
				price=$p_price,
				is_extra='$is_extra',
				extra_items='$extra_items',
				currency='$currency',
				time='$alltime',
				description_en='$description_en',
				description_ar='$description_ar',
				image_url ='$upload_image',
				url = '$url',
				is_active='$is_active'
			";
			$where = "id='$id'";
			$tbl_name = 'tbl_packages';
			$query = $obj->update_data($tbl_name,$data,$where);
			$res = $obj->execute_query($conn,$query);
			if($res==true)
			{
				$_SESSION['edit'] = "<div class='success'>".$lang['edit_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=packages');
			}
			else
			{
				$_SESSION['edit'] = "<div class='error'>".$lang['edit_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=edit_package&id='.$id);
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
                <script>
				var app = angular.module('shanidkvApp', []);
  app.controller('MainCtrl', function($scope) {

  $scope.choices = <?php echo $extra_items; ?>;
  
  $scope.addNewChoice = function() {
    $scope.choices.push({});
  };
    
  $scope.removeChoice = function() {
    var lastItem = $scope.choices.length-1;
    $scope.choices.splice(lastItem);
  };
  
});
 app.controller('userCtrl', function($scope) {

  $scope.users = <?php echo $time; ?>;;
  
  $scope.addNewUser = function() {
    $scope.users.push({});
  };
    
  $scope.removeUser = function() {
    var lastItem = $scope.users.length-1;
    $scope.users.splice(lastItem);
  };
  
  
});
</script>

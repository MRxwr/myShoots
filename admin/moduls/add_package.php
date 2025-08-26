
        
        	<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['add_package'] ?></h5>

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
											<form method="post" action=""  enctype='multipart/form-data' >
                                           
                                            <div ng-app="shanidkvApp">
                                            
		
													
												<div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['english'] ?>)</label>
													<input type="text" name="title_en" class="form-control" value="">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['arabic'] ?>)</label>
													<input type="text" name="title_ar" class="form-control" value="">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['package_price'] ?></label>
													<input type="text" name="price" class="form-control" value="">
												</div>
                                                <div>
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Do you want to extra items?</label>
                                                    <div>
                                                        <input id="is_extra"  name="is_extra" type="checkbox"  class="bs-switch" value="1">
                                                        <label>Yes</label>
                                                    </div>	
                                                </div>
                                                 <div class="form-group" id="extra_items_div" style="display:none;">
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
                                                 
                                                 <div id="email"></div> 
                                                 
                                                 <button type="button" class="btn-primary btn-sm" id="comm"><?php echo $lang['add_time'] ?></button> 
                                                 <input type="hidden" name="alltime" class="form-control"   id="alltime" value="[{}]">
                                                 
                                                </div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['currency'] ?></label>
													<input type="text" name="currency" class="form-control" value="">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['upload_image'] ?></label>
													<input type="file" id="input-file-max-fs" name="image_url" class="dropify" data-max-file-size="2M" />
												</div>
												
												
                                               <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['description'] ?> (<?php echo $lang['english'] ?>)</label>
													<textarea class="textarea_editor form-control" rows="15" name="description_en" ></textarea>
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['description'] ?> (<?php echo $lang['arabic'] ?>)</label>
													<textarea class="textarea_editor form-control" rows="15" name="description_ar" ></textarea>
												</div> 

                                                
                                                <div class="form-group">
															<label class="control-label mb-10"><?php echo $lang['is_active'] ?></label>
															<div>
																<div class="radio">
																	<input type="radio" name="is_active" id="radio_1" value="Yes" checked="checked">
																	<label for="radio_1">
																	<?php echo $lang['yes'] ?>
																	</label>
																</div>
																<div class="radio">
																	<input type="radio" name="is_active" id="radio_2" value="No" >
																	<label for="radio_2">
																	<?php echo $lang['no'] ?>
																	</label>
																</div>
															</div>
														</div>
                                                        
												<div class="form-group">
                                                <input class="btn-primary btn-sm" type="submit" name="submit" id="submit"  value="<?php echo $lang['add_package'] ?>">
                                                </div>
												
												
											</div>	
											</form>
										</div>
									</div>
								</div>
	


	<?php 
		if(isset($_POST['submit']))
		{
			$title_en = $obj->sanitize($conn,$_POST['title_en']);
			$title_ar = $obj->sanitize($conn,$_POST['title_ar']);
			$price = $obj->sanitize($conn,$_POST['price']);
			$is_extra = $obj->sanitize($conn,$_POST['is_extra']);
			$extra_items = $obj->sanitize($conn,$_POST['extra_items']);
			$alltime = $obj->sanitize($conn,$_POST['alltime']);
			$currency = $obj->sanitize($conn,$_POST['currency']);
			$description_en = $obj->sanitize($conn,$_POST['description_en']);
			$description_ar = $obj->sanitize($conn,$_POST['description_ar']);
			$url = strtolower(str_replace(' ', '-', $title_en));
			$is_active = $_POST['is_active'];
			$created_at = date('Y-m-d H:i:s');
			
			$upload_image=mt_rand(100000,999999)."-".$_FILES["image_url"][ "name" ];

$folder="../uploads/images/";

move_uploaded_file($_FILES["image_url"]["tmp_name"], "$folder".$upload_image);


			$data="
				title_en='$title_en',
				title_ar='$title_ar',
				price='$price',
				is_extra='$is_extra',
				extra_items='$extra_items',
				currency='$currency',
				time='$alltime',
				description_en='$description_en',
				description_ar='$description_ar',
				image_url ='$upload_image',
				url = '$url',
				is_active='$is_active',
				created_at='$created_at'
			";

			$tbl_name='tbl_packages';
			$query = $obj->insert_data($tbl_name,$data);
			$res = $obj->execute_query($conn,$query);

			if($res == true)
			{
				$_SESSION['add'] = "<div class='success'>".$lang['add_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=packages');
			}
			else
			{
				$_SESSION['add'] = "<div class='error'>".$lang['add_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=add_package');
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

  $scope.choices = [];
  
  $scope.addNewChoice = function() {
    $scope.choices.push({});
  };
    
  $scope.removeChoice = function() {
    var lastItem = $scope.choices.length-1;
    $scope.choices.splice(lastItem);
  };
  
  
});

 app.controller('userCtrl', function($scope) {

  $scope.users = [];
  
  $scope.addNewUser = function() {
    $scope.users.push({});
  };
    
	
  $scope.removeUser = function() {
    var lastItem = $scope.users.length-1;
    $scope.users.splice(lastItem);
  };
  
  
});


</script>



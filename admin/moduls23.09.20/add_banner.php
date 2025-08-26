			<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['add_banner'] ?></h5>

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
                                           
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['upload_image'] ?></label>
													<input type="file" id="input-file-max-fs" name="image_url" class="dropify" data-max-file-size="2M" />
												</div>
                                               <div class="form-group">
															<label class="control-label mb-10"><?php echo $lang['is_active'] ?></label>
															<div>
																<div class="radio">
																	<input type="radio" name="is_active" id="radio_1" value="Yes" >
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
                                                <input class="btn-primary btn-sm" type="submit" name="submit" value="<?php echo $lang['add_banner'] ?>">
                                                </div>
												
												
												
											</form>
										</div>
									</div>
								</div>
	

	<?php 
		if(isset($_POST['submit']))
		{
			$upload_image=mt_rand(100000,999999)."-".$_FILES["image_url"][ "name" ];
$folder="../uploads/images/";
move_uploaded_file($_FILES["image_url"]["tmp_name"], "$folder".$upload_image);
            $is_active = $_POST['is_active'];

			$data="
				image ='$upload_image',
				is_active='$is_active'
			";

			$tbl_name='tbl_banners';
			$query = $obj->insert_data($tbl_name,$data);
			$res = $obj->execute_query($conn,$query);

			if($res == true)
			{
				$_SESSION['add'] = "<div class='success'>".$lang['add_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=banners');
			}
			else
			{
				$_SESSION['add'] = "<div class='error'>".$lang['add_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=add_banner');
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
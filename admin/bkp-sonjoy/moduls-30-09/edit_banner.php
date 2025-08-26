	<?php 
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}

		if (isset($_GET['id']) && !empty($_GET['id'])) {
			$id = $_GET['id'];
			$tbl_name = 'tbl_banners';
			$where = "id='$id'";

			$query = $obj->select_data($tbl_name,$where);
			$res = $obj->execute_query($conn,$query);

			if($res==true)
			{
				$count_rows = $obj->num_rows($res);
				if($count_rows==1)
				{
					$row = $obj->fetch_data($res);
					$image = "../uploads/images/".$row['image'];
					$is_active = $row['is_active'];
				}
			}
		}
		else
		{
			header('location:'.SITEURL.'admin/index.php?page=banners');
		}
	?>
	<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['edit_banner'] ?></h5>

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
													<input type="file" id="input-file-max-fs" name="image_url" class="dropify"  data-default-file="<?php echo $image; ?>"/>
                                                    <input type="hidden" name="image_url_hid" value="<?php echo $row['image']; ?>" />
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
                                                <input class="btn-primary btn-sm" type="submit" name="submit" value="<?php echo $lang['edit_banner'] ?>">
                                                </div>
												
												
												
											</form>
										</div>
									</div>
								</div>

	<?php 
		if(isset($_POST['submit']))
		{
					//echo "Clicked";
			//echo $id = $_POST['id'];
			//exit;
			if($_FILES["image_url"][ "name" ] != ""){
			$upload_image=mt_rand(100000,999999)."-".$_FILES["image_url"][ "name" ];
			$folder="../uploads/images/";
			if (move_uploaded_file($_FILES["image_url"]["tmp_name"], "$folder".$upload_image))  {
			unlink($image); 
			}
			} else {
				$upload_image = $obj->sanitize($conn,$_POST['image_url_hid']);
			}
            $is_active = $_POST['is_active'];
				$data="
				image ='$upload_image',
				is_active='$is_active'
			";
			$where = "id='$id'";
			$tbl_name = 'tbl_banners';
			$query = $obj->update_data($tbl_name,$data,$where);
			$res = $obj->execute_query($conn,$query);
			if($res==true)
			{
				$_SESSION['edit'] = "<div class='success'>".$lang['edit_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=banners');
			}
			else
			{
				$_SESSION['edit'] = "<div class='error'>".$lang['edit_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=edit_banner&id='.$id);
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
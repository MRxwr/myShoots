	<?php 
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}


			$id =1;
			$tbl_name = 'tbl_settings';
			$where = "id='$id'";

			$query = $obj->select_data($tbl_name,$where);
			$res = $obj->execute_query($conn,$query);

			if($res==true)
			{
				$count_rows = $obj->num_rows($res);
				if($count_rows==1)
				{
					$row = $obj->fetch_data($res);
					$site_title = $row['site_title'];
					$site_url = $row['site_url'];
					$site_description = $row['site_description'];
					$site_address = $row['site_address'];
					$site_phone = $row['site_phone'];
					$site_fax = $row['site_fax'];
					$site_email = $row['site_email'];
					$payment = $row['payment'];
					$payment_api_key = $row['payment_api_key'];
					$payment_api_screte = $row['payment_api_screte'];
					$image = "../uploads/images/".$row['site_logo'];
				}
			}
		
	?>
	<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['setting'] ?></h5>

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
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> </label>
													<input type="text" name="site_title" class="form-control"  value="<?php echo $site_title; ?>">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['site_url'] ?> </label>
													<input type="text" name="site_url" class="form-control"  value="<?php echo $site_url; ?>">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['site_logo'] ?></label>
													<input type="file" id="input-file-max-fs" name="image_url" class="dropify" data-default-file="<?php echo $image; ?>"/>
                                                    <input type="hidden" name="image_url_hid" value="<?php echo $row['site_logo']; ?>" />
												</div>
												
												
                                               <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['site_description'] ?></label>
													<textarea class="form-control" rows="15" name="site_description" ><?php echo $site_description; ?></textarea>
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['site_address'] ?> (<?php echo $lang['arabic'] ?>)</label>
													<textarea class="form-control" rows="15" name="site_address" ><?php echo $site_address; ?></textarea>
												</div> 
                                                
                                                 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['site_phone'] ?> </label>
													<input type="text" name="site_phone" class="form-control" value="<?php echo $site_phone; ?>">
												</div>
                                                 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['site_fax'] ?> </label>
													<input type="text" name="site_fax" class="form-control"  value="<?php echo $site_fax; ?>">
												</div>
                                                 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['site_email'] ?> </label>
													<input type="text" name="site_email" class="form-control"  value="<?php echo $site_email; ?>">
												</div>
                                                 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['payment'] ?> </label>
													<input type="text" name="payment" class="form-control"  value="<?php echo $payment; ?>">
												</div>
                                                 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['payment_api_key'] ?> </label>
													<input type="text" name="payment_api_key" class="form-control"  value="<?php echo $payment_api_key; ?>">
												</div>
                                                 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['payment_api_screte'] ?> </label>
													<input type="text" name="payment_api_screte" class="form-control"  value="<?php echo $payment_api_screte; ?>">
												</div>
                                                
                                                
                                            
												
												<div class="form-group">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <input class="btn-primary btn-sm" type="submit" name="submit" value="<?php echo $lang['setting'] ?>">
                                                </div>
												
												
												
											</form>
										</div>
									</div>
								</div>

	<?php 
		if(isset($_POST['submit']))
		{
		    $site_title = $obj->sanitize($conn,$_POST['site_title']);
			$site_url = $obj->sanitize($conn,$_POST['site_url']);
			$site_description = $obj->sanitize($conn,$_POST['site_description']);
			$site_address = $obj->sanitize($conn,$_POST['site_address']);
			$site_phone = $obj->sanitize($conn,$_POST['site_phone']);
			$site_fax = $obj->sanitize($conn,$_POST['site_fax']);
			$site_email = $obj->sanitize($conn,$_POST['site_email']);
			$payment = $obj->sanitize($conn,$_POST['payment']);
			$payment_api_key = $obj->sanitize($conn,$_POST['payment_api_key']);
			$payment_api_screte = $obj->sanitize($conn,$_POST['payment_api_screte']);

	
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
				site_url='$site_url',
				site_title='$site_title',
				site_description='$site_description',
				site_logo ='$upload_image',
				site_address='$site_address',
				site_phone = '$site_phone',
				site_fax ='$site_fax',
				site_email ='$site_email',
				payment = '$payment',
				payment_api_key = '$payment_api_key',
				payment_api_screte = '$payment_api_screte'
			";
			$where = "id='$id'";
			$tbl_name = 'tbl_settings';
			$query = $obj->update_data($tbl_name,$data,$where);
			$res = $obj->execute_query($conn,$query);
			if($res==true)
			{
				$_SESSION['edit'] = "<div class='success'>".$lang['edit_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=settings');
			}
			else
			{
				$_SESSION['edit'] = "<div class='error'>".$lang['edit_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=settings&id='.$id);
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
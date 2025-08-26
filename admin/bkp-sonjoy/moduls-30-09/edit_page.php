	<?php 
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}

		if (isset($_GET['id']) && !empty($_GET['id'])) {
			$id = $_GET['id'];
			$tbl_name = 'tbl_pages';
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
					$description_en = $row['description_en'];
					$description_ar = $row['description_ar'];
					$is_active = $row['is_active'];
				}
			}
		}
		else
		{
			header('location:'.SITEURL.'admin/index.php?page=pages');
		}
	?>
	<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['edit_page'] ?></h5>

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
											<form method="post" action="">
												<div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['english'] ?>)</label>
													<input type="text" name="title_en" class="form-control" value="<?php echo $title_en; ?>">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['arabic'] ?>)</label>
													<input type="text" name="title_ar" class="form-control" value="<?php echo $title_ar; ?>">
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
                                                <input class="btn-primary btn-sm" type="submit" name="submit" value="<?php echo $lang['edit_page'] ?>">
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
			$title_en = $obj->sanitize($conn,$_POST['title_en']);
			$title_ar = $obj->sanitize($conn,$_POST['title_ar']);
			$description_en = $obj->sanitize($conn,$_POST['description_en']);
			$description_ar = $obj->sanitize($conn,$_POST['description_ar']);
			$url = strtolower(str_replace(' ', '-', $title_en));
			$is_active = $obj->sanitize($conn,$_POST['is_active']);


			$data = "
				title_en='$title_en',
				title_ar='$title_ar',
				description_en='$description_en',
				description_ar='$description_ar',
				url = '$url',
				is_active='$is_active'
			";
			$where = "id='$id'";
			$tbl_name = 'tbl_pages';
			$query = $obj->update_data($tbl_name,$data,$where);
			$res = $obj->execute_query($conn,$query);
			if($res==true)
			{
				$_SESSION['edit'] = "<div class='success'>".$lang['edit_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=pages');
			}
			else
			{
				$_SESSION['edit'] = "<div class='error'>".$lang['edit_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=edit_page&id='.$id);
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
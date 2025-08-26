			<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['add_page'] ?></h5>

						</div>
						<!-- Breadcrumb -->
						<!--<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						  <ol class="breadcrumb">
							<li><a href="index.html">Dashboard</a></li>
							<li><a href="#"><span><?php echo $lang['page'] ?></span></a></li>
							<li class="active"><span><?php echo $lang['add_page'] ?></span></li>
						  </ol>
						</div>-->
						<!-- /Breadcrumb -->
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
													<input type="text" name="title_en" class="form-control" value="">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['arabic'] ?>)</label>
													<input type="text" name="title_ar" class="form-control" value="">
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
                                                <input class="btn-primary btn-sm" type="submit" name="submit" value="<?php echo $lang['add_page'] ?>">
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
			$description_en = $obj->sanitize($conn,$_POST['description_en']);
			$description_ar = $obj->sanitize($conn,$_POST['description_ar']);
			$url = strtolower(str_replace(' ', '-', $title_en));
			//$category = $_POST['category'];
			$is_active = $_POST['is_active'];
			$created_at = date('Y-m-d H:i:s');

			$data="
				title_en='$title_en',
				title_ar='$title_ar',
				description_en='$description_en',
				description_ar='$description_ar',
				url = '$url',
				is_active='$is_active',
				created_at='$created_at'
			";

			$tbl_name='tbl_pages';
			$query = $obj->insert_data($tbl_name,$data);
			$res = $obj->execute_query($conn,$query);

			if($res == true)
			{
				$_SESSION['add'] = "<div class='success'>".$lang['add_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=pages');
			}
			else
			{
				$_SESSION['add'] = "<div class='error'>".$lang['add_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=add_page');
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
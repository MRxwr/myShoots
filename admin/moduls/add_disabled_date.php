			<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['add_date'] ?></h5>

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
												<div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['disabled_date'] ?></label>
													<input type="text" name="disabled_date"  id="datepicker" class="form-control " value=""  autocomplete="off">
												</div>
                                              
                                                        
												<div class="form-group">
                                                <input class="btn-primary btn-sm" type="submit" name="submit" value="<?php echo $lang['add'] ?>">
                                                </div>
												
												
                                            </div>
											</form>
										</div>
									</div>
								</div>
	

	<?php 
		if(isset($_POST['submit']))
		{
			$disabled_date = $obj->sanitize($conn,$_POST['disabled_date']);
			$data="
				disabled_date='$disabled_date'
			";

			$tbl_name='tbl_disabled_date';
			$query = $obj->insert_data($tbl_name,$data);
			$res = $obj->execute_query($conn,$query);

			if($res == true)
			{
				$_SESSION['add'] = "<div class='success'>".$lang['add_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=disabled_date');
			}
			else
			{
				$_SESSION['add'] = "<div class='error'>".$lang['add_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=add_disabled_date');
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
                    

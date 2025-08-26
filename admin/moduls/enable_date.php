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
					$open_date = $row['open_date'];
					$close_date = $row['close_date'];
					
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
													<label class="control-label mb-10 text-left"><?php echo $lang['open_date'] ?></label>
													<input type="text" name="open_date"   id="datepicker_open" class="form-control datepicker " value="<?php echo $open_date?>" autocomplete="off">
												</div>
												<div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['close_date'] ?></label>
													<input type="text" name="close_date"  id="datepicker_close" class="form-control datepicker " value="<?php echo $close_date?>"  autocomplete="off">
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
									$id =1;
									$open_date = $obj->sanitize($conn,$_POST['open_date']);
									$close_date = $obj->sanitize($conn,$_POST['close_date']);
									$data="
										open_date='$open_date',
										close_date='$close_date'
									";
									$where = "id='$id'";
									$tbl_name = 'tbl_settings';
									$query = $obj->update_data($tbl_name,$data,$where);
									$res = $obj->execute_query($conn,$query);
									if($res==true)
									{
										$_SESSION['edit'] = "<div class='success'>".$lang['edit_success']."</div>";
										header('location:'.SITEURL.'admin/index.php?page=enable_date');
									}
									else
									{
										$_SESSION['edit'] = "<div class='error'>".$lang['edit_fail']."</div>";
										header('location:'.SITEURL.'admin/index.php?page=enable_date&id='.$id);
									}
								}
							?>
						</div>
						</div>
					</div>
					<!-- /Row -->
	<?php 
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}


			$id =1;
			$tbl_name = 'tbl_users';
			$where = "id='$id'";

			$query = $obj->select_data($tbl_name,$where);
			$res = $obj->execute_query($conn,$query);

			if($res==true)
			{
				$count_rows = $obj->num_rows($res);
				if($count_rows==1)
				{
					$row = $obj->fetch_data($res);
					$full_name = $row['full_name'];
					$email = $row['email'];
					$password = $row['password'];
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
													<label class="control-label mb-10 text-left"><?php echo $lang['full_name'] ?> </label>
													<input type="text" name="full_name" class="form-control"  value="<?php echo $full_name; ?>">
												</div>
                                                <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['email'] ?> </label>
													<input type="text" name="email" class="form-control"  value="<?php echo $email; ?>">
												</div>
                                               
                                                 <div class="form-group">
													<label class="control-label mb-10 text-left"><?php echo $lang['password'] ?> </label>
													<input type="text" name="password" class="form-control" value="">
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
		    $full_name = $obj->sanitize($conn,$_POST['full_name']);
			$email = $obj->sanitize($conn,$_POST['email']);
			
			
            if(isset($_POST['password']) && ($_POST['password'] !="")){
				$password = md5($obj->sanitize($conn,$_POST['password']));
			} else {
				$password = $password;
			}
				$data="
				full_name='$full_name',
				email='$email',
				password='$password'
			";
			$where = "id='$id'";
			$tbl_name = 'tbl_users';
			$query = $obj->update_data($tbl_name,$data,$where);
			$res = $obj->execute_query($conn,$query);
			if($res==true)
			{
				$_SESSION['edit'] = "<div class='success'>".$lang['edit_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=profile');
			}
			else
			{
				$_SESSION['edit'] = "<div class='error'>".$lang['edit_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=profile&id='.$id);
			}
		}
	?>
						</div>
						</div>
					</div>
					<!-- /Row -->
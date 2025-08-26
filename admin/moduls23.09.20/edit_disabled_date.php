

	<?php 
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}

		if(isset($_GET['id']) && !empty($_GET['id']))
		{
			$id = $_GET['id'];
			$tbl_name ='tbl_disabled_date';
			$where = "id='$id'";

			$query = $obj->select_data($tbl_name,$where);
			$res = $obj->execute_query($conn,$query);
			if($res)
			{
				$count_rows = $obj->num_rows($res);
				if ($count_rows==1) {
					$row = $obj->fetch_data($res);
					$disabled_date = $row['disabled_date'];
				}
			}
		}
		else
		{
			header('location:'.SITEURL.'admin/index.php?page=disabled_date');
		}
	?>
<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h5 class="txt-dark"><?php echo $lang['edit_date'] ?></h5>

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
                                <label class="control-label mb-10 text-left"><?php echo $lang['disabled_date'] ?></label>
                                <input type="text" name="disabled_date"  id="datepicker" value="<?php echo $disabled_date; ?>" required="true" class="form-control"  autocomplete="off">
                            </div>
                            
                                                
                            <div class="input-group">
                                <span class="input-label">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" name="submit" value="<?php echo $lang['edit_date'] ?>" class="btn-primary btn-sm">
                                </span>
                            </div>
                            <br>
                        </form>
                                      </div>
									</div>
								</div>
                           </div>
						</div>
					</div>
					<!-- /Row -->	
	<?php 
		if(isset($_POST['submit']))
		{
			//echo "Click";
			$id = $_POST['id'];
			$disabled_date = $obj->sanitize($conn,$_POST['disabled_date']);

			$tbl_name = 'tbl_disabled_date';

			$data= "
				disabled_date = '$disabled_date'
			";
			$where = "id='$id'";

			$query = $obj->update_data($tbl_name,$data,$where);

			$res = $obj->execute_query($conn,$query);

			if($res==true)
			{
				//Category Successfully Added
				$_SESSION['add'] = "<div class='success'>".$lang['edit_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=disabled_date');
			}
			else
			{
				//Failed to Add Categoy
				$_SESSION['add'] = "<div class='error'>".$lang['edit_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=edit_category&id='.$id);
			}
		}
	?>

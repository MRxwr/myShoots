

	<?php 
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}

		if(isset($_GET['id']) && !empty($_GET['id']))
		{
			$id = $_GET['id'];
			$tbl_name ='tbl_categories';
			$where = "id='$id'";

			$query = $obj->select_data($tbl_name,$where);
			$res = $obj->execute_query($conn,$query);
			if($res)
			{
				$count_rows = $obj->num_rows($res);
				if ($count_rows==1) {
					$row = $obj->fetch_data($res);
					$title_en = $row['title_en'];
					$title_ar = $row['title_ar'];
					$is_active = $row['is_active'];
					$include_in_menu = $row['include_in_menu'];
				}
			}
		}
		else
		{
			header('location:'.SITEURL.'admin/index.php?page=categories');
		}
	?>
<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h5 class="txt-dark"><?php echo $lang['edit_category'] ?></h5>

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
                                <input type="text" name="title_en" value="<?php echo $title_en; ?>" required="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['arabic'] ?>)</label>
                                <input type="text" name="title_ar" value="<?php echo $title_ar; ?>" class="form-control">
                            </div>
<div class="form-group">
            <label class="control-label mb-10"><?php echo $lang['is_active'] ?></label>
            <div>
                <div class="radio">
                    <input type="radio" name="is_active" id="radio_1" value="Yes" <?php if($is_active=='Yes'){echo "checked='checked'";} ?> >
                    <label for="radio_1">
                    <?php echo $lang['yes'] ?>
                    </label>
                </div>
                <div class="radio">
                    <input type="radio" name="is_active" id="radio_2" value="No"  <?php if($is_active=='No'){echo "checked='checked'";} ?>>
                    <label for="radio_2">
                    <?php echo $lang['no'] ?>
                    </label>
                </div>
            </div>
        </div>
        
         <div class="form-group">
            <label class="control-label mb-10"><?php echo $lang['include_in_menu'] ?></label>
            <div>
                <div class="radio">
                    <input type="radio" name="include_in_menu" id="menu_1" value="Yes" <?php if($include_in_menu=='Yes'){echo "checked='checked'";} ?>>
                    <label for="menu_1">
                    <?php echo $lang['yes'] ?>
                    </label>
                </div>
                <div class="radio">
                    <input type="radio" name="include_in_menu" id="menu_2" value="No" <?php if($include_in_menu=='No'){echo "checked='checked'";} ?> >
                    <label for="menu_2">
                    <?php echo $lang['no'] ?>
                    </label>
                </div>
            </div>
        </div>
                            
                                                
                            <div class="input-group">
                                <span class="input-label">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" name="submit" value="<?php echo $lang['edit_category'] ?>" class="btn-primary btn-sm">
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
			$title_en = $obj->sanitize($conn,$_POST['title_en']);
			$title_ar = $obj->sanitize($conn,$_POST['title_ar']);
			$is_active = $_POST['is_active'];
			$include_in_menu = $_POST['include_in_menu'];

			$tbl_name = 'tbl_categories';

			$data= "
				title_en = '$title_en',
				title_ar = '$title_ar',
				is_active = '$is_active',
				include_in_menu = '$include_in_menu'
			";
			$where = "id='$id'";

			$query = $obj->update_data($tbl_name,$data,$where);

			$res = $obj->execute_query($conn,$query);

			if($res==true)
			{
				//Category Successfully Added
				$_SESSION['add'] = "<div class='success'>".$lang['edit_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=categories');
			}
			else
			{
				//Failed to Add Categoy
				$_SESSION['add'] = "<div class='error'>".$lang['edit_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=edit_category&id='.$id);
			}
		}
	?>

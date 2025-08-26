			<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark"><?php echo $lang['add_category'] ?></h5>

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

	<?php 
		if(isset($_SESSION['add']))
		{
			echo $_SESSION['add'];
			unset($_SESSION['add']);
		}
	?>

	<form method="post" action="">
		<div class="form-group">
			<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['english'] ?>)</label> 
			<input type="text" name="title_en" placeholder="Category Title in English" required="true" class="form-control">
		</div>
		<div class="form-group">
			<label class="control-label mb-10 text-left"><?php echo $lang['title'] ?> (<?php echo $lang['arabic'] ?>)</label>
			<input type="text" name="title_ar" placeholder="Category Title in Arabic" class="form-control">
		</div>
        <div class="form-group">
            <label class="control-label mb-10"><?php echo $lang['is_active'] ?></label>
            <div>
                <div class="radio">
                    <input type="radio" name="is_active" id="radio_1" value="Yes">
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
            <label class="control-label mb-10"><?php echo $lang['include_in_menu'] ?></label>
            <div>
                <div class="radio">
                    <input type="radio" name="include_in_menu" id="menu_1" value="Yes">
                    <label for="menu_1">
                    <?php echo $lang['yes'] ?>
                    </label>
                </div>
                <div class="radio">
                    <input type="radio" name="include_in_menu" id="menu_2" value="No" >
                    <label for="menu_2">
                    <?php echo $lang['no'] ?>
                    </label>
                </div>
            </div>
        </div>


		<div class="form-group">
			<span class="input-label">
				<input type="submit" name="submit" value="<?php echo $lang['add_category'] ?>" class="btn-primary btn-sm">
			</span>
		</div>
		<br>
	</form>
	</div>
									</div>
								</div>
	<?php 
		if(isset($_POST['submit']))
		{
			//echo "Click";
			$title_en = $obj->sanitize($conn,$_POST['title_en']);
			$title_ar = $obj->sanitize($conn,$_POST['title_ar']);
			$is_active = $_POST['is_active'];
			$include_in_menu = $_POST['include_in_menu'];
			$created_at = date('Y-m-d H:i:s');

			$tbl_name = 'tbl_categories';

			$data= "
				title_en = '$title_en',
				title_ar = '$title_ar',
				is_active = '$is_active',
				include_in_menu = '$include_in_menu',
				created_at = '$created_at'
			";

			$query = $obj->insert_data($tbl_name,$data);

			$res = $obj->execute_query($conn,$query);

			if($res==true)
			{
				//Category Successfully Added
				$_SESSION['add'] = "<div class='success'>".$lang['add_success']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=categories');
			}
			else
			{
				//Failed to Add Categoy
				$_SESSION['add'] = "<div class='error'>".$lang['add_fail']."</div>";
				header('location:'.SITEURL.'admin/index.php?page=add_category');
			}
		}
	?>
					</div>
						</div>
					</div>
					<!-- /Row -->
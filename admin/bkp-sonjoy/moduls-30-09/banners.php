	
    
    	<!-- Title -->
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark"><?php echo $lang['banner_list'] ?></h5>
					</div>


	<?php 
		if(isset($_SESSION['add']))
		{
			echo $_SESSION['add'];
			unset($_SESSION['add']);
		}
		if(isset($_SESSION['edit']))
		{
			echo $_SESSION['edit'];
			unset($_SESSION['edit']);
		}
		if(isset($_SESSION['delete']))
		{
			echo $_SESSION['delete'];
			unset($_SESSION['delete']);
		}
	?>

	
                
                <!-- Row -->
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default card-view">
							<div class="panel-heading">
								<div class="pull-left">
                                        <a href="<?php echo SITEURL; ?>admin/index.php?page=add_banner">
                                        <button class="btn-primary btn-sm"><?php echo $lang['add'] ?></button>
                                        </a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
                                                        <th><?php echo $lang['banner'] ?></th>
                                                        <th><?php echo $lang['actions'] ?></th>
													</tr>
												</thead>
												<tfoot>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
                                                        <<th><?php echo $lang['banner'] ?></th>
                                                        <th><?php echo $lang['actions'] ?></th>
													</tr>
												</tfoot>
												<tbody>
                                               <?php 
												$tbl_name = 'tbl_banners';
												$query = $obj->select_data($tbl_name);
												$res = $obj->execute_query($conn,$query);
												$sn = 1;
									
												if($res)
												{
													$count_rows= $obj->num_rows($res);
													if($count_rows > 0)
													{
														while ($row=$obj->fetch_data($res)) {
															$id = $row['id'];
															$image = "../uploads/images/".$row['image'];
															?>
									
															<tr>
																<td><?php echo $sn++; ?>. </td>
																<td><img src="<?php echo $image;  ?>" width="200" height="80"  /></td>
																
																<td>
																	<a href="<?php echo SITEURL; ?>admin/index.php?page=edit_banner&id=<?php echo $id; ?>" class="btn-success btn-sm"><?php echo $lang['edit'] ?></a>  
																	<a href="<?php echo SITEURL; ?>admin/moduls/delete.php?page=banners&id=<?php echo $id; ?>" class="btn-error btn-sm"><?php echo $lang['delete'] ?></a>
																</td>
															</tr>
									
															<?php
														}
													}
													else
													{
														echo "<tr><td colspan='5' class='error'>No Package Found.</td></tr>";
													}
												}
											?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
				<!-- /Row -->
    </div>
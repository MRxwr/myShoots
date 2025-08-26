	
    
    	<!-- Title -->
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark"><?php echo $lang['pages'] ?></h5>
					</div>

	<br>
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
                                        <a href="<?php echo SITEURL; ?>admin/index.php?page=add_page">
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
														<th><?php echo $lang['title'] ?></th>
														<th><?php echo $lang['is_active'] ?></th>
														<th><?php echo $lang['actions'] ?></th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th><?php echo $lang['sn'] ?></th>
														<th><?php echo $lang['title'] ?></th>
														<th><?php echo $lang['is_active'] ?></th>
														<th><?php echo $lang['actions'] ?></th>
													</tr>
												</tfoot>
												<tbody>
                                                <?php 
												$tbl_name = 'tbl_pages';
												$query = $obj->select_data($tbl_name);
												$res = $obj->execute_query($conn,$query);
												$sn = 1;
									
												if($res==true)
												{
													$count_rows = $obj->num_rows($res);
													if($count_rows>0)
													{
														while ($row=$obj->fetch_data($res)) {
															$id = $row['id'];
															$title = $row['title_'.$_SESSION['lang']];
															$is_active = $row['is_active'];
															?>
                                                            <tr>
                                                            <td><?php echo $sn++; ?>. </td>
                                                                <td><?php echo $title; ?></td>
                                                                <td>
																	<?php if($is_active=='Yes'){ ?>
																		<span class="label label-success"><?php echo $lang['yes']; ?></span><?php } else if($is_active=='No'){ ?> <span class="label label-danger"><?php echo $lang['no']; ?></span> <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo SITEURL; ?>admin/index.php?page=edit_page&id=<?php echo $id; ?>" class="btn-success btn-sm"><?php echo $lang['edit'] ?></a> 
								<a href="<?php echo SITEURL; ?>admin/moduls/delete.php?page=pages&id=<?php echo $id; ?>" class="btn-error btn-sm"><?php echo $lang['delete'] ?></a>	
                                                                </td>
                                                            </tr>
                                                    <?php
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo"<tr><td colspan='5' class='error'>No Posts Found.</td></tr>";
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
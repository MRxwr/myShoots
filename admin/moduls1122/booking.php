	
    
    	<!-- Title -->
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark"><?php echo $lang['booking'] ?></h5>
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
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
                                                        <th><?php echo $lang['package_id'] ?></th>
                                                        <th><?php echo $lang['transaction_id'] ?></th>
                                                        <th><?php echo $lang['booking_date'] ?></th>
                                                        <th><?php echo $lang['booking_time'] ?></th>
                                                        <th><?php echo $lang['booking_price'] ?></th>
                                                        <th><?php echo $lang['is_active'] ?></th>
													</tr>
												</thead>
												<tfoot>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
                                                        <th><?php echo $lang['package_id'] ?></th>
                                                        <th><?php echo $lang['transaction_id'] ?></th>
                                                        <th><?php echo $lang['booking_date'] ?></th>
                                                        <th><?php echo $lang['booking_time'] ?></th>
                                                        <th><?php echo $lang['booking_price'] ?></th>
                                                        <th><?php echo $lang['is_active'] ?></th>
													</tr>
												</tfoot>
												<tbody>
                                               <?php 
												$tbl_name = 'tbl_booking';
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
															$package_id = $row['package_id'];
															$transaction_id = $row['transaction_id'];
															$booking_date = $row['booking_date'];
															$booking_time = $row['booking_time'];
															$booking_price = $row['booking_price'];
															$is_active = $row['status'];
															?>
									
															<tr>
																<td><?php echo $sn++; ?>. </td>
																<td><?php echo $package_id; ?></td>
																<td><?php echo $transaction_id; ?></td>
																<td><?php echo $booking_date; ?></td>
																<td><?php echo $booking_time; ?></td>
																<td>$<?php echo $booking_price; ?></td>
															   <td>
																	<?php if($is_active=='Yes'){echo $lang['yes'];}else if($is_active=='No'){echo $lang['no'];} ?>
																	
																</td>
																
															</tr>
									
															<?php
														}
													}
													else
													{
														echo "<tr><td colspan='5' class='error'>No Categories Found.</td></tr>";
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
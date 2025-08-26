	
    
    	<!-- Title -->
	<div class="row heading-bg">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark"><?php echo $lang['booking_success'] ?></h5>
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
                                                        <th><?php echo $lang['package_name'] ?></th>
                                                        <th><?php echo $lang['customer_name'] ?></th>
                                                        <th><?php echo $lang['mobile_number'] ?></th>
                                                        <th><?php echo $lang['baby_name'] ?></th>
                                                        <th><?php echo $lang['baby_age'] ?></th>
                                                        <th><?php echo $lang['instructions'] ?></th>
                                                        <th><?php echo $lang['booking_date'] ?></th>
                                                        <th><?php echo $lang['booking_time'] ?></th>
                                                        <th><?php echo $lang['extra_items'] ?></th>
                                                        <th><?php echo $lang['booking_price'] ?></th>
                                                        <th><?php echo $lang['transaction_id'] ?></th>
                                                        <th><?php echo $lang['is_active'] ?></th>
													</tr>
												</thead>
												<tfoot>
													<tr>
                                                        <th><?php echo $lang['sn'] ?></th>
                                                        <th><?php echo $lang['package_name'] ?></th>
                                                        <th><?php echo $lang['customer_name'] ?></th>
                                                        <th><?php echo $lang['mobile_number'] ?></th>
                                                        <th><?php echo $lang['baby_name'] ?></th>
                                                        <th><?php echo $lang['baby_age'] ?></th>
                                                        <th><?php echo $lang['instructions'] ?></th>
                                                        <th><?php echo $lang['booking_date'] ?></th>
                                                        <th><?php echo $lang['booking_time'] ?></th>
                                                        <th><?php echo $lang['extra_items'] ?></th>
                                                        <th><?php echo $lang['booking_price'] ?></th>
                                                        <th><?php echo $lang['transaction_id'] ?></th>
                                                        <th><?php echo $lang['is_active'] ?></th>
													</tr>
												</tfoot>
												<tbody>
                                               <?php 
												$tbl_name = 'tbl_booking';
												$where = " status='Yes'";
												//$query = $obj->select_data($tbl_name);
												$query = $obj->select_data($tbl_name,$where);
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
															$customer_name = $row['customer_name'];
															$mobile_number = $row['mobile_number'];
															$baby_name = $row['baby_name'];
															$baby_age = $row['baby_age'];
															$instructions = $row['instructions'];
															$booking_date = $row['booking_date'];
															$booking_time = $row['booking_time'];
															$extra_items = $row['extra_items'];
															$booking_price = $row['booking_price'];
															$is_active = $row['status'];
															$tbl_name1 = 'tbl_packages';
															$where = 'id='.$package_id;
												            $query1 = $obj->select_data($tbl_name1,$where);
															$res1 = $obj->execute_query($conn,$query1);
															$row1 = $obj->fetch_data($res1);
															$package_name = $row1['title_'.$_SESSION['lang']];
															?>
									
															<tr>
																<td><?php echo $sn++; ?>. </td>
																<td><?php echo $package_name; ?></td>
																<td><?php echo $customer_name; ?></td>
                                                                <td><?php echo $mobile_number; ?></td>
                                                                <td><?php echo $baby_name; ?></td>
                                                                <td><?php echo $baby_age; ?></td>
                                                                <td><?php echo $instructions; ?></td>
																<td><?php echo $booking_date; ?></td>
																<td><?php echo $booking_time; ?></td>
                                                                <td>
                                                                    <ul class="list-unstyled">
                                                                    <?php 
																	if($extra_items != ""){
                                                                    $rows = json_decode($extra_items); 
                                                                    foreach($rows as $row ){
                                                                    echo "<li>- ".$row->item." ".$row->price." KD.</li>";
                                                                    }
																	}
                                                                    ?>
                                                                    </ul>
                                                                </td>
                                                                <td><?php echo $booking_price; ?>KD</td>
                                                                <td><?php echo $transaction_id; ?></td>
																
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
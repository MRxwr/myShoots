	<div class="fixed-sidebar-left">
		<ul class="nav navbar-nav side-nav nicescroll-bar">
			<li class="navigation-header">
				<span>Main</span> 
				<i class="zmdi zmdi-more"></i>
			</li>
			<li>
				<a href="<?php echo SITEURL; ?>admin" data-toggle="collapse" data-target="#dashboard_dr">
					<div class="pull-left"><i class="zmdi zmdi-local-store mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
				</li>
				<li><hr class="light-grey-hr mb-10"/></li>
				<li class="navigation-header">
					<span>component</span> 
					<i class="zmdi zmdi-more"></i>
				</li>

				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_page"><div class="pull-left"><i class="zmdi zmdi-collection-text mr-20"></i><span class="right-nav-text">Pages</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_page" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=pages">List</a>
						</li>
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=add_page">Add New</a>
						</li>

					</ul>
				</li>

				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_gallery"><div class="pull-left"><i class="zmdi zmdi-collection-folder-image mr-20"></i><span class="right-nav-text">Gallery</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_gallery" class="collapse collapse-level-1 two-col-list">
                      <li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=categories">Categories List</a>
						</li>
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=add_category">Add category</a>
						</li>

						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=galleries">Gallery List</a>
						</li>
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=add_gallery">Add Gallery</a>
						</li>

					</ul>
				</li>

				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_book"><div class="pull-left"><i class="zmdi zmdi-collection-text mr-20"></i><span class="right-nav-text">Booking</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_book" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=booking">List</a>
						</li>
						<!--<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=add_booking">Add New</a>
						</li>-->

					</ul>
				</li>

				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_package"><div class="pull-left"><i class="zmdi zmdi-smartphone-setup mr-20"></i><span class="right-nav-text">Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_package" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=packages">List</a>
						</li>
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=add_package">Add New</a>
						</li>

					</ul>
				</li>

				<li><hr class="light-grey-hr mb-10"/></li>
				<li class="navigation-header">
					<span>System</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#pages_dr"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">Settings</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="pages_dr" class="collapse collapse-level-1 two-col-list">
						<li>
							<a href="<?php echo SITEURL; ?>admin/index.php?page=settings">Site Settings</a>
						</li>
						<!-- <li>
							<a href="login.html">Site</a>
						</li>
						<li>
							<a href="signup.html">Payment</a>
						</li>
						<li>
							<a href="forgot-password.html">Recover Password</a>
						</li>
						<li>
							<a href="reset-password.html">reset Password</a>
						</li>
 -->
					</ul>
				</li>

			</ul>
		</div>
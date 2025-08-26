		<?php 
		$page = "";
		if(isset($_GET['page']) && !empty($_GET['page']))
		{
			$page = $_GET['page'];	
		} 
		?>
    
    
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
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_banner"><div class="pull-left"><i class="zmdi zmdi-smartphone-setup mr-20"></i><span class="right-nav-text">Banners</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_banner" class="collapse collapse-level-1 two-col-list <?php if($page == 'banners' || $page == 'add_banner' || $page == 'edit_banner' ){ ?> in <?php } ?>">
						<li>
							<a href="index.php?page=banners" <?php if($page == 'banners'){ ?> class="active" <?php } ?>>List</a>
						</li>
						<li>
							<a href="index.php?page=add_banner" <?php if($page == 'add_banner'){ ?> class="active" <?php } ?>>Add New</a>
						</li>

					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_page"><div class="pull-left"><i class="zmdi zmdi-collection-text mr-20"></i><span class="right-nav-text">Pages</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_page" class="collapse collapse-level-1 two-col-list <?php if($page == 'pages' || $page == 'add_page' || $page == 'edit_page'){ ?> in <?php } ?>">
						<li>
							<a href="index.php?page=pages" <?php if($page == 'pages'){ ?> class="active" <?php } ?>>List</a>
						</li>
						<li>
							<a href="index.php?page=add_page" <?php if($page == 'add_page'){ ?> class="active" <?php } ?>>Add New</a>
						</li>

					</ul>
				</li>

				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_gallery"><div class="pull-left"><i class="zmdi zmdi-collection-folder-image mr-20"></i><span class="right-nav-text">Gallery</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_gallery" class="collapse collapse-level-1 two-col-list <?php if($page == 'categories' || $page == 'add_category' || $page == 'edit_category' || $page == 'galleries' || $page == 'add_gallery'  || $page == 'edit_gallery'){ ?> in <?php } ?>">
                    <!-- <li>
							<a href="index.php?page=categories" <?php if($page == 'categories'){ ?> class="active" <?php } ?>>Categories List</a>
						</li>
						<li>
							<a href="index.php?page=add_category" <?php if($page == 'add_category'){ ?> class="active" <?php } ?>>Add category</a>
						</li> -->

						<li>
							<a href="index.php?page=galleries" <?php if($page == 'galleries'){ ?> class="active" <?php } ?>>Photo List</a>
						</li>
						<li>
							<a href="index.php?page=add_gallery" <?php if($page == 'add_gallery'){ ?> class="active" <?php } ?>>Add Photo</a>
						</li>

					</ul>
				</li>

				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_book"><div class="pull-left"><i class="zmdi zmdi-collection-text mr-20"></i><span class="right-nav-text">Booking</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_book" class="collapse collapse-level-1 two-col-list <?php if($page == 'booking' || $page == 'booking-success' || $page == 'booking-failed'){ ?> in <?php } ?>">
						<li>
							<a href="index.php?page=booking" <?php if($page == 'booking'){ ?> class="active" <?php } ?>>Booking All</a>
						</li>
						<li>
							<a href="index.php?page=booking-success" <?php if($page == 'booking-success'){ ?> class="active" <?php } ?>><?php echo $lang['booking_success'] ?></a>
						</li>
						<li>
							<a href="index.php?page=booking-failed" <?php if($page == 'booking-failed'){ ?> class="active" <?php } ?>><?php echo $lang['booking_faild'] ?></a>
						</li>
						<li>
							<a href="index.php?page=booking-cancel" <?php if($page == 'booking-cancel'){ ?> class="active" <?php } ?>><?php echo 'Cancel Bookings' //$lang['booking_faild'] ?></a>
						</li>
					</ul>
				</li>
                
                <li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_package"><div class="pull-left"><i class="zmdi zmdi-smartphone-setup mr-20"></i><span class="right-nav-text">Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="ui_package" class="collapse collapse-level-1 two-col-list <?php if($page == 'packages' || $page == 'add_package' || $page == 'edit_package' ){ ?> in <?php } ?>">
						<li>
							<a href="index.php?page=packages" <?php if($page == 'packages'){ ?> class="active" <?php } ?>>List</a>
						</li>
						<li>
							<a href="index.php?page=add_package" <?php if($page == 'add_package'){ ?> class="active" <?php } ?>>Add New</a>
						</li>

					</ul>
				</li>

             <li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#disabled_date"><div class="pull-left"><i class="zmdi zmdi-apps mr-20"></i><span class="right-nav-text">Disabled Date</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="disabled_date" class="collapse collapse-level-1 two-col-list <?php if($page == 'disabled_date'){ ?> in <?php } ?>">
						<li>
							<a href="index.php?page=disabled_date" <?php if($page == 'disabled_date'){ ?> class="active" <?php } ?>>List</a>
						</li>
						<li>
							<a href="index.php?page=add_disabled_date">Add New</a>
						</li>
					</ul>
				</li>
				<li><hr class="light-grey-hr mb-10"/></li>
				<li class="navigation-header">
					<span>System</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#pages_cdr"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">Calendar</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="pages_cdr" class="collapse collapse-level-1 two-col-list <?php if($page == 'booking-calendar'){ ?> in <?php } ?>">
						<li>
							<a href="index.php?page=booking-calendar" <?php if($page == 'booking-calendar'){ ?> class="active" <?php } ?>>Booking Calendar</a>
						</li>
						<li>
							<a href="index.php?page=enable_date" <?php if($page == 'enable_date'){ ?> class="active" <?php } ?>>Open/Close date</a>
						</li>

					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#pages_dr"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">Settings</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
					<ul id="pages_dr" class="collapse collapse-level-1 two-col-list <?php if($page == 'settings'){ ?> in <?php } ?>">
						<li>
							<a href="index.php?page=settings" <?php if($page == 'settings'){ ?> class="active" <?php } ?>>Site Settings</a>
						</li>

					</ul>
				</li>

			</ul>
		</div>
<?php
// Get the current file name
$current_page = basename($_SERVER['PHP_SELF']);

// Define an array to map page names to display text
$page_titles = [
    'dashboard.php' => 'Dashboard',
    'schedule.php' => 'Assign an Employee',
    'bookings.php' => 'View Bookings',
		'packages.php' => 'Manage Packages',
		'inventory.php' => 'Manage Products',
		'profile.php' => 'Profile',
		'update_profile.php' => 'Update Profile',
		'user-information.php' => 'User Information',
		'manage-account.php' => 'Manage Account',
		'add_package.php' => 'Add Package',
		'view_packages.php' => 'View Packages',
		'add_product.php' => 'Add Product',
		'view_products.php' => 'View Products',
		'add_category.php' => 'Add Category',
		'view_category.php' => 'View Category',
		'edit_category.php' => 'Edit Category',
		'edit_product.php' => 'Edit Product',
		'transaction.php' => 'Transaction History',
		'view_admin.php' => 'View Admin Information',
		'view_employee.php' => 'View Employee Information',
		'view_customer.php' => 'View Customer Information',
		'update_employee.php' => 'Edit Employee Information',
		'update_customer.php' => 'Edit Customer Information',
		'view_admin_account.php' => 'View Admin Information',
		'view_employee_account.php' => 'View Employee Information',
		'view_customer_account.php' => 'View Customer Information',
		'update_employee_account.php' => 'Edit Employee Information',
		'update_customer_account.php' => 'Edit Customer Information',
    
];

// Set a default title in case the page is not listed
$page_title = isset($page_titles[$current_page]) ? $page_titles[$current_page] : 'Dashboard';
?>

<style>
	.header{
		background-color: #17153B;
	}

	.dashboard_bar h1{
		color: white;
	}

	.dropdown-item:hover{
		background: rgba(0, 0, 0, 0.8);
	}

</style>

<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        <h1><?php echo $page_title; ?></h1>
                          </div>
                            </div>
                            <ul class="navbar-nav header-right">

													<li class="nav-item">
								            <a href="transaction" class="btn d-sm-inline-block d-none" style="background-color: rgba(0, 0, 0, 0.3); padding:15px 20px; box-shadow: 1px 1px 5px black; border-radius: 10px; color:white;">
								            	<i class="fa-solid fa-peso-sign" style="color: white;"></i>
															<span class="nav-text" style="color: white;">Transaction History</span>
								            </a>
		           					  </li>	

													&nbsp;

													<li class="nav-item dropdown">
                            <a href="#" class="btn d-sm-inline-block d-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: rgba(0, 0, 0, 0.3); padding:15px 20px; box-shadow: 1px 1px 5px black; border-radius: 10px; color:white;">
                              <i class="fa-solid fa-user" style="color:white;"></i>
                              <span class="nav-text">Manage Account</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown" style="background-color: rgba(0, 0, 0, 0.3); border-radius: 10px;                          ">
                              <li><a class="dropdown-item text-white" href="user-information" style="color: white;">User Information</a></li>
                              <li><a class="dropdown-item text-white" href="manage-account" style="color: white;">User Account</a></li>
                            </ul>
                          </li>


													&nbsp;
            
                          <li class="nav-item">
								            <a href="logout.php" class="btn d-sm-inline-block d-none" style="background-color: red; padding:15px 20px;             border-radius: 10px; color:white;">
								            	<i class="fa-solid fa-right-from-bracket"></i>
								            </a>
		           					  </li>
                       </ul>
                     </div>
		           		</nav>
		           	</div>
		           </div>

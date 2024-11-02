<?php
// Get the current file name
$current_page = basename($_SERVER['PHP_SELF']);

// Define an array to map page names to display text
$page_titles = [
    'dashboard.php' => 'Dashboard',
    'schedule.php' => 'Assign an Employee',
    'bookings.php' => 'Booking',
		'inventory.php' => 'Inventory',
		'transaction.php' => 'Transaction History',
		'profile.php' => 'Profile',
		'update_profile.php' => 'Update Profile',
		'user-information.php' => 'User Information',
		'manage-account.php' => 'Manage Account',
    
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
								<a href="logout.php" class="btn d-sm-inline-block d-none" style="background-color: red; padding:15px 20px; border-radius: 10px; color:white;">
									<i class="fa-solid fa-right-from-bracket"></i>
								</a>
							</li>
                        </ul>
                    </div>
				</nav>
			</div>
		</div>

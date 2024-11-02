<?php
// Get the current file name
$current_page = basename($_SERVER['PHP_SELF']);

// Define an array to map page names to display text
$page_titles = [
    'index.php' => 'Homepage',
    'schedule.php' => 'My Schedule',
    'bookings.php' => 'Booking History',
		'inventory.php' => 'Inventory',
		'profile.php' => 'Profile', 
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

<div class="header" style="height: 100px;">
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
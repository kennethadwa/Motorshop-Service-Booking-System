<?php
session_start();

include('../connection.php');

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 1) {
    header("Location: ../login-register.php");
    exit();
}

// Query for total employees
$query_employees = "SELECT COUNT(*) AS total_employees FROM employees";
$result_employees = mysqli_query($conn, $query_employees);
$total_employees = mysqli_fetch_assoc($result_employees)['total_employees'];

// Query for total customers
$query_customers = "SELECT COUNT(*) AS total_customers FROM customers";
$result_customers = mysqli_query($conn, $query_customers);
$total_customers = mysqli_fetch_assoc($result_customers)['total_customers'];

// Query for total bookings
$query_bookings = "SELECT COUNT(*) AS total_bookings FROM booking_request"; 
$result_bookings = mysqli_query($conn, $query_bookings);
$total_bookings = mysqli_fetch_assoc($result_bookings)['total_bookings'];

// Query for total schedules
$query_schedules = "SELECT COUNT(*) AS total_schedules FROM schedule"; 
$result_schedules = mysqli_query($conn, $query_schedules);
$total_schedules = mysqli_fetch_assoc($result_schedules)['total_schedules'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sairom Dashboard</title>
	<link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<!-- Style CSS -->
    <link href="css/style.css" rel="stylesheet">
	
</head>
<body >

<!-- Preloader Start -->
<?php include('pre-loader.php'); ?>
<!-- Preloader End-->


<!-- Main wrapper Start -->
<div id="main-wrapper">
<!-- Nav Header Start -->
<?php include('nav-header.php'); ?>
<!-- Nav Header End -->

	
<!-- Header Start -->
<?php include('header.php'); ?>
<!-- Header End -->


<!-- Sidebar Start -->
<?php include('sidebar.php'); ?>
<!-- Sidebar End -->

		 
<!-- Content Body Start -->
<div class="content-body">
<div class="container-fluid">
<div class="row invoice-card-row">
<!-- Card 1 --> 
<?php include('./cards/card1.php'); ?>

<!-- Card 2 -->
<?php include('./cards/card2.php'); ?>
			 
<!-- Card 3 -->
<?php include('./cards/card3.php'); ?>

<!-- Card 4 -->
<?php include('./cards/card4.php'); ?>
</div>

<div class="row">
<!-- Card 5 -->
<?php include('./cards/card5.php'); ?>

<!-- Card 6 -->
<?php include('./cards/card6.php'); ?>

<!-- Card 7 -->
<?php include('./cards/card7.php'); ?>

<!-- Card 8 -->
<?php include('./cards/card8.php'); ?>

<!-- Card 9 -->
<?php include('./cards/card9.php'); ?>

<!-- Card 10 -->
<?php include('./cards/card10.php'); ?>

<!-- Card 11 -->
<?php include('./cards/card11.php'); ?>
</div>
</div>
</div>
<!-- Content Body End -->

</div>
<!-- Main wrapper end -->

<!-- Scripts -->
<!-- Required vendors -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
	
<!-- Apex Chart -->
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
	
<!-- Dashboard 1 -->
<script src="js/dashboard/dashboard-1.js"></script>

<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>
	
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: login.php");
    exit();
}
include('../connection.php');

$admin_id = $_SESSION['admin_id'];

include('chart_query.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sairom Dashboard</title>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<!-- Style CSS -->
    <link href="css/style.css" rel="stylesheet">

		<style>
			body{
				background-color: #17153B;
			}

			::-webkit-scrollbar {
         width: 18px; 
      }

      ::-webkit-scrollbar-track {
          background: #17153B;
      }
      
      ::-webkit-scrollbar-thumb {
          background-color: #DA0C81; 
          border-radius: 10px; 
          border: 2px solid #DA0C81; 
      }

      ::-webkit-scrollbar-thumb:hover {
          background-color: #555;
      }
		</style>
</head>
<body>

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

				<!-- Card 7 -->
				<?php include('./cards/card7.php'); ?>

				<!-- Card 8 -->
				<?php include('./cards/card8.php'); ?>

				<!-- Card 9 -->
				<?php include('./cards/card9.php'); ?>

				<!-- Card 10 -->
				<?php include('./cards/card10.php'); ?>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Dashboard 1 -->
<script src="js/dashboard/dashboard-1.js"></script>

<script src="js/custom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>
	
</body>
</html>

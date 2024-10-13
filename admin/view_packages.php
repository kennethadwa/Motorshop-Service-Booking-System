<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php');

// Fetch packages data from the database
$query = "SELECT package_name, price FROM packages"; 
$result = $conn->query($query);

$packages = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = [
            'name' => $row['package_name'],
            'price' => '$' . number_format($row['price'], 2) // Format the price as currency
        ];
    }
} else {
    $packages = []; // No packages found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Packages</title>
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

      .card-body {
       display: flex;
       flex-wrap: wrap; /* Allow cards to wrap to the next line if needed */
       justify-content: space-evenly; /* Evenly space the cards */
      }
    </style>
</head>
<body>

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
            <div class="col-12">
                <div class="card mb-4" style="box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
                    <div class="card-body">
                        <?php include('./cards/package_ajax.php'); ?>
                    </div>
                </div>
            </div>
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

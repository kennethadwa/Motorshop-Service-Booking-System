<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bookings</title>
	<link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<!-- Style CSS -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
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

        .btn-custom{
            background-color: #D91656;
            color: white;
            box-shadow: 1px 1px 10px black;
            padding: 40px 20px;
            border-radius: 5px;
            margin: 5px;
            font-size: 1.7rem;
            font-family: Verdana;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 20px;
            width: 100%; 
            transition: 0.5s ease;
        }

        .btn-custom:hover{
            background-color: #FF4E88;
            color: white;
        }

        .btn-customs{
            background-color: #4F1787;
            color: white;
            box-shadow: 1px 1px 10px black;
            padding: 40px 20px;
            border-radius: 5px;
            margin: 5px;
            font-size: 1.8rem;
            font-family: Verdana;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 20px;
            width: 100%; 
            transition: 0.5s ease;
        }

        .btn-customs:hover{
            background-color: #4A249D;
            color: white;
        }

        @media (max-width: 768px) {
            .btn-custom {
                font-size: 1rem;
                padding: 15px;
            }
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
                <div class="card mb-4" style="box-shadow: none; background:transparent;">
                    <div class="card-body text-center">
                        <!-- Row 1: Packages -->
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                <a href="add_package" class="btn btn-custom">Add Package</a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                <a href="view_packages" class="btn btn-custom">View Packages</a>
                            </div>
                        </div>

                        <!-- Row 2: Products -->
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                <a href="add_product" class="btn btn-customs">Add Product</a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                <a href="view_products" class="btn btn-customs">View Products</a>
                            </div>
                        </div>
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


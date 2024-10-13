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
    <title>Add Package</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #17153B;
        }
        .container-fluid {
            display: flex;
            justify-content: center;
            height: 100vh; /* Center vertically */
        }
        .card {
            max-width: 800px; /* Set max-width for the card */
            width: 100%; /* Allow full width on smaller screens */
            height: auto;
            margin: auto; /* Center the card */
            box-shadow: 2px 2px 2px black; 
            background-image: linear-gradient(to bottom, #030637, #3C0753);
        }
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
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
                <div class="card mb-4">
                    <div class="card-body">
                        
                        <!-- Add Package Form -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group mt-3">
                                <label for="package_name">Package Name:</label>
                                <input type="text" name="package_name" id="package_name" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="description">Description:</label>
                                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="price">Price:</label>
                                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                            </div>
                            
                            <!-- Multiple Image Upload Input -->
                            <div class="form-group mt-3">
                                <label for="images">Upload Images:</label>
                                <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                            </div>
                            <div class="add-btn" style="display: flex; justify-content:center">
                              <button type="submit" class="btn btn-primary mt-3" style="background: blue; color: white; border: none; box-shadow: 1px 1px 10px black; border-radius: 10px;">Add Package</button>
                            </div>
                            
                        </form>
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
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
<script src="js/dashboard/dashboard-1.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>

</body>
</html>

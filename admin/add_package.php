<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); 

$package_added = false; // Variable to check if the package was added

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $duration_unit = $_POST['duration_unit']; // New input for unit
    $status = $_POST['status'];

    // Convert duration to hours if unit is in days
    if ($duration_unit === 'days') {
        $duration *= 24; // Convert days to hours
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO packages (package_name, description, price, duration, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $package_name, $description, $price, $duration, $status);

    // Execute the statement
    if ($stmt->execute()) {
        $package_added = true; // Set to true if package is added successfully
    } else {
        echo "Error: " . $stmt->error; // This will display the error if there's an issue
    }

    // Close the statement
    $stmt->close();
}
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
            height: 100vh;
        }
        .card {
            max-width: 600px;
            width: 90%; 
            height: auto;
            box-shadow: 2px 2px 2px black; 
            background-image: linear-gradient(to bottom, #030637, #3C0753);
        }
        @media (min-width: 768px) {
            .card {
                width: 600px;
            }
        }
        @media (max-width: 576px) {
            .card {
                width: 100%; 
                margin: 0 10px; 
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
                                <div class="form-group mt-3">
                                    <label for="duration">Duration:</label>
                                    <input type="number" name="duration" id="duration" class="form-control" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="duration_unit">Duration Unit:</label>
                                    <select name="duration_unit" id="duration_unit" class="form-control" required>
                                        <option value="hours">Hours</option>
                                        <option value="days">Days</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="status">Status:</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="add-btn" style="display: flex; justify-content:center">
                                    <button type="submit" class="btn btn-primary mt-3" style="background: blue; color: white; border: none; box-shadow: 1px 1px 10px black; border-radius: 10px;">Add Package</button>
                                </div>
                            </form>

                            <?php if ($package_added): ?>
                            <script>
                                alert("Package added successfully!");
                                window.location.href = "inventory.php"; // Change to your actual inventory page
                            </script>
                            <?php endif; ?>

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

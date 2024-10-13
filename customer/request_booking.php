<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_SESSION['customer_id']; // Assuming customer_id is stored in session
    $model_name = $_POST['model_name'];
    $address = $_POST['address'];
    $request_date = $_POST['request_date'];
    $request_time = $_POST['request_time'];
    $description = $_POST['description'];

    // Insert into booking_request table
    $insertSql = "INSERT INTO booking_request (customer_id, model_name, address, request_date, request_time, description)
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    
    // Corrected bind_param call with 'isssss' to match six parameters
    $stmt->bind_param('isssss', $customer_id, $model_name, $address, $request_date, $request_time, $description);

    if ($stmt->execute()) {
        $request_id = $stmt->insert_id; // Get the inserted request ID

        // Handle multiple image uploads
        if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
            $target_dir = "../uploads/booking_images/";

            foreach ($_FILES['images']['name'] as $key => $image_name) {
                $image_tmp_name = $_FILES['images']['tmp_name'][$key];
                $image_target_path = $target_dir . basename($image_name);

                // Validate if it's an actual image
                $check = getimagesize($image_tmp_name);
                if ($check !== false) {
                    if (move_uploaded_file($image_tmp_name, $image_target_path)) {
                        $imageSql = "INSERT INTO booking_images (request_id, image_path) VALUES (?, ?)";
                        $imageStmt = $conn->prepare($imageSql);
                        $imageStmt->bind_param('is', $request_id, $image_target_path);
                        $imageStmt->execute();
                    }
                }
            }
        }

        echo "<script>alert('Booking request submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting booking request: " . $stmt->error . "');</script>";
    }
}
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
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
            .card {
                max-width: 100%;
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
                <div class="card mb-4" style="box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753); max-width: 800px; height:auto; width: 100%;">
                    <div class="card-body">
                        
                        <!-- Booking Request Form -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group mt-3">
                                <label for="model_name">Motorcycle Model:</label>
                                <input type="text" name="model_name" id="model_name" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>
                            <div class="row">
                            <div class="col-md-6 col-sm-12 mt-3">
                                <div class="form-group">
                                    <label for="request_date">Booking Date:</label>
                                    <input type="date" name="request_date" id="request_date" class="form-control" required>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <div class="form-group">
                                        <label for="request_time">Booking Time:</label>
                                        <input type="time" name="request_time" id="request_time" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                 <label for="description">Description:</label>
                                 <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                             </div>
                         
                             <!-- Multiple Image Upload Input -->
                             <div class="form-group mt-3">
                                 <label for="images">Upload Images:</label>
                                 <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                             </div>

                             <div class="sub-btn" style="display: flex; justify-content: center;">
                                <button type="submit" class="btn btn-primary mt-3" style="background: blue; color: white; border: none; box-shadow: 1px 1px 10px rgba(255, 255, 255, 0.39);">Submit Request</button>
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

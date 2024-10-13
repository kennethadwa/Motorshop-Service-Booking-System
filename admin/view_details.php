<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch booking request data based on request_id
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;

if ($request_id > 0) {
    // SQL query to join booking_request and customers table
    $sql = "SELECT br.request_id, 
               CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
               br.model_name AS model, 
               br.address, 
               br.request_date, 
               br.request_time, 
               br.description,
               br.status  
        FROM booking_request br
        JOIN customers c ON br.customer_id = c.customer_id
        WHERE br.request_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_name = $row['customer_name'];
        $model = $row['model'];
        $address = $row['address'];
        $request_date = $row['request_date'];
        $request_time = $row['request_time'];
        $description = $row['description'];
        $currentStatus = $row['status'];
    } else {
        $error_message = "No booking request found for Request ID: $request_id.";
    }
} else {
    $error_message = "Invalid request ID. Received: $request_id.";
}

// Assuming you're getting the request ID from a query parameter
$requestId = isset($_GET['request_id']) ? $_GET['request_id'] : 0;

// Fetch images for the booking request
$imageSql = "SELECT image_path FROM booking_images WHERE request_id = ?";
$stmt = $conn->prepare($imageSql);
$stmt->bind_param("i", $requestId);
$stmt->execute();
$imageResult = $stmt->get_result();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $newStatus = $_POST['status'];
    $updateSql = "UPDATE booking_request SET status = ? WHERE request_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $newStatus, $request_id);
    if ($updateStmt->execute()) {
        header("Location: bookings.php"); // Redirect to bookings page after update
        exit();
    } else {
        $error_message = "Error updating status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Booking Request</title>
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #17153B;
        }

        .request-info {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: transparent;
        }

        .info-container {
            max-width: 100%;
            padding: 15px;
            text-align: left;
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

        .img-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }

        .img-container img {
            width: 100%; /* Responsive width */
            height: 250px; /* Fixed height for uniformity */
            object-fit: cover; /* Ensures images fill the container and crop if necessary */
            border-radius: 8px; /* Optional: adds rounded corners */
        }

        /* Default column width */
        .img-container div {
            flex: 0 0 calc(33.333% - 10px); /* Default: 3 images per row */
            margin: 5px; /* Add margin for spacing */
        }

        /* Adjusting column widths for different screen sizes */
        @media (max-width: 768px) {
            .img-container div {
                flex: 0 0 calc(50% - 10px); /* Two images per row on medium screens */
                max-width: calc(50% - 10px);
            }
        }

        @media (max-width: 576px) {
            .img-container div {
                flex: 0 0 100%; /* One image per row on small screens */
                max-width: 100%;
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
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 col-md-10 col-sm-12"> <!-- Responsive columns -->
                    <div class="card" style="box-shadow: 2px 2px 5px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
                        <div class="card-body row justify-content-center">
                            <?php if (isset($error_message)): ?>
                                <p><?php echo $error_message; ?></p>
                            <?php elseif (isset($success_message)): ?>
                                <p style="color: green;"><?php echo $success_message; ?></p>
                            <?php else: ?>
                                <div class='request-info'>
                                    <div class='info-container'>
                                        <p style="color: white; font-size: 1rem; font-family:Verdana, Geneva, Tahoma, sans-serif;"><strong style="color: gray;">Request ID:</strong> <?php echo $request_id; ?></p>
                                        <p style="color: white; font-size: 1rem; font-family:Verdana, Geneva, Tahoma, sans-serif;"><strong style="color: gray;">Customer Name:</strong> <?php echo $customer_name; ?></p>
                                        <p style="color: white; font-size: 1rem; font-family:Verdana, Geneva, Tahoma, sans-serif;"><strong style="color: gray;">Model:</strong> <?php echo $model; ?></p>
                                        <p style="color: white; font-size: 1rem; font-family:Verdana, Geneva, Tahoma, sans-serif;"><strong style="color: gray;">Address:</strong> <?php echo $address; ?></p>
                                        <p style="color: white; font-size: 1rem; font-family:Verdana, Geneva, Tahoma, sans-serif;"><strong style="color: gray;">Request Date:</strong> <?php echo $request_date; ?></p>
                                        <p style="color: white; font-size: 1rem; font-family:Verdana, Geneva, Tahoma, sans-serif;"><strong style="color: gray;">Request Time:</strong> <?php echo $request_time; ?></p>
                                        <p style="color: white; font-size: 1rem; font-family:Verdana, Geneva, Tahoma, sans-serif;"><strong style="color: gray;">Description:</strong> <?php echo $description; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="img-container" style="display: flex; justify-content:center;">
                                <?php
                                if ($imageResult->num_rows > 0) {
                                    while ($row = $imageResult->fetch_assoc()) {
                                        echo '<div class="col-12 col-sm-6 col-md-4">'; 
                                        echo '<img src="' . $row['image_path'] . '" class="img-thumbnail">';
                                        echo '</div>';
                                    }
                                } else {
                                    
                                    
                                    echo '<p>No images available for this booking.</p>';
                                }
                                ?>
                            </div>

                            <!-- Status Selection Form -->
                            <form method="POST" action="">
                                <div class="col-12 text-center mt-3" style="display: flex; flex-direction: column; align-items: center;">
                                    <select name="status" id="status" required style="border-radius: 10px; padding: 10px 20px; margin-bottom: 10px;">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="pending" <?php echo ($currentStatus == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="approved" <?php echo ($currentStatus == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                        <option value="completed" <?php echo ($currentStatus == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="rejected" <?php echo ($currentStatus == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn mt-2" style="box-shadow: none; border: none; background: green;"><i class="fa-solid fa-pen-nib" style="color: #ffffff;"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main wrapper End -->

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

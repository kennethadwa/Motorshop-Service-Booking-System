<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php');

// Assuming you're getting the request ID from a query parameter
$requestId = isset($_GET['request_id']) ? $_GET['request_id'] : 0;

// Fetch description for the booking request
$requestSql = "SELECT description FROM booking_request WHERE request_id = ?";
$requestStmt = $conn->prepare($requestSql);
$requestStmt->bind_param("i", $requestId);
$requestStmt->execute();
$requestResult = $requestStmt->get_result();
$description = '';

if ($requestResult->num_rows > 0) {
    $row = $requestResult->fetch_assoc();
    $description = $row['description'];
}

// Fetch images for the booking request
$imageSql = "SELECT image_path FROM booking_images WHERE request_id = ?";
$stmt = $conn->prepare($imageSql);
$stmt->bind_param("i", $requestId);
$stmt->execute();
$imageResult = $stmt->get_result();

// Fetch status for the booking request
$statusSql = "SELECT status FROM booking_request WHERE request_id = ?";
$statusStmt = $conn->prepare($statusSql);
$statusStmt->bind_param("i", $requestId);
$statusStmt->execute();
$statusResult = $statusStmt->get_result();

$status = '';
if ($statusResult->num_rows > 0) {
    $statusRow = $statusResult->fetch_assoc();
    $status = $statusRow['status'];
} else {
    $status = 'No status available';
}

// Determine the color based on the status
$statusColor = '';
switch ($status) {
    case 'pending':
        $statusColor = 'orange';
        break;
    case 'approved':
        $statusColor = 'green';
        break;
    case 'completed':
        $statusColor = 'yellowgreen';
        break;
    case 'rejected':
        $statusColor = 'red';
        break;
    default:
        $statusColor = 'white'; 
        break;
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

      .desc{
        background-color: rgba(0, 0, 0, 0.39);;
        color: white;
        border: 1px solid black;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 10px;
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
            <div class="row invoice-card-row">
                <div class="col-12">
                    <div class="card mb-4" style="box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
                        <div class="card-body">

                        <div class="status-msg d-flex justify-content-center">
                                <h3 style="color: <?php echo $statusColor; ?>; font-family: Arial; font-weight: 600; margin-bottom: 30px;"><?php echo '<span style="color: white;">Status: </span>' . ucfirst($status); ?></h3> 
                            </div>
          
                        <div class="desc">
                          <h5 class="card-title" style="font-weight: bold; font-family: Verdana; color: white;">Customer Description</h5>
                            <p class="card-text"><?php echo htmlspecialchars($description); ?></p>
                        </div>
                            

                            <div class="img-container">
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
                            
                            <div style="height: 50px; display: flex; justify-content: center; margin: 30px;">
                              <a href="pay_deposit?request_id=<?php echo $requestId; ?>" style="background: blue; font-weight: bold;  font-size: 1.1rem; padding: 10px 15px; box-shadow: 1px 1px 7px black; border-radius: 5px;">Pay Deposit</a>
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

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

// Fetch customer details by joining customers with booking_request
$customerSql = "SELECT c.first_name, c.last_name, c.contact_no, c.address, c.email 
                FROM booking_request br
                JOIN customers c ON br.customer_id = c.customer_id
                WHERE br.request_id = ?";
$customerStmt = $conn->prepare($customerSql);
$customerStmt->bind_param("i", $requestId);
$customerStmt->execute();
$customerResult = $customerStmt->get_result();

$first_name = $last_name = $contact_no = $address = $email = '';
if ($customerResult->num_rows > 0) {
    $customerRow = $customerResult->fetch_assoc();
    $first_name = $customerRow['first_name'];
    $last_name = $customerRow['last_name'];
    $contact_no = $customerRow['contact_no'];
    $address = $customerRow['address'];
    $email = $customerRow['email'];
}

// Fetch package details by joining packages with booking_request
$packageSql = "SELECT p.package_id, p.package_name, p.duration, p.price 
               FROM booking_request br
               JOIN packages p ON br.package_id = p.package_id
               WHERE br.request_id = ?";
$packageStmt = $conn->prepare($packageSql);
$packageStmt->bind_param("i", $requestId);
$packageStmt->execute();
$packageResult = $packageStmt->get_result();

$package_id = $package_name = $duration = $price = '';
if ($packageResult->num_rows > 0) {
    $packageRow = $packageResult->fetch_assoc();
    $package_id = $packageRow['package_id'];
    $package_name = $packageRow['package_name'];
    $duration = $packageRow['duration'];
    $price = $packageRow['price'];
}


// Fetch the employee name assigned to the booking
$employeeSql = "SELECT e.first_name, e.last_name
                FROM schedule s
                JOIN employees e ON s.employee_id = e.employee_id
                JOIN booking_request br ON s.booking_id = br.request_id
                WHERE br.request_id = ?";
$employeeStmt = $conn->prepare($employeeSql);
$employeeStmt->bind_param("i", $requestId);
$employeeStmt->execute();
$employeeResult = $employeeStmt->get_result();

$employee_name = '';
if ($employeeResult->num_rows > 0) {
    $employeeRow = $employeeResult->fetch_assoc();
    $employee_name = $employeeRow['first_name'] . ' ' . $employeeRow['last_name'];
} else {
    $employee_name = 'No employee assigned yet';
}

// Fetch description and status for the booking request
$requestSql = "SELECT request_date, request_time, description, status FROM booking_request WHERE request_id = ?";
$requestStmt = $conn->prepare($requestSql);
$requestStmt->bind_param("i", $requestId);
$requestStmt->execute();
$requestResult = $requestStmt->get_result();
$description = $status = '';

if ($requestResult->num_rows > 0) {
    $row = $requestResult->fetch_assoc();
    $request_date = $row['request_date'];
    $request_time = $row['request_time'];
    $description = $row['description'];
    $status = $row['status'];
} else {
    $status = 'No status available';
}

// Fetch images for the booking request
$imageSql = "SELECT image_path FROM booking_images WHERE request_id = ?";
$imageStmt = $conn->prepare($imageSql);
$imageStmt->bind_param("i", $requestId);
$imageStmt->execute();
$imageResult = $imageStmt->get_result();

// Determine the color based on the status
$statusColor = '';
switch ($status) {
    case 'pending':
        $statusColor = 'orange';
        break;
    case 'approved':
        $statusColor = 'green';
        break;
    case 'paid':
        $statusColor = 'lightgreen';
        break;
    case 'in progress':
        $statusColor = 'lightblue';
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


// Prepare the SQL query to fetch comments and requested_date
$commentSql = "SELECT comments, date_requested FROM booking_request WHERE request_id = ?";
$commentStmt = $conn->prepare($commentSql);
$commentStmt->bind_param("i", $requestId);
$commentStmt->execute();
$commentResult = $commentStmt->get_result();

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
        width: 100%;
        height: 250px; 
        object-fit: cover; 
        border-radius: 8px; 
    }

  
    .img-container div {
        flex: 0 0 calc(33.333% - 10px);
        margin: 5px; 
    }

    
    @media (max-width: 768px) {
        .img-container div {
            flex: 0 0 calc(50% - 10px); 
            max-width: calc(50% - 10px);
        }
    }

    @media (max-width: 576px) {
        .img-container div {
            flex: 0 0 100%; 
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
                    <div class="card mb-4" style="box-shadow: none; background: transparent;">
                        <div class="card-body">

                        <div class="status-msg" style="display: flex; flex-direction: column; justify-content:center; align-items: center;">
                            <h3 style="color: <?php echo $statusColor; ?>; font-family: Arial; font-weight: 600; margin-bottom: 30px;">
                                <?php echo '<span style="color: white;">Status: </span>' . ucfirst($status); ?>
                            </h3>
                            <p style="font-size: 1.2rem; font-weight: 600; color:lightblue;"><?php echo '<span style= "color: white">Assigned Employee: </span>' . $employee_name; ?></p> 
                        </div>

                        <div class="desc" style="display:flex; flex-direction: column; font-size: 1rem;">
                            <!-- Customer Details -->
                            <p>Customer Name: <?php echo $first_name . ' ' . $last_name; ?></p>
                            <p>Contact No. <?php echo $contact_no; ?></p>
                            <p>Address: <?php echo $address; ?></p>
                            <p>Email Address: <?php echo $email; ?></p>
                            <br>

                            <!-- Package Details -->
                            <p>Package No. <?php echo $package_id; ?></p>
                            <p>Package Name: <?php echo $package_name; ?></p>
                            <p>Duration: <?php echo $duration . ' hours'; ?></p>
                            <p>Package Price: ₱<?php echo $price; ?></p>
                            <br>

                            <!-- Request fate & Time -->
                            <p>Requested Date & Time: <?php echo $request_date . ' : ' . $request_time; ?></p>
                            <p style="color: orange;"><?php if($status == 'paid' || $status == 'in progress' || $status == 'completed'){ echo '(Payment Completed)'; } ?>
                            </p>                        
                            <div class="desc">
                            <strong class="card-title" style="color: gray; text-align:center; font-size: 0.9rem;">Description</strong>
                            <p class="card-text"><br><?php echo htmlspecialchars($description); ?></p>
                        </div>
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

                        <br>

                        <div class="comments-section" style="display: flex; flex-direction: column; align-items: center; margin-top: 20px;">
                             <h4 style="color: white; text-align: center; font-weight: 600;">Comments</h4>
                             <?php
                             if ($commentResult && $commentResult->num_rows > 0) {
                                 while ($commentRow = $commentResult->fetch_assoc()) {
                                     echo '<div class="desc" style="color: #FFF; padding: 10px; border-radius: 8px; margin-top: 10px; width: 80%;                         ">';
                                     echo '<p style="margin: 0; font-size: 0.9rem;">' . htmlspecialchars($commentRow['comments']) . '</p>';
                                     echo '<small style="color: #999;">' . date("F j, Y, g:i a", strtotime($commentRow['date_requested'])) . '</small>';
                                     echo '</div>';
                                 }
                             } else {
                                 echo '<p style="color: #FFF;">No comments available for this booking.</p>';
                             }
                             ?>
                         </div>
                         
                         <br>

                        <!-- DELETE BOOKING BUTTON -->
                            <?php if ($status == 'pending' || $status == 'approved'): ?>
                                <div class="delete" style="display: flex; justify-content: center; align-items:center;">
                                    <form action="delete_booking.php" method="POST">
                                        <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
                                        <button type="submit" class="btn mt-4" style="background: red; color: white; box-shadow: 1px 1px 10px black;">
                                            Delete Booking Request
                                        </button>
                                    </form>
                                </div>
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

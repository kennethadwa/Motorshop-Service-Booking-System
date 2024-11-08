<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php');


// Fetch booking request data based on request_id
$requestId = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;

if ($requestId > 0) {
    // Fetch customer details
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

    // Fetch package details
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

    // Fetch request details
    $requestSql = "SELECT request_date, request_time, description, status FROM booking_request WHERE request_id = ?";
    $requestStmt = $conn->prepare($requestSql);
    $requestStmt->bind_param("i", $requestId);
    $requestStmt->execute();
    $requestResult = $requestStmt->get_result();

    $request_date = $request_time = $description = $status = '';
    if ($requestResult->num_rows > 0) {
        $row = $requestResult->fetch_assoc();
        $request_date = $row['request_date'];
        $request_time = $row['request_time'];
        $description = $row['description'];
        $status = $row['status'];
    }

    // Fetch images for the booking request
    $imageSql = "SELECT image_path FROM booking_images WHERE request_id = ?";
    $imageStmt = $conn->prepare($imageSql);
    $imageStmt->bind_param("i", $requestId);
    $imageStmt->execute();
    $imageResult = $imageStmt->get_result();

    include('booking_confirmation.php');

    // Handle status update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
        $newStatus = $_POST['status'];
        $updateSql = "UPDATE booking_request SET status = ? WHERE request_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $newStatus, $requestId);
        $updateStmt->execute();
        header("Location: bookings.php");
    }

    

} else {
    echo "Invalid request ID.";
    exit();
}


// Define the status flow
$statusFlow = ['pending', 'approved', 'in progress', 'completed', 'rejected'];

// Determine the current status index
$currentIndex = array_search($status, $statusFlow);

// Generate the select options dynamically
$options = '';
foreach ($statusFlow as $statusOption) {
    // Check if the status is 'pending' or 'approved' to show 'rejected'
    if ($statusOption === 'rejected' && !in_array($status, ['pending', 'approved'])) {
        continue; // Skip adding the rejected option
    }

    // Only add the option if it is not the current status or any previous status
    if ($statusOption !== $status && array_search($statusOption, $statusFlow) > $currentIndex) {
        $options .= "<option value=\"$statusOption\">".ucfirst($statusOption)."</option>";
    }
}

// Add the current status as selected
$options .= "<option value=\"$status\" selected>".ucfirst($status)."</option>";


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


// Handle status and comments update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $newStatus = $_POST['status'];
    $newComments = isset($_POST['comments']) ? $_POST['comments'] : '';

    $updateSql = "UPDATE booking_request SET status = ?, comments = ? WHERE request_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssi", $newStatus, $newComments, $requestId);
    $updateStmt->execute();
    echo "<script>alert('Updated Successfully')</script>";
    header("Location: bookings.php");
    exit();
}


// Fetch request details including comments
$requestSql = "SELECT request_date, request_time, description, status, comments FROM booking_request WHERE request_id = ?";
$requestStmt = $conn->prepare($requestSql);
$requestStmt->bind_param("i", $requestId);
$requestStmt->execute();
$requestResult = $requestStmt->get_result();

$request_date = $request_time = $description = $status = $comments = '';
if ($requestResult->num_rows > 0) {
    $row = $requestResult->fetch_assoc();
    $request_date = $row['request_date'];
    $request_time = $row['request_time'];
    $description = $row['description'];
    $status = $row['status'];
    $comments = $row['comments'];  // Fetch existing comments
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin View Booking</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #17153B;
        }

        .desc {
            background-color: rgba(0, 0, 0, 0.39);
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

<div id="main-wrapper">
    <?php include('nav-header.php'); ?>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row invoice-card-row">
                <div class="col-12">
                    <div class="card mb-4" style="box-shadow: none; background: transparent;">
                        <div class="card-body">
                            <div class="status-msg d-flex justify-content-center">
                                <h3 style="color: <?php echo $statusColor; ?>; font-family: Arial; font-weight: 600; margin-bottom: 30px;">
                                    <?php echo '<span style="color: white;">Status: </span>' . ucfirst($status); ?>
                                </h3>
                            </div>

                            <div class="desc" style="font-size: 1rem;">
                                <p>Customer Name: <?php echo $first_name . ' ' . $last_name; ?></p>
                                <p>Contact No.: <?php echo $contact_no; ?></p>
                                <p>Address: <?php echo $address; ?></p>
                                <p>Email: <?php echo $email; ?></p>
                                <br>
                                <p>Package No.: <?php echo $package_id; ?></p>
                                <p>Package Name: <?php echo $package_name; ?></p>
                                <p>Duration: <?php echo $duration . ' hours'; ?></p>
                                <p>Package Price: ₱<?php echo $price; ?></p>
                                <br>
                                <p>Requested Date & Time: <?php echo $request_date . ' : ' . $request_time; ?></p>
                                <p style="color: orange;"><?php if ($status == 'paid' || $status == 'in progress' || $status == 'completed') echo '(Payment Completed)'; ?></p></p>
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

                            <form method="POST" action="">

                                <div class="form-group mt-4">
                                    <label for="status">Change Status:</label>
                                    <select class="form-control" name="status" id="status">
                                        <?php echo $options; ?>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="comments">Comments:</label>
                                    <textarea class="form-control" name="comments" id="comments" rows="3" placeholder="Enter comments here..."><?php echo htmlspecialchars($comments); ?></textarea>
                                </div>


                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary mt-3" style="box-shadow: 1px 1px 10px black;">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

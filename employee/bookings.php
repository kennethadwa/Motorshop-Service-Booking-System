<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 1) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); 

// Fetch booking requests
$requestSql = "SELECT br.request_id, 
                      CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
                      br.model_name AS vehicle_model, 
                      br.address, 
                      br.status
               FROM booking_request br
               JOIN customers c ON br.customer_id = c.customer_id";
$requests = $conn->query($requestSql);
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
</head>
<body >

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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Customer Name</th>
                                        <th>Vehicle Model</th>
                                        <th>Booking Address</th>
                                        <th>Status</th>
                                        <th class="text-center">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php if ($requests->num_rows > 0): ?>
                                      <?php while ($row = $requests->fetch_assoc()): ?>
                                          <tr>
                                              <td><?php echo $row['request_id']; ?></td> <!-- Display Request ID -->
                                              <td><?php echo $row['customer_name']; ?></td> <!-- Display Customer Name -->
                                              <td><?php echo $row['vehicle_model']; ?></td> <!-- Display Vehicle Model -->
                                              <td><?php echo $row['address']; ?></td> <!-- Display Booking Address -->
                                              <td><?php echo ucfirst($row['status']); ?></td> <!-- Display Status -->
                                              <td class="text-center">
                                                  <a href="view_details.php?request_id=<?php echo $row['request_id']; ?>" class="btn btn-primary">
                                                      <i class="fas fa-eye"></i> View
                                                  </a>
                                              </td>
                                          </tr>
                                      <?php endwhile; ?>
                                  <?php else: ?>
                                      <tr>
                                          <td colspan="6" class="text-center">No Booking Requests Available</td> <!-- Message when no requests are found -->
                                      </tr>
                                  <?php endif; ?>
                                </tbody>
                            </table>
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
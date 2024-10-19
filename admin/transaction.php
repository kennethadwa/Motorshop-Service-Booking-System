<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php');

// Fetch all transactions for admin, ordered by transaction date descending
$sql = "SELECT 
            CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
            t.request_id, 
            t.deposit_amount, 
            t.payment_method, 
            t.transaction_status, 
            t.created_at 
        FROM transactions t
        JOIN booking_request br ON t.request_id = br.request_id
        JOIN customers c ON br.customer_id = c.customer_id 
        ORDER BY t.created_at DESC"; // Order by created_at descending
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
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
        .table {
            border: none; /* Remove default table border */
        }
        .table th,
        .table td {
            border: none; /* Remove default border for cells */
            padding: 15px; /* Add some padding */
        }
        .table tr {
            border-bottom: 1px solid white; /* Add a bottom border for each row */
        }
        .table tr:last-child {
            border-bottom: none; /* Remove the bottom border for the last row */
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
                            <div class="table-responsive">
                                <table class="table text-white">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>Customer Name</th>
                                            <th>Request Booking No.</th>
                                            <th>Deposit Amount</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Transaction Date</th>
                                            <th>Action</th> <!-- Added Action column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php if ($result->num_rows > 0): ?>
                                          <?php while ($row = $result->fetch_assoc()): ?>
                                              <tr style="text-align: center;">
                                                  <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['request_id']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['deposit_amount']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['transaction_status']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                  <td>
                                                      <a href="view_details.php?request_id=<?php echo htmlspecialchars($row['request_id']); ?>" class="btn" style="box-shadow: 1px 1px 10px black; background: blue; color: white; border-radius: 10px;">View</a>
                                                  </td>
                                              </tr>
                                          <?php endwhile; ?>
                                      <?php else: ?>
                                          <tr>
                                              <td colspan="7" class="text-center">No transactions found.</td>
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

<?php
$stmt->close();
$conn->close();
?>

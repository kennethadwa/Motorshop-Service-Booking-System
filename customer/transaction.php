<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php');

// Get the customer_id from the session (assuming it's stored in session)
$customerId = $_SESSION['customer_id'];

// Fetch transactions for the logged-in customer
// Fetch transactions for the logged-in customer
$sql = "SELECT CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
               t.deposit_amount, 
               t.payment_method, 
               t.transaction_status, 
               t.created_at 
        FROM transactions t
        JOIN booking_request br ON t.request_id = br.request_id
        JOIN customers c ON br.customer_id = c.customer_id
        WHERE br.customer_id = ?
        ORDER BY t.created_at DESC";  // Orders by created_at in descending order

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerId);
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
            margin: 0;
            padding: 0;
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
            border: none; 
        }
        .table th,
        .table td {
            border: none; 
            padding: 15px; 
        }
        .table tr {
            border-bottom: 1px dashed white; 
        }
        .table tr:last-child {
            border-bottom: none; 
        }
        .new-badge {
            color: orange;
            font-weight: bold;
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
                <div class="card mb-4" style="box-shadow: none; border: 1px dashed white; background: none;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-white">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th>Customer Name</th>
                                        <th>Deposit Amount</th>
                                        <th>Payment Method</th>
                                        <th>Transaction Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php if ($result->num_rows > 0): ?>
                                      <?php while ($row = $result->fetch_assoc()): ?>
                                          <tr style="text-align: center;">
                                              <td>
                                                  <?php echo htmlspecialchars($row['customer_name']); ?>
                                                  <?php 
                                                  $isNewTransaction = (strtotime($row['created_at']) > strtotime('-1 day'));
                                                  if ($isNewTransaction): ?>
                                                      <span style="color: orange;">(New)</span>
                                                  <?php endif; ?>
                                              </td>
                                              <td><?php echo htmlspecialchars($row['deposit_amount']); ?></td>
                                              <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                              <td><?php echo htmlspecialchars($row['transaction_status']); ?></td>
                                              <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                          </tr>
                                      <?php endwhile; ?>
                                  <?php else: ?>
                                      <tr>
                                          <td colspan="5" class="text-center">No transactions found.</td>
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

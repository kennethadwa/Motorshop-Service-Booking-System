<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); 

$scheduleSql = "SELECT s.schedule_id, 
                       c.profile AS customer_profile,
                       CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                       e.profile AS employee_profile,
                       CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                       br.request_date,
                       br.request_time,
                       br.address,
                       br.status,
                       br.request_id
                FROM schedule s
                LEFT JOIN booking_request br ON s.booking_id = br.request_id
                LEFT JOIN customers c ON br.customer_id = c.customer_id
                LEFT JOIN employees e ON s.employee_id = e.employee_id
                WHERE br.status IN ('in progress')"; 
$schedules = $conn->query($scheduleSql);

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
        table {
            border-collapse: collapse; 
            width: 100%;
        }

        th, td {
            text-align: center;
            padding: 10px;
            border: none; 
        }

        tr {
            border-bottom: 1px solid #ddd; 
        }

        th {
            background-color: #f2f2f2;
            border-bottom: 2px solid #ddd; 
        }

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
                            <div class="d-flex justify-content-end mb-3">
                                <a href="assign_employee" class="btn" style="background: #525CEB; box-shadow: 1px 1px 10px black; border-radius: 5px; color: white;"> <i class="fa fa-plus"></i> Assign Employee</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
    <tr style="color: white; background: transparent;">
        <th>Customer:</th>
        <th>Assigned Employee</th>
        <th>Scheduled Date</th>
        <th>Address</th>
        <th>Status</th>
        <th>View Details</th>
    </tr>
</thead>
<tbody>
    <?php if ($schedules->num_rows > 0): ?>
        <?php while ($row = $schedules->fetch_assoc()): ?>
            <tr style="background: transparent; color: white;">
                <td>
                    <img src="<?php echo $row['customer_profile']; ?>" alt="Customer Profile" width="40" height="40" style="border-radius: 50%; margin-right: 10px;">
                    <?php echo $row['customer_name']; ?>
                </td>
                <td>
                    <img src="<?php echo $row['employee_profile']; ?>" alt="Employee Profile" width="40" height="40" style="border-radius: 50%; margin-right: 10px;">
                    <?php echo $row['employee_name']; ?>
                </td>
                <td><?php echo $row['request_date'] . ' ' . $row['request_time']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td style="color: lightblue;"><?php echo ucfirst($row['status']); ?></td>
                <td class="text-center">
                    <a href="view_details.php?request_id=<?php echo $row['request_id']; ?>" class="btn" style="background: #4A249D; box-shadow: 2px 2px 5px black; border-radius: 5px; color: white; border: none;">
                        <i class="fas fa-eye"></i> View
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr style="background-color: transparent;">
            <td colspan="6" class="text-center" style="color: white;">No Scheduled Appointments Available</td>
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

<?php
$conn->close();
?>

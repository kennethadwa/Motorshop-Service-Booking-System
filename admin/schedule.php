<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); // Make sure this path is correct

// Fetch schedule data
$sql = "SELECT s.schedule_id, 
               CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
               CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
               s.schedule_date 
        FROM schedule s
        LEFT JOIN customers c ON s.customer_id = c.customer_id
        LEFT JOIN employees e ON s.employee_id = e.employee_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check Schedule</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- Main wrapper Start -->
<div id="main-wrapper">
    <?php include('nav-header.php'); ?>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row invoice-card-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h3>Add Schedule</h3>
                                </div>
                                <div>
                                    <a href="add_schedule.php" class="btn btn-success"><i class="fas fa-plus"></i>
                                      ADD SCHEDULE</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-bordered table-sm'>
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Assigned Employee</th>
                                            <th>Scheduled Date</th>
                                            <th>View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$row['customer_name']}</td>
                                                        <td>{$row['employee_name']}</td>
                                                        <td>{$row['schedule_date']}</td>
                                                        <td class='text-center'><a href='view_details.php?schedule_id={$row['schedule_id']}' class='btn btn-primary'><i class='fas fa-eye'></i>View</a></td>
                                                      </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='4' class='text-center'>No schedules found.</td></tr>";
                                        }
                                        $conn->close(); // Close the connection if it's opened in connection.php
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include('footer.php'); ?>

</div>

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

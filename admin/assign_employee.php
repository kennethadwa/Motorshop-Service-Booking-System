<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php'); // Make sure this path is correct

// Fetch customers
$customerSql = "SELECT customer_id, CONCAT(first_name, ' ', last_name) AS full_name FROM customers";
$customers = $conn->query($customerSql);

// Fetch employees
$employeeSql = "SELECT employee_id, CONCAT(first_name, ' ', last_name) AS full_name FROM employees";
$employees = $conn->query($employeeSql);

// Fetch request IDs from service_requests where status is 'Approved'
$requestSql = "SELECT request_id FROM service_requests WHERE status = 'Approved'";
$requests = $conn->query($requestSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Schedule</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="vendor/select2/css/select2.min.css" rel="stylesheet"> <!-- Include Select2 CSS -->
    <style>
        .card {
            max-width: 600px; /* Set max width for the card */
            margin: 0 auto; /* Center the card */
        }

        body {
            background-color: #17153B;
        }
        /* Responsive Design */
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
    <?php include('nav-header.php'); ?>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row invoice-card-row justify-content-center">
                <div class="col-md-6">
                    <div class="card" style="box-shadow: 2px 2px 2px black; background-color: rgba(0, 0, 0, 0.151);">
                        <div class="card-body">
                           <div class="d-flex justify-content-center mb-3">
                           </div> 
                            
                            <form action="submit_schedule.php" method="POST"> <!-- Adjust action as necessary -->
                                <div class="mb-3">
                                    <label for="employee" class="form-label">Assign Employee</label>
                                    <select id="employee" name="employee_id" class="form-select select2" required>
                                        <option value="">Select Employee</option>
                                        <?php while ($row = $employees->fetch_assoc()): ?>
                                            <option value="<?php echo $row['employee_id']; ?>">
                                                <?php echo $row['full_name']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="request" class="form-label">Booking Request No.</label>
                                    <select id="request" name="request_id" class="form-select" required>
                                        <option value="">Select Request No.</option>
                                        <?php while ($row = $requests->fetch_assoc()): ?>
                                            <option value="<?php echo $row['request_id']; ?>">
                                                <?php echo $row['request_id']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="scheduled_date" class="form-label">Scheduled Date</label>
                                    <input type="date" id="scheduled_date" name="scheduled_date" class="form-control" required>
                                </div>

                                <div class="d-flex justify-content-center mb-3 mt-3">
                                  <a href="schedule" class="btn" style="background-color: orange; color: white;"> <i class="fas fa-arrow-left"></i></a>
                                  &nbsp;
                                  <button type="submit" class="btn" style="background: green; color: white; box-shadow: none;"><i class="fa-solid fa-pen-nib" style="color: #ffffff;"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="vendor/select2/js/select2.min.js"></script> <!-- Include Select2 JS -->
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
<script src="js/dashboard/dashboard-1.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2(); // Initialize Select2
});
</script>

</body>
</html>

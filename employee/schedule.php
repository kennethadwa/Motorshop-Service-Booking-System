<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 1) {
    header("Location: ../login-register.php");
    exit();
}


include('../connection.php'); 

$employee_id = $_SESSION['employee_id']; 


$cardsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startIndex = ($page - 1) * $cardsPerPage;


$totalSchedulesSql = "SELECT COUNT(*) AS total FROM schedule s
                      LEFT JOIN booking_request br ON s.booking_id = br.request_id
                      WHERE s.employee_id = ? AND br.status = 'In Progress'";
$stmt = $conn->prepare($totalSchedulesSql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$totalSchedules = $result->fetch_assoc()['total'];


$totalPages = ceil($totalSchedules / $cardsPerPage);


$scheduleSql = "SELECT s.schedule_id, 
                       CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                       CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                       br.request_date,
                       br.address,
                       br.status,
                       c.profile as customer_profile,
                       e.profile as employee_profile,
                       br.request_id,
                       br.is_new
                FROM schedule s
                LEFT JOIN booking_request br ON s.booking_id = br.request_id
                LEFT JOIN customers c ON br.customer_id = c.customer_id
                LEFT JOIN employees e ON s.employee_id = e.employee_id
                WHERE s.employee_id = ? AND br.status = 'In Progress'
                ORDER BY br.request_date DESC
                LIMIT ? OFFSET ?";
$stmt = $conn->prepare($scheduleSql);
$stmt->bind_param("iii", $employee_id, $cardsPerPage, $startIndex);
$stmt->execute();
$schedules = $stmt->get_result();


$scheduleArray = [];
while ($row = $schedules->fetch_assoc()) {
    $scheduleArray[] = $row;
}


$mostRecentDate = !empty($scheduleArray) ? $scheduleArray[0]['request_date'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Schedule</title>
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

        /* Card styles */
        .invoice-card-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }

        .card {
            background: rgba(0, 0, 0, 0.473); 
            border: none; 
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5); 
            margin-bottom: 20px;
        }

        .card-body img {
            border-radius: 10px; 
            margin-right: 10px;
        }

        .card-body h5 {
            color: white;
        }

        .card-body p {
            color: lightblue;
        }

        .btn {
            background: #4A249D; 
            box-shadow: 2px 2px 5px black; 
            border-radius: 5px; 
            color: white; 
            border: none;
        }

        .btn:hover {
            background: #711DB0;
        }

    </style>
</head>
<body>

<div id="main-wrapper">
    <!-- Include headers and sidebar -->
    <?php include('nav-header.php'); ?>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row invoice-card-row">
                <?php if (count($scheduleArray) > 0): ?>
                    <?php foreach ($scheduleArray as $row): ?>
                        <div class="col-lg-4 col-md-6 mb-4 d-flex flex-wrap justify-content-evenly">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="<?php echo $row['customer_profile']; ?>" alt="Customer Profile" width="120" height="110">
                                        <h5 class="card-title"><?php echo $row['customer_name']; ?></h5>
                                    </div>
                                    <p><strong>Assigned to: </strong><?php echo $row['employee_name']; ?></p>
                                    <p><strong>Status: </strong> <?php echo ucfirst($row['status']); ?></p>
                                    <div class="text-center">
                                        <a href="view_details.php?request_id=<?php echo $row['request_id']; ?>" class="btn">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <div class="alert" role="alert" style="color: white; background: transparent;">
                            No Scheduled Appointments Available
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Include Scripts -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>

</body>
</html>


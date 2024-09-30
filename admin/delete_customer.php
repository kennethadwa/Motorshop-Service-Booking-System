<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
header("Location: ../login-register.php");
exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Customer</title>
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .confirmation-container {
            max-width: 320px;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto; /* Center the card */
        }

        .info-container {
            max-width: 100%;
            padding: 15px;
            text-align: center;
        }

        .action-btn {
            margin: 10px;
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
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 col-md-10 col-sm-12"> <!-- Responsive columns -->
                    <div class="card">
                        <div class="card-body row justify-content-center">
                            <h2 class="text-center mb-3">Delete Customer</h2>
                            <?php
                            // Database connection
                            $conn = new mysqli("localhost", "root", "", "sairom_service");

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch customer data based on customer_id
                            if (isset($_GET['id'])) {
                                $customer_id = intval($_GET['id']);
                                $sql = "SELECT first_name, last_name FROM customers WHERE customer_id = '$customer_id'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $full_name = $row['first_name'] . ' ' . $row['last_name'];

                                    echo "<div class='confirmation-container'>";
                                    echo "<div class='info-container'>";
                                    echo "<p>Are you sure you want to delete <strong>$full_name</strong>?</p>";
                                    echo "</div>";
                                } else {
                                    echo "<p>No customer found.</p>";
                                }
                            } else {
                                echo "<p>Invalid customer ID.</p>";
                            }

                            $conn->close();
                            ?>

                            <!-- Action Buttons -->
                            <div class="col-12 text-center mt-4">
                                <a href="customers.php" class="btn btn-warning action-btn"> <i class="fas fa-arrow-left"></i> No</a>
                                <form action="delete_customer_process.php" method="POST" class="d-inline">
                                    <input type="hidden" name="customer_id" value="<?php echo isset($customer_id) ? $customer_id : ''; ?>">
                                    <button type="submit" class="btn btn-danger action-btn"><i class="fa-solid fa-trash" style="color: #ffffff;"></i> Yes</button>
                                </form>
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

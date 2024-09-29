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
    <title>Customers Information</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .action-btn {
            display: inline-flex;
            align-items: center;
            margin-right: 5px;
        }
        .action-btn i {
            margin-right: 5px;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .profile-picture {
            width: 50px; /* Adjust size as needed */
            height: 50px; /* Adjust size as needed */
            border-radius: 50%; /* Make it circular */
            object-fit: cover; /* Ensure image covers the circle */
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
                <!-- customer Table Start -->
                <div class="col-12"> <!-- Full width for all devices -->
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-center">customer List</h2>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <h3>Add Customer</h3>
                                </div>
                                <div class="col-md-6 text-md-end"> <!-- Align text to the end on larger screens -->
                                    <!-- Add customer Button -->
                                    <button class="btn btn-primary" onclick="window.location.href='add_customer.php'">
                                        <i class="fa fa-plus"></i>ADD CUSTOMER
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive"> <!-- Makes table responsive -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Profile Picture</th> <!-- New column for profile picture -->
                                            <th>Full Name</th>
                                            <th>Contact Number</th>
                                            <th>Email</th>
                                            <th>Account Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Database connection
                                        $conn = new mysqli("localhost", "root", "", "sairom_service");
                                        

                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }

                                        // Fetch customer data
                                        $sql = "SELECT customer_id, first_name, last_name, contact_no, email, account_type, profile FROM customers";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $full_name = $row['first_name'] . ' ' . $row['last_name'];
                                                $contact_no = $row['contact_no'];
                                                $email = $row['email'];
                                                $account_type = $row['account_type'] == 1 ? '<span style="color: green;">customer</span>' : 'Other';
                                                $customer_id = $row['customer_id'];
                                                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg'; // Default picture if none exists

                                                echo "<tr>
                                                        <td><img src='$profile_picture' alt='Profile Picture' class='profile-picture'></td>
                                                        <td>$full_name</td>
                                                        <td>$contact_no</td>
                                                        <td>$email</td>
                                                        <td>$account_type</td>
                                                        <td>
                                                            <a class='action-btn btn btn-info' href='view_customer.php?id=$customer_id'>
                                                                <i class='fa fa-eye'></i>View
                                                            </a>
                                                        </td>
                                                      </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No customers found</td></tr>";
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div> <!-- End of table-responsive -->
                        </div>
                    </div>
                </div>
                <!-- customer Table End -->
            </div>
        </div>
    </div>
    <!-- Content Body End -->

    <!-- Footer Start -->
    <?php include('footer.php'); ?>
    <!-- Footer End -->

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

<?php
include '../connection.php';
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Fetch Admin Data
$admin_query = "SELECT admin_id, email, password, account_type, profile FROM admin";
$admin_result = mysqli_query($conn, $admin_query);

// Fetch Employee Data
$employee_query = "SELECT employee_id, email, password, account_type, profile FROM employees";
$employee_result = mysqli_query($conn, $employee_query);

// Fetch Customer Data
$customer_query = "SELECT customer_id, email, password, account_type, profile FROM customers";
$customer_result = mysqli_query($conn, $customer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Account</title>
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
        .admin { color: red; }
        .employee { color: green; }
        .customer { color: blue; }
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
                <!-- Manage Account Card Start -->
                <div class="col-12"> <!-- Full width for all devices -->
                    <div class="card">
                        <div class="card-body">                                     
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <h3>Manage Account</h3>
                                </div>
                                <div class="col-md-6 text-md-end"> <!-- Align text to the end on larger screens -->
                                    <button class="btn btn-primary" onclick="window.location.href='add_user.php'">
                                        <i class="fa fa-plus"></i>ADD USER
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive"> <!-- Makes table responsive -->
                                <ul class="nav nav-tabs" id="userTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="true">Admin</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="employee-tab" data-bs-toggle="tab" data-bs-target="#employee" type="button" role="tab" aria-controls="employee" aria-selected="false">Employee</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab" aria-controls="customer" aria-selected="false">Customer</button>
                                    </li>
                                </ul>

                                <!-- Tabs content -->
                                <div class="tab-content" id="userTabsContent">
                                    <!-- Admin Tab -->
                                    <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                                        <table class="table mt-3">
                                            <thead>
                                                <tr>
                                                    <th>Profile</th> 
                                                    <th>Email</th>
                                                    <th>Password</th>
                                                    <th>Account Type</th>
                                                    <th>View Information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($admin_result)) { 
                                                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg';
                                                $account_type = $row['account_type'];
                                                ?>
                                                    <tr>
                                                        <td><img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture"></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['password']; ?></td>
                                                        <td class="<?php echo $account_type == 0 ? 'admin' : ($account_type == 1 ? 'employee' : 'customer'); ?>">
                                                           <?php 
                                                           if ($account_type == 0) {
                                                               echo 'Admin';
                                                           } elseif ($account_type == 1) {
                                                               echo 'Employee';
                                                           } elseif ($account_type == 2) {
                                                               echo 'Customer';
                                                           }
                                                           ?>
                                                       </td>
                                                        <td><a href="view_admin.php?id=<?php echo $row['admin_id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Employee Tab -->
                                    <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                                        <table class="table mt-3">
                                            <thead>
                                                <tr>
                                                    <th>Profile</th> 
                                                    <th>Email</th>
                                                    <th>Password</th>
                                                    <th>Account Type</th>
                                                    <th>View Information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($employee_result)) { 
                                                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg';
                                                $account_type = $row['account_type'];
                                                ?>
                                                    <tr>
                                                        <td><img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture"></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['password']; ?></td>
                                                        <td class="<?php echo $account_type == 0 ? 'admin' : ($account_type == 1 ? 'employee' : 'customer'); ?>">
                                                            <?php 
                                                            if ($account_type == 0) {
                                                                echo 'Admin';
                                                            } elseif ($account_type == 1) {
                                                                echo 'Employee';
                                                            } elseif ($account_type == 2) {
                                                                echo 'Customer';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><a href="view_employee.php?id=<?php echo $row['employee_id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Customer Tab -->
                                    <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                                        <table class="table mt-3">
                                            <thead>
                                                <tr>
                                                    <th>Profile</th> <!-- Added Profile column -->
                                                    <th>Email</th>
                                                    <th>Password</th>
                                                    <th>Account Type</th>
                                                    <th>View Information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($customer_result)) { 
                                                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg';
                                                $account_type = $row['account_type'];
                                                ?>
                                                    <tr>
                                                        <td><img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture"></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['password']; ?></td>
                                                        <td class="<?php echo $account_type == 0 ? 'admin' : ($account_type == 1 ? 'employee' : 'customer'); ?>">
                                                            <?php 
                                                            if ($account_type == 0) {
                                                                echo 'Admin';
                                                            } elseif ($account_type == 1) {
                                                                echo 'Employee';
                                                            } elseif ($account_type == 2) {
                                                                echo 'Customer';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><a href="view_customer.php?id=<?php echo $row['customer_id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- End of tab-content -->
                            </div> <!-- End of table-responsive -->
                        </div>
                    </div>
                </div>
                <!-- Manage Account Card End -->
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

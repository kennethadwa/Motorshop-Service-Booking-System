<?php
include '../connection.php';
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Fetch Admin Data
$admin_query = "SELECT admin_id, first_name, last_name, contact_no, address, profile, account_type, age, birthday, sex FROM admin";
$admin_result = mysqli_query($conn, $admin_query);

// Fetch Employee Data
$employee_query = "SELECT employee_id, first_name, last_name, contact_no, address, account_type, profile, age, birthday, sex FROM employees";
$employee_result = mysqli_query($conn, $employee_query);

// Fetch Customer Data
$customer_query = "SELECT customer_id, first_name, last_name, contact_no, address, profile, account_type, age, birthday, sex FROM customers";
$customer_result = mysqli_query($conn, $customer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Information</title>
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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }


	body{
	  background-color: #17153B;
      font-family: Verdana;
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
    border-bottom: 1px dashed #ddd; 
}

th {
    background-color: #f2f2f2;
    border-bottom: 2px dashed #ddd; 
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
                <!-- User Information Card Start -->
                <div class="col-12">
                    <div class="card" style="box-shadow: none; border: 1px dashed white; background: transparent">
                        <div class="card-body">                                     
                            <div class="table-responsive">
                                <ul class="nav nav-tabs" id="userTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="true" style="background: transparent; font-family: Verdana; color: pink; font-weight: 600; ">Admin</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="employee-tab" data-bs-toggle="tab" data-bs-target="#employee" type="button" role="tab" aria-controls="employee" aria-selected="false" style="background: transparent; color: pink; font-weight: 600; font-family: Verdana; ">Employee</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab" aria-controls="customer" aria-selected="false" style="background: transparent; color: pink; font-weight: 600; font-family: Verdana; ">Customer</button>
                                    </li>
                                </ul>

                                <!-- Tabs content -->
                                <div class="tab-content" id="userTabsContent">
                                    <!-- Admin Tab -->
<div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
    <table class="table mt-3">
        <thead>
            <tr style="color: white;">
                <th>Profile Picture</th>  
                <th>Name</th>
                <th>Age</th>         <!-- Moved Age here -->
                <th>Birthday</th>    <!-- Moved Birthday here -->
                <th>Sex</th>         <!-- Moved Sex here -->
                <th>Contact No.</th>
                <th>Address</th>
                <th>View Information</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($admin_result)) { 
                $full_name = $row['first_name'] . ' ' . $rows['last_name'];
                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg'; 
            ?>
                <tr style="color: white;">
                    <td><img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture"></td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $row['age']; ?></td>         <!-- Moved Age data here -->
                    <td><?php echo $row['birthday']; ?></td>    <!-- Moved Birthday data here -->
                    <td><?php echo $row['sex']; ?></td>         <!-- Moved Sex data here -->
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><a href="view_admin?id=<?php echo $row['admin_id']; ?>" class="btn btn-info btn-sm" style="background: #4A249D; box-shadow: 2px 2px 5px black; border-radius: 5px; color: white; border: none;"><i class="fas fa-eye"></i> View</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Employee Tab -->
<div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="employee-tab">
    <table class="table mt-3">
        <thead>
            <tr style="color: white;">
                <th>Profile Picture</th>  
                <th>Name</th>
                <th>Age</th>         <!-- Moved Age here -->
                <th>Birthday</th>    <!-- Moved Birthday here -->
                <th>Sex</th>         <!-- Moved Sex here -->
                <th>Contact No.</th>
                <th>Address</th>
                <th>View Information</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($employee_result)) { 
                $full_name = $row['first_name'] . ' ' . $row['last_name'];
                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg'; 
            ?>
                <tr style="color: white;">
                    <td><img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture"></td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $row['age']; ?></td>         <!-- Moved Age data here -->
                    <td><?php echo $row['birthday']; ?></td>    <!-- Moved Birthday data here -->
                    <td><?php echo $row['sex']; ?></td>         <!-- Moved Sex data here -->
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><a href="view_employee?id=<?php echo $row['employee_id']; ?>" class="btn btn-info btn-sm" style="background: #4A249D; box-shadow: 2px 2px 5px black; border-radius: 5px; color: white; border: none;"><i class="fas fa-eye"></i> View</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Customer Tab -->
<div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">
    <table class="table mt-3">
        <thead>
            <tr style="color: white;">
                <th>Profile Picture</th>
                <th>Name</th>
                <th>Age</th>         <!-- Moved Age here -->
                <th>Birthday</th>    <!-- Moved Birthday here -->
                <th>Sex</th>         <!-- Moved Sex here -->
                <th>Contact No.</th>
                <th>Address</th>
                <th>View Information</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($customer_result)) { 
                $full_name = $row['first_name'] . ' ' . $row['last_name'];
                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg'; 
            ?>
                <tr style="color: white;">
                    <td><img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture"></td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $row['age']; ?></td>         <!-- Moved Age data here -->
                    <td><?php echo $row['birthday']; ?></td>    <!-- Moved Birthday data here -->
                    <td><?php echo $row['sex']; ?></td>         <!-- Moved Sex data here -->
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><a href="view_customer?id=<?php echo $row['customer_id']; ?>" class="btn" style="background: #4A249D; box-shadow: 2px 2px 5px black; border-radius: 5px; color: white; border: none;"> <i class="fas fa-eye"></i> View</a></td>
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
                <!-- User Information Card End -->
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

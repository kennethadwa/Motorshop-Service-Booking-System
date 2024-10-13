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
    <title>Add Admin</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <!-- Style CSS -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .content-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-group {
            margin-bottom: 15px;
        }

        .form-group input, .form-group select {
            width: 100%;
        }
        .btn {
            margin-top: 20px;
        }
        .card {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

      body{
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
            <div class="col-lg-12 col-md-10 col-sm-12"> 
                <div class="card" style="box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
                    <div class="card-body">

                        <!-- FORM -->
<form action="add_admin_process.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    
    <!-- New Fields for Age, Birthday, and Sex -->
    <div class="form-group">
        <label for="age">Age</label>
        <input type="number" class="form-control" id="age" name="age" required>
    </div>
    <div class="form-group">
        <label for="birthday">Birthday</label>
        <input type="date" class="form-control" id="birthday" name="birthday" required>
    </div>
    <div class="form-group">
        <label for="sex">Sex</label>
        <select class="form-control" id="sex" name="sex" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <!-- End of new fields -->

    <div class="form-group">
        <label for="contact_no">Contact Number</label>
        <input type="text" class="form-control" id="contact_no" name="contact_no" required>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" name="address">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="account_type">Account Type</label>
        <select class="form-control" id="account_type" name="account_type" required>
            <option value="0">Admin</option>
        </select>
    </div>
    <!-- Profile Picture Upload -->
    <div class="form-group">
        <label for="profile">Profile Picture</label>
        <input type="file" class="form-control-file" id="profile" name="profile" accept="image/*">
    </div>
    <div class="text-center">
        <a href="manage-account" class="btn action-btn" style="box-shadow: none; border: none; background: orange;"><i class="fas fa-arrow-left"></i></a>
        &nbsp;
        <button type="submit" class="btn" style="background: blue;"><i class="fa-solid fa-user-plus" style="color: #ffffff;"></i></button>
    </div>
</form>
<!-- FORM END -->


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

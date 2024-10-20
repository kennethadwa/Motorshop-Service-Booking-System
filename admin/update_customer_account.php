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
    <title>Update Customer</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .content-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input, 
        .form-group select {
            width: 100%;
        }
        .btn {
            margin-top: 20px;
        }
        .text-center {
            text-align: center;
        }
        .profile-picture-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
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
                <div class="card" style="box-shadow: none; background: transparent;">
                    <div class="card-body">
                        <?php
                        // Database connection
                        $conn = new mysqli("localhost", "root", "", "sairom_service");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch customer data based on customer_id
                        if (isset($_GET['id'])) {
                            $customer_id = intval($_GET['id']);
                            $sql = "SELECT email, profile, account_type FROM customers WHERE customer_id = '$customer_id'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $email = $row['email'];
                                $profile_picture = !empty($row['profile']) ? $row['profile'] : 'uploads/customer_profile/default_profile.jpg'; 
                                $account_type = $row['account_type'];
                            } else {
                                echo "<p>No customer found.</p>";
                            }
                        } else {
                            echo "<p>Invalid customer ID.</p>";
                        }

                        $conn->close();
                        ?>

                        <div class="profile-picture-wrapper">
                            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture" style="width: 130px; height: 120px; border-radius: 10px;">
                        </div>

                        <form action="update_customer_account_process.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" style="background-color: transparent; color: white;" name="email" value="<?php echo $email; ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" style="background-color: transparent; color: white;" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" style="background-color: transparent; color: white;" name="confirm_password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="profile">Profile Picture:</label>
                                <input type="file" name="profile" class="form-control-file">
                            </div>
                            <div class="form-group">
                                <label for="account_type">Account Type:</label>
                                <select name="account_type" style="background-color: transparent; color: white;" class="form-control">
                                    <option value="2" <?php echo ($account_type == 2) ? 'selected' : ''; ?>>Customer</option>
                                </select>
                            </div>
                            <div class="text-center">

                                <a href="manage-account.php" class="btn" style="box-shadow: none; border: none; background: orange; color: white;"> <i class="fas fa-arrow-left"></i> Back</a>
                                &nbsp;
                                <button type="submit" class="btn" style="box-shadow: none; border: none; background: green; color: white;"><i class="fa-solid fa-pen-nib" style="color: #ffffff;"></i> Update</button>
                                
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Body End -->
</div>
<!-- Main wrapper end -->

<!-- Scripts -->
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

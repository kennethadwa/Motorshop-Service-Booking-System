<?php
session_start();
if (!isset($_SESSION['account_type']) || (int)$_SESSION['account_type'] !== 0) {
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
    <title>View Customer</title>
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .customer-info {
            max-width: 320px;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .info-container {
            max-width: 100%;
            padding: 15px;
            text-align: center;
        }

        .profile-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover;
        }

        .action-btn {
            margin: 10px;
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
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 col-md-10 col-sm-12">
                    <div class="card" style="box-shadow: 1px 1px 10px black; background: transparent;">
                        <div class="card-body row justify-content-center">
                            <?php
                            // Database connection
                            $conn = new mysqli("localhost", "root", "", "sairom_service");

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch customer data based on customer_id
                            if (isset($_GET['id'])) {
                                $customer_id = intval($_GET['id']);
                                $sql = "SELECT email, password, profile, account_type FROM customers WHERE customer_id = '$customer_id'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $email = $row['email'];
                                    $password = $row['password']; // Be careful displaying passwords
                                    $profile_picture = !empty($row['profile']) ? $row['profile'] : 'uploads/customer_profile/default_profile.jpg';
                                    
                                    // Check account type and display "Customer" in blue if account_type is 2
                                    $account_type = $row['account_type'] == 2 ? "<span style='color: blue; font-weight: bold;'>Customer</span>" : "Other";

                                    echo "<div class='customer-info'>";
                                    echo "<img src='$profile_picture' alt='Profile Picture' class='profile-image'>"; // Display the profile picture
                                    echo "<div class='info-container'>";
                                    echo "<p><strong>Email:</strong> $email</p>";
                                    echo "<p><strong>Password:</strong> $password</p>"; // Be cautious displaying this
                                    echo "<p><strong>Account Type:</strong> $account_type</p>";
                                    echo "</div>";
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
                                <a href="manage-account.php" class="btn btn-warning action-btn" style="box-shadow: none; border: none; background: orange; color: white;"> <i class="fas fa-arrow-left"></i> Back</a>


                                <a href="update_customer_account.php?id=<?php echo $customer_id; ?>" class="btn btn-success action-btn" style="box-shadow: none; border: none; background: green; color: white;"><i class="fa-solid fa-pen-nib" style="color: #ffffff;"></i> Update</a>


                                <a href="delete_customer.php?id=<?php echo $customer_id; ?>" class="btn btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this customer?')" style="color: white; background: red;"><i class="fa-solid fa-trash" style="color: #ffffff; "></i> Delete</a>
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

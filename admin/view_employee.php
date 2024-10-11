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
    <title>View Employee</title>
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .employee-info {
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
                <div class="col-lg-7 col-md-10 col-sm-12"> <!-- Responsive columns -->
                    <div class="card" style="box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
                        <div class="card-body row justify-content-center">
                            <?php
                            // Database connection
                            $conn = new mysqli("localhost", "root", "", "sairom_service");
                            
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            
                            // Fetch employee data based on employee_id
                            if (isset($_GET['id'])) {
                                $employee_id = intval($_GET['id']);
                                $sql = "SELECT first_name, last_name, contact_no, address, email, profile, account_type, age, birthday, sex FROM employees WHERE employee_id = '$employee_id'";
                                $result = $conn->query($sql);
                            
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $full_name = $row['first_name'] . ' ' . $row['last_name'];
                                    $age = $row['age'];
                                    $birthday = $row['birthday'];
                                    $sex = $row['sex'];
                                    $contact_no = $row['contact_no'];
                                    $address = $row['address'];
                                    $email = $row['email'];
                                    $profile_picture = !empty($row['profile']) ? $row['profile'] : 'uploads/employee_profile/default_profile.jpg'; 
                                    $account_type = $row['account_type'] == 1 ? "<span class='account-type' style='color: green'>Employee</span>" : "Other";

                                    echo "<div class='employee-info'>";
                                    echo "<img src='$profile_picture' alt='Profile Picture' class='profile-image'>"; // Profile image at the top
                                    echo "<div class='info-container'>";
                                    echo "<p><strong>Full Name:</strong> $full_name</p>";
                                    echo "<p><strong>Age:</strong> $age</p>";
                                    echo "<p><strong>Birthday:</strong> $birthday</p>";
                                    echo "<p><strong>Sex:</strong> $sex</p>";
                                    echo "<p><strong>Contact Number:</strong> $contact_no</p>";
                                    echo "<p><strong>Address:</strong> $address</p>";
                                    echo "</div>";
                                    echo "</div>";
                                } else {
                                    echo "<p>No employee found.</p>";
                                }
                            } else {
                                echo "<p>Invalid employee ID.</p>";
                            }
                            
                            $conn->close();
                            ?>
                            
                            <!-- Action Buttons -->
                            <div class="col-12 text-center mt-4">
                                <a href="user-information" class="btn action-btn" style="box-shadow: none; border: none; background: orange;"> <i class="fas fa-arrow-left"></i></a>
                                <a href="update_employee?id=<?php echo $employee_id; ?>" class="btn btn-success action-btn" style="box-shadow: none; border: none; background: green;"><i class="fa-solid fa-pen-nib" style="color: #ffffff;"></i></a>
                                <a href="delete_employee?id=<?php echo $employee_id; ?>" class="btn action-btn" style="box-shadow: none; border: none; background: red;"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a>
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

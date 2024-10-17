<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
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
    <title>Profile</title>
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .customer-info {
            max-width: 320px;
            height: auto;
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
        }

        .info-container {
            max-width: 100%; /* Allow container to be responsive */
            padding: 15px; /* Optional padding */
            text-align: center; /* Center text inside the container */
        }

        .profile-image {
            width: 80px; /* Set width to 80px */
            height: 80px; /* Set height to 80px for a smaller size */
            border-radius: 50%; /* Make the image circular */
            margin-bottom: 10px; /* Spacing below the image */
            object-fit: cover; /* Maintain aspect ratio and cover the area */
        }

        .action-btn {
            margin: 10px; /* Spacing between buttons */
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
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 col-md-10 col-sm-12"> <!-- Responsive columns -->
                    <div class="card" style="box-shadow: none;">
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
                                $sql = "SELECT first_name, last_name, contact_no, address, email, profile, account_type, age, birthday, sex FROM customers WHERE customer_id = '$customer_id'";
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
                                    $profile_picture = !empty($row['profile']) ? $row['profile'] : 'uploads/customer_profile/default_profile.jpg'; 
                                    $account_type = $row['account_type'] == 1 ? "<span class='account-type' style='color: green'>Customer</span>" : "Other";

                                    echo "<div class='customer-info'>";
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
                                    echo "<p>No customer found.</p>";
                                }
                            } else {
                                echo "<p>Invalid customer ID.</p>";
                            }
                            
                            $conn->close();
                            ?>
                            
                            <!-- Action Buttons -->
                            <div class="col-12 text-center mt-4">
                                <a href="index" class="btn btn-warning action-btn"> <i class="fas fa-arrow-left"></i> Back</a>
                                <a href="update_profile?id=<?php echo $customer_id; ?>" class="btn btn-success action-btn"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i> Update</a>
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
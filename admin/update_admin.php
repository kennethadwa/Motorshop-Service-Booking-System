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
    <title>Update Admin</title>
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
            width: 100px; /* Adjust the size as needed */
            height: 100px; /* Adjust the size as needed */
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc; /* Optional: border for the profile picture */
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
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Update Admin Information</h2>
                        <?php
                        // Database connection
                        $conn = new mysqli("localhost", "root", "", "sairom_service");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch admin data based on admin_id
                        if (isset($_GET['id'])) {
                            $admin_id = intval($_GET['id']);
                            $sql = "SELECT first_name, last_name, contact_no, address, email, profile, account_type FROM admin WHERE admin_id = '$admin_id'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $full_name = $row['first_name'] . ' ' . $row['last_name'];
                                $contact_no = $row['contact_no'];
                                $address = $row['address'];
                                $email = $row['email'];
                                $profile_picture = !empty($row['profile']) ? $row['profile'] : 'uploads/admin_profile/default_profile.jpg'; 
                                $account_type = $row['account_type']; // Get account type
                            } else {
                                echo "<p>No admin found.</p>";
                            }
                        } else {
                            echo "<p>Invalid admin ID.</p>";
                        }

                        $conn->close();
                        ?>

                        <div class="profile-picture-wrapper">
                            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
                        </div>

                        <form action="update_admin_process.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_no">Contact Number:</label>
                                <input type="text" name="contact_no" value="<?php echo $contact_no; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" name="address" value="<?php echo $address; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="profile">Profile Picture:</label>
                                <input type="file" name="profile" class="form-control-file">
                            </div>
                            <div class="form-group">
                                <label for="account_type">Account Type:</label>
                                <select name="account_type" class="form-control" required>
                                    <option value="0" <?php echo ($account_type == 0) ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="admins.php" class="btn btn-warning"> <i class="fas fa-arrow-left"></i> Back</a>
                            </div>
                        </form>

                    </div>
                </div>
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

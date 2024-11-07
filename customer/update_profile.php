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
            max-width: 100%;
            margin: auto;
            background: #2B2A4C;
            box-shadow: none;
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
        body {
            background-color: #17153B;
        }
        /* Scrollbar styles */
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
                <div class="card" style="background: transparent;">
                    <div class="card-body">
                        <?php
                        // Database connection
                        $conn = new mysqli("localhost", "root", "", "sairom_service");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Initialize variables
                        $row = [];
                        $full_name = '';
                        $contact_no = '';
                        $address = '';
                        $email = '';
                        $profile_picture = 'uploads/customer_profile/default_profile.jpg'; // Default profile picture
                        $account_type = '';
                        $age = '';
                        $birthday = '';
                        $sex = '';

                        // Fetch customer data based on customer_id
                        if (isset($_GET['id'])) {
                            $customer_id = intval($_GET['id']);
                            $sql = "SELECT first_name, last_name, contact_no, address, email, profile, account_type, age, birthday, sex FROM customers WHERE customer_id = '$customer_id'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $full_name = $row['first_name'] . ' ' . $row['last_name'];
                                $contact_no = $row['contact_no'];
                                $address = $row['address'];
                                $email = $row['email'];
                                $profile_picture = !empty($row['profile']) ? $row['profile'] : $profile_picture; 
                                $account_type = $row['account_type']; 
                                $age = $row['age'];
                                $birthday = $row['birthday'];
                                $sex = $row['sex'];
                            } else {
                                echo "<p>No customer found.</p>";
                            }
                        } else {
                            echo "<p>Invalid customer ID.</p>";
                        }

                        $conn->close();
                        ?>

                        <div class="profile-picture-wrapper">
                            <img id="profilePicture" src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture" style="width: 130px; height: 120px; border-radius: 10px;">
                        </div>

                        <form action="update_profile_process.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="customer_id" value="<?php echo isset($customer_id) ? $customer_id : ''; ?>">
                            <div class="row">
                                <!-- Left Column -->

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" name="first_name" style="background-color: transparent; color: white;" value="<?php echo isset($row['first_name']) ? $row['first_name'] : ''; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" name="last_name" style="background-color: transparent; color: white;" value="<?php echo isset($row['last_name']) ? $row['last_name'] : ''; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="age">Age:</label>
                                        <input type="number" name="age" style="background-color: transparent; color: white;" value="<?php echo $age; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday">Birthday:</label>
                                        <input type="date" style="background-color: transparent; color: white;" name="birthday" value="<?php echo $birthday; ?>" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sex">Sex:</label>
                                        <select name="sex" style="background-color: transparent; color: white;" class="form-control">
                                            <option value="Male" <?php echo $sex == 'Male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo $sex == 'Female' ? 'selected' : ''; ?>>Female</option>
                                            <option value="Other" <?php echo $sex == 'Other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_no">Contact Number:</label>
                                        <input type="text" style="background-color: transparent; color: white;" name="contact_no" value="<?php echo $contact_no; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" style="background-color: transparent; color: white;" name="address" value="<?php echo $address; ?>" class="form-control">
                                    </div>
                                </div>


                                <!-- Right Column -->
                                <div class="col-md-4">       
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" style="background-color: transparent; color: white;" name="email" value="<?php echo $email; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" style="background-color: transparent; color: white;" name="password" class="form-control">
                                        <small>Leave blank to keep the current password.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password:</label>
                                        <input type="password" style="background-color: transparent; color: white;" name="confirm_password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="profile">Profile Picture:</label>
                                        <input type="file" id="profileInput" name="profile" class="form-control-file" onchange="uploadProfilePicture()">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="profile?id=<?php echo isset($customer_id) ? $customer_id : ''; ?>" class="btn btn-warning"> <i class="fas fa-arrow-left"></i> Back</a>
                                &nbsp;
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
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


<script>
function uploadProfilePicture() {
    const profileInput = document.getElementById('profileInput').files[0];
    const profilePicture = document.getElementById('profilePicture');
    const formData = new FormData();
    formData.append('profile', profileInput);

    fetch('update_profile_picture.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the profile picture preview
            profilePicture.src = data.filepath + '?' + new Date().getTime(); // Append timestamp to prevent caching
            alert('Profile picture updated successfully!');
        } else {
            alert(data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

</body>
</html>

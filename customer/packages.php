<?php
session_start();

include('../connection.php');
require_once '../config.php';
require_once '../vendor/autoload.php';

// Authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['access_token'])) {
        $client->setAccessToken($token['access_token']);

        // Get profile info
        $google_oauth = new \Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $userinfo = [
            'email' => $google_account_info['email'],
            'first_name' => $google_account_info['givenName'],
            'last_name' => $google_account_info['familyName'],
            'sex' => $google_account_info['gender'],
            'token' => $google_account_info['id'],
        ];

        // Check if Google account already exists in the database
        $sql = "SELECT * FROM customers WHERE token = '{$userinfo['token']}'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            // Existing user
            $userinfo = mysqli_fetch_assoc($result);
            $_SESSION['token'] = $userinfo['token']; // Use token for Google SSO users
            $_SESSION['customer_id'] = $userinfo['customer_id'];
            $_SESSION['account_type'] = $userinfo['account_type']; // Set account type
        } else {
            // New user, insert into the database
            $sql = "INSERT INTO customers (first_name, last_name, sex, email, account_type, token) 
                    VALUES ('{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['sex']}', '{$userinfo['email']}', 2, '{$userinfo['token']}')";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Error creating account: " . mysqli_error($conn));
            }

            // Retrieve the customer ID of the newly inserted user
            $stmt = $conn->prepare("SELECT customer_id, account_type FROM customers WHERE token = ?");
            $stmt->bind_param("s", $userinfo['token']);
            $stmt->execute();
            $stmt->bind_result($customer_id, $account_type);
            $stmt->fetch();
            $_SESSION['token'] = $userinfo['token']; // Use token for Google SSO users
            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['account_type'] = $account_type; // Set account type
            $stmt->close();

            echo "<script>alert('Account Successfully Created!');</script>";
        }

        // Redirect after login or account creation
        header("Location: packages"); // Redirect to your main page
        exit();
    } else {
        echo "Authentication failed. Please try again.";
        die();
    }
} else {
    // Check if user is already logged in using other methods
    if (isset($_SESSION['customer_id'])) {
        $sql = "SELECT * FROM customers WHERE customer_id = '{$_SESSION['customer_id']}'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $userinfo = mysqli_fetch_assoc($result);
            $_SESSION['account_type'] = $userinfo['account_type'];
        }
    }
}

// Redirect if account_type is not set to 2
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php"); // Redirect to login page if not allowed
    exit();
}

// Fetch packages data with needed items from the database
$query = "SELECT p.package_id, p.package_name, p.price, pp.product_id, pr.product_name 
          FROM packages p 
          LEFT JOIN package_products pp ON p.package_id = pp.package_id 
          LEFT JOIN products pr ON pp.product_id = pr.product_id"; 
$result = $conn->query($query);

$packages = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $package_name = $row['package_name'];
        // Create a new package entry if it doesn't exist
        if (!isset($packages[$package_name])) {
            $packages[$package_name] = [
                'id' => $row['package_id'], // Store package ID for editing
                'price' => '₱' . number_format($row['price'], 2), // Format the price as currency
                'needed_items' => [] // Initialize needed items
            ];
        }
        // Add the product name to the needed items array
        if ($row['product_name']) {
            $packages[$package_name]['needed_items'][] = $row['product_name'];
        }
    }
} else {
    $packages = []; // No packages found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Packages</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <!-- Style CSS -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #17153B;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
            margin: 0;
            padding: 0;
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

        .card-body {
            display: flex;
            flex-wrap: wrap; /* Allow cards to wrap to the next line if needed */
            justify-content: space-evenly; /* Evenly space the cards */
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 400px;
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
                <div class="col-12">
                    <div class="search-container d-flex justify-content-center">
                        <input type="text" id="search-input" placeholder="Search packages..." onkeyup="filterPackages()">
                    </div>
                    <div class="card mb-4" style="box-shadow: none; background: transparent;">
                        <div class="card-body" id="package-list">
                            <?php include('./cards/package_ajax.php'); ?>
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

<script>
    function filterPackages() {
        const input = document.getElementById('search-input');
        const filter = input.value.toLowerCase();
        const packageList = document.getElementById('package-list');
        const cards = packageList.getElementsByClassName('pcard');

        for (let i = 0; i < cards.length; i++) {
            const packageName = cards[i].querySelector('.title').textContent.toLowerCase();
            if (packageName.includes(filter)) {
                cards[i].style.display = '';
            } else {
                cards[i].style.display = 'none';
            }
        }
    }
</script>

</body>
</html>

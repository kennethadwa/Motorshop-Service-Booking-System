<?php

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register");
    exit();
}

$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
$lastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available';

// Connect to the database
$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->close();
?>

<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="./images/ion/bussiness-man.png"/>
                    <div class="header-info ms-3">
                        <span class="font-w600">Hi, <b><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></b></span>
                        <small class="text-end font-w400"><?php echo htmlspecialchars($email); ?></small>
                    </div>
                </a>
            </li>
            
            <li><a href="index.php" aria-expanded="false">
                <i class="flaticon-025-dashboard"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            </li>

            <li><a href="schedule" aria-expanded="false">
                <i class="fa-regular fa-calendar-days"></i>
                <span class="nav-text">Schedule</span>
            </a>
            </li>

            <li><a href="bookings" aria-expanded="false">
                <i class="fa-regular fa-envelope"></i>
                <span class="nav-text">Booking Requests</span>
            </a>
            </li>

            <li><a href="inventory" aria-expanded="false">
                <i class="fa-solid fa-truck-ramp-box"></i>
                <span class="nav-text">Inventory</span>
            </a>
            </li>

            <li><a href="transaction" aria-expanded="false">
                <i class="fa-solid fa-dollar-sign"></i>
                <span class="nav-text">Transaction History</span>
            </a>
            </li>

            <li><a href="user-information" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">User Information</span>
            </a>
            </li>

            <li><a href="manage-account" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">Manage Account</span>
            </a>
            </li>
            
            <li><a href="logout" class="ai-icon" aria-expanded="false">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="nav-text">Logout</span>
            </a></li>
        </ul>
    </div>
</div>

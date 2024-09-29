<?php

$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
$lastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available';
?>

<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="images/ion/man (1).png" width="20" alt=""/>
                    <div class="header-info ms-3">
                        <span class="font-w600">Hi, <b><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></b></span>
                        <small class="text-end font-w400"><?php echo htmlspecialchars($email); ?></small>
                    </div>
                </a>
            </li>
            <li><a href="index.php" aria-expanded="false">
                <i class="flaticon-025-dashboard"></i>
                <span class="nav-text">Dashboard</span>
            </a></li>
            <li><a href="employees.php" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">Employees</span>
            </a></li>
            <li><a href="customers.php" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">Customers</span>
            </a></li>
            <li><a href="schedule.php" aria-expanded="false">
                <i class="fa-regular fa-calendar-days"></i>
                <span class="nav-text">Schedule</span>
            </a></li>
            <li><a href="bookings.php" aria-expanded="false">
                <i class="fa-solid fa-handshake"></i>
                <span class="nav-text">Booking Requests</span>
            </a></li>
            <li><a href="logout.php" class="ai-icon" aria-expanded="false">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="nav-text">Logout</span>
            </a></li>
        </ul>
    </div>
</div>

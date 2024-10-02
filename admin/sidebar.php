<?php
session_start();

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
$lastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available';
$admin_id = $_SESSION['admin_id']; // Assuming you store the admin ID in the session

// Connect to the database
$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the profile image from the admin table
$sql = "SELECT profile FROM admin WHERE admin_id = '$admin_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_image = !empty($row['profile']) ? $row['profile'] : 'images/ion/man (1).png'; // Default image if none exists
} else {
    $profile_image = 'images/ion/man (1).png'; // Default image if no record is found
}

$conn->close();
?>

<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="<?php echo htmlspecialchars($profile_image); ?>" width="20" alt="Profile Image"/>
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
            <li><a href="user-information.php" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">User Information</span>
            </a></li>
            <li><a href="manage-account.php" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">Manage Account</span>
            </a></li>
            <li><a href="schedule.php" aria-expanded="false">
                <i class="fa-regular fa-calendar-days"></i>
                <span class="nav-text">Schedule</span>
            </a></li>
            <li><a href="parts-inventory.php" aria-expanded="false">
                <i class="fa-regular fa-calendar-days"></i>
                <span class="nav-text">Parts Inventory</span>
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

<?php
// Start session
session_start();

// Check if account type is admin (0), redirect to login if not
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "sairom_service");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set default values for session variables
$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
$lastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available';

$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null; 
$employee_id = isset($_SESSION['employee_id']) ? $_SESSION['employee_id'] : null;
$customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : null;

// Variables to store profile info
$full_name = 'Guest';
$profile_picture = 'path/to/default/profile/picture.jpg'; // Default profile picture

// Fetch Admin Data for the logged-in admin
if ($admin_id) {
    $admin_query = "SELECT admin_id, first_name, last_name, profile 
                    FROM admin 
                    WHERE admin_id = ?";

    $stmt = $conn->prepare($admin_query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $admin_result = $stmt->get_result();

    if ($row = $admin_result->fetch_assoc()) { 
        $full_name = $row['first_name'] . ' ' . $row['last_name'];
        $profile_picture = $row['profile'] ? $row['profile'] : $profile_picture;
    }
} elseif ($employee_id) {
    // Fetch Employee Data
    $employee_query = "SELECT employee_id, first_name, last_name, profile 
                       FROM employees 
                       WHERE employee_id = ?";

    $stmt = $conn->prepare($employee_query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $employee_result = $stmt->get_result();

    if ($row = $employee_result->fetch_assoc()) {
        $full_name = $row['first_name'] . ' ' . $row['last_name'];
        $profile_picture = $row['profile'] ? $row['profile'] : $profile_picture;
    }
} elseif ($customer_id) {
    // Fetch Customer Data
    $customer_query = "SELECT customer_id, first_name, last_name, profile 
                       FROM customers 
                       WHERE customer_id = ?";

    $stmt = $conn->prepare($customer_query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $customer_result = $stmt->get_result();

    if ($row = $customer_result->fetch_assoc()) {
        $full_name = $row['first_name'] . ' ' . $row['last_name'];
        $profile_picture = $row['profile'] ? $row['profile'] : $profile_picture;
    }
}
?>

<style>
    .my-profile {
        width: 100%;
        height: auto;
        padding: 10px 0 0 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profileBtn {
        width: auto;
        height: auto;
        padding: 5px;
        border: 1px solid transparent;
        background-color: #E85C0D;
        color: white;
        transition: 0.5s ease-in;
    }

    .profileBtn:hover {
        background: #FF6500;
        color: white;
    }

    .profile-picture {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>

<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
                    <div class="header-info ms-3">
                        <span class="font-w600">Hi, <b><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></b></span>
                        <small class="text-end font-w400"><?php echo htmlspecialchars($email); ?></small>
                    </div>
                </a>

                <div class="my-profile">
                    <a class="profileBtn" style="color: white;" href="profile?id=<?php echo $admin_id ? $admin_id : ($employee_id ? $employee_id : $customer_id); ?>">View Profile</a>
                </div>
            </li>
            
            <li><a href="index.php" aria-expanded="false">
                <i class="flaticon-025-dashboard"></i>
                <span class="nav-text">Dashboard</span>
            </a></li>

            <li><a href="schedule" aria-expanded="false">
                <i class="fa-regular fa-calendar-days"></i>
                <span class="nav-text">Schedule</span>
            </a></li>

            <li><a href="bookings" aria-expanded="false">
                <i class="fa-regular fa-envelope"></i>
                <span class="nav-text">Booking Requests</span>
            </a></li>

            <li><a href="inventory" aria-expanded="false">
                <i class="fa-solid fa-truck-ramp-box"></i>
                <span class="nav-text">Inventory</span>
            </a></li>

            <li><a href="transaction" aria-expanded="false">
                <i class="fa-solid fa-dollar-sign"></i>
                <span class="nav-text">Transaction History</span>
            </a></li>

            <li><a href="user-information" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">User Information</span>
            </a></li>

            <li><a href="manage-account" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <span class="nav-text">Manage Account</span>
            </a></li>
            
            <li><a href="logout" class="ai-icon" aria-expanded="false">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="nav-text">Logout</span>
            </a></li>
        </ul>
    </div>
</div>

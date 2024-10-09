<?php

include('../connection.php');

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 1) {
    header("Location: ../login-register");
    exit();
}

$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
$lastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Employee Data
$employee_query = "SELECT employee_id, first_name, last_name, contact_no, address, account_type, profile, age, birthday, sex FROM employees";
$employee_result = mysqli_query($conn, $employee_query);

while ($row = mysqli_fetch_assoc($employee_result)) { 
                $employee_id = $row['employee_id'];
                $full_name = $row['first_name'] . ' ' . $row['last_name'];
                $profile_picture = $row['profile'] ? $row['profile'] : 'path/to/default/profile/picture.jpg'; 
}

?>

<style>
    .my-profile{
        width: 100%;
        height: auto;
        padding: 10px 0 0 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profileBtn{
        width: auto;
        height: auto;
        padding: 5px;
        border: 1px solid transparent;
        background-color: #E85C0D;;
        color: white;
        transition: 0.5s ease-in;
    }

    .profileBtn:hover{
        background:  #FF6500;
        color: white;
    }
</style>

<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="view_employee.php?id=<?php echo $employee_id; ?>" role="button" data-bs-toggle="dropdown">
                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
                    <div class="header-info ms-3">
                        <span class="font-w600">Hi, <b><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></b></span>
                        <small class="text-end font-w400"><?php echo htmlspecialchars($email); ?></small>
                    </div>
                </a>

                <div class="my-profile">
                    <a class="profileBtn" style="color: white;" href="profile?id=<?php echo $employee_id; ?>">View Profile</a>
                </div>

            </li>
            
            <li><a href="index.php" aria-expanded="false">
                <i class="flaticon-025-dashboard"></i>
                <span class="nav-text">Home</span>
            </a>
            </li>

            <li><a href="schedule" aria-expanded="false">
                <i class="fa-regular fa-calendar-days"></i>
                <span class="nav-text">My Schedule</span>
            </a>
            </li>

            <li><a href="bookings" aria-expanded="false">
                <i class="fa-solid fa-dollar-sign"></i>
                <span class="nav-text">Booking History</span>
            </a>
            </li>
            
            <li><a href="logout" class="ai-icon" aria-expanded="false">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="nav-text">Logout</span>
            </a></li>
        </ul>
    </div>
</div>

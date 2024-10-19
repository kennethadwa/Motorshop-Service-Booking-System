<?php

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register");
    exit();
}

$conn = new mysqli("localhost", "root", "", "sairom_service");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';
$lastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$emails = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available';

$c_admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null; 
$c_employee_id = isset($_SESSION['employee_id']) ? $_SESSION['employee_id'] : null;
$c_customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : null;


$full_name = 'Guest';
$prof_pictures = 'path/to/default/profile/picture.jpg'; 


if ($c_customer_id) {
    // Fetch Customer Data
    $customer_queries = "SELECT customer_id, first_name, last_name, profile 
                       FROM customers 
                       WHERE customer_id = ?";

    $stmt = $conn->prepare($customer_queries);
    $stmt->bind_param("i", $c_customer_id);
    $stmt->execute();
    $customer_results = $stmt->get_result();

    if ($rows= $customer_results->fetch_assoc()) {
        $full_name = $rows['first_name'] . ' ' . $rows['last_name'];
        $prof_pictures = $rows['profile'] ? $rows['profile'] : $prof_pictures;
    }
}
?>

<style>
    body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    .my-profile {
        width: 100%;
        height: auto;
        padding: 0 0 10px 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profileBtn {
        width: auto;
        height: auto;
        padding: 5px;
        border-radius: 5px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border: 1px solid transparent;
        background-color: #FF3EA5;
        color: white;
        transition: 0.3s ease-in;
    }

    .profileBtn:hover {
        background: #FF3FF9;
        color: white;
    }

    .profile-picture {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .drp_btn{
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .dlabnav{
        background-color: #180161;
        box-shadow: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .nav-text{
        color: white;
    }

    .nav-text:hover{
        color: white;
    }

    .nav-text:active{
        color: white;
    }

    i{
        color: white;
    }

    i:active{
        color: white;
    }

    .nav-link{
        border: none;
    }
    .nav9link img{
        box-shadow: none;
    }

    .hamburger{
        color: white;
    }

    .header-profile{
        background-color: #2E236C;
        margin: 0;
    }

    .header-profile .nav-link{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .header-profile .nav-link img{
        width: 80px;
        height: 80px;
    }

    .header-profile .nav-link .header-info{
        width: auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .header-profile .nav-link .prof{
       display: flex;
       justify-content: center;
       align-items: center;
    }
</style>

<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="header-profile">
                <a class="nav-link" href="javascript:void(0);" style="border: none;">
                    <div class="prof">
                        <img src="<?php echo $prof_pictures; ?>" alt="Profile Picture" class="profile-picture" style="border: none; box-shadow: none; object-fit: cover;">
                    </div>
                    
                    <div class="header-info ms-3">
                        <span class="font-w600" style="color: white; font-size: 1.2rem;">Hi, <b><?php echo htmlspecialchars($firstName); ?></b></span>
                        <p class="text-end font-w400" style="color: white; font-size: 0.9rem;"><?php echo htmlspecialchars($emails); ?></p>
                    </div>
                </a>
                <div class="my-profile">
                    <a class="profileBtn" style="color: white;" href="profile?id=<?php echo $c_customer_id ? $c_customer_id : ($c_customer_id ? $c_customer_id : $c_customer_id); ?>">View Profile</a>
                </div>
            </li>

            <li><a href="index" aria-expanded="false">
                <i class="flaticon-025-dashboard"></i>
                <span class="nav-text">Home</span>
            </a></li>

            <li><a href="packages" aria-expanded="false">
                <i class="fa-regular fa-calendar-days"></i>
                <span class="nav-text">Packages</span>
            </a></li>

            <li><a href="request_booking" aria-expanded="false">
                <i class="fa-solid fa-dollar-sign"></i>
                <span class="nav-text">Book a Service</span>
            </a></li>

            <li><a href="booking_history" aria-expanded="false">
                <i class="fa-solid fa-dollar-sign"></i>
                <span class="nav-text">Booking History</span>
            </a></li>

            <li><a href="transaction" aria-expanded="false">
                <i class="fa-solid fa-dollar-sign"></i>
                <span class="nav-text">Transaction History</span>
            </a></li>
        </ul>
    </div>
</div>

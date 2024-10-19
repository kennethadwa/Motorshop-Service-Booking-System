<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking History</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #17153B;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
            margin: 0;
            padding: 0;
        }
        .tab-content {
            color: white;
        }
        .table {
            background: transparent;
        }
        th, td {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

<!-- Main wrapper Start -->
<div id="main-wrapper">
    <?php include('nav-header.php'); ?>
    <?php include('header.php'); ?>
    <?php include('sidebar.php'); ?>

    <!-- Content Body Start -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4" style="box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
                        <div class="card-body">
                            <h4 class="mt-4" style="color: white;">Your Booking Requests</h4>

                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs" id="bookingTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-status="pending" href="#" style="background: transparent; color: pink; font-weight: 600; ">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="approved" href="#" style="background: transparent; color: pink; font-weight: 600; ">Approved</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="paid" href="#" style="background: transparent; color: pink; font-weight: 600; ">Paid</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="in progress" href="#" style="background: transparent; color: pink; font-weight: 600; ">In Progress</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="completed" href="#" style="background: transparent; color: pink; font-weight: 600; ">Completed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-status="rejected" href="#" style="background: transparent; color: pink; font-weight: 600; ">Rejected</a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content mt-3">
                                <div id="bookingTableContent" class="table-responsive"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Body End -->
</div>
<!-- Main wrapper End -->

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
document.addEventListener('DOMContentLoaded', function() {
    loadTabData('pending'); // Load default tab content

    // Handle tab switching
    document.querySelectorAll('#bookingTabs .nav-link').forEach(function(tab) {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelector('#bookingTabs .nav-link.active').classList.remove('active');
            tab.classList.add('active');
            const status = tab.getAttribute('data-status');
            loadTabData(status);
        });
    });
});

function loadTabData(status) {
    const bookingTable = document.getElementById('bookingTableContent');

    // Use AJAX to load booking data without reloading
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `load_bookings.php?status=${status}`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            bookingTable.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>

<script>
let currentPage = 1; // Initialize current page

document.addEventListener('DOMContentLoaded', function() {
    loadTabData('pending', currentPage); // Load default tab content

    // Handle tab switching
    document.querySelectorAll('#bookingTabs .nav-link').forEach(function(tab) {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            document.querySelector('#bookingTabs .nav-link.active').classList.remove('active');
            tab.classList.add('active');
            const status = tab.getAttribute('data-status');
            currentPage = 1; // Reset to first page on status change
            loadTabData(status, currentPage);
        });
    });
});

// Load booking data with status and page number
function loadTabData(status, page) {
    const bookingTable = document.getElementById('bookingTableContent');

    // Use AJAX to load booking data without reloading
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `load_bookings.php?status=${status}&page=${page}`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            bookingTable.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Function to handle pagination click
function changePage(status, page) {
    currentPage = page; // Update current page
    loadTabData(status, currentPage); // Load new data
}
</script>

</body>
</html>

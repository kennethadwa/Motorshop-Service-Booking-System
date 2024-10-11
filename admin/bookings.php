<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php');

// Function to fetch data based on the status
function fetchBookings($status, $limit, $offset, $conn) {
    $requestSql = "SELECT br.request_id, 
                          CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
                          br.model_name AS vehicle_model, 
                          br.address, 
                          br.status
                   FROM booking_request br
                   JOIN customers c ON br.customer_id = c.customer_id
                   WHERE br.status = '$status'
                   LIMIT $limit OFFSET $offset";
    $requests = $conn->query($requestSql);
    return $requests;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bookings</title>
	<link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<link href="css/style.css" rel="stylesheet">
    <style>
		body {
			background-color: #17153B;
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

        table {
    border-collapse: collapse; 
    width: 100%;
}

th, td {
    text-align: center;
    padding: 10px;
    border: none; 
}

tr {
    border-bottom: 1px solid #ddd; 
}

th {
    background-color: #f2f2f2;
    border-bottom: 2px solid #ddd; 
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
	            <div class="col-12" style="box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753); border-radius: 20px; padding: 20px;">
	                <ul class="nav nav-tabs" id="bookingTabs">
	                    <li class="nav-item">
	                        <a class="nav-link active" data-status="pending" style="background: transparent; color: pink; font-weight: 600; " href="#">Pending</a>
	                    </li>
	                    <li class="nav-item">
	                        <a class="nav-link" data-status="approved" style="background: transparent; color: pink; font-weight: 600; " href="#">Approved</a>
	                    </li>
	                    <li class="nav-item">
	                        <a class="nav-link" data-status="completed" style="background: transparent; color: pink; font-weight: 600; " href="#">Completed</a>
	                    </li>
	                    <li class="nav-item">
	                        <a class="nav-link" data-status="rejected" style="background: transparent; color: pink; font-weight: 600; " href="#">Rejected</a>
	                    </li>
	                </ul>

	                <div class="tab-content mt-3">
	                    <div id="bookingTableContent" class="table-responsive"></div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- Content Body End -->
</div>
<!-- Main wrapper End -->

<!-- Scripts -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>

<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>

<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>
<script src="vendor/global/global.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>

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
</body>
</html>


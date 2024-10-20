<?php
session_start();
include('../connection.php');

$status = isset($_GET['status']) ? $_GET['status'] : 'pending';

if (!isset($_SESSION['customer_id'])) {
    echo '<p class="text-danger">You need to log in to view bookings.</p>';
    exit;
}

$customerId = $_SESSION['customer_id'];
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;

$totalSql = "SELECT COUNT(*) as total FROM booking_request WHERE status = '$status' AND customer_id = '$customerId'";
$totalResult = $conn->query($totalSql);
$totalBookings = $totalResult->fetch_assoc()['total'];

$requestSql = "SELECT br.request_id, 
                      CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
                      br.model_name AS vehicle_model, 
                      br.address, 
                      br.request_date,
                      br.status
               FROM booking_request br
               JOIN customers c ON br.customer_id = c.customer_id
               WHERE br.status = '$status' AND br.customer_id = '$customerId'
               ORDER BY br.request_date DESC
               LIMIT $limit OFFSET $offset";
$requests = $conn->query($requestSql);

function getStatusColor($status) {
    switch ($status) {
        case 'pending':
            return 'orange';
        case 'approved':
            return 'green';
        case 'paid':
            return 'lightgreen';
        case 'in progress':
            return 'lightblue';
        case 'completed':
            return '#39FF14';
        case 'rejected':
            return 'red';
        default:
            return '';
    }
}

if ($requests->num_rows > 0) {
    while ($row = $requests->fetch_assoc()) {
        $statusColor = getStatusColor($row['status']);
        
        echo '<div class="card" style="width: 300px; background-color: #2C2A4A; color: white; padding: 15px; margin-bottom: 15px; box-shadow: 2px 2px 5px rgba(0,0,0,0.3); border-radius: 10px;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title" style="color: orange;">Request No. ' . $row['request_id'] . '</h5>';
        echo '<p class="card-text">Customer: ' . $row['customer_name'] . '</p>';
        echo '<p class="card-text">Model: ' . $row['vehicle_model'] . '</p>';
        echo '<p class="card-text">Address: ' . $row['address'] . '</p>';
        echo '<p class="card-text">Date: ' . $row['request_date'] . '</p>';
        echo 'Status:<p class="card-text" style="color: ' . $statusColor . '; font-weight: bold;"> ' . ucfirst($row['status']) . '</p>';
        if ($row['status'] == 'approved') {
            echo '<a href="view_approved_booking.php?request_id=' . $row['request_id'] . '" class="btn btn-primary" style="background-color: #FF3FF9;">View</a>';
        } else {
            echo '<a href="view_booking.php?request_id=' . $row['request_id'] . '" class="btn btn-primary" style="background-color: #FF3FF9;">View</a>';
        }
        echo '</div></div>';
    }
} else {
    echo '<p class="text-center text-white">No Booking Requests Available</p>';
}

// Pagination
$totalPages = ceil($totalBookings / $limit);
if ($totalPages > 1) {
    echo '<nav><ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $i == $page ? 'active' : '';
        echo '<li class="page-item ' . $active . '"><a class="page-link" href="#" onclick="changePage(\'' . $status . '\', ' . $i . ')">' . $i . '</a></li>';
    }
    echo '</ul></nav>';
}
?>

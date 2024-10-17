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

// Ensure the page is at least 1
$page = max(1, $page);
$offset = ($page - 1) * $limit;

// Update the total bookings query to reflect the selected status
$totalSql = "SELECT COUNT(*) as total FROM booking_request WHERE status = '$status' AND customer_id = '$customerId'";
$totalResult = $conn->query($totalSql);
$totalBookings = $totalResult->fetch_assoc()['total'];

// Update the request SQL to fetch bookings based on the selected status
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

// Function to get text color based on status
function getStatusColor($status) {
    switch ($status) {
        case 'pending':
            return 'orange';
        case 'approved':
            return 'green';
        case 'paid': 
            return 'lightgreen'; 
        case 'progress':
            return 'lightblue';
        case 'completed':
            return '#39FF14'; 
        case 'rejected':
            return 'red';
        default:
            return ''; 
    }
}

// Display the table content
echo '<table class="table table-bordered table-striped">';
echo '<thead style="background: transparent;">';
echo '<tr style="background: transparent; font-weight: bold; color: white;">';
echo '<th>Request ID</th>';
echo '<th>Customer Name</th>';
echo '<th>Motorcycle Model</th>';
echo '<th>Address</th>';
echo '<th>Request Date</th>';
echo '<th>Status</th>';
echo '<th>View Details</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($requests->num_rows > 0) {
    while ($row = $requests->fetch_assoc()) {
        echo '<tr style="background: transparent;">';
        echo '<td>' . $row['request_id'] . '</td>';
        echo '<td>' . $row['customer_name'] . '</td>';
        echo '<td>' . $row['vehicle_model'] . '</td>';
        echo '<td>' . $row['address'] . '</td>';
        echo '<td>' . $row['request_date'] . '</td>';
        
        $statusColor = getStatusColor($row['status']);
        echo '<td style="color: ' . $statusColor . '; font-weight: bold;">' . ucfirst($row['status']) . '</td>';
        
        if ($row['status'] == 'approved') {
            echo '<td><a href="view_approved_booking?request_id=' . $row['request_id'] . '" class="btn" style="box-shadow: none; background: #FF3FF9; color: white;">View</a></td>';
        } else {
            echo '<td><a href="view_booking?request_id=' . $row['request_id'] . '" class="btn" style="box-shadow: none; background: #FF3FF9; color: white;">View</a></td>';
        }
        
        echo '</tr>';
    }
} else {
    echo '<tr style="background: transparent;">';
    echo '<td colspan="7" class="text-center">No Booking Requests Available</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

// Pagination Logic
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

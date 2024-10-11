<?php
include('../connection.php');

$status = isset($_GET['status']) ? $_GET['status'] : 'pending';
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalSql = "SELECT COUNT(*) as total FROM booking_request WHERE status = '$status'";
$totalResult = $conn->query($totalSql);
$totalBookings = $totalResult->fetch_assoc()['total'];

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

// Display the table content
echo '<table class="table table-bordered table-striped">';
echo '<thead>';
echo '<tr style="color: white;">';
echo '<th>Request ID</th>';
echo '<th>Customer Name</th>';
echo '<th>Vehicle Model</th>';
echo '<th>Booking Address</th>';
echo '<th>Status</th>';
echo '<th>View Details</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($requests->num_rows > 0) {
    while ($row = $requests->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['request_id'] . '</td>';
        echo '<td>' . $row['customer_name'] . '</td>';
        echo '<td>' . $row['vehicle_model'] . '</td>';
        echo '<td>' . $row['address'] . '</td>';
        echo '<td>' . ucfirst($row['status']) . '</td>';
        echo '<td class="text-center"><a href="view_details.php?request_id=' . $row['request_id'] . '" class="btn btn-primary" style="background: #FF3EA5; box-shadow: 2px 2px 5px #DA0C81; border-radius: 5px; color: white;"><i class="fas fa-eye"></i> View</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr style="background-color: transparent;">';
    echo '<td colspan="6" class="text-center" style="color: white;">No Booking Requests Available</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
?>

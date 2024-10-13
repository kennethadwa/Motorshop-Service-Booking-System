<?php
include('../connection.php');

$status = isset($_GET['status']) ? $_GET['status'] : 'pending';
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total bookings
$totalSql = "SELECT COUNT(*) as total FROM booking_request WHERE status = '$status'";
$totalResult = $conn->query($totalSql);
$totalBookings = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalBookings / $limit);

// Fetch bookings
$requestSql = "SELECT br.request_id, 
                      CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
                      br.model_name AS vehicle_model, 
                      br.status
               FROM booking_request br
               JOIN customers c ON br.customer_id = c.customer_id
               WHERE br.status = '$status'
               LIMIT $limit OFFSET $offset";
$requests = $conn->query($requestSql);

// Display the table content
echo '<table class="table table-bordered table-striped">';
echo '<thead>';
echo '<tr style="color: white; font-weight: bold;">';
echo '<th>Customer Name</th>';
echo '<th>Vehicle Model</th>';
echo '<th>Status</th>';
echo '<th>View Details</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($requests->num_rows > 0) {
    while ($row = $requests->fetch_assoc()) {
        echo '<tr style="background: transparent; color: white;">';
        echo '<td style="background: transparent; color: white;">' . $row['customer_name'] . '</td>';
        echo '<td style="background: transparent; color: white;">' . $row['vehicle_model'] . '</td>';
        echo '<td style="background: transparent; color: white;">' . ucfirst($row['status']) . '</td>';
        echo '<td class="text-center"><a href="view_details.php?request_id=' . $row['request_id'] . '" class="btn btn-primary" style="background: #FF3EA5; box-shadow: 1px 1px 10px rgba(255, 255, 255, 0.39); border-radius: 5px; border:none; color: white;"><i class="fas fa-eye"></i> View</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr style="background-color: transparent;">';
    echo '<td colspan="4" class="text-center" style="color: white;">No Booking Requests Available</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

// Display pagination controls
echo '<div class="pagination" style="text-align:center; margin-top:20px; display: flex; justify-content: center; align-items:center;">';

// Page Number Links
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $page) {
        echo '<span class="btn btn-light" style="margin: 0 5px; color: pink; font-weight: bold;">' . $i . '</span>'; // Current page
    } else {
        echo '<a href="#" class="btn btn-secondary" onclick="loadTabData(\'' . $status . '\', ' . $i . '); return false;" style="margin: 0 5px;">' . $i . '</a>';
    }
}
echo '</div>';
?>

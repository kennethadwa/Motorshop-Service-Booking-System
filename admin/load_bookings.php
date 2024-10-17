<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 0) {
    header("Location: ../login-register.php");
    exit();
}

// Include the database connection
include('../connection.php');

// Set the valid statuses
$validStatuses = ['pending', 'approved', 'in progress', 'completed', 'rejected', 'paid'];

// Get the status and validate it
$status = isset($_GET['status']) && in_array($_GET['status'], $validStatuses) ? $_GET['status'] : 'pending';
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total bookings
$totalSql = "SELECT COUNT(*) as total FROM booking_request WHERE status = ?";
$totalStmt = $conn->prepare($totalSql);
$totalStmt->bind_param('s', $status);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalBookings = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalBookings / $limit);

// Fetch bookings in descending order by date_requested
$requestSql = "SELECT br.request_id, 
                      CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
                      br.model_name AS vehicle_model, 
                      br.status,
                      br.date_requested,
                      br.package_id,
                      br.viewed
               FROM booking_request br
               JOIN customers c ON br.customer_id = c.customer_id
               WHERE br.status = ?
               ORDER BY br.date_requested DESC
               LIMIT ? OFFSET ?";
$requestStmt = $conn->prepare($requestSql);
$requestStmt->bind_param('sii', $status, $limit, $offset);
$requestStmt->execute();
$requests = $requestStmt->get_result();

// Display the table content
echo '<table class="table table-bordered table-striped">';
echo '<thead>';
echo '<tr style="color: white; font-weight: bold;">';
echo '<th>Customer Name</th>';
echo '<th>Vehicle Model</th>';
echo '<th>Status</th>';
echo '<th>Date Requested</th>'; 
echo '<th>View Details</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($requests->num_rows > 0) {
    while ($row = $requests->fetch_assoc()) {
        // Set color based on status
        $statusColor = '';
        switch($row['status']) {
            case 'pending':
                $statusColor = 'orange';
                break;
            case 'approved':
                $statusColor = 'green';
                break;
            case 'in progress':
                $statusColor = 'lightblue';
                break;
            case 'completed':
                $statusColor = 'yellowgreen';
                break;
            case 'rejected':
                $statusColor = 'red';
                break;
            case 'paid':
                $statusColor = 'lightgreen'; 
                break;
            default:
                $statusColor = 'white'; 
                break;
        }

        echo '<tr style="background: transparent; color: white;">';
        echo '<td style="background: transparent; color: white;">' . $row['customer_name'] . '</td>';
        echo '<td style="background: transparent; color: white;">' . $row['vehicle_model'] . '</td>';
        echo '<td style="color: ' . $statusColor . '; font-weight: bold;">' . ucfirst($row['status']) . '</td>';
        echo '<td style="background: transparent; color: white;">' . $row['date_requested'];

        // Add "(New)" label for unviewed requests
        if ($row['viewed'] == 0) {
            echo ' <span style="color: orange; font-weight: bold;">(New)</span>';
        }

        echo '</td>'; // Display Date Requested
        echo '<td class="text-center"><a href="view_details.php?request_id=' . $row['request_id'] . '" class="btn btn-primary" style="background: #4A249D; box-shadow: 2px 2px 5px black; border-radius: 5px; color: white; border: none;"><i class="fas fa-eye"></i> View</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr style="background-color: transparent;">';
    echo '<td colspan="5" class="text-center" style="color: white;">No Booking Requests Available</td>'; 
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
        echo '<a href="#" class="btn" onclick="loadTabData(\'' . $status . '\', ' . $i . '); return false;" style="margin: 0 5px; background: #060047; color: white;">' . $i . '</a>';
    }
}
echo '</div>';
?>

<style>
    .view{
    padding: 10px 15px; 
    color: white; 
    background-color: #180161; 
    border-radius: 10px;
    transition: 0.5s;
    }

    .view{
        background-color: #050C9C;
        color: white;
    }
</style>

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
                      c.email AS customer_email, 
                      c.contact_no AS customer_phone,
                      c.profile AS customer_profile_picture,
                      br.model_name AS vehicle_model, 
                      br.status,
                      br.date_requested,
                      br.package_id,
                      p.package_name,
                      br.viewed
               FROM booking_request br
               JOIN customers c ON br.customer_id = c.customer_id
               JOIN packages p ON br.package_id = p.package_id 
               WHERE br.status = ?
               ORDER BY br.date_requested DESC
               LIMIT ? OFFSET ?";
$requestStmt = $conn->prepare($requestSql);
$requestStmt->bind_param('sii', $status, $limit, $offset);
$requestStmt->execute();
$requests = $requestStmt->get_result();

if ($requests->num_rows > 0) {
    echo '<div class="d-flex flex-wrap">'; // Flex container for cards
    while ($row = $requests->fetch_assoc()) {
        echo '<div class="card m-2" style="width: 25rem;">';
        echo '<div class="card-header d-flex justify-content-between align-items-center">';
        echo '<img src="' . $row['customer_profile_picture'] . '" alt="Profile Picture" style="width: 130px; height: 100px; border-radius: 10px;">';
        echo'<a href="view_details.php?request_id=' . $row['request_id'] . '" class = "view">View Details</a>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<p class="card-text"><strong>Name:</strong> ' . $row['customer_name'] . '</p>';
        echo '<p class="card-text"><strong>Email:</strong> ' . $row['customer_email'] . '</p>';
        echo '<p class="card-text"><strong>Phone:</strong> ' . $row['customer_phone'] . '</p>';
        echo '<br>';
        echo '<p class="card-text"><strong>Motorcycle Model:</strong> ' . $row['vehicle_model'] . '</p>';
        echo '<p class="card-text"><strong>Date Requested:</strong> ' . $row['date_requested'] . '</p>';
        echo '<p class="card-text"><strong>Package No.</strong> ' . $row["package_id"] . ' (' . $row["package_name"] . ')</p>';

        echo '
           <br>
           <div style="display: flex; justify-content: center; align-items:center; flex-direction: column;">
               <p style="font-weight: 600;">Booking No. ' . $row["request_id"] . '</p>
           </div>
            ';

        echo '</div>';
        echo '</div>';
    }
    echo '</div>'; // End of flex container

    // Pagination controls
    echo '<div class="pagination">'; 
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="#" onclick="loadBookings(\'' . $status . '\', ' . $i . ')" class="pagination-link' . ($i === $page ? ' active' : '') . '">' . $i . '</a>';
    }
    echo '</div>';
} else {
    echo '<div class="card">No bookings found.</div>';
}
?>

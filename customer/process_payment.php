<?php
include('../connection.php');

// Update booking request to 'paid' after successful payment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestId = $_POST['request_id'];

    $updateSql = "UPDATE booking_request SET status = 'paid' WHERE request_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    
    echo "success";
}
?>

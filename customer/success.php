<?php
session_start();
include('../connection.php');

// Get request ID
$requestId = isset($_GET['request_id']) ? $_GET['request_id'] : 0;

// Fetch customer and package details for receipt
$sql = "SELECT c.first_name, c.last_name, p.package_name, br.request_date, br.request_time, p.price 
        FROM booking_request br 
        JOIN customers c ON br.customer_id = c.customer_id
        JOIN packages p ON br.package_id = p.package_id
        WHERE br.request_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $requestId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body>
    <h3>Payment Receipt</h3>
    <p>Customer: <?php echo $data['first_name'] . ' ' . $data['last_name']; ?></p>
    <p>Package: <?php echo $data['package_name']; ?></p>
    <p>Booking Date & Time: <?php echo $data['request_date'] . ' ' . $data['request_time']; ?></p>
    <p>Total Paid: ₱<?php echo $data['price'] / 2; ?></p>
    <p>Status: Paid</p>
</body>
</html>

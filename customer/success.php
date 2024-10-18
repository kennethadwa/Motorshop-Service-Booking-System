<?php
session_start();
include('../connection.php');

// Get request ID
$requestId = isset($_GET['request_id']) ? $_GET['request_id'] : 0;

// Fetch customer and package details for receipt
$sql = "SELECT c.first_name, c.last_name, c.contact_no, c.address, c.email, 
               p.package_id, p.package_name, p.duration, p.price, 
               br.request_date, br.request_time 
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .receipt-card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            width: 300px;
            margin: 20px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Courier New', Courier, monospace; /* Monospace font for receipt effect */
        }
        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
        }
        .receipt-footer {
            text-align: center;
            font-size: 0.9em;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="receipt-header">
            <h4>Payment Receipt</h4>
        </div>
        <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($data['first_name'] . ' ' . $data['last_name']); ?></p>
        <p><strong>Contact No:</strong> <?php echo htmlspecialchars($data['contact_no']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($data['address']); ?></p>
        <p><strong>Email Address:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
        <p><strong>Package No:</strong> <?php echo htmlspecialchars($data['package_id']); ?></p>
        <p><strong>Package Name:</strong> <?php echo htmlspecialchars($data['package_name']); ?></p>
        <p><strong>Duration:</strong> <?php echo htmlspecialchars($data['duration']); ?></p>
        <p><strong>Package Price:</strong> ₱<?php echo htmlspecialchars($data['price']); ?></p>
        <p><strong>Deposit Amount:</strong> ₱<?php echo htmlspecialchars($data['price'] / 2); ?></p>
        <p><strong>Status:</strong> Paid</p>
        <div class="receipt-footer">
            <p>Thank you for your purchase!</p>
            <p>*** Please keep this receipt for your records ***</p>
        </div>
    </div>
</body>
</html>

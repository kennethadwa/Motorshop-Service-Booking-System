<?php
session_start();

// Include the database connection
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve posted data
    $requestId = isset($_POST['request_id']) ? $_POST['request_id'] : 0;
    $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $transactionStatus = isset($_POST['transaction_status']) ? $_POST['transaction_status'] : 'pending'; // Default status

    // Fetch package price based on request_id
    $sql = "SELECT p.price FROM booking_request br 
            JOIN packages p ON br.package_id = p.package_id 
            WHERE br.request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    $packageData = $result->fetch_assoc();

    if ($packageData) {
        // Calculate deposit amount
        $depositAmount = $packageData['price'] / 2;

        // Prepare and bind the SQL statement for inserting the transaction
        $sql = "INSERT INTO transactions (request_id, deposit_amount, payment_method, transaction_status, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idss", $requestId, $depositAmount, $paymentMethod, $transactionStatus);

        if ($stmt->execute()) {
            // Successfully inserted
            echo json_encode(['success' => true, 'message' => 'Transaction saved successfully.']);
        } else {
            // Error occurred
            echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        }
    } else {
        // Package not found
        echo json_encode(['success' => false, 'message' => 'Error: Package not found.']);
    }

    $stmt->close();
}

$conn->close();
?>

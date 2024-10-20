<?php
session_start();

// Include the database connection
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve posted data
    $requestId = isset($_POST['request_id']) ? $_POST['request_id'] : 0;

    // Set payment method to 'PayPal' by default
    $paymentMethod = 'PayPal'; // Default value
    $transactionStatus = 'pending'; // Default status

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
            // Successfully inserted, now update the transaction status to 'paid'
            $transactionId = $stmt->insert_id; // Get the ID of the inserted transaction
            
            $updateSql = "UPDATE transactions SET transaction_status = 'paid' WHERE transaction_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $transactionId);

            if ($updateStmt->execute()) {
                // Update the booking_request table to mark the request as 'paid'
                $updateBookingSql = "UPDATE booking_request SET status = 'paid' WHERE request_id = ?";
                $updateBookingStmt = $conn->prepare($updateBookingSql);
                $updateBookingStmt->bind_param("i", $requestId);

                if ($updateBookingStmt->execute()) {
                    // Redirect to success page after updating
                    header("Location: success.php");
                    exit();
                } else {
                    // Handle update error for booking_request
                    echo json_encode(['success' => false, 'message' => 'Error updating booking status: ' . $updateBookingStmt->error]);
                }
                $updateBookingStmt->close();
            } else {
                // Handle update error for transactions
                echo json_encode(['success' => false, 'message' => 'Error updating transaction status: ' . $updateStmt->error]);
            }
            $updateStmt->close();
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

<?php
session_start();
include('../connection.php');

// Get request ID
$requestId = isset($_GET['request_id']) ? $_GET['request_id'] : 0;

// Fetch required deposit amount from booking_request (50% of the package price)
$sql = "SELECT p.price FROM booking_request br JOIN packages p ON br.package_id = p.package_id WHERE br.request_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $requestId);
$stmt->execute();
$result = $stmt->get_result();
$price = $result->fetch_assoc()['price'] / 2;  // 50% deposit

// PayPal Script
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Deposit</title>
    <script src="https://www.paypal.com/sdk/js?client-id=ARsvm_38-yeIedzC88hRFVV9Jwt1QDaAUx59s1IPinhjuJtaRSkshQ_b9gEQ2Weqi_nCThTpC8reg2d0&currency=PHP"></script>
</head>
<body>

<h3>Pay Deposit of ₱<?php echo number_format($price, 2); ?></h3>

<!-- PayPal Button Container -->
<div id="paypal-button-container"></div>

<script>
paypal.Buttons({
    // Set up the transaction
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: <?php echo number_format($deposit_price, 2, '.', ''); ?> // Use the deposit amount
                }
            }]
        });
    },
    // Finalize the transaction
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            // Payment was successful
            console.log('Transaction completed by ' + details.payer.name.given);

            // AJAX call to save the transaction in the database
            var requestId = <?php echo json_encode($requestId); ?>; // Get the request ID
            var depositAmount = <?php echo json_encode($deposit_price); ?>; // Get the deposit amount
            var paymentMethod = 'PayPal'; // Payment method
            var transactionStatus = 'completed'; // Transaction status

            // AJAX request to save the transaction
            $.ajax({
                url: 'save_transaction.php',
                method: 'POST',
                data: {
                    request_id: requestId,
                    deposit_amount: depositAmount,
                    payment_method: paymentMethod,
                    transaction_status: transactionStatus
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    alert('Transaction was successful and saved to the database.');
                    // Optionally redirect or update the UI
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(error);
                    alert('An error occurred while saving the transaction. Please try again.');
                }
            });
        });
    },
    onError: function(err) {
        console.error(err);
        alert('An error occurred during the transaction. Please try again.');
    }
}).render('#paypal-button-container');
</script>


</body>
</html>

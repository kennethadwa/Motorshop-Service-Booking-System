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
                    value: '<?php echo $price; ?>' // Set the deposit value
                }
            }]
        });
    },

    // Finalize the transaction after payment approval
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            // Send an AJAX request to update the booking status to 'paid'
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process_payment.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                window.location.href = "success.php?request_id=<?php echo $requestId; ?>";
            };
            xhr.send("request_id=<?php echo $requestId; ?>");
        });
    }
}).render('#paypal-button-container'); // Display the PayPal button in the container
</script>

</body>
</html>

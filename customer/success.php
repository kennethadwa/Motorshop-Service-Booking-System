<?php
session_start();
include('../connection.php');

// Include PHPMailer files
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// Send receipt email
if ($data) {
    // PHPMailer for sending the email
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kennetics1@gmail.com'; // Your email address
        $mail->Password = 'bcvn mqgw jxlf gmin'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('kennetics1@gmail.com', 'Sairom Motorshop');
        $mail->addAddress($data['email']); // Customer's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment Receipt - Booking No. ' . $requestId;
        $mail->Body = "
            <h4>Payment Receipt</h4>
            <p><strong>Customer Name:</strong> " . htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) . "</p>
            <p><strong>Contact No:</strong> " . htmlspecialchars($data['contact_no']) . "</p>
            <p><strong>Address:</strong> " . htmlspecialchars($data['address']) . "</p>
            <p><strong>Email Address:</strong> " . htmlspecialchars($data['email']) . "</p>
            <p><strong>Package No:</strong> " . htmlspecialchars($data['package_id']) . "</p>
            <p><strong>Package Name:</strong> " . htmlspecialchars($data['package_name']) . "</p>
            <p><strong>Duration:</strong> " . htmlspecialchars($data['duration']) . "</p>
            <p><strong>Package Price:</strong> ₱" . htmlspecialchars(number_format($data['price'], 2)) . "</p>
            <p><strong>Deposit Amount:</strong> ₱" . htmlspecialchars(number_format($data['price'] / 2, 2)) . "</p>
            <p><strong>Status:</strong> Paid</p>
            <p>Thank you for your booking!</p>
            <p>*** Please keep this receipt for your records ***</p>
        ";

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
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
    
   <div class="receipt-title" style="width: 100%; max-height: 80px; display:flex; justify-content: center; align-items: center; margin-bottom: 10px;">
    <h1 style="color: black; font-size:2rem; font-weight:600; font-family: Segoe;">Please Screenshot the Receipt, Thank you!🙂🤗</h1>
   </div>
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
        <p><strong>Package Price:</strong> ₱<?php echo htmlspecialchars(number_format($data['price'], 2)); ?></p>
        <p><strong>Deposit Amount:</strong> ₱<?php echo htmlspecialchars(number_format($data['price'] / 2, 2)); ?></p>
        <p><strong>Status:</strong> Paid</p>
        
        <div class="receipt-footer">
            <p>Thank you for your booking!</p>
            <p>*** Please keep this receipt for your records ***</p>
        </div>
        
        <!-- Countdown Timer -->
        <div id="loading" class="text-center" style="margin-top: 20px;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Redirecting in <span id="countdown">10</span> seconds...</p>
        </div>
    </div>

    <script>
        let countdown = 10; // Set countdown time in seconds
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown; // Update the countdown display
            
            if (countdown <= 0) {
                clearInterval(countdownInterval); // Clear the interval
                window.location.href = 'booking_history'; // Redirect to booking_history.php
            }
        }, 1000); // Decrement every 1000 milliseconds (1 second)
    </script>
</body>
</html>

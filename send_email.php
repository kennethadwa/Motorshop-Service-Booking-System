<?php
// Include Composer's autoload file to load PHPMailer classes
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Assuming you have established a connection to the database
$conn = new mysqli('localhost', 'username', 'password', 'your_database');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the last signed up user's email (or use a specific user ID)
$sql = "SELECT email FROM users ORDER BY id DESC LIMIT 1";  // Adjust the query as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $recipient_email = $row['email'];  // The email of the user who signed up
} else {
    die("No user found");
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server
    $mail->SMTPAuth   = true;             
    $mail->Username   = 'kennetics1@gmail.com'; // SMTP username
    $mail->Password   = 'UCAXTC6P';      // SMTP password (ensure this is secure)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('your_email@example.com', 'Your Name');   // Your email and name
    $mail->addAddress($recipient_email, 'Recipient Name');  // Use the email from the signup form

    // Content
    $mail->isHTML(true);    
    $mail->Subject = 'Welcome to Our Website';
    $mail->Body    = 'Thank you for signing up!';
    $mail->AltBody = 'Thank you for signing up!';

    $mail->send();
    echo 'Welcome email has been sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

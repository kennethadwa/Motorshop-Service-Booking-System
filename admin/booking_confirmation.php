<?php

require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ensure $newStatus is defined
$newStatus = isset($_POST['status']) ? $_POST['status'] : '';

if ($newStatus === 'approved') {
    // Send email notification
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'kennetics1@gmail.com';            
        $mail->Password   = 'bcvn mqgw jxlf gmin';                
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                   

        // Recipients
        $mail->setFrom('kennetics1@gmail.com', 'Sairom Motorshop'); // Sender email and name
        $mail->addAddress($email, $first_name . ' ' . $last_name); // Add a recipient

        // Content
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = 'Booking Request Approved';
        $mail->Body    = 'Dear ' . htmlspecialchars($first_name) . ',<br><br>Your booking request has been approved. You may now proceed for the payment of the deposit.<br><br>Thank you!';
        $mail->AltBody = 'Dear ' . htmlspecialchars($first_name) . ', Your booking request has been approved. You can proceed to payment of the deposit. Thank you!';

        // Send the email
        $mail->send();
        echo "<script>alert('Booking confirmation email has been sent.');</script>";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

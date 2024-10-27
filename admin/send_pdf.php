<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

session_start();
$adminEmail = $_SESSION['email']; // Get the admin's email from the session

if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    // Save the uploaded PDF
    $uploadDir = '../uploads/pdf';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $filePath = $uploadDir . 'Transaction_Report_' . time() . '.pdf';
    move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

    // Configure and send email with PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kennetics1@gmail.com';
        $mail->Password = 'bcvn mqgw jxlf gmin';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('kennetics1@gmail.com', 'Sairom Motor Shop');
        $mail->addAddress($adminEmail);

        // Attach the PDF file
        $mail->addAttachment($filePath);

        // Set email content
        $mail->isHTML(true);
        $mail->Subject = 'Transaction Report';
        $mail->Body = 'Please find attached the transaction report in PDF format.';

        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send email: {$mail->ErrorInfo}";
    }
} else {
    echo "Failed to upload file.";
}

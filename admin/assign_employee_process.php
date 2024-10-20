<?php

require '../vendor/autoload.php'; 

include('../connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send email using PHPMailer
function sendEmail($email, $subject, $body) {
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
        $mail->setFrom('kennetics1@gmail.com', 'Sairom Motorshop');
        $mail->addAddress($email); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $employee_id = $_POST['employee_id'];
    $request_id = $_POST['request_id'];

    // Prepare the insert query for schedule
    $query = "INSERT INTO schedule (employee_id, booking_id) VALUES (?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $employee_id, $request_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Update booking_request status to 'in progress'
            $updateStatusQuery = "UPDATE booking_request SET status = ? WHERE request_id = ?";
            $newStatus = "in progress";

            if ($updateStmt = $conn->prepare($updateStatusQuery)) {
                $updateStmt->bind_param("si", $newStatus, $request_id);

                if ($updateStmt->execute()) {
                    // Fetch customer and employee emails
                    $fetchEmailsQuery = "
                        SELECT c.email AS customer_email, e.email AS employee_email, c.first_name AS customer_name, e.first_name AS employee_name
                        FROM booking_request br
                        JOIN customers c ON br.customer_id = c.customer_id
                        JOIN employees e ON e.employee_id = ?
                        WHERE br.request_id = ?";

                    if ($emailStmt = $conn->prepare($fetchEmailsQuery)) {
                        $emailStmt->bind_param("ii", $employee_id, $request_id);
                        $emailStmt->execute();
                        $emailStmt->bind_result($customer_email, $employee_email, $customer_name, $employee_name);
                        if ($emailStmt->fetch()) {
                            // Prepare and send email to customer
                            $customerSubject = "Your Booking Request is In Progress";
                            $customerBody = "Dear $customer_name,<br>Your booking request #$request_id is now in progress and has been assigned to an employee.";
                            sendEmail($customer_email, $customerSubject, $customerBody);

                            // Prepare and send email to employee
                            $employeeSubject = "New Booking Assigned";
                            $employeeBody = "Dear $employee_name,<br>You have been assigned to a new booking request #$request_id. Please check your schedule.";
                            sendEmail($employee_email, $employeeSubject, $employeeBody);
                        }
                        $emailStmt->close();
                    }
                    // Redirect to schedule page with success message
                    header("Location: schedule.php?message=success");
                } else {
                    echo "Error updating status: " . $updateStmt->error;
                }
                $updateStmt->close();
            } else {
                echo "Error preparing update statement: " . $conn->error;
            }
        } else {
            echo "Error inserting schedule: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing insert statement: " . $conn->error;
    }
}

$conn->close();
?>

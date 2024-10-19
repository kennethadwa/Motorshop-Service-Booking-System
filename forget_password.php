<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    include('connection.php');

    $query = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
  
        $new_password = substr(md5(time()), 0, 8);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE customers SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hashed_password, $email);
        $update->execute();

        require 'vendor/autoload.php'; // PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kennetics1@gmail.com';
        $mail->Password = 'bcvn mqgw jxlf gmin';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email content
        $mail->setFrom('kennetics1@gmail.com', 'Sairom Motorshop');
        $mail->addAddress($email);
        $mail->Subject = 'Temporary Password for Your Account';

        $mail->Body = "
        Dear User,
        
        We received a request to reset your password for your Sairom Motorshop account. As requested, we have generated a new temporary password for you to log in.
        
        Your new temporary password is: $new_password
        
        Please use this password to log in to your account. Once logged in, we strongly recommend changing your password in your profile settings to something more secure and easy to remember.
        
        **Important:** This password is temporary and will allow you to access your account. Please remember to update your password as soon as possible to ensure the security of your account.
        
        If you didn't request a password reset or have any concerns, please contact our support team immediately.
        
        Thank you for using Sairom Motorshop!
        
        Best regards,
        Sairom Motorshop Team
        ";

        if ($mail->send()) {
            // Show success alert and redirect to login-register.php
            echo "<script>
                    alert('Password reset successfully. Please check your email for the new password.');
                    window.location.href = 'login-register.php';
                  </script>";
        } else {
            echo 'Email could not be sent.';
        }
    } else {
        echo 'Email not found.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <style>
      * {
           margin: 0;
           padding: 0;
           box-sizing: border-box;
           font-family: 'Montserrat', sans-serif;
        }

        body {
          background-image: url('./images/loginbg.png');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
          display: flex;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          height: 100vh;
        }

        form{
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          gap: 15px;
        }
    </style>
</head>
<body>
    <h2 style="color: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Forget Your Password?</h2>
    <br>
    <form action="forget_password.php" method="POST">
        <input type="email" name="email" placeholder="Enter your email" style="padding: 10px 20px; font-family: Segoe; font-size: 1rem;" required>

        <button type="submit" style="background-color:blueviolet; color: white; padding: 10px 15px; border-radius: 5px;  box-shadow: 1px 1px 10px black; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1rem; text-align: center;">Submit</button>
    </form>      
</body>
</html>

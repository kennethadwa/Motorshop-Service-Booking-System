<?php
session_start();
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secretKey = '6LddpWYqAAAAAOAe7s3Sfry8xRZhTFur38Ienozm';

        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
        $response = json_decode($verifyResponse);

        if ($response->success) {
            // Query to check if the admin exists
            $query = "SELECT admin_id, first_name, last_name, password FROM admin WHERE email = ? LIMIT 1";

            // Prepare the statement
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['email'] = $email;
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['admin_id'] = $row['admin_id'];

                    header("Location: index");
                    exit();
                } else {
                    echo "<script>alert('Invalid password!'); window.location.href='login.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('No user found with this email!'); window.location.href='login.php';</script>";
                exit();
            }
        } else {
            echo '<script>alert("Failed to verify"); window.location.href="login.php";</script>';
        }
    } else {
        echo '<script>alert("Failed to verify"); window.location.href="login.php";</script>';
    }
}
?>

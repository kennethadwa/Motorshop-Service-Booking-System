<?php
session_start();
include 'connection.php'; // Ensure this file connects to your database

$maxAttempts = 3;
$lockoutTime = 15 * 60; // 15 minutes in seconds
$loginErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the email and password are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        // Sanitize inputs to prevent SQL injection
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        // Prepare query to get user info, including attempts and lockout time
        $query = "SELECT customer_id, first_name, last_name, account_type, password, failed_attempts, last_failed_login FROM customers WHERE email = ? LIMIT 1";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];
                $loginAttempts = $row['failed_attempts'];
                $lockedUntil = $row['last_failed_login'];

                // Check if the account is locked
                if ($lockedUntil && strtotime($lockedUntil) > time()) {
                    $remainingLockTime = ceil((strtotime($lockedUntil) - time()) / 60);
                    $loginErr = "Account locked. Try again in $remainingLockTime minutes.";
                } else {
                    // Verify password
                    if (password_verify($password, $hashed_password)) {
                        // Reset attempts and unlock account on successful login
                        $updateQuery = "UPDATE customers SET failed_attempts = 0, last_failed_login = NULL WHERE email = ?";
                        $stmtUpdate = $conn->prepare($updateQuery);
                        $stmtUpdate->bind_param("s", $email);
                        $stmtUpdate->execute();

                        // Set session variables
                        $_SESSION['email'] = $email;
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['customer_id'] = $row['customer_id'];

                        // Redirect to the customer's dashboard
                        header("Location: ./customer/packages.php");
                        exit();
                    } else {
                        // Wrong password, increment login attempts
                        $loginAttempts++;
                        if ($loginAttempts >= $maxAttempts) {
                            $lockedUntil = date("Y-m-d H:i:s", time() + $lockoutTime);
                            $loginErr = "Too many failed attempts. Account locked for 15 minutes.";
                        } else {
                            $lockedUntil = NULL;
                            $attemptsLeft = $maxAttempts - $loginAttempts;
                            $loginErr = "Incorrect password. Attempts left: $attemptsLeft.";
                        }

                        // Update login attempts and locked_until in database
                        $updateQuery = "UPDATE customers SET failed_attempts = ?, last_failed_login = ? WHERE email = ?";
                        $stmtUpdate = $conn->prepare($updateQuery);
                        $stmtUpdate->bind_param("iss", $loginAttempts, $lockedUntil, $email);
                        $stmtUpdate->execute();
                    }
                }
            } else {
                $loginErr = "No user found with this email.";
            }

            $stmt->close();
        } else {
            $loginErr = "Database error: Unable to prepare statement.";
        }
    } else {
        $loginErr = "Please enter both email and password.";
    }

    // Set error message and redirect back to login
    if ($loginErr) {
        $_SESSION['loginErr'] = $loginErr;
        header("Location: login-register.php");
        exit();
    }
}

// Redirect to login if not a POST request
header("Location: login-register.php");
exit();
?>

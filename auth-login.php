<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize user input
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // QUERY TO FIND THE ACCOUNT LOGGED IN BY THE USER
    $query = "SELECT admin_id, employee_id, customer_id, first_name, last_name, account_type, password FROM (
                SELECT admin_id, NULL AS employee_id, NULL AS customer_id, email, first_name, last_name, account_type, password FROM admin
                UNION ALL
                SELECT NULL AS admin_id, employee_id, NULL AS customer_id, email, first_name, last_name, account_type, password FROM employees
                UNION ALL
                SELECT NULL AS admin_id, NULL AS employee_id, customer_id, email, first_name, last_name, account_type, password FROM customers
              ) AS users
              WHERE email = ? LIMIT 1";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email); // "s" indicates the type is string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // VERIFY PASSWORD
        if (password_verify($password, $hashed_password)) {
            $account_type = $row['account_type'];

            // Set session variables
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $row['first_name']; // Store first name in session
            $_SESSION['last_name'] = $row['last_name']; // Store last name in session
            $_SESSION['account_type'] = $account_type;

            // Set IDs based on account type
            if ($account_type == 0) { // Admin
                $_SESSION['admin_id'] = $row['admin_id']; // Store admin_id in session
            } elseif ($account_type == 1) { // Employee
                $_SESSION['employee_id'] = $row['employee_id']; // Store employee_id in session
            } elseif ($account_type == 2) { // Customer
                $_SESSION['customer_id'] = $row['customer_id']; // Store customer_id in session
            }

            // REDIRECT USER BASED ON THEIR ACCOUNT TYPE
            switch ($account_type) {
                case 0: // Admin
                    header("Location: ./admin/index.php"); // Redirect to admin index
                    break;
                case 1: // Employee
                    header("Location: ./employee/index.php"); // Redirect to employee index
                    break;
                case 2: // Customer
                    header("Location: ./customer/index.php"); // Redirect to customer index
                    break;
                default:
                    echo "<script>alert('Invalid account type!'); window.location.href='login-register.php';</script>";
                    exit();
            }
            exit();
        } else {
            // INVALID PASSWORD
            echo "<script>alert('Invalid password!'); window.location.href='login-register.php';</script>";
            exit();
        }
    } else {
        // INVALID EMAIL
        echo "<script>alert('No user found with this email!'); window.location.href='login-register.php';</script>";
        exit();
    }
}
?>

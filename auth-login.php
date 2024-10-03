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
    $query = "SELECT first_name, last_name, account_type, password FROM (
                SELECT email, password, account_type, first_name, last_name FROM admin
                UNION ALL
                SELECT email, password, account_type, first_name, last_name FROM employees
                UNION ALL
                SELECT email, password, account_type, first_name, last_name FROM customers
              ) AS users
              WHERE email = '$email' LIMIT 1";

    $result = $conn->query($query);

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

            // REDIRECT USER BASED ON THEIR ACCOUNT TYPE
            switch ($account_type) {
                case 0: // Admin
                    header("Location: ./admin/index");
                    break;
                case 1: // Employee
                    header("Location: ./employee/index");
                    break;
                case 2: // Customer
                    header("Location: ./customer/index");
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

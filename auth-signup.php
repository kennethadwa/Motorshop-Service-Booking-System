<?php
session_start();
include 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $contact = mysqli_real_escape_string($conn, $contact);
    $password = mysqli_real_escape_string($conn, $password);
    $confirm_password = mysqli_real_escape_string($conn, $confirm_password);

    // CHECK IF PASSWORD MATCH
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit();
    }

    // HASH PASSWORD
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // CHECK IF EMAIL ALREADY EXISTS
    $email_check_query = "SELECT email FROM (
                            SELECT email FROM admin
                            UNION ALL
                            SELECT email FROM employees
                            UNION ALL
                            SELECT email FROM customers
                          ) AS users
                          WHERE email = '$email' LIMIT 1";

    $result = $conn->query($email_check_query);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // INSERT USER SA CUSTOMER TABLE
        $query = "INSERT INTO customers (first_name, last_name, contact_no, email, password, account_type) 
                  VALUES ('$first_name', '$last_name', '$contact', '$email', '$hashed_password', 2)";

        if ($conn->query($query)) {
            echo "<script>alert('Registration successful!'); window.location.href='login-register';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>

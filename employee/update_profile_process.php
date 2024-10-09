<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = intval($_POST['employee_id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Password handling
    $password = $_POST['password']; // Assuming this is the new password
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Passwords do not match.');
                window.history.back();
              </script>";
        exit;
    }

    // Hash the password before saving (optional but recommended)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/employee_profile/";
    $target_file = $target_dir . basename($profile_picture);

    // Prepare the SQL query based on whether a new profile picture is uploaded
    if (!empty($profile_picture) && move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql = "UPDATE employees SET first_name='$first_name', last_name='$last_name', age='$age', birthday='$birthday', sex='$sex', 
                contact_no='$contact_no', address='$address', email='$email', profile='$target_file', password='$hashed_password' 
                WHERE employee_id='$employee_id'";
    } else {
        $sql = "UPDATE employees SET first_name='$first_name', last_name='$last_name', age='$age', birthday='$birthday', sex='$sex', 
                contact_no='$contact_no', address='$address', email='$email', password='$hashed_password' 
                WHERE employee_id='$employee_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Profile information updated successfully.');
                window.location.href = 'profile?id={$employee_id}'; // Redirect to view_employee.php
              </script>";
        exit;
    } else {
        echo "Error updating employee: " . $conn->error;
    }
}

$conn->close();
?>

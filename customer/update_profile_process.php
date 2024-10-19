<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = intval($_POST['customer_id']); // Changed from employee_id to customer_id
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Password handling
    $password = $_POST['password']; // New password
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if (!empty($password) && $password !== $confirm_password) {
        echo "<script>
                alert('Passwords do not match.');
                window.history.back();
              </script>";
        exit;
    }

    // Hash the password before saving (optional but recommended)
    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "../uploads/customer_profile/"; // Corrected directory for customer profiles
    $target_file = $target_dir . basename($profile_picture);

    // Prepare the SQL query based on whether a new profile picture is uploaded
    $sql = "UPDATE customers SET first_name='$first_name', last_name='$last_name', age='$age', birthday='$birthday', sex='$sex', 
            contact_no='$contact_no', address='$address', email='$email'";

    if (!empty($profile_picture) && move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql .= ", profile='$target_file'"; // Include profile picture only if it's uploaded
    }

    // Only update password if a new one is provided
    if ($hashed_password) {
        $sql .= ", password='$hashed_password'"; // Add password only if it's being updated
    }

    $sql .= " WHERE customer_id='$customer_id'"; // Ensure you use the correct ID for the customers table

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Profile information updated successfully.');
                window.location.href = 'profile?id={$customer_id}'; // Redirect to view_customer.php
              </script>";
        exit;
    } else {
        echo "Error updating customer: " . $conn->error; // Add more details if there's an error
    }
}

$conn->close();
?>

<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = intval($_POST['admin_id']); // Using 'admin_id' instead of 'employee_id'
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']); // New email input
    $password = $_POST['password']; // New password input
    $confirm_password = $_POST['confirm_password']; // New confirm password input

    // Password confirmation logic
    if (!empty($password) || !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            echo "<script>
                    alert('Passwords do not match.');
                    window.history.back();
                  </script>";
            exit;
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $password_sql = ", password='$hashed_password'"; // Prepare SQL part for password
        }
    } else {
        $password_sql = ""; // No password change
    }

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/admin_profile/";
    $target_file = $target_dir . basename($profile_picture);

    // Check if a new profile picture is uploaded
    if (!empty($profile_picture) && move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql = "UPDATE admin SET first_name='$first_name', last_name='$last_name', age='$age', birthday='$birthday', sex='$sex', contact_no='$contact_no', address='$address', email='$email', profile='$target_file' $password_sql WHERE admin_id='$admin_id'";
    } else {
        $sql = "UPDATE admin SET first_name='$first_name', last_name='$last_name', age='$age', birthday='$birthday', sex='$sex', contact_no='$contact_no', address='$address', email='$email' $password_sql WHERE admin_id='$admin_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Admin profile updated successfully.');
                window.location.href = 'profile?id={$admin_id}'; // Correct redirection to admin's profile
              </script>";
        exit;
    } else {
        echo "Error updating admin: " . $conn->error;
    }
}

$conn->close();
?>

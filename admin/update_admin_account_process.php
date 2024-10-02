<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = intval($_POST['admin_id']);  
    $email = $conn->real_escape_string($_POST['email']);
    $account_type = $conn->real_escape_string($_POST['account_type']); 

    // Hash the new password if provided
    $new_password = $_POST['password'];  // Assuming 'password' is the input name
    $hashed_password = !empty($new_password) ? password_hash($new_password, PASSWORD_DEFAULT) : null;

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/admin_profile/"; 
    $target_file = $target_dir . basename($profile_picture);

    // Prepare the SQL statement
    $sql = "UPDATE admin SET 
            email='$email', 
            account_type='$account_type'";

    if ($hashed_password) {
        $sql .= ", password='$hashed_password'";  // Add hashed password to the SQL query
    }

    if (!empty($profile_picture) && move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql .= ", profile='$target_file'";  // Add profile picture if uploaded
    }

    $sql .= " WHERE admin_id='$admin_id'";  // Update for the specific admin

    if ($conn->query($sql) === TRUE) {
        // Successful update
        echo "<script>
                alert('Admin information updated successfully.'); 
                window.location.href = 'view_admin.php?id={$admin_id}'; 
              </script>";
        exit;
    } else {
        echo "Error updating admin: " . $conn->error;  
    }
}

$conn->close();
?>

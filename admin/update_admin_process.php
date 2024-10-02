<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = intval($_POST['admin_id']);  
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);  // Add age
    $birthday = $conn->real_escape_string($_POST['birthday']);  
    $sex = $conn->real_escape_string($_POST['sex']);  
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $address = $conn->real_escape_string($_POST['address']);

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/admin_profile/"; 
    $target_file = $target_dir . basename($profile_picture);
    
    // Prepare the SQL statement with new fields
    if (move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql = "UPDATE admin SET 
                first_name='$first_name', 
                last_name='$last_name', 
                age='$age', 
                birthday='$birthday', 
                sex='$sex', 
                contact_no='$contact_no', 
                address='$address', 
                profile='$target_file'
                WHERE admin_id='$admin_id'"; 
    } else {
        $sql = "UPDATE admin SET 
                first_name='$first_name', 
                last_name='$last_name', 
                age='$age', 
                birthday='$birthday', 
                sex='$sex', 
                contact_no='$contact_no', 
                address='$address'
                WHERE admin_id='$admin_id'";  // Changed condition from customer_id to admin_id
    }
    
    if ($conn->query($sql) === TRUE) {
        // Successful update
        echo "<script>
                alert('Admin information updated successfully.');  // Changed alert message
                window.location.href = 'view_admin.php?id={$admin_id}'; // Redirect to view_admin.php
              </script>";
        exit;
    } else {
        echo "Error updating admin: " . $conn->error;  // Changed error message
    }
}

$conn->close();
?>

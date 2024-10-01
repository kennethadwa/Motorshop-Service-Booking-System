<?php

include('../connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = intval($_POST['admin_id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Retrieve account_type from POST data and cast to int
    $account_type = intval($_POST['account_type']); 

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/admin_profile/"; 
    $target_file = $target_dir . basename($profile_picture);
    
    if (move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql = "UPDATE admin SET first_name='$first_name', last_name='$last_name', contact_no='$contact_no', address='$address', email='$email', profile='$target_file', account_type='$account_type' WHERE admin_id='$admin_id'";
    } else {
        $sql = "UPDATE admin SET first_name='$first_name', last_name='$last_name', contact_no='$contact_no', address='$address', email='$email', account_type='$account_type' WHERE admin_id='$admin_id'";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Admin information updated successfully.'); // Changed alert message
                window.location.href = 'view_admin.php?id={$admin_id}'; // Redirect to view_admin.php
              </script>";
        exit;
    } else {
        echo "Error updating admin: " . $conn->error; 
    }
}

$conn->close();
?>

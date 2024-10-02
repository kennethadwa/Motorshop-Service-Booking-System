<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = intval($_POST['customer_id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);  // Add age
    $birthday = $conn->real_escape_string($_POST['birthday']);  // Add birthday
    $sex = $conn->real_escape_string($_POST['sex']);  // Add sex
    $contact_no = $conn->real_escape_string($_POST['contact_no']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Retrieve account_type from POST data
    $account_type = $conn->real_escape_string($_POST['account_type']); 

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/customer_profile/";
    $target_file = $target_dir . basename($profile_picture);
    
    // Prepare the SQL statement with new fields
    if (move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql = "UPDATE customers SET 
                first_name='$first_name', 
                last_name='$last_name', 
                age='$age', 
                birthday='$birthday', 
                sex='$sex', 
                contact_no='$contact_no', 
                address='$address', 
                email='$email', 
                profile='$target_file', 
                account_type='$account_type' 
                WHERE customer_id='$customer_id'";
    } else {
        $sql = "UPDATE customers SET 
                first_name='$first_name', 
                last_name='$last_name', 
                age='$age', 
                birthday='$birthday', 
                sex='$sex', 
                contact_no='$contact_no', 
                address='$address', 
                email='$email', 
                account_type='$account_type' 
                WHERE customer_id='$customer_id'";
    }
    
    if ($conn->query($sql) === TRUE) {
        // Successful update
        echo "<script>
                alert('Customer information updated successfully.');
                window.location.href = 'view_customer.php?id={$customer_id}'; // Redirect to view_customers.php
              </script>";
        exit;
    } else {
        echo "Error updating customer: " . $conn->error;
    }
}

$conn->close();
?>

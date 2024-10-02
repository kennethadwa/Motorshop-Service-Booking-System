<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = intval($_POST['customer_id']);  
    $email = $conn->real_escape_string($_POST['email']);
    $account_type = $conn->real_escape_string($_POST['account_type']);  

    $new_password = $_POST['password'];
    $hashed_password = !empty($new_password) ? password_hash($new_password, PASSWORD_DEFAULT) : null;

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/customer_profile/";  // Updated to reflect customer profile picture directory
    $target_file = $target_dir . basename($profile_picture);

    // Update customer info query
    $sql = "UPDATE customers SET 
            email='$email', 
            account_type='$account_type'";

    if ($hashed_password) {
        $sql .= ", password='$hashed_password'";  
    }

    if (!empty($profile_picture) && move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql .= ", profile='$target_file'";  
    }

    $sql .= " WHERE customer_id='$customer_id'";  

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Customer information updated successfully.'); 
                window.location.href = 'view_customer_account.php?id={$customer_id}'; 
              </script>";
        exit;
    } else {
        echo "Error updating customer: " . $conn->error;  
    }
}

$conn->close();
?>

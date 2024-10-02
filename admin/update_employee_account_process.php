<?php

$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = intval($_POST['employee_id']);  
    $email = $conn->real_escape_string($_POST['email']);
    $account_type = $conn->real_escape_string($_POST['account_type']); 


    $new_password = $_POST['password'];
    $hashed_password = !empty($new_password) ? password_hash($new_password, PASSWORD_DEFAULT) : null;

    $profile_picture = $_FILES['profile']['name'];
    $target_dir = "uploads/employee_profile/"; 
    $target_file = $target_dir . basename($profile_picture);

  
    $sql = "UPDATE employees SET 
            email='$email', 
            account_type='$account_type'";

    if ($hashed_password) {
        $sql .= ", password='$hashed_password'";  
    }

    if (!empty($profile_picture) && move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $sql .= ", profile='$target_file'";  
    }

    $sql .= " WHERE employee_id='$employee_id'";  

    if ($conn->query($sql) === TRUE) {
  
        echo "<script>
                alert('Employee information updated successfully.'); 
                window.location.href = 'view_employee_account.php?id={$employee_id}'; 
              </script>";
        exit;
    } else {
        echo "Error updating employee: " . $conn->error;  
    }
}

$conn->close();
?>

<?php
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $account_type = $_POST['account_type'];

    // Handle file upload for profile picture
    $profile = null;
    if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        $target_dir = "uploads/employee_profile/";  
        $file_name = time() . "_" . basename($_FILES['profile']['name']); 
        $target_file = $target_dir . $file_name;
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
            $profile = $target_file; 
        } else {
            echo "Sorry, there was an error uploading the file.";
            exit; 
        }
    }

    $sql = "INSERT INTO employees (first_name, last_name, contact_no, address, email, password, profile, account_type) 
            VALUES ('$first_name', '$last_name', '$contact_no', '$address', '$email', '$password', '$profile', '$account_type')";

    if (mysqli_query($conn, $sql)) {
        // Display alert and redirect to employees.php
        echo "<script>
                alert('Employee added successfully');
                window.location.href = 'employees.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

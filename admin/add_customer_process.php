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
        $target_dir = "../uploads/customer_profile/";  
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

    $sql = "INSERT INTO customers (first_name, last_name, contact_no, address, email, password, profile, account_type) 
            VALUES ('$first_name', '$last_name', '$contact_no', '$address', '$email', '$password', '$profile', '$account_type')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted customer ID
        $customer_id = mysqli_insert_id($conn);

        // Display alert and redirect to view_customer.php with the correct customer ID
        echo "<script>
                alert('Customer added successfully');
                window.location.href = 'manage-account';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

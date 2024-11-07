<?php
session_start();


$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => "Connection failed: " . $conn->connect_error]));
}


$target_dir = "../uploads/admin_profile/";
$admin_id = intval($_SESSION['admin_id']); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile'])) {
    $profile_picture = $_FILES['profile']['name'];
    $target_file = $target_dir . basename($profile_picture);

    if (move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        
        $sql = "UPDATE admin SET profile='$target_file' WHERE admin_id='$admin_id'";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'filepath' => $target_file]);
        } else {
            echo json_encode(['success' => false, 'error' => "Database update failed"]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => "File upload failed"]);
    }
} else {
    echo json_encode(['success' => false, 'error' => "Invalid request"]);
}

$conn->close();
?>

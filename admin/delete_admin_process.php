<?php
$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = intval($_POST['admin_id']);
    
    // Perform delete operation
    $sql = "DELETE FROM admin WHERE admin_id = '$admin_id'";

    if ($conn->query($sql) === TRUE) {
        // Successful deletion
        echo "<script>
                alert('Admin deleted successfully.');
                window.location.href = 'user-information.php';
              </script>";
        exit;
    } else {
        echo "Error deleting admin: " . $conn->error;
    }
}

$conn->close();
?>

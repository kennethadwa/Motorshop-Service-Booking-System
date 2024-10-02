<?php
$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = intval($_POST['employee_id']);
    
    // Perform delete operation
    $sql = "DELETE FROM employees WHERE employee_id = '$employee_id'";

    if ($conn->query($sql) === TRUE) {
        // Successful deletion
        echo "<script>
                alert('Employee deleted successfully.');
                window.location.href = 'user-information.php'; // Redirect to employees page
              </script>";
        exit;
    } else {
        echo "Error deleting employee: " . $conn->error;
    }
}

$conn->close();
?>

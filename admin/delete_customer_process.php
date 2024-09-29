<?php
$conn = new mysqli("localhost", "root", "", "sairom_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = intval($_POST['customer_id']);
    
    // Perform delete operation
    $sql = "DELETE FROM customers WHERE customer_id = '$customer_id'";

    if ($conn->query($sql) === TRUE) {
        // Successful deletion
        echo "<script>
                alert('Customer deleted successfully.');
                window.location.href = 'customers.php'; // Redirect to customers page
              </script>";
        exit;
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
}

$conn->close();
?>

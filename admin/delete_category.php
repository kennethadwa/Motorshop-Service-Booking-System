<?php
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $category_id = $_POST['category_id'];

 
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);

  
    if ($stmt->execute()) {
        
        header("Location: inventory.php?message=Category deleted successfully");
        exit;
    } else {
      
        echo "Error deleting category: " . $stmt->error;
    }

  
    $stmt->close();
}


$conn->close();
?>

<?php
include('../connection.php'); 


if (isset($_GET['package_id'])) {
  
    $package_id = mysqli_real_escape_string($conn, $_GET['package_id']);
    
 
    $query = "DELETE FROM packages WHERE package_id = '$package_id'";


    if (mysqli_query($conn, $query)) {
        echo "Package deleted successfully.";
        
        header("Location: view_packages"); 
        exit();
    } else {
        echo "Error deleting package: " . mysqli_error($conn);
    }
} else {
    echo "No package ID provided.";
}
?>

<?php
session_start();
include('../connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $employee_id = $_POST['employee_id'];
    $request_id = $_POST['request_id'];


    $query = "INSERT INTO schedule (employee_id, booking_id) VALUES (?, ?)";

    if ($stmt = $conn->prepare($query)) {
    
        $stmt->bind_param("ii", $employee_id, $request_id);

        // Execute the statement
        if ($stmt->execute()) {
           
            $updateStatusQuery = "UPDATE booking_request SET status = ? WHERE request_id = ?";
            $newStatus = "in progress";

            if ($updateStmt = $conn->prepare($updateStatusQuery)) {
             
                $updateStmt->bind_param("si", $newStatus, $request_id);

                
                if ($updateStmt->execute()) {
                
                    header("Location: schedule?message=success");
                } else {
                    // Error handling for status update
                    echo "Error updating status: " . $updateStmt->error;
                }

               
                $updateStmt->close();
            } else {
               
                echo "Error preparing update statement: " . $conn->error;
            }
        } else {
            
            echo "Error inserting schedule: " . $stmt->error;
        }

       
        $stmt->close();
    } else {
       
        echo "Error preparing insert statement: " . $conn->error;
    }
}


$conn->close();
?>

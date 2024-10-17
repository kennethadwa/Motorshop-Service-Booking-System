<?php
session_start();
include('../connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $employee_id = $_POST['employee_id'];
    $request_id = $_POST['request_id'];

    // Prepare an SQL query to insert the employee_id and request_id into the schedule table
    $query = "INSERT INTO schedule (employee_id, booking_id) VALUES (?, ?)";

    if ($stmt = $conn->prepare($query)) {
        // Bind the variables to the prepared statement as parameters
        $stmt->bind_param("ii", $employee_id, $request_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Prepare the update query to change the status of the booking request
            $updateStatusQuery = "UPDATE booking_request SET status = ? WHERE request_id = ?";
            $newStatus = "in progress";

            if ($updateStmt = $conn->prepare($updateStatusQuery)) {
                // Bind the variables to the prepared statement as parameters
                $updateStmt->bind_param("si", $newStatus, $request_id);

                // Execute the statement
                if ($updateStmt->execute()) {
                    // Success, redirect to another page or display success message
                    header("Location: schedule.php?message=success");
                } else {
                    // Error handling for status update
                    echo "Error updating status: " . $updateStmt->error;
                }

                // Close the update statement
                $updateStmt->close();
            } else {
                // Error in preparing the update statement
                echo "Error preparing update statement: " . $conn->error;
            }
        } else {
            // Error handling
            echo "Error inserting schedule: " . $stmt->error;
        }

        // Close the insert statement
        $stmt->close();
    } else {
        // Error in preparing the insert statement
        echo "Error preparing insert statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

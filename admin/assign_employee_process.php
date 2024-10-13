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
            // Success, redirect to another page or display success message
            header("Location: schedule.php?message=success");
        } else {
            // Error handling
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

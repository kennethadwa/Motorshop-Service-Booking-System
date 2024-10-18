<?php
session_start();
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php");
    exit();
}

include('../connection.php');

if (isset($_POST['request_id'])) {
    $requestId = $_POST['request_id'];

    // 1. Delete all images related to this booking request
    $imageSql = "SELECT image_path FROM booking_images WHERE request_id = ?";
    $imageStmt = $conn->prepare($imageSql);
    $imageStmt->bind_param("i", $requestId);
    $imageStmt->execute();
    $imageResult = $imageStmt->get_result();

    while ($row = $imageResult->fetch_assoc()) {
        $imagePath = $row['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file from the server
        }
    }

    // Delete the image records from the database
    $deleteImagesSql = "DELETE FROM booking_images WHERE request_id = ?";
    $deleteImagesStmt = $conn->prepare($deleteImagesSql);
    $deleteImagesStmt->bind_param("i", $requestId);
    $deleteImagesStmt->execute();

    // 2. Delete the booking request from the booking_request table
    $deleteRequestSql = "DELETE FROM booking_request WHERE request_id = ?";
    $deleteRequestStmt = $conn->prepare($deleteRequestSql);
    $deleteRequestStmt->bind_param("i", $requestId);

    if ($deleteRequestStmt->execute()) {
        // Redirect back to the booking list or confirmation page
        header("Location: booking_history?message=Booking+Deleted+Successfully");
        exit();
    } else {
        echo "Error deleting booking request.";
    }
} else {
    echo "No request ID provided.";
}
?>

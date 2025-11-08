<?php
// delete_donation.php

require_once "includes/conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM donation WHERE ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Record deleted successfully
        echo '<script>alert("Donation record deleted successfully."); window.location.href="index.php";</script>';
    } else {
        // Error deleting record
        echo '<script>alert("Error deleting donation record: ' . $stmt->error . '"); window.location.href="index.php";</script>';
    }

    $stmt->close();
} else {
    echo '<script>alert("No donation ID provided."); window.location.href="index.php";</script>';
}

$conn->close();
?>
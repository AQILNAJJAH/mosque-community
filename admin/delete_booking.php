<?php
include "includes/conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM `bookings_record` WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        // Successful deletion
        header('Location: index.php');
    } else {
        // Handle error
        echo "Error deleting record: " . $conn->error;
    }
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>

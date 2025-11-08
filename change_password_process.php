<?php
// Include the database connection file
include 'db_conn.php';

// Check if the 'code' parameter is set in the URL
if(isset($_GET['code'])) {
    // Retrieve the code from the URL
    $code = $_GET['code'];

    // Check if the database connection is successful
    if($conn->connect_error) {
        die('Could not connect to the database');
    }

    // Query to check if the code is valid and not expired
    $verifyQuery = $conn->query("SELECT * FROM users WHERE code = '$code' AND updated_time >= NOW() - INTERVAL 1 DAY");

    // If the code is not found or expired, redirect to index.html
    if($verifyQuery->num_rows == 0) {
        header("Location: index.html");
        exit();
    }

    // Check if the 'change' form is submitted
    if(isset($_POST['change'])) {
        // Retrieve the email and new password from the form
        $email = $_POST['email'];
        $new_password = $_POST['new_password'];

        // Hash the new password before updating it in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Query to update the password in the database
        $changeQuery = $conn->query("UPDATE users SET password = '$hashed_password' WHERE email = '$email' AND code = '$code' AND updated_time >= NOW() - INTERVAL 1 DAY");

        // If the password is successfully updated, redirect to a success page
        if($changeQuery) {
            header("Location: success.html");
            exit();
        }
    }

    // Close the database connection
    $conn->close();
}
else {
    // If the 'code' parameter is not set in the URL, redirect to index.html
    header("Location: index.html");
    exit();
}
?>
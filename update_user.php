<?php
include "db_conn.php";

// Function to safely escape input values
function sanitizeInput($input) {
    global $conn;
    return $conn->real_escape_string($input);
}

session_start();

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION["user_id"]; // Assuming you store the user's ID in the session
    $username = sanitizeInput($_POST["username"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Validate password length (optional)
    // Uncomment the following lines if you want to require a minimum password length
    /*
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    */

    // Initialize category variable with existing category value from session
    $category = isset($_SESSION["category"]) ? $_SESSION["category"] : '';

    // Check if an image file is uploaded
    $image = '';
    if ($_FILES["image"]["size"] > 0) {
        $targetDirectory = "uploads/";
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile;
        } else {
            $errors[] = 'Error uploading image.';
        }
    }

    if (empty($errors)) {
        // Check if a new password was provided
        $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : '';

        // Build the SQL query for updating user information
        $sql = "UPDATE users SET username = '$username', email = '$email',";
        if (!empty($hashedPassword)) {
            $sql .= " password = '$hashedPassword',";
        }
        if (!empty($image)) {
            $sql .= " image = '$image',";
        }
        $sql .= " category = '$category' WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            // Success alert
            echo '<div class="alert alert-success" role="alert">
                        User information updated successfully!
                    </div>';

            // Store image information in session before redirecting
            $_SESSION["user_image"] = $image;

            // Update session variables with new user information
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $_SESSION["category"] = $category;
            exit();
        } else {
            // Danger alert
            $errors[] = 'Error: ' . $sql . '<br>' . $conn->error;
        }
    }
    // Display error messages here if needed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Information</title>
    <link rel="icon" href="image/mosque.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        #image-preview {
            max-width: 200px; /* Set the maximum width of the image */
            max-height: 200px; /* Set the maximum height of the image */
            margin: 0 auto; /* Center the image horizontally */
            display: block; /* Ensure proper margin */
            border-radius: 50%; /* Make the image round */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Update User Information</h2>

            <?php
            // Display error messages here if needed
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                }
            }
            ?>

            <form action="update_user.php" method="post" enctype="multipart/form-data">
                <!-- Populate the form fields with the user's current information -->
                <div class="text-center mb-3">
                    <img id="image-preview" src="<?php echo isset($_SESSION["user_image"]) ? $_SESSION["user_image"] : ''; ?>" alt="Profile Picture">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" class="form-control" name="category" required>
                        <option value="admin" <?php echo isset($_SESSION["category"]) && $_SESSION["category"] == "admin" ? 'selected' : ''; ?>>Admin</option>
                        <option value="ala_community" <?php echo isset($_SESSION["category"]) && $_SESSION["category"] == "ala_community" ? 'selected' : ''; ?>>Al-A'la Community</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Profile Picture</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*" onchange="previewImage()">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Update Information</button>
                <a href="index.html" class="btn btn-secondary btn-block">Cancel</a>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
    function previewImage() {
        var input = document.getElementById('image');
        var preview = document.getElementById('image-preview');

        var reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
</script>
</body>
</html>
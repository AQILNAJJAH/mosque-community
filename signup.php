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
    $username = sanitizeInput($_POST["username"]);
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Validate password length
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if (empty($errors)) {
        // Process the uploaded image
        $targetDirectory = "uploads/";
    
        // Create the "uploads" directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
    
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Image uploaded successfully, insert data into the database
            $image = $targetFile;
            $category = sanitizeInput($_POST["category"]); // Get the category value
    
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            // Modify the SQL query to include the category
            $sql = "INSERT INTO users (image, username, email, password, category) VALUES ('$image', '$username', '$email', '$hashedPassword', '$category')";
    
            if ($conn->query($sql) === TRUE) {
                // Success alert
                echo '<div class="alert alert-success" role="alert">
                            Signup successful!
                        </div>';
    
                // Store image information in session before redirecting
                $_SESSION["user_image"] = $image;
    
                // Redirect to login.php after successful signup
                header("Location: login.php");
                exit();
            } else {
                // Danger alert
                $errors[] = 'Error: ' . $sql . '<br>' . $conn->error;
            }
        } else {
            // Danger alert for image upload error
            $errors[] = 'Error uploading image.';
        }
    }    
    // Display error messages here if needed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add these lines to include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Add this line to include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Sign Up Here</title>
    <link rel="icon" href="image/mosque.png" type="image/png">
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('image/masajid.jpg'); /* Replace 'background-image.jpg' with your image file path */
    background-size: cover; /* Cover the entire background */
        }

        .container {
    max-width: 500px; /* Adjust the value as needed */
    margin: 0 auto;
    padding: 50px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    background-color: rgba(255, 255, 255, 0.8);
}


        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #image-container {
    text-align: center;
}

#image-preview {
    max-width: 50%;
    height: auto;
    margin: 0 auto; /* This will center the image horizontally */
    display: block; /* Ensures that margin works properly */
    border-radius: 50%; /* Circular border-radius */
}
     
    </style>
</head>
<body>

<div class="container">
    <h2>Sign Up Here</h2>

    <?php
    // Display error messages here if needed
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
    }
    ?>

    <form action="signup.php" method="post" enctype="multipart/form-data">
        <div id="image-container" style=text-center>
            <img id="image-preview" src="#" alt="">
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
    <label for="category">Category:</label>
    <select id="category" name="category" required>
        <option value="admin">Admin</option>
        <option value="ala_community">Al-A'la Community</option>
    </select>
</div>

        <div class="input-group mb-3">
            <label class="input-group-text" for="image">Profile Picture</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage()">
        </div>

        <div class="form-btn">
            <button type="submit">Sign Up</button>
        </div>
        <div>
            <p>Already registered? <a href="login.php">Login here</a></p>
        </div>
    </form>
</div>

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
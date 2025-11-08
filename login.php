<?php
include "db_conn.php";

// Function to safely escape input values
function sanitizeInput($input) {
    global $conn;
    return $conn->real_escape_string($input);
}

session_start();

$alertMessage = ''; // Initialize an empty string to store alert messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Check if the provided password matches the hashed password in the database
        if (password_verify($password, $row['password'])) {
            // Password is correct, start the session
            $_SESSION["user_id"] = $row["id"]; // Assuming 'id' is the primary key in your 'users' table
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["category"] = $row["category"];

            // Store image information in session
            $_SESSION["user_image"] = $row["image"];

            // Redirect to different pages based on the user's category
            if ($row["category"] == "admin") {
                header("Location: admin/index.php"); // Redirect to admin page
            } elseif ($row["category"] == "ala_community") {
                header("Location: index.html"); // Redirect to Al-A'la Community page
            } else {
                // If the category does not match any known category, handle the error appropriately
                $alertMessage = '<div class="alert alert-danger" role="alert">
                    Unknown category.
                </div>';
            }
            exit();
        } else {
            // Password is incorrect
            $alertMessage = '<div class="alert alert-danger" role="alert">
                Incorrect password.
            </div>';
        }
    } else {
        // Email is not found in the database
        $alertMessage = '<div class="alert alert-danger" role="alert">
            Email not found.
        </div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Users Login</title>
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
            background-image: url('images/masjid2.jpg');
            background-size: cover; 
        }

        .container {
    max-width: 500px; 
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
        <h2>Login Here</h2>

        <?php
        // Display the uploaded image if it exists in the session
        if (isset($_SESSION["user_image"])) {
            $image = $_SESSION["user_image"];
            echo '<div class="text-center">
                      <img id="image-preview" src="' . $image . '" alt="">
                  </div>';
        }
        ?>

        <?php echo $alertMessage; ?> <!-- Display alert message within the container -->

        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <p> <a href="forgot_password.html">Forgot password?</a></p>

            <div>
                <p>Not registered yet? <a href="signup.php">Sign up here</a></p>
            </div>
        </form>
    </div>
</body>
</html>
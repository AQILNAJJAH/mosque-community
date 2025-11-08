<?php
// Process donation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    require_once "includes/conn.php";

    $date = $_POST['date'];
    $total_amount = $_POST['total_amount'];

    // Validate and upload file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $file_size = $_FILES["file"]["size"];
    
    // Check file size (5MB max)
    if ($file_size > 5000000) {
        echo '<div class="alert alert-danger" role="alert">Error: File size exceeds 5MB limit.</div>';
        exit();
    }

    // Allow certain file formats (example: jpg, png, pdf)
    $allowed_types = array("jpg", "jpeg", "png", "pdf");
    if (!in_array($file_type, $allowed_types)) {
        echo '<div class="alert alert-danger" role="alert">Error: Only JPG, JPEG, PNG & PDF files are allowed.</div>';
        exit();
    }

    // Check if file upload is successful
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo '<div class="alert alert-danger" role="alert">Error: File upload failed.</div>';
        exit();
    }

    // Insert donation record into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO donation (date, total_amount, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $date, $total_amount, $target_file);
    
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Donation added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error adding donation: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../image/mosque.png" type="image/png">
    <title>Donation Form</title>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Donation Form</h2>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="total_amount">Total Amount</label>
                            <input type="number" class="form-control" id="total_amount" name="total_amount" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Upload File</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
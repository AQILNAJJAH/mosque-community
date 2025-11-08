<?php
    require_once "includes/conn.php"; 

    // Check if ID is provided
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch donation record
        $sql = "SELECT * FROM donation WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Donation record not found.";
            exit();
        }
    } else {
        echo "Invalid request.";
        exit();
    }

    // Handle form submission to update record
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $date = $_POST['date'];
        $total_amount = $_POST['total_amount'];
        $file_path = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];

        // Handle file upload
        if (!empty($file_path)) {
            $upload_dir = "uploads/";
            $file_path = $upload_dir . basename($file_path);
            if (!move_uploaded_file($temp_name, $file_path)) {
                echo "Error uploading file.";
                exit();
            }
        } else {
            $file_path = $row['file_path'];
        }

        // Update record in the database
        $updateSql = "UPDATE donation SET date=?, total_amount=?, file_path=? WHERE ID=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("sdsi", $date, $total_amount, $file_path, $id);

        if ($stmt->execute()) {
            // Redirect to view page after successful update
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="icon" href="../image/mosque.png" type="image/png">
  <title>Edit Donation Record</title>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Edit Donation Record</h2>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['date']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="total_amount">Total Amount</label>
                            <input type="number" class="form-control" id="total_amount" name="total_amount" value="<?php echo $row['total_amount']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Upload File</label>
                            <input type="file" class="form-control-file" id="file" name="file">
                            <p>Current file: <a href="<?php echo $row['file_path']; ?>" download>Download</a></p>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Update</button>
                        <a href="index.php" class="btn btn-default btn-block">Cancel</a>
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
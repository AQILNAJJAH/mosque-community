<?php
    require_once "includes/conn.php"; 

    // Check if ID is provided
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch booking record
        $sql = "SELECT * FROM bookings_record WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Booking record not found.";
            exit();
        }
    } else {
        echo "Invalid request.";
        exit();
    }

    // Handle form submission to update record
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $date = $_POST['date'];

        // Update record in the database
        $updateSql = "UPDATE bookings_record SET FIRSTNAME=?, MIDDLENAME=?, LASTNAME=?, PHONE=?, EMAIL=?, DATE=? WHERE ID=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ssssssi", $firstname, $middlename, $lastname, $phone, $email, $date, $id);

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
  <title>Edit Booking Record</title>
  <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2>Edit Booking Record</h2>
    <form method="POST">
      <div class="form-group">
        <label for="firstname">First Name:</label>
        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row['FIRSTNAME']; ?>">
      </div>
      <div class="form-group">
        <label for="middlename">Middle Name:</label>
        <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo $row['MIDDLENAME']; ?>">
      </div>
      <div class="form-group">
        <label for="lastname">Last Name:</label>
        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['LASTNAME']; ?>">
      </div>
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['PHONE']; ?>">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['EMAIL']; ?>">
      </div>
      <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['DATE']; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="index.php" class="btn btn-default">Cancel</a>
    </form>
  </div>
</body>
</html>

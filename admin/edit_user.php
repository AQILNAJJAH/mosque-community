<?php
include "includes/conn.php";
$id = "";
$username = "";
$category = "";
$email = "";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (!isset($_GET['id'])) {
        header("location:edit_user.php");
        exit;
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if (!$row) {
        header("location:edit_user.php");
        exit;
    }
    $username = $row["username"];
    $category = $row["category"];
    $email = $row["email"];
} else {
    $id = $_POST["id"];
    $username = $_POST["name"];
    $category = $_POST["category"];
    $email = $_POST["email"];

    if ($_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];

        // Move uploaded image to a desired folder
        move_uploaded_file($image_temp, "$image");

        // Update query with the image field
        $sql = "UPDATE users SET username='$username', category='$category', email='$email', image='$image' WHERE id='$id'";
    } else {
        // If no new image uploaded, update without changing the image field
        $sql = "UPDATE users SET username='$username', category='$category', email='$email' WHERE id='$id'";
    }

    $result = $conn->query($sql);
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>EDIT USERS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.html">AL-A'LA COMMUNITY</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../add_user.php"><span style="font-size:larger;">Add New</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="col-lg-6 m-auto">
    <form method="post" enctype="multipart/form-data">
        <br><br>
        <div class="card">
            <div class="card-header bg-primary">
                <h1 class="text-white text-center"> Edit Member </h1>
            </div>
            <br>

            <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control"> <br>

            <label> Name: </label>
            <input type="text" name="name" value="<?php echo $username; ?>" class="form-control"> <br>

            <label> ID: </label>
            <input type="text" name="id" value="<?php echo $id; ?>" class="form-control" placeholder="Enter ID" readonly> <br>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" disabled>
                    <option value="admin" <?php echo $category == "admin" ? 'selected' : ''; ?>>Admin</option>
                    <option value="ala_community" <?php echo $category == "ala_community" ? 'selected' : ''; ?>>Al-A'la Community</option>
                </select>
                <input type="hidden" name="category" value="<?php echo $category; ?>">
            </div>

            <br><label> Email: </label>
            <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"> <br>

            <label> Image: </label>
            <input type="file" name="image" class="form-control"> <br>

            <button class="btn btn-success" type="submit" name="submit"> Submit </button>
            <a class="btn btn-info" type="submit" name="cancel" href="index.php"> Cancel </a><br>
        </div>
    </form>
</div>
</body>
</html>
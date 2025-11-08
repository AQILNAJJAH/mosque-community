<?php
include 'db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search User</title>
    <link rel="icon" href="image/mosque.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Optional: Add your custom styles here -->
    <style>
        
        body {
    background: url('image/m.webp') center center fixed;
    background-size: cover;
}

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }

        .btn-dark {
            background-color: #343a40;
            border-color: #343a40;
        }

        .btn-dark:hover {
            background-color: #1d2124;
            border-color: #1d2124;
        }

        .table {
            margin-top: 20px;
        }

        h2 {
            color: #dc3545;
        }
    </style>
</head>
<body>
    
<div class="container my-5">
    <form method="post">
        <input type="text" placeholder="Search Data" name="search">
        <button class="btn btn-dark btn-sm" name="submit">Search</button>
</form>
<div class="container my-5">
    <table class="table">
        <?php
        if(isset($_POST['submit'])){
            $search=$_POST['search'];

            $sql="Select * from `users` where id like '%$search%' or username like '%$search%'";
            $result=mysqli_query($conn, $sql);
            if($result){
            if(mysqli_num_rows($result)>0){
                echo '<thead>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Category</th>
                </tr>
                </thead>
                ';
                while($row=mysqli_fetch_assoc($result)){
                echo '<tbody>
                <td><a href="searchData.php?data='.$row['id'].
                '">'.$row['id'].'</a></td>
                <td>'.$row['username'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['category'].'</td>
                <tr>

                </tr>
                </tbody>';
                }

            }else{
                echo '<h2 class=:text-danger>Data not found</h2>';
            }
            }
        }
        ?>
    </table>
    <a class="btn btn-dark btn-md" href="delete_user.php" role="button">BACK</a>
</div>
</body>
</html>
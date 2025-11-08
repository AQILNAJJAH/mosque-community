<?php include 'change_password_process.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="icon" href="image/mosque.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
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
           background-image: url('download.jpg'); 
           background-size: cover; 
        }

       .container {
            max-width: 500px; /* Adjust the value as needed */
            margin: 0 auto;
            padding: 50px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            background-color: rgba(255, 255, 255, 0.8);
        }


        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

   </style>
    <div class="container p-3 border border-5 rounded-3" style="width: 40%">
        <h1 class="display-6 text-center p-2 bg-light">
            Change Password
        </h1>
        <form action="" method="post">
            <div class="row mb-3 justify-content-md-center">
                <label for="inputEmail" class="col-4 col-form-label">Email</label>
                <div class="col-lg-auto">
                    <input type="email" name="email" id="inputEmail" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3 justify-content-md-center">
                <label for="inputPassword" class="col-4 col-form-label">New Password</label>
                <div class="col-lg-auto">
                    <input type="password" name="new_password" id="inputPassword" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3 justify-content-md-center">
                <div class="col-8">
                    <button type="submit" class="btn btn-primary" name="change">Change</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
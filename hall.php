<?php
include 'db_conn.php';

//Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    //prepare and execute the database insertion
    $sql = "INSERT INTO `hall`(`name`, `email`, `phone`, `start_date`, `end_date`)
     VALUES ('$name','$email','$phone','$start_date','$end_date')";

     if($conn->query($sql) == TRUE){
        echo "Booking Successfully";
     }else{
        echo "Error: " .$sql . "<br>" .$conn->error; 
     }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hall Booking Form</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" href="image/mosque.png" type="image/png">
</head>
<body>
    <div class="background">
        <div class="booking-form">
            <h2>Dewan Al-A'la Booking Form</h2>
            <form action="hall.php" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
 
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
           
                <label for="destination">Phone Number:</label>
                <input type="text" name="phone" id="destination" required>
           
                <label for="departure-date">Event Date (Start):</label>
                <input type="date" name="start_date" id="start_date" required>
               
                <label for="return-date">Event Date (End):</label>
                <input type="date" name="end_date" id="end_date" required>

                <button type="submit">Book Now</button>
            </form>
        </div>
    </div>
</body>
</html>

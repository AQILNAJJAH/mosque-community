<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "mosque";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, 3308);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
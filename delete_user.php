<?php
include "db_conn.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE from `users` where id=$id";
    $conn->query($sql);
}
header('Location: http://localhost/fyp/admin/index.php');
exit;
?>
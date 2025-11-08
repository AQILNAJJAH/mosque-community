<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
@include 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}
?>

<header class="header">

   <div class="flex">

      <a href="#" class="logo">HAJJ/UMRAH ESSENTIALS</a>

      <nav class="navbar">
      <a href="admin/index.php">home</a>
         <a href="admin.php">add products</a>
         <a href="admin_orders.php">view orders</a>
      </nav>

   </div>

</header>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
@include 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$select_cart_count = mysqli_query($conn, "SELECT COUNT(*) AS cart_count FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
$cart_count = mysqli_fetch_assoc($select_cart_count)['cart_count'];
?>

<header class="header">

   <div class="flex">

      <a href="#" class="logo">HAJJ/UMRAH ESSENTIALS</a>
      

      <nav class="navbar"> 
        <a href="index.html">Home</a>
        <a href="products.php">view products</a>
        
      </nav>

      <a href="cart.php" class="cart">
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    <span class="cart-count"><?php echo $cart_count; ?></span>
</a>
<style>
   .cart {
    position: relative;
    display: inline-block;
}

.cart-count {
    position: absolute;
    top: -10px; /* Adjust as needed */
    right: -10px; /* Adjust as needed */
    background-color: red; /* Background color for visibility */
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px; /* Smaller font size */
    line-height: 1;
}
</style>

      <div id="menu-btn" class="fas fa-bars"></div>

   </div>

</header>
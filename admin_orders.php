<?php
@include 'db_conn.php';

session_start();

// Handle order deletion
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `order` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Orders</title>
   <link rel="icon" href="image/mosque.png" type="image/png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .orders .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
         gap: 1.5rem;
         margin-top: 2rem;
      }

      .orders .box {
         background: #fff;
         border-radius: 5px;
         box-shadow: 0 5px 15px rgba(0,0,0,.1);
         padding: 1.5rem;
         text-align: left;
         border: 1px solid #ccc;
      }

      .orders .box p {
         margin-bottom: 1rem;
         font-size: 1.2rem;
         color: #333;
      }

      .orders .box p span {
         font-weight: bold;
         color: #555;
      }

      .orders .box .delete-btn {
         display: inline-block;
         margin-top: 1rem;
         background: #e74c3c;
         color: #fff;
         padding: .75rem 1.5rem;
         border-radius: 5px;
         text-decoration: none;
         transition: background .3s ease;
      }

      .orders .box .delete-btn:hover {
         background: #c0392b;
      }

      .empty {
         text-align: center;
         font-size: 1.5rem;
         color: #999;
      }
   </style>
</head>
<body>

<?php include 'header_a.php'; ?>

<div class="container">

<section class="orders">

   <h1 class="heading">Orders</h1>

   <div class="box-container">

      <?php
         $select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
         if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> Order ID : <span><?php echo $fetch_orders['id']; ?></span> </p>
         <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Address : <span><?php echo $fetch_orders['flat'].', '.$fetch_orders['street'].', '.$fetch_orders['city'].', '.$fetch_orders['state'].', '.$fetch_orders['country'].' - '.$fetch_orders['pin_code']; ?></span> </p>
         <p> Payment Method : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> Products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Total Price : <span>RM<?php echo number_format($fetch_orders['total_price'], 2); ?></span> </p>
         <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No orders placed yet!</p>';
      }
      ?>

   </div>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
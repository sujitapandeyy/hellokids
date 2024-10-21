<?php

require('connection.php');

session_start();
$user_email = $_SESSION['useremail'];

if (!isset($_SESSION['username'])) {
    header('location:login.php?error=You need to Login first!!');
    exit(); // Add exit after redirecting to prevent further execution
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style/order.css?v=2.1">

   <title>Order</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
        
        .error-container {
         /* text-align: center; */
         /* margin: 10px 0; */
         }

      .error-container.success {
         background-color: lightgreen;
          }

      .error-container.failed {
         background-color: lightcoral;
         }
    
    </style>

</head>
<body>
   

<section class="heading">
    <h2>Order History</h2>
    <br/>
    <a href="index.php" class="option-btn">Home</a>
    
</section>

<section class="displayorder">
    <?php
        $total_orders = 0;
        $select_orders = mysqli_query($con, "SELECT * FROM `orders` WHERE email = '$user_email'") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_order = mysqli_fetch_assoc($select_orders)){
            $total_orders++;
    ?>    
    <p> Order <?php echo $total_orders ?>: <?php echo $fetch_order['placedon'];echo $fetch_order['totalproduct'] ?> <span>(Total Price: <?php echo 'Rs'.$fetch_order['totalprice'].'/-' ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">No order history available</p>';
        }
    ?>
</section>

<section class="checkout">
    <!-- Add any additional content or functionality here if needed -->
</section>

</body>
</html>

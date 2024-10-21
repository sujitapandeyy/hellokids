<?php

require('connection.php');







session_start();
$user_id = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
    header('location:login.php?error=You need to Login first!!');
} else {
    $email = $_SESSION['useremail'];
}

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $method = mysqli_real_escape_string($con, $_POST['method']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $placed_on = date('Y-m-d');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE username = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($con, "SELECT * FROM `orders` WHERE username = '$user_id' AND phone = '$phone' AND email = '$email' AND method = '$method' AND address = '$address' AND totalproduct = '$total_products' AND totalprice = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        header("Location: order.php?error=your cart is empty!");

    }elseif(mysqli_num_rows($order_query) > 0){
        header("Location: order.php?error=order placed already!");
    }else{

        // mysqli_query($con, "INSERT INTO `orders`(username, phone, email, method, address,city, totalproduct, totalprice, placedon) VALUES('$user_id', '$phone', '$email', '$method', '$address', '$city', '$total_products', '$cart_total', '$placed_on')") or die('query failed');

        $insert_query = "INSERT INTO `orders` (username, phone, email, method, address,city, totalproduct, totalprice, placedon) VALUES('$user_id', '$phone', '$email', '$method', '$address', '$city', '$total_products', '$cart_total', '$placed_on')";
    
        if (mysqli_query($con, $insert_query)) {

            
            // Update product quantities in the product
        $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE email = '$email'") or die('query failed');
        if (mysqli_num_rows($cart_query) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                $product_id = $cart_item['id'];
                $cart_quantity = $cart_item['quantity'];
                mysqli_query($con, "UPDATE `products` SET stock = stock - '$cart_quantity' WHERE pid = '$product_id'") or die('query failed');
            }
        }
            // Clear the cart after successful order placement
            mysqli_query($con, "DELETE FROM `cart` WHERE email = '$email'") or die('query failed');
            header("Location: order.php?error=Order placed successfully!");
            
        } else {
            header("Location: order.php?error=Failed to place order. Please try again.");
        }
    }
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
    <h2>Checkout Order</h2>
    <br/>
    <a href="index.php" class="option-btn">Home</a>
    
</section>

<section class="displayorder">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE username = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo 'Rs'.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">grand total : <span>Rs. <?php echo $grand_total; ?>/-</span></div>
</section>

<section class="checkout">

    <form action="" method="POST" >

        <h3>Place Your Order</h3>

        <div class="flex">
        <?php if(isset($_GET['error'])): ?>
      <?php
      $errorMessage = $_GET['error'];
      $errorClass = ($errorMessage === 'Order placed successfully!') ? 'success' : 'failed';
      ?>
      <div class="error-container <?php echo $errorClass; ?>">
         <p class="formerror"><?php echo $errorMessage; ?></p>
      </div>
      <?php endif;
      $select_user = mysqli_query($con, "SELECT * FROM `registered_user` WHERE email = '$email'") or die('query failed');
                $registered_user = mysqli_fetch_assoc($select_user);
                ?>
                <div class="input">
                    <span>Full Name :</span>
                    <input type="hidden" name="Full_name" class="box" value="<?php echo isset($registered_user['Full_name']) ? $registered_user['Full_name'] : ''; ?>" required>
                    <?php echo isset($registered_user['Full_name']) ? $registered_user['Full_name'] : ''; ?>
                </div>
                <div class="input">
                    <span>Email :</span>
                    <input type="hidden" name="email" class="box" value="<?php echo isset($registered_user['Email']) ? $registered_user['Email'] : ''; ?>" required>
                    <span><?php echo isset($registered_user['Email']) ? $registered_user['Email'] : ''; ?></span>
                </div>
            <div class="inputBox">
                <span>Phone number :</span>
                <input type="number" name="phone" min="0" placeholder="Enter your number">
            </div>
            <div class="inputBox">
                <span>Payment Method :</span>
                <select name="method">
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit card">credit card</option>
                    <option value="paypal">paypal</option>
                    <option value="paytm">paytm</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Address:</span>
                <input type="text" name="address" placeholder="e.g. Sorakhutte-3.">
            </div>
            
            <div class="inputBox">
                <span>City :</span>
                <input type="text" name="city" placeholder="e.g. kathmandu">
           
        </div>

        <input type="submit" name="order" value="order now" class="btn">

    </form>

</section>








</body>
</html>
<?php

require('connection.php');




session_start();

$user_id = $_SESSION['username'];

if(!isset($user_id)){
   header('Location: login.php?error=Login first');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('Location: cart.php?error=Deleted successfully!!');

}

if(isset($_GET['delete_all'])){
    mysqli_query($con, "DELETE FROM `cart` WHERE username = '$user_id'") or die('query failed');
    header('Location: cart.php?error=All Product Deleted successfully!!');
};

// if(isset($_POST['update_quantity'])){
//     $cart_id = $_POST['cart_id'];
//     $cart_quantity = $_POST['cart_quantity'];
//     mysqli_query($con, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
//     header('Location: cart.php?error=Quantity Updated successfully!!');
// }

if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    $product_availableQuantity = $_POST['product_availableQuantity'];
    
    if ($cart_quantity > $product_availableQuantity) {
        header("Location: cart.php?error=Requested quantity exceeds available quantity in stock!!!");
        exit();
    } else {
        mysqli_query($con, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
        header("Location: cart.php?error=Cart quantity updated!");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style/cart.css?v=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/dashboard.css">

</head>
<body>
   
<section class="heading">
    <h3>Shopping Cart</h3>
    <a href="index.php" class="option-btn">Home</a>
    <a href="history.php" class="option-btn">History</a>
</section>

<section class="shopping-cart">

    <h1 class="title">Products added</h1>

    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE username = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                        $product_id = $fetch_cart['id'];
                        $select_product = mysqli_query($con, "SELECT stock FROM `products` WHERE pid = '$product_id'") or die('query failed');
                        if(mysqli_num_rows($select_product) > 0) {
                            $fetch_product = mysqli_fetch_assoc($select_product);
                            $product_availableQuantity = $fetch_product['stock'];
                        }
                        else {
                            $product_availableQuantity = 0;
                        }
    ?>
    <div  class="box">
        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_cart['name']; ?></div>
        <div class="price">Rs<?php echo $fetch_cart['price']; ?>/-</div>
        <form action="" method="post">
        <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
                <input type="hidden" name="product_availableQuantity" value="<?php echo $product_availableQuantity; ?>">
                <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
                <input type="submit" value="Update" class="option-btn" name="update_quantity">
             </form>
        <div class="sub-total"> sub-total : <span>Rs <?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
    </div>
    <?php
    $grand_total += $sub_total;
        }
    }else{
        echo '<p class="empty">your cart is empty</p>';
    }
    ?>
    </div>

    <div class="more-btn">
        <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from cart?');">delete all</a>
    </div>

    <div class="cart-total">
        <p>GRAND TOTAL : <span>Rs<?php echo $grand_total; ?>/-</span></p>
        <a href="browse.php" class="option-btn">continue shopping</a>
        <a href="order.php?" class="btn  <?php echo ($grand_total > 1)?'':'disabled' ?>">Order Now!!</a>
    </div>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
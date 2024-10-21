<?php
@include 'connection.php';

session_start();
if (isset($_SESSION['username'])) {
    $email = $_SESSION['useremail'];
    $username = $_SESSION['username'];
}


$error = ''; // Initialize error variable

if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_brand = $_POST['product_brand'];
    $product_quantity = $_POST['product_quantity'];
    // Check if the entered quantity exceeds the available stock
    $select_stock = mysqli_query($con, "SELECT stock FROM `products` WHERE pid = '$product_id'") or die('query failed');
    $fetch_stock = mysqli_fetch_assoc($select_stock);
    $available_stock = $fetch_stock['stock'];

    if ($product_quantity > $available_stock) {
        $error = "Quantity exceeds available stock";
    } else {
        $check_cart_numbers = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name' AND username = '$username'") or die('query failed');

        if (mysqli_num_rows($check_cart_numbers) > 0) {
            $error = "Already added to cart";
        } else {
            mysqli_query($con, "INSERT INTO `cart`( username,email,id, name, price, quantity,brand, image) VALUES('$username','$email','$product_id', '$product_name', '$product_price', '$product_quantity','$product_brand', '$product_image')") or die('query failed');
            $error = "Product added to cart";
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
   <title>search page</title>
   <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favIcon.png" type="image/png">
    <link rel="stylesheet" href="style/search.css?v=1.1">
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
    <h3>Search Section</h3>
    <p> <a href="index.php" > <i class="fas fa-home" style="color: palevioletred";></i></a> &nbsp; &nbsp;
    <a href="cart.php" ><i class="fa-solid fa-cart-shopping" style="color: palevioletred";></i></a></p>

</section>

<section class="quick-view">
    <?php
    if(isset($_GET['error'])): ?>
        <?php
        $errorMessage = $_GET['error'];
        $errorClass = ($errorMessage === 'Product added to cart') ? 'success' : 'failed';
        ?>
        <div class="error-container <?php echo $errorClass; ?>">
            <p class="formerror"><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>
      <?php
        if(isset($_POST['search'])){
         $search_box = mysqli_real_escape_string($con, $_POST['searchKeyword']);
         $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image"><br/>
         <div class="name"><label class="label">Name: </label><?php echo $fetch_products['name']; ?></div>
        <div class="type"><label class="label">Categories: </label><?php echo $fetch_products['categories']; ?></div>
        <div class="type"><label class="label">Brand: </label><?php echo $fetch_products['brand']; ?></div>
          <div class="price"><label class="label">Price: </label>₹<?php echo $fetch_products['price']; ?>/-</div>
          <div class="stock"><label class="label">Stock available: </label><?php echo $fetch_products['stock']; ?></div>
        <div class="details"><label class="label">Description: </label><?php echo $fetch_products['details']; ?></div>
        <!-- <input type="number" name="product_quantity" value="1" min="0" class="qty"><br/> -->
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['pid']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_type" value="<?php echo $fetch_products['categories']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_brand" value="<?php echo $fetch_products['brand']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <!-- <input type="submit" value="add to cart" name="add_to_cart" class="btn"> -->

         <?php
                if(isset($_SESSION['loggedin']) ==true)    
                {
                    echo'<input type="number" name="product_quantity" value="1" min="0" class="qty"><br/>';
                        echo'<input type="submit" value="add to cart" name="add_to_cart" class="btn">';
                }
                
             ?>

      </form>
    <?php
            }
        }else{
        echo '<p class="empty">no products details available!</p>';
        }
        
    }
    ?>

    <div class="option-btn">
        <a href="browse.php" class="option">Continue Shopping</a>
    </div>

</section>

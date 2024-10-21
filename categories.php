<?php
require('connection.php');
session_start();
$username=$_SESSION['username'];
if(isset($_SESSION['username'])){
    $email = $_SESSION['useremail'];
}
// else{
//     header("Location: login.php?error=Login first");
// }?>
 <?php




if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_brand = $_POST['product_brand'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    // $check_cart_numbers = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name'") or die('query failed');
    $check_cart_numbers = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name' AND username = '$username'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        // "error=Already added to cart";
        header("Location: categories.php?error=Already added to cart");
        
    }else{
        
        
        mysqli_query($con, "INSERT INTO `cart`(email,id, name, price, quantity, image,brand,username) VALUES('$email','$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image', '$product_brand','$username')") or die('query failed');
        // $message[] = 'product added to cart';
        header("Location: categories.php?error=product added to cart");
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>product</title>
   <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favIcon.png" type="image/png">
    <link rel="stylesheet" href="style/categories.css?v=3.0">
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
    <h3>Categories</h3>
    <p> <a href="index.php">home</a></p>
</section>

<section class="Category" id="Category">
    
    <section id="categoryquick-cont">
        <?php
        $select_products = mysqli_query($con, "SELECT MIN(pid) as pid, name, categories, details, price, MIN(image) as image FROM `products` GROUP BY categories") or die('query failed');
        
        if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
                ?>
        <form action="" method="POST" class="box">
        <!-- <div onclick="window.location.href='categories.php#<?php echo $fetch_products['categories']; ?>'"> -->
        <!-- <div onclick="window.location.href='categories.php#<?php echo $fetch_products['categories']; ?>&pid=<?php echo $fetch_products['pid']; ?>'"> -->
        <div onclick="redirectToCategory('<?php echo $fetch_products['categories']; ?>')">

            <div id="quick-img">
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image" height="50">
                <h3><div class="type"><?php echo $fetch_products['categories']; ?></div></h3>
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['categories']; ?>">
                <!-- Additional input fields or buttons can go here -->
            </div>
        </div>
        </form>
        
        <script>
    function redirectToCategory(category) {
        window.location.href = 'categories.php#category=' + encodeURIComponent(category);
    }
</script>
        <?php
            }
        } else {
            echo '<p class="empty">No categories available yet!</p>';
        }
        ?>
       
    </section>

    <div class="more-btn">
        <!-- <a href="shop.php" class="option-btn">load more</a> -->
    </div>
</section>



<section class="heading">
    <h3>Products</h3>
</section>
<!-- <section class="products"> -->
    <section class="Category" id="Category">
        
        
        <?php
    if(isset($_GET['error'])): ?>
      <?php
      $errorMessage = $_GET['error'];
      $errorClass = ($errorMessage === 'product added to cart'||$errorMessage === 'Product added to cart') ? 'success' : 'failed';
      ?>
      <div class="error-container <?php echo $errorClass; ?>">
        <p class="formerror"><?php echo $errorMessage; ?></p>
    </div>
    <?php endif; ?>
    <!-- <div class="box"> -->
        <?php
        $select_products = mysqli_query($con, "SELECT * FROM `products` ORDER BY categories") or die('query failed');
        $currentType = null;
        
        if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
                // if ($fetch_products['categories'] != $currentType) {
                //     // New product type encountered, display heading
                //     echo '<h2 class="type-heading">' . $fetch_products['categories'] . '</h2>';
                //     $currentType = $fetch_products['categories'];
                // }
                ?>
        <section id="quick-cont">
    <form action="" method="POST" class="box">
    <!-- <div onclick='window.location.href="categories.php"'> -->
    <div onclick="window.location.href='view.php?pid=<?php echo $fetch_products['pid']; ?>'">
    <div id="quick-img">
        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image" >
        <div class="price">₹<?php echo $fetch_products['price']; ?>/-</div>
        <div class="name"><?php echo $fetch_products['name']; ?></div>
        <div class="brand"><?php echo $fetch_products['brand']; ?></div>
        <div class="type"><?php echo $fetch_products['categories']; ?></div>
        <input type="hidden" name="product_id" value="<?php echo $fetch_products['pid']; ?>">
        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
        <input type="hidden" name="product_brand" value="<?php echo $fetch_products['brand']; ?>">
        <input type="hidden" name="product_type" value="<?php echo $fetch_products['categories']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
        
        <?php
            if(isset($_SESSION['loggedin']) == true) {
                echo '<input type="number" name="product_quantity" value="1" min="0" class="qty"><br/>';
                echo '<input type="submit" value="add to cart" name="add_to_cart" class="btn">';
            }
        ?>
       
        </div>
        </div>
    
    </form>
    
</section>
    <?php
        }
    } else {
        echo '<p class="empty">no products added yet!</p>';
    }
    ?>
</div>


   </div>

</section>






<?php @include 'footer.php'; ?>

<!-- <script src="js/script.js"></script> -->

</body>
</html>
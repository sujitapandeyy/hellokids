<?php
@include 'connection.php';

session_start();
if (isset($_SESSION['username'])) {
    $email = $_SESSION['useremail'];
}

$username = $_SESSION['username'];

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
    <title>Quick View</title>
    <link rel="stylesheet" href="style/view.css?v=2.1">
</head>

<body>

<section class="heading">
    <h3>Product Details</h3>
   
</section>

    <section class="quick-view">

        <?php if (!empty($error)) : ?>
            <div class="error-container <?php echo ($error === 'Product added to cart') ? 'success' : 'failed'; ?>">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE pid = '$pid'") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                    <div id="quick">
                        <form action="" method="POST">
                            <div class="product-details">
                            <div class="product-image">
                                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                            </div>
                                <div class="name"><span class="label">Name:</span> <?php echo $fetch_products['name']; ?></div>
                                <div class="type"><span class="label">Categories:</span> <?php echo $fetch_products['categories']; ?></div>
                                <div class="type"><span class="label">Brand:</span> <?php echo $fetch_products['brand']; ?></div>
                                <div class="price"><span class="label">Price:</span> Rs<?php echo $fetch_products['price']; ?>/-</div>
                                <div class="stock"><span class="label">Stock available:</span> <?php echo $fetch_products['stock']; ?></div>
                                <div class="details"><span class="label">Description:</span> <?php echo $fetch_products['details']; ?></div>
                            </div>
                           
                            <input type="hidden" name="product_id" value="<?php echo $fetch_products['pid']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                            <input type="hidden" name="product_type" value="<?php echo $fetch_products['categories']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                            <input type="hidden" name="product_brand" value="<?php echo $fetch_products['brand']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                            <div style="display:flex">
                            <?php
                            if (isset($_SESSION['loggedin']) == true) {
                                echo '<input type="number" name="product_quantity" value="1" min="0" class="qty"><br/>'; echo"&nbsp"; echo"&nbsp"; echo"&nbsp";
                                echo '<input type="submit" value="add to cart" name="add_to_cart" class="btn">';
                            }
                           ?>
                             
                         
                            
                        </form>
                        </div>
        <?php
                }
            } else {
                echo '<p class="empty">no products details available!</p>';
                ?>
            
        <?php
            }
        }
        ?>

        <div class="option-btn">
            <a href="browse.php" class="option-btn">Back</a>
        </div>

    </section>

</body>

</html>


<?php

require('connection.php');
session_start();

if(!isset($_SESSION['Adminname'])){
    header("Location: login.php?error=Login first");
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($con, $_POST['name']);
   $stock = mysqli_real_escape_string($con, $_POST['stock']);
   $brand = mysqli_real_escape_string($con, $_POST['brand']);
   $type = mysqli_real_escape_string($con, $_POST['type']);
   $price = mysqli_real_escape_string($con, $_POST['price']);
   $details = mysqli_real_escape_string($con, $_POST['details']);

   mysqli_query($con, "UPDATE `products` SET name = '$name',stock = '$stock', brand = '$brand', categories = '$type', details = '$details', price = '$price' WHERE pid = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;
   $old_image = $_POST['update_p_image'];
   
   if(!empty($image)){
      if($image_size > 2000000){
        //  $message[] = 'image file size is too large!';
         header("Location: Adminproduct.php?error=image file size is too large!");

      }else{
         mysqli_query($con, "UPDATE `products` SET image = '$image' WHERE pid = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folter);
         unlink('uploaded_img/'.$old_image);
        //  $message[] = 'image updated successfully!';
         header("Location: Adminproduct.php?error=image updated successfully!");

      }
   }

//    $message[] = 'product updated successfully!';
   header("Location: Adminproduct.php?error=product updated successfully!");


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <link rel="stylesheet" href="style/dashboard.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


</head>
<body>
   
<?php @include 'adminheader.php'; ?>

<section class="update-product">

<?php

   $update_id = $_GET['update'];
   $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE pid = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>

<form action="" method="post" enctype="multipart/form-data">
<h1 class="title">Update Product</h1>

<?php if(isset($_GET['error'])): ?>
      <?php
      $errorMessage = $_GET['error'];
      $errorClass = ($errorMessage =='product updated successfully!') ? 'success' : 'failed';
      ?>
      <div class="error-container <?php echo $errorClass; ?>">
         <p class="formerror"><?php echo $errorMessage; ?></p>
      </div>
      <?php endif; ?>
   <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="image"  alt=""><span class="formerror" height="10"></span>
   <input type="hidden" value="<?php echo $fetch_products['pid']; ?>" name="update_p_id"><span class="formerror"></span>
   <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image"><span class="formerror" ></span>
   <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="update product name" name="name"><span class="formerror"></span>
   <input type="text" class="box" value="<?php echo $fetch_products['brand']; ?>" required placeholder="update product brand" name="brand"><span class="formerror"></span>
   <select  class="box" name="type"  placeholder="Enter product type" required>

   <option value="Baby Grooming">Baby Grooming</option>
        <option value="Baby Clothing">Baby Clothing </option>
        <option value="Baby shampoo And Oil">Baby shampoo And Oil </option>
        
        <option value="Others">Others</option>
    </select> <span class="formerror"></span>
    <!-- <input type="text" class="box" value="<?php echo $fetch_products['brand']; ?>" required placeholder="Update brand name" name="name"><span class="formerror"></span> -->
      <input type="number" min="0" class="box" value="<?php echo $fetch_products['stock']; ?>" required placeholder="Update product Stock" name="stock"><span class="formerror"></span>
      <!-- <input type="text" value="<?php echo $fetch_products['brand']; ?>" required placeholder="Update product brand" name="stock"><span class="formerror"></span> -->
   

   <input type="number" min="0" class="box" value="<?php echo $fetch_products['price']; ?>" required placeholder="update product price" name="price"><span class="formerror"></span>
   <textarea name="details" class="box" required placeholder="update product details" cols="30" rows="10"><?php echo $fetch_products['details']; ?></textarea><span class="formerror"></span>
   <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image"><span class="formerror"></span>
   <input type="submit" value="Update " name="update_product" class="option-btn">
   <a href="Adminproduct.php" class="delete-btn">Cancel</a>
</form>

<?php
      }
   }else{
      echo '<p class="empty">no update product select</p>';
   }
?>

</section>


</body>
</html>
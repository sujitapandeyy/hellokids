<?php
require('connection.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head> 
<script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favIcon.png" type="image/png">
    <link rel="stylesheet" href="style/index.css">
</head>
<body>

    <section id="header">
        <a href="#"><img src="img/hellokids.jpg" class="logo" height="50px" alt=""> </a>
        <div class="search-box">
            <form>
                <input type ="text" name ="search" id ="srch" placeholder="Search">
                <button type ="submit"><i class="fa fa-search"></i></button>
            </form>
         </div>
        <div>

            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="About.php">About</a></li>
                <li><a href="product.php">Categories</a></li>
                <li><a href="FAQs.php">FAQs</a></li>
                <!-- <li><a href="contact.php">contact</a></li> -->

                <?php
                if(isset($_SESSION['loggedin']) ==true)    
                {
                        echo'<li><a href="logout.php">Logout</a></li>';
                }
                else{
                    echo'<li><a href="login.php">Login</a></li>';
                     }
                    ?>
            
            

                <!-- <li><a href="login.php">Login</a></li> -->
               <li> <a href="cart.php"> <i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
         </div>
    </section>
</body>
</html>
<!-- 
<?php
                // if(isset($_SESSION['loggedin']) ==true)    
                // {
                        // echo"<li><a id='user_btn' class='fas fa-user'>Logout</a></li>";
                // }
                // else{
                    // echo"<li><a id='lr_btn' class='fas fa-user'></a></li>";
                    //  }
                ?>
               <li> <a href="#MainCart"> <i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
    </section>
    <div class="loginregister-box">
        <a href="login.php" class="delete-btn">Login</a>
        <a href="register.php" class="delete-btn">Register</a>
    </div> -->

    <!-- also user logout popup box manage  -->
    <!-- <script src="user.js"></script>
    <script src="js/admin.js"></script> -->

<?php
require('connection.php');
session_start();
    // if(!isset($_SESSION['email'])){
    //     header("Location: login.php?error=Login first");
    // }
    ?><html lang="en">
    <head>
        <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
        <!-- <link rel="stylesheet" href="index.css"> -->
        <link rel="stylesheet" href="style/index.css?v=4.9"/>

        <title>Document</title>
    
    </head>
    <body>
        <!-- nav-->
        <section id="Home">
        <div class="navbar">
            <div class="navdiv">
            <img src="img/hellokk.png" class="imgmain" height="70px">
            <div class="searchbox">
            <!-- <form>
                <input type ="text" name ="search" id ="srch" placeholder="Search">
                <button type ="submit"><i class="fa fa-search"></i></button>
            </form> -->

            <form action="search.php" method="POST">

                <input type="text" name="searchKeyword" id="search-input" placeholder="Search">
                <button type="submit" name="search" class="search-icon"><i class="fas fa-search"></i></button>
            </form>

         </div>
        <div>
            <ul>
                <li><a href="#Home">Home</a></li>
                <li><a href="#About">About</a></li> 
                <li><a href="#Category">Category</a></li>
                <li><a href="#Contact">Contact</a></li>
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
            </ul>
            </div>
            
        </div>
        <div class="img">
            <div class="overlay">
                <h1>MUST-HAVES <br>FOR YOUR BABY</h1>
                <P ><i>“Like stars are to the sky, so are the children to our world. They deserve to shine!"</i></P>
                <a id="explore" href="browse.php"><h5>EXPLORE PRODUCT</H5> <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        </section>
            <!--About-->
            
            <section class="contactUs" id="About">
        <h2 class="heading">ABOUT Us</h2>
        <div class="container">
            <section class="about">
                <div class="about-image">
                 <img src="img/about.jpg"  width="100%">     
                </div>
                    <div class="about-content">
                    <h2> "Our hello Kids Center" </h2>
                     <p> "Hello Kids Online Shopping Center" is a new platform or business that has come into existence after my last update, I won't have details about it. To get accurate and up-to-date information about this specific online shopping center, I recommend checking their official website, contacting their customer support, or searching for recent reviews and news articles. Get your baby's product to keep them shine like a star and also to keep to helthy,neat, fit and fine. You can have many products of popular brands. </p><br/><br/>
                    </div>
            </section> 
            <br/>
               <h1 style= "text-align:center " > BRANDS!!!! </h1>
               <section class="brand">
            <div class="row">
                <div style="display: flex; justify-content: center; align-items: center; height: 10% gap: 1.0rem;">
    <img src="img/johnsons-logo-vector.png" style="width:15%";/>&nbsp;&nbsp;
                
                    <img src="img/himal logo.PNG" style="width:15%"; />&nbsp;&nbsp;
              
                <!-- <div style="display: flex; justify-content: center; align-items: center; height: 10%;"> -->
                    <img src="img/maayu.png" style="width:15%";/>
                    </div>   
        </div>
    </section>
                    </section>
<section class="Category" id="Category">
    <h2 class="heading">Category</h2>
    
    <section id="quick-cont">
        <!-- <div id="quick-img"> -->
        <?php
       
            $select_product_types = mysqli_query($con, "SELECT DISTINCT categories FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_product_types) > 0) {
                while ($fetch_product_types = mysqli_fetch_assoc($select_product_types)) {
                    $product_type = $fetch_product_types['categories'];
    
                    $select_product_image = mysqli_query($con, "SELECT image FROM `products` WHERE categories = '$product_type' LIMIT 1") or die('query failed');
                    $fetch_product_image = mysqli_fetch_assoc($select_product_image);
                    $image_path = 'uploaded_img/' . $fetch_product_image['image'];
    
                    ?>

                    <div id="quick-img" onclick='window.location.href="browse.php#<?php echo $product_type; ?>"'>
    
                            <img src="<?php echo $image_path; ?>" alt="<?php echo $product_type; ?>" height="120px" width="100px">
                            <h4><?php echo $product_type; ?></a></h4>
                        </a>
                    </div>
    
        
        </form>
        
    
        <?php
            }
        } else {
            echo '<p class="empty">No categories available yet!</p>';
        }
        ?>
        <div style="text-decoration: none;
    background-color: #28a745;
    color: turquoise;
    padding:10px 10px;
    border-radius: 5px;
    margin-right:0%;
    margin-top:30%;
    display:flex;
    height:10%;
    width:10%;

    font-size: 18px;">
        <a id="explore" href="browse.php"><h5>Browse</H5> <i class="fa-solid fa-arrow-right"></i></a>

        </div>
    </section>

    <div class="more-btn">
        <!-- <a href="shop.php" class="option-btn">load more</a> -->
    </div>
</section>


</section>
    <section class="contactUs" id="Contact">
        <h2 class="heading">Contact Us</h2>
        
    </div>
    <section class="footer">
        <div class="social">
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-snapchat"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-facebook-f"></i></a>
        </div>
        <div id="footer-item" >
            <!-- <div>
    
                <ul class="list">
                  <li>
                    <a href="#">Home</a>
                  </li>
                  <li>
                    <a href="#">Terms</a>
                  </li>
                  <li>
                    <a href="#">Privacy Policy</a>
                  </li>
                  <li>
                    <a href="#">Privacy Policy</a>
                  </li>
                  <li>
                    <a href="#">Privacy Policy</a>
                  </li>
                </ul>
            </div> -->
            <div class="detail">
            <h3>Head Office</h3>
            <div >
                <li>
                    <i class="fa-solid fa-map-location"></i>
                    <p>Paknajol,Kathmandu,Nepal</p>
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <p>SNS@gmail.com</p>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <p>+977-9840030217,+977-9803293612,+977-9840180934</p>
                </li>
            </div>
        </div>
        </div>
        <p class="copyright">Hellokids @ 2024</p>
      </section>
    </body>
    </html>
</body>
</html>
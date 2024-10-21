
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login And Registration</title>
    <link rel="stylesheet" href="style/login.css?v=1.7"/>
    <style>
      
      .error-container.success {
         color:rgb(0, 255, 0);;
          }

      .error-container.failed {
         color: lightcoral;
         }
    
    </style>
</head>
<body>


    <div class="img">
    <div class="popup-container">
            <div class="popup">
                <form method="post" action="login-reg.php"><h2>
                    <p>UserLogin</p>
                    <button type="reset"> <a href="index.php">X</a></button>
                </h2>
                <?php
                  if(isset($_GET['error'])): ?>
                    <?php
                    $errorMessage = $_GET['error'];
                    $errorClass = ($errorMessage === 'Registration successful! you can now login!!') ? 'success' : 'failed';
                    ?>
                    <div class="error-container <?php echo $errorClass; ?>">
                       <p class="formerror"><?php echo $errorMessage; ?></p>
                    </div>
                    <?php endif; ?>
                <input type="text" placeholder="Enter E-mail" name="email" required/><br/>
                <input type="password" placeholder="Password" name="password" required/><br/>
                <button type="Submit" class="loginbutton" name="login">Login</button>
                <p> <br/>Don't have account ? <a href="register.php">Register</a></p>
                </form>
            </div>
                  </div>
        </div>
        
        

</body>
</html>
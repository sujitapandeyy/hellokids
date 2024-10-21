
<?php
require('connection.php');
session_start();
//if try to login directly to admindashboard
    if(!isset($_SESSION['Adminname'])){
        header("Location: login.php?error=Login first");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <link rel="stylesheet" href="style/dashboard.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>
<body>
   
<?php @include 'adminheader.php'; ?>

<section class="dashboard">

   <h1 class="title">Admin Dashboard : </h1>

 
  

</section>



</body>
</html>
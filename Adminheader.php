
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
  <title>Dashboard</title>
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
  <div class="container">
    <nav>
      <div class="navbar">
        <div class="logo">
          <img src="img/hellok.png" alt="">
        

        </div>
        <!-- <h1> Admin</h1> -->
        <ul>
          <li><a href="dashboard.php">
            <i class="fas fa-home"></i>
            <span class="nav-item">Dashboard</span>
          </a>
          </li>
          <li><a href="adminproduct.php">
            <i class="fas fa-chart-bar"></i>
            <span class="nav-item">Products</span>
          </a>
          </li>
          <li><a href="adminorder.php">
            <i class="fas fa-tasks"></i>
            <span class="nav-item">Orders</span>
          </a>
          </li>
          <li><a href="adminusers.php">
            <i class="fas fa-users"></i>
            <span class="nav-item">Users</span>
          </a>
          </li>
          </li>
          <li><a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Logout</span>
          </a>
          </li>
        </ul>
      </div>
  </nav>

 

</body>
</html>

<?php

    include 'connect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       .first-part{
        color: white;
        background-color: black;
        padding-left: 10px;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        font-family: 'Times New Roman', Times, serif;
       }

       .second-part{
        color: black;
        background-color: white;
        padding-right: 10px;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        font-family: 'Times New Roman', Times, serif;
       }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="index.php"><span class="first-part">Tech </span><span class="second-part"> Island</span></a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tech Island</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?php echo $home;?>" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?php if($category=="phones"){echo "active";}?>" href="category.php?category=phones">Mobile Phones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?php if($category=="accessories"){echo "active";}?>" href="category.php?category=accessories">Accessories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?php if($category=="hardwares"){echo "active";}?>" href="category.php?category=hardwares">Mobile Hardware</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 <?php echo $about;?>" href="about.php">About</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="searchPage.php" class="navIcons"><i class="fa-solid fa-magnifying-glass"></i></a>
            <a href="orders.php" class="navIcons"><i class="fa-solid fa-box-open"></i></a>
            <?php
              $orderCountQuery = "SELECT * FROM orders WHERE User_Id='$userId'";
              $orderQueryResult = $conn->query($orderCountQuery);
              $orderCount = $orderQueryResult->num_rows;
            ?>
            <span class="wish-qty"><?= $orderCount; ?></span>
            <a href="wishlist.php" class="navIcons"><i class="fa-solid fa-heart"></i></a>
            <?php
              $wishCountQuery = "SELECT * FROM wishlist WHERE User_Id='$userId'";
              $wishQueryResult = $conn->query($wishCountQuery);
              $wishItemCount = $wishQueryResult->num_rows;
            ?>
            <span class="wish-qty"><?= $wishItemCount; ?></span>
            <a href="cart.php" class="navIcons"><i class="fa-solid fa-cart-shopping"></i></a>
            <?php
              $cartCountQuery = "SELECT * FROM cart WHERE User_Id='$userId'";
              $cartQueryResult = $conn->query($cartCountQuery);
              $cartItemCount = $cartQueryResult->num_rows;
            ?>
            <span class="cart-qty"><?= $cartItemCount; ?></span>
            <button type="button" class="navIcons" data-toggle="modal" data-target="#x"><i class="fa-solid fa-user"></i></button>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <?php
      $selectQuery="SELECT * FROM users WHERE UserId='$userId'";
      $result=$conn->query($selectQuery);
      if($result->num_rows > 0){
        $fetch_profile=mysqli_fetch_assoc($result);
    ?>

      <div class="modal fade" tabindex="-1" role="dialog" id="x">
        <div class="modal-dialog modal-dialog-right" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"><?= $fetch_profile['FirstName']; ?></h5>
                  <button type="button" class="btn-close" data-dismiss="modal" area-label="Close" area-hidden="true"></button>
                </div>
                <div class="modal-body row">
                  <div class="col-6">
                    <a href="admin_logout.php" class="delete-btn" onclick="return confirm('Logout this site?');">Logout</a>
                  </div>
                  <div class="col-6">
                    <a href="userProfile.php" class="update-btn">Profile</a>
                  </div>
                </div>
              </div>
          </div>
      </div>

    <?php
      }else{
    ?>

      <div class="modal fade" tabindex="-1" role="dialog" id="x">
        <div class="modal-dialog modal-dialog-right" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-dismiss="modal" area-label="Close" area-hidden="true"></button>
            </div>
            <div class="modal-body row">
              <div class="col" style="width:200px">
                <a href="LogReg.php" class="option-btn">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php    
      }
    ?>
</body>
</html>
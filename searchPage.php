<?php

    include 'connect.php';

    $success="";
    $unsuccess="";

    session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']['Role'] == 'customer'){
        $userId=$_SESSION['user']['UserId'];
    }
    else{
        $userId="";
    }

    if(isset($_POST['addCart'])){

        if(empty($userId)){
          header('location:LogReg.php');
        }else{
          $user_Id = $_POST['userId'];
          $productId = $_POST['productId'];
          $productName = $_POST['productName'];
          $productPrice = $_POST['productPrice'];
          $quantity = $_POST['quantity'];
          $productImage = $_POST['productImage'];
    
          $checkQuery = "SELECT * FROM cart WHERE User_Id = '$userId' AND Pid='$productId'";
          $result = $conn->query($checkQuery);
          if($result->num_rows>0){
            $unsuccess="Already exist in the cart !";
          }else{
            $Query="INSERT INTO cart(User_Id,Pid,Name,Price,Quantity,Image) VALUES('$user_Id','$productId','$productName','$productPrice','$quantity','$productImage')";
            if($conn->query($Query)==TRUE){
              $success="Added to cart";
            }
          }
        }
      }

      if(isset($_POST['addWishlist'])){
    
        if(empty($userId)){
          header('location:LogReg.php');
        }else{
          $user_Id = $_POST['userId'];
          $productId = $_POST['productId'];
          $productName = $_POST['productName'];
          $productPrice = $_POST['productPrice'];
          $productImage = $_POST['productImage'];
    
          $checkQuery = "SELECT * FROM wishlist WHERE User_Id = '$userId' AND Pid='$productId'";
          $result = $conn->query($checkQuery);
          if($result->num_rows>0){
            $unsuccess="Already exist in the wishlist !";
          }else{
            $Query="INSERT INTO wishlist(User_Id,Pid,Name,Price,Image) VALUES('$user_Id','$productId','$productName','$productPrice','$productImage')";
            if($conn->query($Query)==TRUE){
              $success="Added to wishlist";
            }
          }
        }
      }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    
    <?php include 'userHeader.php';?>

    <div class="container search-form" style="margin-top:120px;">
        <p style="text-align:center;"><span class="success-message"><?=$success;?></span><span class="unsuccess-message"><?=$unsuccess?></span></p>
        <form action="" method="POST">
            <input name="search_item" class="search-input" type="text" placeholder="search..." aria-label="default input example" required>
            <button type="submit" name="search" class="btn-primary search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    
    <div class="container" style="margin-top:40px;">
        <div class="row justify-content-center">
            <?php
                if(isset($_POST['search']) OR isset($_POST['search_item'])){
                    $search_item = $_POST['search_item'];
                    $searchQuery = "SELECT * FROM products WHERE Category LIKE '%$search_item%' OR Name LIKE '%$search_item%' OR Brand LIKE '%$search_item%'";
                    $result=$conn->query($searchQuery);
                    if($result->num_rows>0){
                        while($fetch_products=mysqli_fetch_assoc($result)){
                        
            ?>
            <div class="col-md-3 col-sm-6" style="margin-bottom:40px; padding:30px;">
                <div class="product-box">
                    <div class="product-inner-box position-relative">
                        <form action="" method="POST">
                            <div class="products-icons position-absolute">
                                <input type="hidden" name="userId" value="<?= $fetch_profile['UserId'];?>">
                                <input type="hidden" name="productId" value="<?= $fetch_products['Id'];?>">
                                <input type="hidden" name="productName" value="<?= $fetch_products['Name'];?>">
                                <input type="hidden" name="productPrice" value="<?= $fetch_products['Price'];?>">
                                <input type="hidden" name="productImage" value="<?= $fetch_products['Image'];?>">
                                <button type="submit" name="addWishlist" class="wish"><i class="fa-solid fa-heart"></i></button>
                                <a href="quickView.php?pid=<?= $fetch_products['Id']; ?>&category=<?= $fetch_products['Category']; ?>" class="text-decoration-none"><i class="fa-solid fa-eye"></i></a>
                            </div>
                        </form>
                        <div class="discount">
                            <span class="badge rounded-0"><i class="fa-solid fa-arrow-down"></i>29%</span>
                        </div>
                        <img src="UploadImages/<?= $fetch_products['Image'];?>" alt="" class="img-fluid home-product-img">
                        <div class="cart-button">
                            <button type="button" name="addCart" class="btn btn-white shadow-sm rounded-pill" data-toggle="modal" data-target="#modal_<?php echo $fetch_products['Id'];?>"><i class="fa-solid fa-cart-shopping"></i> Add to cart</button>
                        </div>
                  
                    </div>
                    <div class="product-info">
                        <div class="product-name">
                            <h5><?= $fetch_products['Name']; ?></h5>
                        </div>
                        <div class="product-price">
                            <span>LKR: <?= $fetch_products['Price']; ?>/-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade cartModal" tabindex="-1" role="dialog" id="modal_<?php echo $fetch_products['Id'];?>">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="heading"><?= $fetch_products['Name']; ?></h3>
                            <button type="button" class="btn-close" data-dismiss="modal" area-label="Close" area-hidden="true"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="card cart-card" style="width: 32rem;">
                                <img src="UploadImages/<?= $fetch_products['Image']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">LKR: <?= $fetch_products['Price']; ?>/-</h5>
                                    <br> 
                                    <h5 class="heading">Description:</h5>
                                    <p class="card-text"><?= $fetch_products['Details']; ?></p>
                                </div>
                            </div>
                            <div class="cart-card-bottom sticky-bottom flex">
                                <form action="" method="POST" class="cartForm">
                                    <div class="row">
                                        <div class="col modal-col">
                                            <label for="" class="label-qty">Quantity: </label>
                                            <input type="hidden" name="userId" value="<?= $fetch_profile['UserId'];?>">
                                            <input type="hidden" name="productId" value="<?= $fetch_products['Id'];?>">
                                            <input type="hidden" name="productName" value="<?= $fetch_products['Name'];?>">
                                            <input type="hidden" name="productPrice" value="<?= $fetch_products['Price'];?>">
                                            <input type="hidden" name="productImage" value="<?= $fetch_products['Image'];?>">
                                            <input type="number" calss="form-control" name="quantity" id="input-qty" min="1" max="10" value="1" oninput="this.value = Math.abs(this.value)">
                                        </div>
                                        <div class="col modal-col" style="margin-top:5px; text-align:right;">
                                            <button type="submit" name="addCart" class="btn add-cart-btn shadow-sm rounded-pill"><i class="fa-solid fa-cart-shopping"></i> Continue</button>
                                        </div>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                        }
                    }else{
                        echo '<p class="empty">No products found!</p>';
                        echo '<div style="height:90px;"></div>';
                    }
                }
            ?>
        </div>
    </div>





    <br><br>
    <?php include 'footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <script src="script.js"></script>
</body>
</html>
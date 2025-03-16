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

      $category = $_GET['category'];

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

    <div class="container productView my-5 pt-5">
        <p style="text-align:center;"><span class="success-message"><?=$success;?></span><span class="unsuccess-message"><?=$unsuccess?></span></p>
        <?php
            $pid=$_GET['pid'];
            $showQuery = "SELECT * FROM products WHERE Id='$pid'";
            $result=$conn->query($showQuery);
            if($result->num_rows>0){
                while($fetch_products=mysqli_fetch_assoc($result)){
                            
        ?>
        <div class="row mt-5">
            <div class="col-lg-5 col-md-12 col-12">
                <img class="img-fluid w-100 pb-1" src="UploadImages/<?=$fetch_products['Image'];?>" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <h6 class="mt-5">Home / products</h6>
                <h3 class="mt-5 quickView-name"><?=$fetch_products['Name'];?></h3>
                <h4 class="mt-3 quickView-price">LKR. <?=$fetch_products['Price'];?>/-</h4>
                <button type="button" name="addCart" class="btn btn-primary shadow-sm rounded-pill addCart-btn mt-5" data-toggle="modal" data-target="#modal_<?php echo $fetch_products['Id'];?>"><i class="fa-solid fa-cart-shopping"></i> Add to cart</button>
                
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

                <form action="" method="POST">
                    <input type="hidden" name="userId" value="<?= $fetch_profile['UserId'];?>">
                    <input type="hidden" name="productId" value="<?= $fetch_products['Id'];?>">
                    <input type="hidden" name="productName" value="<?= $fetch_products['Name'];?>">
                    <input type="hidden" name="productPrice" value="<?= $fetch_products['Price'];?>">
                    <input type="hidden" name="productImage" value="<?= $fetch_products['Image'];?>">
                    <button type="submit" name="addWishlist" class="btn btn-primary shadow-sm rounded-pill addWish-btn mt-2">Add to wishlist</button>
                </form>
                <h4 class="mt-5 mb-2">Description</h4>
                <span><?=$fetch_products['Details'];?></span>
            </div>
        </div>
        <?php
                }
            }else{
                echo '<p class="empty">No products found!</p>';
                echo '<div style="height:182px;"></div>';
            }
        ?>
    </div>

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
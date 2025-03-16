<?php
  include 'connect.php';

  $home="active";
  $about="";


  $cartStatus="";
  $wishlistStatus="";

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
        $cartStatus="Already exist in the cart !";
      }else{
        $Query="INSERT INTO cart(User_Id,Pid,Name,Price,Quantity,Image) VALUES('$user_Id','$productId','$productName','$productPrice','$quantity','$productImage')";
        if($conn->query($Query)==TRUE){
          $cartStatus="Added to cart";
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
        $wishlistStatus="Already exist in the wishlist !";
      }else{
        $Query="INSERT INTO wishlist(User_Id,Pid,Name,Price,Image) VALUES('$user_Id','$productId','$productName','$productPrice','$productImage')";
        if($conn->query($Query)==TRUE){
          $wishlistStatus="Added to wishlist";
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
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="index-body">

    <!--Nav bar-->
    <?php include 'userHeader.php'?>
    <!--Nav bar end-->

<br><br>

    <!--Hero section-->
    
    <div class="row mt-5">

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" >
            
            <div class="carousel-inner" >
              <div class="carousel-item active">
                <img src="img/sized_ip15.jpg" class="d-block w-100" style="width: 100%; height: 500px;" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/EditedS24.png" class="d-block w-100" style="width: 100%; height: 500px;" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/pixel.jpeg" class="d-block w-100" style="width: 100%; height: 500px;" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

    </div>
  <section class="hero-section">
    <!--Hero sectio End-->
      <br><br>
    <!--facilities-->

    <div class="container text-center mt-5 mb-5">
        <div class="row row-cols-5">
          <div class="col-md-2.4 facilities">
            <u><i class="fa-solid fa-truck"></i></u>
            <ul>Island-wide</ul>
            <ul>Delivery</ul>
          </div>
          <div class="col-md-2.4 facilities">
            <ul><i class="fa-solid fa-comments"></i></ul>
            <ul>99% Customer</ul>
            <ul>Feedbacks</ul>
          </div>
          <div class="col-md-2.4 facilities">
            <ul><i class="fa-solid fa-award"></i></ul>
            <ul>Warranty Add-ons</ul>
            <ul>Available</ul>
          </div>
          <div class="col-md-2.4 facilities">
            <ul><i class="fa-solid fa-credit-card"></i></ul>
            <ul>Leading Credit Cards</ul>
            <ul>& Cash on Delivery</ul>
          </div>
          <div class="col-md-2.4 facilities">
            <ul><i class="fa-solid fa-mobile-screen-button"></i></ul>
            <ul>Genuine Devices</ul>
            <ul>with Warranty</ul>
          </div>
        </div>
      </div>

    <!--End facilities-->
    <br><br>
    <!--latest products begings-->

    <h2 class="heading" style="text-align:center;">LATEST PRODUCTS</h2>
    <br><br>

    <div class="container">
      <div class="row justify-content-center">
            <?php
                $showQuery = "SELECT * FROM products LIMIT 4";
                $result=$conn->query($showQuery);
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
                    <h3><?= $fetch_products['Name']; ?></h3>
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
                    <!--<h6 style="color: red; text-align:center;"><?= $cartStatus; ?></h6>-->
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
                    echo '<p class="empty">No products added!</p>';
                }
            ?>
      </div>
    </div>

    </section>


    <div class="row mt-5">

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" >
            
            <div class="carousel-inner" >
              <div class="carousel-item active">
                <img src="img/airpods-pro-2.jpeg" class="d-block w-100" style="width: 100%; height: 500px;" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/apple-vision-pro.jpeg" class="d-block w-100" style="width: 100%; height: 500px;" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/galaxy-watch5-pro.jpg" class="d-block w-100" style="width: 100%; height: 500px;" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

    </div>
    <br><br>
    <div class="container">
      <h2 class="heading" style="text-align:center;">LATEST ACCESSORIES</h2>
      <br><br>
      <div class="row justify-content-center">
            <?php
                $showQuery = "SELECT * FROM products WHERE Category='accessories' LIMIT 4";
                $result=$conn->query($showQuery);
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
                    <h3><?= $fetch_products['Name']; ?></h3>
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
                    <!--<h6 style="color: red; text-align:center;"><?= $cartStatus; ?></h6>-->
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
                    echo '<p class="empty">No products added!</p>';
                }
            ?>
      </div>
    </div>













    <!--Start modal-->

  

    <div class="modal" tabindex="-1" role="dialog" id="x8">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="btn-close" data-dismiss="modal" area-label="Close" area-hidden="true"></button>
          </div>
        </div>
      </div>
    </div>
    
    <!--end modal-->




    <!--latest products end-->

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
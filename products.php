<?php
    $show="";
    
    include 'connect.php';

    $home="";
    $products="active";
    $orders="";
    $admin="";
    $users="";
    $mesages="";

    session_start();

    if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] !== 'admin' && $_SESSION['user']['Role'] !== 'stock_keeper')) {
        header("Location: LogReg.php");
        exit;
    }


    $admin_id = $_SESSION['user']['UserId'];

    if(!isset($admin_id)){
        header('location:LogReg.php');
    }

    if($_SESSION['user']['Role']=='stock_keeper'){
        $displayHome="none";
        $displayProducts="block";
        $displayOrders="none";
        $displayAdmin="none";
        $displayUsers="none";
        $displayMessages="none";
    }



    if(isset($_POST['add'])){
        $category=$_POST['categorySelect'];
        $brand=$_POST['brand'];
        $productName=$_POST['name'];
        $price=$_POST['price'];
        $productDetails=$_POST['details'];

        
        $image_name=$_FILES['image']['name'];
        $image_size=$_FILES['image']['size'];
        $image_tmp_name=$_FILES['image']['tmp_name'];
        $image_folder='UploadImages/'.$image_name;

        if ($image_size > 2000000) {
            echo "<script>alert('The image too large! try again.');</script>";
            echo "<script>window.location.href = 'products.php';</script>";
        }else{
        
            if (move_uploaded_file($image_tmp_name,$image_folder)) {
                $checkProduct="SELECT * FROM products WHERE Name='$productName'";
                $result=$conn->query($checkProduct);
                if($result->num_rows>0){
                    echo "<script>alert('The product already exists!');</script>";
                    echo "<script>window.location.href = 'products.php';</script>";
                }
                else{

                    //move_uploaded_file($image_tmp_name,$image_folder);

                    $insertQuery="INSERT INTO products(Category,Brand,Name,Price,Image,Details) VALUES ('$category','$brand','$productName','$price','$image_name','$productDetails')";
                    
                    if($conn->query($insertQuery)==TRUE){
                        $show = "New product was added";
                    }
                    else{
                        echo "Error:".$conn->error;
                    }
                }
            }else{
                echo "<script>alert('Image uploading error!');</script>";
                echo "<script>window.location.href = 'products.php';</script>";
            }

        }
       
    }

    if(isset($_GET['delete'])){
        $product_id = $_GET['delete'];
        $imageSelectQuery = mysqli_query($conn,"SELECT * FROM products WHERE Id='$product_id'");
        $fetched_image= mysqli_fetch_assoc($imageSelectQuery);

        if ($fetched_image && file_exists('UploadImages/' . $fetched_image['Image'])) {
            unlink('UploadImages/'. $fetched_image['Image']);
        }

        $deleteQuery="DELETE FROM products WHERE Id='$product_id'";
        $conn->query($deleteQuery);

        $deleteCart = "DELETE FROM cart WHERE Pid='$product_id'";
        $conn->query($deleteCart);

        $deletewishlist="DELETE FROM wishlist WHERE Pid='$product_id'";
        $conn->query($deletewishlist);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <style>
        .card{
            background-color: grey;
        }
        .card-body .updatebtn{
            background-color: #007FC3;
            width:48%;
        }
        .card-body .updatebtn:hover{
            background-color: black;
        }
        .card-body .deletebtn{
            background-color: red;
            width:48%;
        }
        .card-body .deletebtn:hover{
            background-color: black;
        }
        .nav-item{
        }
        .product-heading{
            color: white;
            background-color: black;
            text-align:center;
            margin-top: 50px;
            margin-bottom: 50px;
        }
    </style>



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include 'admin_header.php' ?>

    <div class="container form-style" style="margin-top: 150px; width:500px;">
        <h6 style="color: #0bcb78; text-align:center;"><?= $show; ?></h6>
        <h3 class="heading" style="text-align:center;margin-top: 20px;margin-bottom: 40px;">ADD PRODUCTS</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label" id="categoryLabel" style="display: none;">Category</label>
                <select class="form-select" aria-label="Default select example" name="categorySelect" id="categorySelect" required>
                    <option selected disabled>Select Category</option>
                    <option value="phones">Mobile Phones</option>
                    <option value="accessories">Accessories</option>
                    <option value="hardwares">Hardwares</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="InputBrand" class="form-label" id="brandLabel" style="display: none;">Brand</label>
                <input type="text" class="form-control" name="brand" id="brand" placeholder="Brand" required>
            </div>
            <div class="mb-3">
                <label for="InputName" class="form-label" id="nameLabel" style="display: none;">Product Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <label for="InputPrice" class="form-label" id="priceLabel" style="display: none;">Price</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="Price" required>
            </div>
            <div class="mb-3">
                <label for="InputImage" class="form-label" id="imageLabel" style="display: none;">Image</label>
                <input class="form-control" type="file" name="image" id="formFile" accept="image/jpg, image/jpeg, image/png" required>
            </div>
            <div class="mb-3">
                <label for="InputConfirmPassword" class="form-label" id="detailsLabel" style="display: none;">Details</label>
                <textarea class="form-control" id="details" name="details" rows="5" placeholder="Add product details" required></textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Add" name="add">
        </form>
    </div>

    <!--Show added product starts-->

    <h2 class="product-heading">ADDED PHONES</h2>

    <div class="container">
        <div class="row justify-content-center">
            <?php
                $showQuery = "SELECT * FROM products WHERE Category='phones'";
                $result=$conn->query($showQuery);
                if($result->num_rows>0){
                    while($fetch_products=mysqli_fetch_assoc($result)){
                        
            ?>
            <div class="col-md-3" style="padding:10px;">
                    <div class="card mb-3" style="box-shadow: 0 10px 15px rgb(160, 150, 150);">
                        <div style="height:300px;">
                            <img src="UploadImages/<?= $fetch_products['Image']; ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?= $fetch_products['Name']; ?></h4>
                            <h5>$<?= $fetch_products['Price']; ?>/-</h5>
                            <a href="update_product.php?update=<?= $fetch_products['Id']; ?>" class="btn btn-primary updatebtn">Update</a><!--Query parameter-->
                            <a href="products.php?delete=<?= $fetch_products['Id']; ?>" class="btn btn-primary deletebtn" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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

    <br>

    <h2 class="product-heading">ADDED ACCESSORIES</h2>

    <div class="container">
        <div class="row justify-content-center">
            <?php
                $showQuery = "SELECT * FROM products WHERE Category='accessories'";
                $result=$conn->query($showQuery);
                if($result->num_rows>0){
                    while($fetch_products=mysqli_fetch_assoc($result)){
                        
            ?>
            <div class="col-md-3" style="padding:10px;">
                    <div class="card mb-3" style="box-shadow: 0 10px 15px rgb(160, 150, 150);">
                        <div style="height:300px;">
                            <img src="UploadImages/<?= $fetch_products['Image']; ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?= $fetch_products['Name']; ?></h4>
                            <h5>$<?= $fetch_products['Price']; ?>/-</h5>
                            <a href="update_product.php?update=<?= $fetch_products['Id']; ?>" class="btn btn-primary updatebtn">Update</a><!--Query parameter-->
                            <a href="products.php?delete=<?= $fetch_products['Id']; ?>" class="btn btn-primary deletebtn" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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

    <br>

    <h2 class="product-heading">ADDED HARDWARES</h2>

    <div class="container">
        <div class="row justify-content-center">
            <?php
                $showQuery = "SELECT * FROM products WHERE Category='hardwares'";
                $result=$conn->query($showQuery);
                if($result->num_rows>0){
                    while($fetch_products=mysqli_fetch_assoc($result)){
                        
            ?>
            <div class="col-md-3" style="padding:10px;">
                    <div class="card mb-3" style="box-shadow: 0 10px 15px rgb(160, 150, 150);">
                        <div style="height:300px;">
                            <img src="UploadImages/<?= $fetch_products['Image']; ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?= $fetch_products['Name']; ?></h4>
                            <h5>$<?= $fetch_products['Price']; ?>/-</h5>
                            <a href="update_product.php?update=<?= $fetch_products['Id']; ?>" class="btn btn-primary updatebtn">Update</a><!--Query parameter-->
                            <a href="products.php?delete=<?= $fetch_products['Id']; ?>" class="btn btn-primary deletebtn" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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


    <!--Show added product ends-->

    <script>

        const nameInput = document.getElementById('name');
        const nameLabel = document.getElementById('nameLabel');

        const priceInput = document.getElementById('price');
        const priceLabel = document.getElementById('priceLabel');
    
        const brandInput = document.getElementById('brand');
        const brandLabel = document.getElementById('brandLabel');

        const imageInput = document.getElementById('formFile');
        const imageLabel = document.getElementById('imageLabel');

        const detailsInput = document.getElementById('details');
        const detailsLabel = document.getElementById('detailsLabel');

        const categorySelect = document.getElementById('categorySelect');
        const categoryLabel = document.getElementById('categoryLabel');
        
        nameInput.addEventListener('focus', function() {
            nameLabel.style.display = 'block';
        });

        nameInput.addEventListener('blur', function() {
            if (!nameInput.value) {
                nameLabel.style.display = 'none';
            }
        });

        priceInput.addEventListener('focus', function() {
            priceLabel.style.display = 'block';
        });

        priceInput.addEventListener('blur', function() {
            if (!priceInput.value) {
                priceLabel.style.display = 'none';
            }
        });

        brandInput.addEventListener('focus', function() {
            brandLabel.style.display = 'block';
        });

        brandInput.addEventListener('blur', function() {
            if (!brandInput.value) {
                brandLabel.style.display = 'none';
            }
        });

        
        imageInput.addEventListener('focus', function() {
            imageLabel.style.display = 'block';
        });

        imageInput.addEventListener('blur', function() {
            if (!imageInput.value) {
                imageLabel.style.display = 'none';
            }
        });

        detailsInput.addEventListener('focus', function() {
            detailsLabel.style.display = 'block';
        });

        detailsInput.addEventListener('blur', function() {
            if (!detailsInput.value) {
                detailsLabel.style.display = 'none';
            }
        });

        categorySelect.addEventListener('change', function() {
            categoryLabel.style.display = 'block';
        });

        if (categorySelect.value === "") {
            categoryLabel.style.display = 'none';
        }
        
    </script>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
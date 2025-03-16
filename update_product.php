<?php
    include 'connect.php';

    $home="";
    $products="active";
    $orders="";
    $admin="";
    $users="";
    $mesages="";

    $show="";
    $unsuccess="";

    session_start();

    if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] !== 'admin' && $_SESSION['user']['Role'] !== 'stock_keeper')) {
        header("Location: LogReg.php");
        exit;
    }

    $admin_id = $_SESSION['user']['UserId'];
    $update_id=$_GET['update'];

    if($_SESSION['user']['Role']=='stock_keeper'){
        $displayHome="none";
        $displayProducts="block";
        $displayOrders="none";
        $displayAdmin="none";
        $displayUsers="none";
        $displayMessages="none";
    }

    if(isset($_POST['update'])){
        $category=$_POST['categorySelect'];
        $brand=$_POST['brand'];
        $productName=$_POST['name'];
        $price=$_POST['price'];
        $productDetails=$_POST['details'];

        $updateQuery="UPDATE products SET Category='$category', Brand='$brand', Name='$productName', Price='$price', Details='$productDetails' WHERE Id='$update_id'";
        $status=$conn->query($updateQuery);
        if($status==TRUE){
            $show="Product was updated";
        }

        $imageUpdateQuery = mysqli_query($conn,"SELECT * FROM products WHERE Id = '$update_id'");
        $fetched=mysqli_fetch_assoc($imageUpdateQuery);
        $old_image=$fetched['Image'];

        $image_name=$_FILES['image']['name'];
        $image_size=$_FILES['image']['size'];
        $image_tmp_name=$_FILES['image']['tmp_name'];
        $image_folder='UploadImages/'.$image_name;

        if(!empty($image_name)){
            if($image_size>2000000){
                echo "<script>alert('The image too large! try again.');</script>";
                echo "<script>window.location.href = 'update_product.php';</script>";
            }else{
                if($old_image!==$image_name){
                    $imageUpdateQuery="UPDATE products SET Image='$image_name' WHERE Id='$update_id'";
                    $conn->query($imageUpdateQuery);
                    move_uploaded_file($image_tmp_name,$image_folder);
                    unlink('UploadImages/'.$old_image);
                }else{
                    $unsuccess="Image cannot be updated. Updated image name should be different to the old image name";
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
    <title>update_product</title>

    <style>
        *{
            font-family: 'Roboto', sans-serif;
        }
        .card-img-top{
            max-height:400px;
            max-width:400px;
        }
        input{
            color:blue;
        }
        .card-body input.btn:hover{
            background-color: black;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    
    <?php include 'admin_header.php' ?>

    <div class="container">
        <?php
            $update_id=$_GET['update'];
            $showQuery = "SELECT * FROM products WHERE Id='$update_id'";
            $result=$conn->query($showQuery);
            if($result->num_rows>0){
                while($fetch_products=mysqli_fetch_assoc($result)){
                            
        ?>

        <div class="container form-style" style="margin-top: 150px; width: 525px;">
            <h6 style="color: #0bcb78; text-align:center;"><?= $show; ?></h6>
            <p style="text-align:center;"><span class="unsuccess-message"><?=$unsuccess;?></span></p>
            <h3 class="heading" style="text-align:center;margin-top: 20px;">UPDATE PRODUCTS</h3>
            <div class="card" style="width: 30rem; border:none;">
                <div style="text-align:center;">
                    <img src="UploadImages/<?= $fetch_products['Image']; ?>" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label" id="categoryLabel">Category</label>
                            <select class="form-select" aria-label="Default select example" name="categorySelect" id="categorySelect" required style="color:blue;">
                                <option selected disabled>Select Category</option>
                                <option value="phones" <?php if ($fetch_products['Category'] == 'phones') echo 'selected'; ?>>Mobile Phones</option>
                                <option value="accessories" <?php if ($fetch_products['Category'] == 'accessories') echo 'selected'; ?>>Accessories</option>
                                <option value="hardwares" <?php if ($fetch_products['Category'] == 'hardwares') echo 'selected'; ?>>Hardwares</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="InputBrand" class="form-label" id="brandLabel">Brand</label>
                            <input type="text" class="form-control" name="brand" id="brand" placeholder="Brand" value="<?= $fetch_products['Brand'];?>" required style="color:blue;">
                        </div>
                        <div class="mb-3">
                            <label for="InputName" class="form-label" id="nameLabel">Product Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?= $fetch_products['Name'];?>" required style="color:blue;">
                        </div>
                        <div class="mb-3">
                            <label for="InputPrice" class="form-label" id="priceLabel">Price</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="<?= $fetch_products['Price'];?>" required style="color:blue;">
                        </div>
                        <div class="mb-3">
                            <label for="InputImage" class="form-label" id="imageLabel">Image</label>
                            <input class="form-control" type="file" name="image" id="formFile" accept="image/jpg, image/jpeg, image/png" style="color:blue;">
                        </div>
                        <div class="mb-3">
                            <label for="InputConfirmPassword" class="form-label" id="detailsLabel">Details</label>
                            <textarea class="form-control" id="details" name="details" rows="5" placeholder="Add product details" required style="color:blue;"><?= $fetch_products['Details'];?></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary update-btn" value="Update" name="update">
                    </form>
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




    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
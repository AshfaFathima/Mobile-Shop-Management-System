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

    if(empty($userId)){
        header('location:LogReg.php');
    }else{}



    if(isset($_POST['placeOrder'])){
        $fName=$_POST['fName'];
        $lName=$_POST['lName'];
        $fullName=$fName.' '.$lName;
        $phNumber=$_POST['phNumber'];
        $email=$_POST['email'];
        $paymentMethod=$_POST['payMethod'];
        $address=$_POST['address'];
        $products=$_POST['totalProducts'];
        $grandPrice=$_POST['grandTotal'];
        $currentDate=date('Y-m-d');
        

        if($paymentMethod=="bank transfer"){
            if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){
                $image_name=$_FILES['image']['name'];
                $image_size=$_FILES['image']['size'];
                $image_tmp_name=$_FILES['image']['tmp_name'];
    
                if($image_size > 2000000){
                    echo "<script>alert('The image too large! try again.');</script>";
                    header('checkout.php');
                }else{
    
                    $unique_imageName=uniqid().'_'.$image_name;
                    $image_folder='PaymentSlips/'.$unique_imageName;
                    
    
                    if(move_uploaded_file($image_tmp_name,$image_folder)){
                        $query="INSERT INTO orders(User_Id,Name,Number,Email,Method,Address,Total_products,Total_price,Placed_on,Payment_status,Payment_slip,Delivery_status) VALUES('$userId','$fullName','$phNumber','$email','$paymentMethod','$address','$products','$grandPrice','$currentDate','pending','$unique_imageName','processing')";
                        $insertResult=$conn->query($query);
                        if($insertResult==TRUE){
                            $success="Placed Order";
    
                            $deleteQuery="DELETE FROM cart WHERE User_Id='$userId'";
                            $conn->query($deleteQuery);
                        }
                    }else{
                        echo 'error';
                    }
                }
            }else{
                $unsuccess="Please upload payment slip !";
            }

        }

        if($paymentMethod=="cash on delivery"){
            $query="INSERT INTO orders(User_Id,Name,Number,Email,Method,Address,Total_products,Total_price,Placed_on,Payment_status,Delivery_status) VALUES('$userId','$fullName','$phNumber','$email','$paymentMethod','$address','$products','$grandPrice','$currentDate','pending','processing')";
            $insertResult=$conn->query($query);
            if($insertResult==TRUE){
                $success="Placed Order";

                $deleteQuery="DELETE FROM cart WHERE User_Id='$userId'";
                $conn->query($deleteQuery);
            }
        }
        


    }


    $grandTotal=$_GET['total'];
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
    
    <p style="text-align:center;margin-top:120px;"><span class="success-message"><?=$success;?></span><span class="unsuccess-message"><?=$unsuccess?></span></p>
    <h2 class="heading mb-5" style="text-align:center;">CHECKOUT</h2>
    <?php
        $cartQuery="SELECT * FROM cart WHERE User_id='$userId'";
        $queryResult=$conn->query($cartQuery);
        if($queryResult->num_rows>0){
    ?>
    <div class="container">
        <div class="row">
            <div class="col-5 checkout-Sections">
                <p>Total Price</p>
                <h2>LKR. <?= $grandTotal;?>/-</h2>
                <table class="table checkout-Table">
                    <tbody>
                <?php
                    $showQuery = "SELECT * FROM cart WHERE User_Id='$userId'";
                    $result=$conn->query($showQuery);
                    if($result->num_rows>0){
                        while($fetch_cart=mysqli_fetch_assoc($result)){
                            $totalProductsArray[]=$fetch_cart['Name'].'*'.$fetch_cart['Quantity'];

                ?>
                    <tr>
                        <td><img src="UploadImages/<?=$fetch_cart['Image'];?>" class="checkoutImages"></td>
                        <td class="checkoutText"><?= $fetch_cart['Name'];?></td>
                        <td class="checkoutText"><?= $fetch_cart['Price'];?> * <?= $fetch_cart['Quantity']?></td>
                    </tr>
                <?php
                        }
                        $totalProducts=implode('|',$totalProductsArray);
                    }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="col-7 checkout-Sections">
                <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                    <input type="hidden" name="totalProducts" value="<?= $totalProducts;?>">
                    <input type="hidden" name="grandTotal" value="<?= $grandTotal;?>">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="fName" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lName" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone number</label>
                        <input type="text" name="phNumber" class="form-control" maxlength="10" inputmode="numeric" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control"  required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment method</label>
                        <select id="paymentMethod" name="payMethod" class="form-select" required>
                            <option value="cash on delivery">Cash on delivery</option>
                            <option value="bank transfer" selected>Bank transfer</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" id="paymentSlipLabel">Payment slip</label>
                        <input type="file" name="image" class="form-control" id="paymentSlipInput" accept="image/jpg, image/jpeg, image/png">
                    </div>
                    <div class="col-12 place-order-btn-section">
                        <button type="submit" name="placeOrder" class="btn rounded-pill btn-place-order">Place order</button>
                        <br><br>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        }else{
            echo '<p class="empty">No products in cart to place order!</p>';
        }
    ?>

    <br><br>

    <?php include 'footer.php';?>

    <script>

        const paymentMethod = document.getElementById('paymentMethod');

        const paymentSlipLabel = document.getElementById('paymentSlipLabel');
        const paymentSlipInput = document.getElementById('paymentSlipInput');

        paymentMethod.addEventListener('change', function(){
            if(this.value==='bank transfer'){
                paymentSlipInput.style.display='block';
                paymentSlipLabel.style.display='block';
                paymentSlipInput.required=true;
            }else{
                paymentSlipInput.style.display='none';
                paymentSlipLabel.style.display='none';
                paymentSlipInput.required=false;
            }
        });


    </script>


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
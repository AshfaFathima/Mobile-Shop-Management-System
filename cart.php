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

    if(isset($_POST['qtyUpdate'])){
        $qtyId=$_POST['qtyId'];
        $quantity=$_POST['quantity'];
        $qtyQuery="UPDATE cart SET Quantity='$quantity' WHERE Id='$qtyId'";
        if($conn->query($qtyQuery)==TRUE){
            $success="Saved";
        }
    }

    if(isset($_POST['cartDelete'])){
        $deleteId=$_POST['deleteId'];
        $deleteQuery="DELETE FROM cart WHERE Id='$deleteId'";
        if($conn->query($deleteQuery)==TRUE){
            $unsuccess="Product was removed";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    
    <?php include 'userHeader.php';?>

    <div class="container" style="margin-top:120px;">
        <p style="text-align:center;"><span class="success-message"><?=$success;?></span><span class="unsuccess-message"><?=$unsuccess?></span></p>
        <h2 class="heading" style="text-align:center;">SHOPPING CART</h2>
        <br>
        <table class="table cart-table">
            <thead class="table-dark center">
                <th>Product</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </thead>
            <?php
                $grandTotal=0;
                $showQuery = "SELECT * FROM cart WHERE User_Id='$userId'";
                $result=$conn->query($showQuery);
                if($result->num_rows>0){
                    while($fetch_cart=mysqli_fetch_assoc($result)){
                        $total=$fetch_cart['Price']*$fetch_cart['Quantity'];
                        $grandTotal+=$total;
            ?>
            <tbody>
                <tr>
                    <td><img src="UploadImages/<?= $fetch_cart['Image'];?>" class="cartImages"></td>
                    <td><?= $fetch_cart['Name'];?></td>
                    <td><?= $fetch_cart['Price'];?>/-</td>
                    <td>
                        <form action="" method="POST">
                            <div class="input-group mb-3">
                                <input type="hidden" name="qtyId" value="<?= $fetch_cart['Id'];?>">
                                <input type="number" class="cart-Quantity" name="quantity" min="1" max="10" value="<?= $fetch_cart['Quantity'];?>" oninput="this.value = Math.abs(this.value)">
                                <button class="btn save-btn" type="submit" name="qtyUpdate">save</button>
                            </div>
                        </form>
                    </td>
                    <td><?= $total;?>/-</td>
                    <td class="center">
                        <form action="" method="POST">
                            <input type="hidden" name="deleteId" value="<?=$fetch_cart['Id'];?>">
                            <button type="submit" name="cartDelete" class="btn cart-delete-btn rounded-pill" onclick="return confirm('Are you sure you want to remove this item?');"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
            <?php
                    }
                
            ?>
                <tr>
                    <td colspan="4" class=" grand-total center">Grand total price: </td>
                    <td class="grand-total"><?= $grandTotal;?>/-</td>
                    <td class="center"><a href="checkout.php?total=<?= $grandTotal;?>" class="btn checkout-btn rounded-pill">Checkout</button></td>
                </tr>
            <?php
                }else{
                    echo '<tr><td colspan="6"><p class="empty">No products in cart!</p></td></tr>';
                    
                }
            ?>

            </tbody>
        </table>


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
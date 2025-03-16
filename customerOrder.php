<?php
    include 'connect.php';

    $success="";
    $unsuccess="";

    $linkedOrderId=$_GET['Id'];
    $grandTotal=$_GET['grandTotal'];

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

    <div class="container mb-5" style="margin-top:120px;">
        <h2 class="heading mb-5" style="text-align:center;margin-top: 20px;margin-bottom: 40px;">ORDER ID:<?= $linkedOrderId;?></h2>
        <div class="row">
            <div class="col-5 orderView">
                <p>Total Price</p>
                <h2>LKR. <?= $grandTotal;?>/-</h2>
                <br>
                <p>Total Products</p>
                <table class="table checkout-Table">
                    <tbody>
                <?php
                    $showQuery = "SELECT * FROM orders WHERE Id='$linkedOrderId'";
                    $result=$conn->query($showQuery);
                    if($result->num_rows>0){
                        $fetch_orders=mysqli_fetch_assoc($result);
                        $totalProducts=$fetch_orders['Total_products'];
                        $seperateProducts=explode('|',$totalProducts);

                        foreach($seperateProducts as $eachProduct){
                ?>
                    <tr>
                        <td><?= $eachProduct;?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="col-7 orderView">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <p>User Id: <span class="fetchData"><?= $fetch_orders['User_Id'];?></span></p>
                        <p>Name: <span class="fetchData"><?= $fetch_orders['Name'];?></span></p>
                        <p>Email: <span class="fetchData"><?= $fetch_orders['Email'];?></span></p>
                        <p>Phone number: <span class="fetchData"><?= $fetch_orders['Number'];?></span></p>
                        <p>Address: <span class="fetchData"><?= $fetch_orders['Address'];?></span></p>
                        <p>Total products: <span class="fetchData"><?= $fetch_orders['Total_products'];?></span></p>
                        <p>Total price: <span class="fetchData">LKR. <?= $fetch_orders['Total_price'];?>/-</span></p>
                        <p>Placed on: <span class="fetchData"><?= $fetch_orders['Placed_on'];?></span></p>
                        <p>Payment method: <span class="fetchData"><?= $fetch_orders['Method'];?></span></p>
                        <p>Payment Status: <span class="fetchData"  style="color:<?php if($fetch_orders['Payment_status']=='pending'){echo 'red';}else{echo 'rgb(0, 190, 0)';}?>"><?= $fetch_orders['Payment_status'];?></span></p>
                </ul>
            </div>
        </div>
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
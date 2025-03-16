<?php

    include 'connect.php';

    $success="";
    $unsuccess="";

    $home="";
    $products="";
    $orders="active";
    $admin="";
    $users="";
    $mesages="";

    $linkedOrderId=$_GET['Id'];
    $grandTotal=$_GET['grandTotal'];


    session_start();

    if (!isset($_SESSION['user']) || ($_SESSION['user']['Role'] !== 'admin' && $_SESSION['user']['Role'] !== 'accountant' && $_SESSION['user']['Role'] !== 'deliverer')) {
        header("Location: LogReg.php");
        exit;
    }

    $admin_id = $_SESSION['user']['UserId'];

    if(!isset($admin_id)){
        header('location:LogReg.php');
    }

    if($_SESSION['user']['Role']=='accountant' || $_SESSION['user']['Role']=='deliverer'){
        $displayHome="none";
        $displayProducts="none";
        $displayOrders="block";
        $displayAdmin="none";
        $displayUsers="none";
        $displayMessages="none";
    }


    if(isset($_POST['update'])){
        $order_id = $_POST['orderId'];
        $payment_status = $_POST['paymentStatus'];

        $statusUpdateQuery = "UPDATE orders SET Payment_status='$payment_status' WHERE Id='$order_id'";
        if($conn->query($statusUpdateQuery)){
            $success= "Payment status was updated";
        }
    }

    if(isset($_POST['deliver'])){
        $deliver_id = $_POST['orderId'];
        $checkQuery="SELECT * FROM deliverorders WHERE deliver_id='$deliver_id'";
        $checkResult=$conn->query($checkQuery);
        if($checkResult->num_rows>0){
            $unsuccess="The order already proceeded to deliver !";
        }else{
            $idInsertQuery = "INSERT INTO deliverorders(deliver_id) VALUES('$deliver_id') ";
            if($conn->query($idInsertQuery)){
                $success="Proceeded to deliver";
            }
        }

        
    }

    if(isset($_POST['updateDeliveryStatus'])){
        $order_id = $_POST['orderId'];
        $delivery_status = $_POST['deliveryStatus'];
        $currentDate=date('Y-m-d');

        $statusUpdateQuery = "UPDATE orders SET Delivery_status='$delivery_status',Delivered_on='$currentDate' WHERE Id='$order_id'";
        if($conn->query($statusUpdateQuery)){
            $success= "Delivery status was updated";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    
    <?php include 'admin_header.php';?>

    <p style="text-align:center;margin-top:120px;"><span class="success-message"><?=$success;?></span><span class="unsuccess-message"><?=$unsuccess;?></span></p>
    <h2 class="heading mb-5" style="text-align:center;margin-top: 20px;margin-bottom: 40px;">ORDER ID:<?= $linkedOrderId;?></h2>
    <div class="container mt-5 mb-5">
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
                
                <!--Check the payment_slip is null-->
            </div>
            <?php
                if($_SESSION['user']['Role']!=='deliverer'){

                
            ?>
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
                        <form action="" method="POST">
                            <input type="hidden" name="orderId" value="<?= $fetch_orders['Id']; ?>">
                            <div class="row g-3 align-items-left">
                                <div class="col-auto"  style="position:relative; left:-20px;">
                                    <label style="text-align:left">Payment Status:</label>
                                </div>
                                <div class="col-auto">
                                    <select name="paymentStatus" class="form-select" aria-label="Default select example">
                                        <option value="<?= $fetch_orders['Payment_status'];?>" selected dissabled class="fetchData"><?= $fetch_orders['Payment_status'];?></option>
                                        <option value="pending" class="fetchData">pending</option>
                                        <option value="complete" class="fetchData">complete</option>
                                    </select>
                                </div>
                            </div>
                                
                    </li>
                            <li class="list-group-item">
                            <button type="submit" class="btn btn-primary update-btn mb-2" name="update">Update</button>
                            <button type="submit" class="btn btn-primary option-btn" name="deliver">Proceed to deliver</button>
                            <br><br>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <br><br>
        <div class="row orderView">
            <?php
                if(!empty($fetch_orders['Payment_slip'])){
                    echo '<h2 class="heading mb-5" style="text-align:center;">Payment Slip</h2>';
                    echo '<img src="PaymentSlips/'.$fetch_orders['Payment_slip'].'" alt="download error" class="payment-slip-img">';
                }
            ?>
        </div>
        <?php
                }else{
        ?>
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
                        <p>Payment status: <span class="fetchData"><?= $fetch_orders['Payment_status'];?></span></p>
                        <form action="" method="POST">
                            <input type="hidden" name="orderId" value="<?= $fetch_orders['Id']; ?>">
                            <div class="row g-3 align-items-left">
                                <div class="col-auto"  style="position:relative; left:-20px;">
                                    <label style="text-align:left">Delivery Status:</label>
                                </div>
                                <div class="col-auto">
                                    <select name="deliveryStatus" class="form-select" aria-label="Default select example">
                                        <option value="<?= $fetch_orders['Delivery_status'];?>" selected dissabled class="fetchData"><?= $fetch_orders['Delivery_status'];?></option>
                                        <option value="processing" class="fetchData">processing</option>
                                        <option value="delivered" class="fetchData">delivered</option>
                                    </select>
                                </div>
                            </div>
                                
                    </li>
                            <li class="list-group-item">
                            <button type="submit" class="btn btn-primary update-btn mb-2" name="updateDeliveryStatus">Update</button>
                            <br><br>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <?php 
                }
        ?>
        <br><br>
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
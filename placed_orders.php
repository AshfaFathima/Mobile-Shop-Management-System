<?php
    include 'connect.php';

    $modal="";
    $home="";
    $products="";
    $orders="active";
    $admin="";
    $users="";
    $mesages="";

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


    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $deleteQuery = "DELETE FROM orders WHERE Id='$delete_id'";
        $conn->query($deleteQuery);

        $deleteDeliverQuery = "DELETE FROM deliverorders WHERE deliver_Id='$delete_id'";
        $conn->query($deleteDeliverQuery);

        header('location:placed_orders.php');
    }

    if(isset($_GET['deleteDelivered'])){
        $delete_id = $_GET['deleteDelivered'];
        $deleteQuery = "DELETE FROM deliverorders WHERE Id='$delete_id'";
        $conn->query($deleteQuery);
        header('location:placed_orders.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>placed_orders</title>
    <style>
        *{
            font-family: 'Roboto', sans-serif;
        }
        .fetchData{
            color:blue;
        }
    </style>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include 'admin_header.php';?>
        <h2 class="heading" style="text-align:center;">PLACED ORDERS</h2>
        <h5 style="text-align:center; color:green;"><?= $modal;?></h5>
        <div class="container">
            <div class="row justify-content-center">
                <?php
                if($_SESSION['user']['Role']!=='deliverer'){

                
                    if(isset($_GET['orderStatus'])){
                        $orderStatus=$_GET['orderStatus'];
                        $placedOrderQuery="SELECT * FROM orders WHERE Payment_status = '$orderStatus'";
                    }else{
                        $placedOrderQuery="SELECT * FROM orders";
                    }
                        $result=$conn->query($placedOrderQuery);
                        if($result->num_rows>0){
                            while($fetch_orders=mysqli_fetch_assoc($result)){
                ?>
                <div class="col-md-4" style="padding:10px;">
                    <div class="card order-card" style="width: 25rem;">
                        <div class="card-header">
                            <h5 class="heading" style="text-align:center;margin-top: 20px;">ORDER: <span><?= $fetch_orders['Id'];?></span></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <p>User Id: <span class="fetchData"><?= $fetch_orders['User_Id'];?></span></p>
                                <p>Name: <span class="fetchData"><?= $fetch_orders['Name'];?></span></p>
                                <p>Email: <span class="fetchData"><?= $fetch_orders['Email'];?></span></p>
                                <p>Phone number: <span class="fetchData"><?= $fetch_orders['Number'];?></span></p>
                                <p>Placed on: <span class="fetchData"><?= $fetch_orders['Placed_on'];?></span></p>
                                <p>Payment method: <span class="fetchData"><?= $fetch_orders['Method'];?></span></p>
                                <p>Payment status: <span class="fetchData"><?= $fetch_orders['Payment_status'];?></span></p>
                                <p>Delivery status: <span class="fetchData"><?= $fetch_orders['Delivery_status'];?></span></p>
                                <?php
                                    if($fetch_orders['Delivery_status']=='delivered'){
                                        echo'<p>Delivered on: <span class="fetchData">'.$fetch_orders['Delivered_on'].'</span></p>';
                                    }
                                ?>
                                
                                
                            </li>
                            <li class="list-group-item">
                                <a href="orderView.php?Id=<?= $fetch_orders['Id'];?>&grandTotal=<?= $fetch_orders['Total_price'];?>" class="btn btn-primary update-btn">View</a>
                                <br><br>
                                <a href="placed_orders.php?delete=<?= $fetch_orders['Id']; ?>" class="btn btn-primary delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
                        }
                    }else{
                        echo '<p class="empty">No placed orders</p>';
                    }
                }else{
                    
                    $deliverIdQuery="SELECT * FROM deliverorders";
                    $deliverIdResult=$conn->query($deliverIdQuery);
                    if($deliverIdResult->num_rows>0){
                        while($fetch_deliverId=mysqli_fetch_assoc($deliverIdResult)){
                            $deliverId=$fetch_deliverId['deliver_Id'];
                            $placedOrderQuery="SELECT * FROM orders WHERE Id='$deliverId'";
                            $ordersResult=$conn->query($placedOrderQuery);
                            if($ordersResult->num_rows>0){
                                while($fetch_orders=mysqli_fetch_assoc($ordersResult)){

                ?>
                <div class="col-md-4" style="padding:10px;">
                    <div class="card order-card" style="width: 25rem;">
                        <div class="card-header">
                            <h5 class="heading" style="text-align:center;margin-top: 20px;">ORDER: <span><?= $fetch_orders['Id'];?></span></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <p>User Id: <span class="fetchData"><?= $fetch_orders['User_Id'];?></span></p>
                                <p>Name: <span class="fetchData"><?= $fetch_orders['Name'];?></span></p>
                                <p>Email: <span class="fetchData"><?= $fetch_orders['Email'];?></span></p>
                                <p>Phone number: <span class="fetchData"><?= $fetch_orders['Number'];?></span></p>
                                <p>Placed on: <span class="fetchData"><?= $fetch_orders['Placed_on'];?></span></p>
                                <p>Payment method: <span class="fetchData"><?= $fetch_orders['Method'];?></span></p>
                                <p>Payment status: <span class="fetchData"><?= $fetch_orders['Payment_status'];?></span></p>
                                <p>Payment status: <span class="fetchData"><?= $fetch_orders['Payment_status'];?></span></p>
                                <p>Delivery status: <span class="fetchData"><?= $fetch_orders['Delivery_status'];?></span></p>
                                <?php
                                    if($fetch_orders['Delivery_status']=='delivered'){
                                        echo'<p>Delivered on: <span class="fetchData">'.$fetch_orders['Delivered_on'].'</span></p>';
                                    }
                                ?>
                                
                            </li>
                            <li class="list-group-item">
                                <a href="orderView.php?Id=<?= $fetch_orders['Id'];?>&grandTotal=<?= $fetch_orders['Total_price'];?>" class="btn btn-primary update-btn">View</a>
                                <br><br>
                                <a href="placed_orders.php?deleteDelivered=<?= $fetch_deliverId['Id']; ?>" class="btn btn-primary delete-btn" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
                                }
                            }

                        }
                    }else{
                        echo '<p class="empty">No placed orders</p>';
                    }
                }
                ?>
            </div>
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
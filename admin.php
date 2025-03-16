<?php

    include 'connect.php';

    $home="active";
    $products="";
    $orders="";
    $admin="";
    $users="";
    $mesages="";

  session_start();

    // Check if user is logged in as admin
    if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'admin') {
        // Redirect to login page
        header("Location: LogReg.php");
        exit;
    }

    // Get the user ID from the session
    $admin_id = $_SESSION['user']['UserId'];

    if(!isset($admin_id)){
        header('location:LogReg.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            font-family: 'Roboto', sans-serif;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css">

</head>
<body>

    <?php include 'admin_header.php'?>

    <!--Admin dashboard section start-->

    <div class="container text-center" style="margin-top: 100px;">
        <h2 class="heading">DASHBOARD</h2>
        <div class="row">
            
            <div class="col custom-col align-self-end">
                <h3>Welcome!</h3>
                <p><?= $fetch_profile['LastName']; ?></p>
                <a href="update_profile.php" class="btn update-btn">Update Profile</a>
            </div>
            <div class="col custom-col">
                <?php
                    $total_pendings = 0;

                    $query = mysqli_query($conn,"SELECT * FROM orders WHERE payment_status = 'pending'");
                    while($fetched_pendings = mysqli_fetch_assoc($query)){
                    $total_pendings += $fetched_pendings['Total_price'];
                    }
                ?>
                <h3><span>$<span><?= $total_pendings; ?></span></span>/-</h3>
                <p>Total pendings</p>
                <a href="placed_orders.php?orderStatus=pending" class="btn option-btn">See Orders</a>
            </div>
            <div class="col custom-col">
                <?php
                    $total_completes = 0;

                    $query = mysqli_query($conn,"SELECT * FROM orders WHERE Payment_status = 'complete'");
                    while($fetched_completes = mysqli_fetch_assoc($query)){
                    $total_completes += $fetched_completes['Total_price'];
                    }
                ?>
                <h3><span>$<span><?= $total_completes; ?></span></span>/-</h3>
                <p>Total completes</p>
                <a href="placed_orders.php?orderStatus=complete" class="btn option-btn">See Orders</a>
            </div>
            <div class="col custom-col">
                <?php

                $query = mysqli_query($conn,"SELECT * FROM orders");
                $number_of_orders = mysqli_num_rows($query);

                ?>
                <h3><?= $number_of_orders; ?></h3>
                <p>Total orders</p>
                <a href="placed_orders.php" class="btn option-btn">See Orders</a>
            </div>
        </div>
        <br>
        <div class="row align-items-end">
            <div class="col custom-col">
                <?php

                    $query = mysqli_query($conn,"SELECT * FROM products");
                    $number_of_products = mysqli_num_rows($query);

                ?>
                <h3><?= $number_of_products; ?></h3>
                <p>Products added</p>
                <a href="products.php" class="btn option-btn">See Products</a>
            </div>
            <div class="col custom-col">
                <?php

                    $query = mysqli_query($conn,"SELECT * FROM users WHERE Role='customer'");
                    $number_of_users = mysqli_num_rows($query);

                ?>
                <h3><?= $number_of_users; ?></h3>
                <p>Users accounts</p>
                <a href="users_accounts.php" class="btn option-btn">See Users</a>
            </div>
            <div class="col custom-col">
                <?php

                    $query = mysqli_query($conn,"SELECT * FROM users WHERE Role = 'admin' OR Role = 'stock_keeper' OR Role = 'deliverer' OR Role = 'accountant'");
                    $number_of_admins = mysqli_num_rows($query);

                ?>
                <h3><?= $number_of_admins; ?></h3>
                <p>Admins accounts</p>
                <a href="admin_accounts.php" class="btn option-btn">See Admins</a>
            </div>
            <div class="col custom-col">
                <?php

                    $query = mysqli_query($conn,"SELECT * FROM messages ");
                    $number_of_messages = mysqli_num_rows($query);

                ?>
                <h3><?= $number_of_messages; ?></h3>
                <p>Total messages</p>
                <a href="messages.php" class="btn option-btn">See Messages</a>
            </div>
        </div>
    </div>

    <!--Admin dashboard section end-->







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
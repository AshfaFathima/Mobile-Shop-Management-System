<?php
    include 'connect.php';

    $home="";
    $products="";
    $orders="";
    $admin="active";
    $users="";
    $mesages="";
    $modal="";

    session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'admin') {
        header("Location: LogReg.php");
        exit;
    }

    $admin_id = $_SESSION['user']['UserId'];

    if(!isset($admin_id)){
        header('location:LogReg.php');
    }

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $deleteQuery = "DELETE FROM users WHERE UserId='$delete_id'";
        $conn->query($deleteQuery);
        header('location:admin_accounts.php');
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

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-4" style="margin-top:120px;">
                <div class="card" style="width: 25rem;">
                    <div class="card-header">
                        <h5 class="heading" style="text-align:center;margin-top: 20px;">Register new admin</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="register_admin.php" class="option-btn">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="heading" style="text-align:center; margin-top: 50px;">Admin Accounts</h2>

    <div class="container">
        <div class="row justify-content-left">

            <?php
                $selectQuery="SELECT * FROM users WHERE Role = 'admin' OR Role = 'stock_keeper' OR Role = 'deliverer' OR Role = 'accountant'";
                $result = $conn->query($selectQuery);

                if($result->num_rows>0){
                    while($fetch_admins=mysqli_fetch_assoc($result)){
                        
                    
            ?>
            <div class="col-md-3" style="padding:10px;">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        <h5 class="heading" style="text-align:center;margin-top: 20px;"><span><?= $fetch_admins['LastName'];?></span></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p>Id: <span class="fetchData"><?= $fetch_admins['UserId'];?></span></p>
                            <p>Role: <span class="fetchData"><?= $fetch_admins['Role'];?></span></p>
                        </li>
                        <li class="list-group-item">
                            <?php
                                if($fetch_admins['UserId']==$admin_id){
                                    echo '<a href="update_profile.php" class="update-btn">Update Profile</a>';
                                }
                                else{
                                    echo '<a href="admin_accounts.php?delete=' . $fetch_admins['UserId'] . '" class="btn btn-primary delete-btn" onclick="return confirm(\'Are you sure you want to delete this admin account?\');">Delete</a>';
                                }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">No admin accounts</p>';
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
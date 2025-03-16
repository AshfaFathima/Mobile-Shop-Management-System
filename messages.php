<?php
    include 'connect.php';

    $home="";
    $products="";
    $orders="";
    $admin="";
    $users="";
    $mesages="active";

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
        $deleteQuery = "DELETE FROM messages WHERE Id='$delete_id'";
        $conn->query($deleteQuery);
        header('location:messages.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

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

    <div class="container">
        <?php include 'admin_header.php';?>
        <h2 class="heading" style="text-align:center;">Customer Messages</h2>
        <div class="row justify-content-center">
            <?php
                $showQuery = "SELECT * FROM messages";
                $result=$conn->query($showQuery);
                if($result->num_rows>0){
                    while($fetch_messages=mysqli_fetch_assoc($result)){
                            
                ?>
                <div class="col-md-3" style="padding:10px;">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            <h5 class="heading" style="text-align:center;margin-top: 20px;">User Id: <span><?= $fetch_messages['User_Id'];?></span></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <p>Name: <span class="fetchData"><?= $fetch_messages['Name'];?></span></p>
                                <p>Phone number: <span class="fetchData"><?= $fetch_messages['Number'];?></span></p>
                                <p>Email: <span class="fetchData"><?= $fetch_messages['Email'];?></span></p>
                            </li>
                            <li class="list-group-item">
                                <p>Message: <span class="fetchData"><?= $fetch_messages['Message'];?></span></p>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">No messages!</p>';
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
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

    <div class="container" style="margin-top:120px;">
        <p style="text-align:center;"><span class="success-message"><?=$success;?></span><span class="unsuccess-message"><?=$unsuccess?></span></p>
        <h2 class="heading" style="text-align:center;">Order History</h2>
        <br>
        <table class="table cart-table">
            <thead class="table-dark">
                <th>Order Id</th>
                <th>Products</th>
                <th>Status</th>
                <th class="center">Action</th>
            </thead>
            <?php
                $showQuery = "SELECT * FROM orders WHERE User_Id='$userId'";
                $result=$conn->query($showQuery);
                if($result->num_rows>0){
                    while($fetch_order=mysqli_fetch_assoc($result)){
            ?>
            <tbody>
                <tr>
                    <td>#<?= $fetch_order['Id'];?></td>
                    <td><?= $fetch_order['Total_products'];?></td>
                    <td style="color:<?php if($fetch_order['Payment_status']=='pending'){echo 'red';}else{echo 'blue';}?>"><?= $fetch_order['Payment_status'];?></td>
                    <td><a href="customerOrder.php?Id=<?= $fetch_order['Id'];?>&grandTotal=<?= $fetch_order['Total_price']?>" class="btn btn-primary update-btn">View</a></td>
                </tr>
            <?php
                    }
                }else{
                    echo '<tr><td colspan="6"><p class="empty">No Orders avilale!</p></td></tr>';
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
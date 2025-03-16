<?php

    include 'connect.php';

    $home="";
    $about="active";

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
    }


    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $number=$_POST['number'];
        $email=$_POST['email'];
        $message=$_POST['comment'];

        $query="INSERT INTO messages(User_Id,Name,Email,Number,Message) VALUES('$userId','$name','$email','$number','$message')";
        $result=$conn->query($query);

        if($result==TRUE){
            $success="Message submited";
        }else{
            $unsuccess="Error!";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <?php include 'userHeader.php';?>

    <div class="container form-style contact-section">
        <br>
        <p style="text-align:center;"><span class="success-message"><?=$success;?></span><span class="unsuccess-message"><?=$unsuccess?></span></p>
        <h3 class="heading" style="text-align:center;margin-top: 10px;margin-bottom: 40px;">COMMENTS</h3>
        <form action="" method="POST">
            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" placeholder="" required>
                <label>Name</label>
            </div>
            <div class="form-floating">
                <input type="text" name="number" class="form-control" placeholder="" required>
                <label>Contact Number</label>
            </div>
            <br>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" name="comment" placeholder="Leave a comment here" style="height: 150px" required></textarea>
                <label for="floatingTextarea2">Comments</label>
            </div>
            <br>
            <div class="center">
                <button type="submit" name="submit" class="btn btn-primary rounded-pill contact-submit-btn">Submit</button>
            </div>
        </form>
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
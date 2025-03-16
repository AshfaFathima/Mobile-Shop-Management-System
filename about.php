<?php

    include 'connect.php';

    $home="";
    $about="active";

    session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']['Role'] == 'customer'){
        $userId=$_SESSION['user']['UserId'];
    }
    else{
        $userId="";
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
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body{
            background-image: url('img/world_Map.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

    </style>
</head>
<body class="about-background">
    
    <?php include 'userHeader.php';?>

    <div class="container about-Background" style="margin-top:120px; margin-bottom:50px">
        <div class="row mt-5">
            <div class="col-lg-5 col-md-12 col-12">
                <img class="img-fluid w-100 pb-1" src="img/about2.png" alt="">
            </div>
            <div class="col-lg-5 col-md-12 col-12">
                <h3 class="about-tittle">Why choose us ?</h3>
                <p class="mt-5 about-description">Welcome to Tech Island, your ultimate destination for the latest smartphones, gadgets, and accessories. At Tech Island, we are passionate about bringing you cutting-edge technology from top brands, ensuring you stay connected and ahead in today's fast-paced world. Our commitment to quality, exceptional customer service, and a seamless shopping experience sets us apart. Whether you're a tech enthusiast or simply looking for the perfect device, Tech Island has something for everyone. Join us on this journey and discover the future of mobile technology.</p>
                <a href="contact.php" class="contactUs-btn btn btn-primary rounded-pill">Contact us ?</a>
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
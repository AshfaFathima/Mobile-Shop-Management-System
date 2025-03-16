<?php

    include 'connect.php';

    $SuccessMessage="";
    $errorMessage="";

    session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']['Role'] == 'customer'){
        $userId=$_SESSION['user']['UserId'];
    }
    else{
        $userId="";
    }


    if(isset($_POST['save'])){
        $firstName=$_POST['fName'];
        $lastName=$_POST['lName'];
        $email=$_POST['email'];
        $oldEmail=$_SESSION['user']['Email'];

        if($email == $oldEmail){
            $updateQuery = "UPDATE users SET FirstName='$firstName', LastName='$lastName', Email='$email' WHERE UserId='$userId'";
            $result = $conn->query($updateQuery);
            if($result == TRUE){
                $SuccessMessage="Successfully updated";
            }else{
                $errorMessage="System error !.";
            }
        }else{
            $checkEmail="SELECT * FROM users WHERE Email='$email'";
            $result=$conn->query($checkEmail);
            if($result->num_rows>0){
                $errorMessage="The updated email address already exists!";
            }else{
                $updateQuery = "UPDATE users SET FirstName='$firstName', LastName='$lastName', Email='$email' WHERE UserId='$userId'";
                $result = $conn->query($updateQuery);
                if($result == TRUE){
                    $SuccessMessage="Data saved";
                }else{
                    $errorMessage="System error !.";
                }
            }
        }
    }

    if(isset($_POST['update'])){
        $inputOldPassword=md5($_POST['Oldpw']);
        $oldPassword=$_SESSION['user']['Password'];
        $password=$_POST['pw'];
        $hashed_password=md5($password);
        $confirm_pw=$_POST['confirm_pw'];

        if($inputOldPassword == $oldPassword){
            if($password == $confirm_pw){
                $pwUpdateQuery = "UPDATE users SET Password='$hashed_password' WHERE UserId='$userId'";
                $result= $conn->query($pwUpdateQuery);
                if($result== TRUE){
                    $SuccessMessage="Password changed";
                }else{
                    $errorMessage="System error !";
                }
            }else{
                $errorMessage="Confirmation Password does not match!";
            }
        }else{
            $errorMessage="Old Password is incorrect!";
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
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/formStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    
    <?php include 'userHeader.php'; ?>


    <div class="container user-profile" style="width:1000px">
        <div class="row pfrofile-section">
            <div class="col-md-1 col-sm-12">
                <div class="container profile">
                    <div class="card profile-card" style="width: 18rem;">
                        <img src="img/profile.jpg" class="card-img-top profile-img" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $fetch_profile['FirstName']; ?> <?= $fetch_profile['LastName']; ?></h5>
                            <p class="card-text"><?= $fetch_profile['Email']; ?></p>
                            <div class="row">
                                <button class="btn btn-primary btn-setting" id="profilebtn"><i class="fa-solid fa-user"></i>  <span>Profile</span><i class="fa-solid fa-chevron-right"></i></button>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary btn-setting" id="privacybtn"><i class="fa-solid fa-shield-halved"></i>  <span>Privacy</span><i class="fa-solid fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-11 col-sm-12">
                
                <div class="container form-style" id="profile">
                    <h6 class="success-Msg"><?= $SuccessMessage; ?></h6>
                    <h6 class="error-Msg"><?= $errorMessage; ?></h6>
                    <h1 class="formTitle">Update Profie</h1>
                    <form method="POST" action="" class="userProfile-form">
                        <div class="mb-3">
                            <label for="InputEmail" class="form-label" id="emailLabel" style="display: none;">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?= $fetch_profile['Email']; ?>" aria-describedby="emailHelp" placeholder="Email" required style="color:blue;">
                        </div>
                        <div class="mb-3">
                            <label for="InputfName" class="form-label" id="fNameLabel" style="display: none;">First Name</label>
                            <input type="text" class="form-control" name="fName" id="fName" placeholder="First Name" value="<?= $fetch_profile['FirstName']; ?>" required style="color:blue;">
                        </div>
                        <div class="mb-3">
                            <label for="InputlName" class="form-label" id="lNameLabel" style="display: none;">Last Name</label>
                            <input type="text" class="form-control" name="lName" id="lName" placeholder="Last Name" value="<?= $fetch_profile['LastName']; ?>" required style="color:blue;">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Save" name="save">
                    </form>
                </div>


                <div class="container form-style" style=" display: none;" id="privacy">
                    <h6 class="success-Msg"><?= $SuccessMessage; ?></h6>
                    <h6 class="error-Msg"><?= $errorMessage; ?></h6>
                    <h1 class="formTitle">Change Password</h1>
                    <form method="POST" action="" class="userProfile-form">
                        <div class="mb-3">
                            <label for="InputPassword1" class="form-label" id="OldpwLabel" style="display: none;">Old Password</label>
                            <input type="password" class="form-control" name="Oldpw" id="Oldpw" placeholder="Old Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputPassword1" class="form-label" id="pwLabel" style="display: none;"> New Password</label>
                            <input type="password" class="form-control" name="pw" id="pw" placeholder="New Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputConfirmPassword" class="form-label" id="cpwLabel" style="display: none;">Confiirm Password</label>
                            <input type="password" class="form-control" name="confirm_pw" id="confirm_pw" placeholder="Confirm New Password" required>
                            <button type="button" id="ShowPassword" onclick="pass()"><i class="fa-solid fa-eye"></i></button>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update" name="update">
                    </form>
                </div>


            </div>
        </div>
    </div>
    

    
    <?php include 'footer.php';?>



<script>

    const fNameInput = document.getElementById('fName');
    const fNameLabel = document.getElementById('fNameLabel');

    const lNameInput = document.getElementById('lName');
    const lNameLabel = document.getElementById('lNameLabel');

    const emailInput = document.getElementById('email');
    const emailLabel = document.getElementById('emailLabel');

    const OldpwInput = document.getElementById('Oldpw');
    const OldpwLabel = document.getElementById('OldpwLabel');

    const pwInput = document.getElementById('pw');
    const pwLabel = document.getElementById('pwLabel');

    const cpwInput = document.getElementById('confirm_pw');
    const cpwLabel = document.getElementById('cpwLabel');


    fNameInput.addEventListener('focus', function() {
        fNameLabel.style.display = 'block';
    });

    fNameInput.addEventListener('blur', function() {
        if (!fNameInput.value) {
            fNameLabel.style.display = 'none';
        }
    });

    lNameInput.addEventListener('focus', function() {
        lNameLabel.style.display = 'block';
    });

    lNameInput.addEventListener('blur', function() {
        if (!lNameInput.value) {
            lNameLabel.style.display = 'none';
        }
    });

    emailInput.addEventListener('focus', function() {
        emailLabel.style.display = 'block';
    });

    emailInput.addEventListener('blur', function() {
        if (!emailInput.value) {
            emailLabel.style.display = 'none';
        }
    });

    OldpwInput.addEventListener('focus', function() {
        OldpwLabel.style.display = 'block';
    });

    OldpwInput.addEventListener('blur', function() {
        if (!OldpwInput.value) {
            OldpwLabel.style.display = 'none';
        }
    });

    pwInput.addEventListener('focus', function() {
        pwLabel.style.display = 'block';
    });

    pwInput.addEventListener('blur', function() {
        if (!pwInput.value) {
            pwLabel.style.display = 'none';
        }
    });

    cpwInput.addEventListener('focus', function() {
        cpwLabel.style.display = 'block';
    });

    cpwInput.addEventListener('blur', function() {
        if (!cpwInput.value) {
            cpwLabel.style.display = 'none';
        }
    });

    
    var x=false;
    function pass(){
        if(x){
            document.getElementById('pw').type='password';
            document.getElementById('confirm_pw').type='password';
            document.getElementById('Oldpw').type='password';
            x=false;
        }else{
            document.getElementById('pw').type='text';
            document.getElementById('confirm_pw').type='text';
            document.getElementById('Oldpw').type='text';
            x=true;
        }
    }

    const profileBtn=document.getElementById('profilebtn');
    const privacyBtn=document.getElementById('privacybtn');
    const profileArea=document.getElementById('profile');
    const privacyArea=document.getElementById('privacy');

    profileBtn.addEventListener('click',function(){
        profileArea.style.display="block";
        privacyArea.style.display="none";
    })

    privacyBtn.addEventListener('click',function(){
        privacyArea.style.display="block";
        profileArea.style.display="none";
    })
</script>


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
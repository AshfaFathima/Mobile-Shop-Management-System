<?php
    include 'connect.php';

    $home="";
    $products="";
    $orders="";
    $admin="active";
    $users="";
    $mesages="";

    session_start();

    $admin_id = $_SESSION['user']['UserId'];

    if(isset($_POST['update'])){
        $firstName=$_POST['fName'];
        $lastName=$_POST['lName'];
        $email=$_POST['email'];
        $oldEmail=$_SESSION['user']['Email'];
        $inputOldPassword=md5($_POST['Oldpw']);
        $oldPassword=$_SESSION['user']['Password'];
        $password=$_POST['pw'];
        $hashed_password=md5($password);
        $confirm_pw=$_POST['confirm_pw'];



        if($email==$oldEmail){
            if($inputOldPassword==$oldPassword) {
                if($password==$confirm_pw){
                    $updateQuery="UPDATE users SET FirstName='$firstName', LastName='$lastName', Email='$email', Password='$hashed_password' WHERE UserId='$admin_id'";
                    $result=$conn->query($updateQuery);   
                    if($result==TRUE){
                        echo "<script>alert('Data Updated.');</script>";
                        echo "<script>window.location.href = 'update_profile.php';</script>";
                    }
                    else{
                        echo "Error:".$conn->error;
                    }
                    
                }else{
                    echo "<script>alert('Confirmation Password does not match. Please try again.');</script>";
                    echo "<script>window.location.href = 'update_profile.php';</script>";
                }
                
            } else {
                echo "<script>alert('Old Password does not match! Please try again.');</script>";
                echo "<script>window.location.href = 'update_profile.php';</script>";
                exit();
            }
        }else{
            $checkEmail="SELECT * FROM users WHERE Email='$email'";
            $result=$conn->query($checkEmail);
            if($result->num_rows>0){
                echo "<script>alert('The updated email address already exists! Please try again.');</script>";
                echo "<script>window.location.href = 'update_profile.php';</script>";
            }else{
                if($inputOldPassword==$oldPassword) {
                    if($password==$confirm_pw){
                        $updateQuery="UPDATE users SET FirstName='$firstName', LastName='$lastName', Email='$email', Password='$hashed_password'";
                        $result=$conn->query($updateQuery);   
                        if($result==TRUE){
                            echo "<script>alert('Data Updated.');</script>";
                            echo "<script>window.location.href = 'update_profile.php';</script>";
                        }
                        else{
                            echo "Error:".$conn->error;
                        }
                        
                    }else{
                        echo "<script>alert('Confirmation Password does not match. Please try again.');</script>";
                        echo "<script>window.location.href = 'update_profile.php';</script>";
                    }
                    
                } else {
                    echo "<script>alert('Old Password does not match! Please try again.');</script>";
                    echo "<script>window.location.href = 'update_profile.php';</script>";
                    exit();
                }
            }
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
    
    <?php include 'admin_header.php'; ?>

    <div class="container form-style" style="margin-top: 150px;">
        <h1 class="formTitle">Update Profie</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label" id="RoleLabel" style="display: none;">Role</label>
                <select class="form-select" aria-label="Default select example" name="roleSelect" id="roleSelect" value="<?= $fetch_profile['Role']; ?>" required style="color:blue;">
                    <option selected disabled>Select Role</option>
                    <option value="admin" <?php if ($fetch_profile['Role'] == 'admin') echo 'selected'; ?> disabled>Admin</option>
                    <option value="stock_keeper" <?php if ($fetch_profile['Role'] == 'stock_keeper') echo 'selected'; ?> disabled>Stock Keeper</option>
                    <option value="deliverer" <?php if ($fetch_profile['Role'] == 'deliverer') echo 'selected'; ?> disabled>Deliverer</option>
                    <option value="accountant" <?php if ($fetch_profile['Role'] == 'accountant') echo 'selected'; ?> disabled>Accountant</option>
                </select>
            </div>
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

        const roleSelect = document.getElementById('roleSelect');
        const roleLabel = document.getElementById('RoleLabel');
        
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

        roleSelect.addEventListener('change', function() {
            roleLabel.style.display = 'block';
        });

        if (roleSelect.value === "") {
            roleLabel.style.display = 'none';
        }

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
        
    </script>

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
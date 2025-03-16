<?php

    include 'connect.php';

    $home="";
    $products="";
    $orders="";
    $admin="active";
    $users="";
    $mesages="";

    $query = mysqli_query($conn,"SELECT * FROM users WHERE Role = 'admin'");
    $fetch_profile = mysqli_fetch_assoc($query);
    $admin_id = $fetch_profile['UserId'];

    if(isset($_POST['register'])){
        $firstName=$_POST['fName'];
        $lastName=$_POST['lName'];
        $role=$_POST['roleSelect'];
        $email=$_POST['email'];
        $password=$_POST['pw'];
        $hashed_password=md5($password);
        $confirm_pw=$_POST['confirm_pw'];
        $hashed_confirm_pw=md5($confirm_pw);


        if($password==$confirm_pw) {
            $checkEmail="SELECT * FROM users WHERE Email='$email'";
            $result=$conn->query($checkEmail);
            if($result->num_rows>0){
                echo "<script>alert('Email address already exists! Please try again.');</script>";
                echo "<script>window.location.href = 'register_admin.php';</script>";
            }
            else{
                $insertQuery="INSERT INTO users(FirstName,LastName,Role,Email,Password) VALUES ('$firstName','$lastName','$role','$email','$hashed_password')";
                
                if($conn->query($insertQuery)==TRUE){
                    echo "<script>alert('New admin registered.');</script>";
                    echo "<script>window.location.href = 'register_admin.php';</script>";
                }
                else{
                    echo "Error:".$conn->error;
                }
            }
        } else {
            echo "<script>alert('Passwords don\'t match. Please try again.');</script>";
            echo "<script>window.location.href = 'register_admin.php';</script>";
            exit();
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
    
    <?php include 'admin_header.php'?>

    <div class="container form-style" style="margin-top: 150px">
        <h1 class="formTitle">Register New Admin</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label" id="RoleLabel" style="display: none;">Role</label>
                <select class="form-select" aria-label="Default select example" name="roleSelect" id="roleSelect" required>
                    <option selected disabled>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="stock_keeper">stock keeper</option>
                    <option value="deliverer">deliverer</option>
                    <option value="accountant">Accountant</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="InputEmail" class="form-label" id="emailLabel" style="display: none;">Email</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="InputfName" class="form-label" id="fNameLabel" style="display: none;">First Name</label>
                <input type="text" class="form-control" name="fName" id="fName" placeholder="First Name" required>
            </div>
            <div class="mb-3">
                <label for="InputlName" class="form-label" id="lNameLabel" style="display: none;">Last Name</label>
                <input type="text" class="form-control" name="lName" id="lName" placeholder="Last Name" required>
            </div>
            <div class="mb-3">
                <label for="InputPassword1" class="form-label" id="pwLabel" style="display: none;">Password</label>
                <input type="password" class="form-control" name="pw" id="pw" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <label for="InputConfirmPassword" class="form-label" id="cpwLabel" style="display: none;">Confiirm Password</label>
                <input type="password" class="form-control" name="confirm_pw" id="confirm_pw" placeholder="Confirm Password" required>
                <button type="button" id="ShowPassword" onclick="pass()"><i class="fa-solid fa-eye"></i></button>
            </div>
            <input type="submit" class="btn btn-primary" value="Register" name="register">
        </form>
    </div>



    <script>

        const fNameInput = document.getElementById('fName');
        const fNameLabel = document.getElementById('fNameLabel');

        const lNameInput = document.getElementById('lName');
        const lNameLabel = document.getElementById('lNameLabel');
    
        const emailInput = document.getElementById('email');
        const emailLabel = document.getElementById('emailLabel');

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
                x=false;
            }else{
                document.getElementById('pw').type='text';
                document.getElementById('confirm_pw').type='text';
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
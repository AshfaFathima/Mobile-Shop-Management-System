<?php

    include 'connect.php';

    $errorMessaage="";
    $successMessage="";

    if(isset($_POST['signup'])){
        $firstName=$_POST['fName'];
        $lastName=$_POST['lName'];
        $role="customer";
        $email=$_POST['email'];
        $password=$_POST['pw'];
        $hashed_password=md5($password);
        $confirm_pw=$_POST['confirm_pw'];
        $hashed_confirm_pw=md5($confirm_pw);


        if($password==$confirm_pw) {
            $checkEmail="SELECT * FROM users WHERE Email='$email'";
            $result=$conn->query($checkEmail);
            if($result->num_rows>0){
                $errorMessaage="Email address already exists!";
            }
            else{
                $insertQuery="INSERT INTO users(FirstName,LastName,Role,Email,Password) VALUES ('$firstName','$lastName','$role','$email','$hashed_password')";
                
                if($conn->query($insertQuery)==TRUE){
                    $successMessage="Registration is successful.";
                }
                else{
                    echo "Error:".$conn->error;
                }
            }
        } else {
            $errorMessaage="Passwords don\'t match.";
            exit();
        }
    }

    if(isset($_POST['signIn'])){
        $email=$_POST['email'];
        $password=$_POST['pw'];
        $password=md5($password);

        $query = "SELECT * FROM users WHERE Email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            session_start();
            $user = mysqli_fetch_assoc($result);
    
            // Store user data in session for authorization
            $_SESSION['user'] = $user;
    

            switch ($user['Role']) {
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'stock_keeper':
                    header("Location: products.php");
                    break;
                case 'deliverer':
                    header("Location: placed_orders.php");
                    break;
                case 'customer':
                    header("Location: index.php");
                    break;
                case 'accountant':
                    header("Location: placed_orders.php");
                    break;
                default:
                    header("Location: LogReg.php");
                    break;
        }
        } else {
    
            $errorMessaage="Incorrect email or password.";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="LogReg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="container" id="signUp" style="display: none;">
        <h4><a href="index.php"><i class="fa-solid fa-house"></i></a></h4>
        <h5 class="message"><span class="error-Msg"><?= $errorMessaage; ?></span><span class="success-Msg"><?= $successMessage; ?></span></h5>
        <h1 class="formTitle">Register</h1>
        <form method="post" action="">
            <div class="inputGroup">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="fName" id="fName" placeholder="First Name" required>
                <label for="fname">Fisrt Name</label>
            </div>
            <div class="inputGroup">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                <label for="lname">Last Name</label>
            </div>
            <div class="inputGroup">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="inputGroup">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="pw" id="pw" placeholder="Password" required style="width: 93%;">
                <button type="button" id="ShowPassword" onclick="pass()"><i class="fa-solid fa-eye"></i></button>
                <label for="password">Password</label>
            </div>
            <div class="inputGroup">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="confirm_pw" id="confirm_pw" placeholder="Confirm Password" required style="width: 93%;">
                <button type="button" id="ShowConfirmPassword" onclick="cpass()"><i class="fa-solid fa-eye"></i></button>
                <label for="confirm_password">Confirm Password</label>
            </div>
            <input type="submit" class="btn" value="sign up" name="signup">
            <div class="links">
                <p>Already Have Account ?</p>
                <button id="signInBtn">Sign In</button>
            </div>
            
        </form>
    </div>

    <div class="container" id="signIn">
        <h4><a href="index.php"><i class="fa-solid fa-house"></i></a></h4>
        <h5 class="message"><span class="error-Msg"><?= $errorMessaage; ?></span><span class="success-Msg"><?= $successMessage; ?></span></h5>
        <h1 class="formTitle">Sign In</h1>
        <form method="post" action="">
            <div class="inputGroup">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="inputGroup">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="pw" id="pw" placeholder="Password" required style="width: 93%;" class="Login-pw">
                <button type="button" id="ShowPassword" onclick="loginpw()"><i class="fa-solid fa-eye"></i></button>
                <label for="password">Password</label>
            </div>
            <p class="recover">
                <a href="RecoverPage.php">Recover Password</a>
            </p>
            <input type="submit" class="btn" value="Sign In" name="signIn">
            <div class="links">
                <p>Don't have account yet?</p>
                <button id="signUpBtn">Sign Up</button>
            </div>
        </form>
    </div>

    <script>

        var x;
        var y;
        var z;
        function pass(){
            if(x==1){
                document.getElementById('pw').type='password';
                x=0;
            }else{
                document.getElementById('pw').type='text';
                x=1;
            }
        }

        function cpass(){
            if(y==1){
                document.getElementById('confirm_pw').type='password';
                y=0;
            }else{
                document.getElementById('confirm_pw').type='text';
                y=1;
            }
        }

        function loginpw(){
            if(z==1){
                document.getElementsByClassName("Login-pw")[0].type='password';
                z=0;
            }else{
                document.getElementsByClassName("Login-pw")[0].type='text';
                z=1;
            }
        }
    </script>
    <script src="LogReg.js"></script>
</body>
</html>
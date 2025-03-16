<?php

    include 'connect.php';

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
                echo "<script>alert('Email address already exists! Please try again.');</script>";
                echo "<script>window.location.href = 'LogReg.php';</script>";
            }
            else{
                $insertQuery="INSERT INTO users(FirstName,LastName,Role,Email,Password) VALUES ('$firstName','$lastName','$role','$email','$hashed_password')";
                
                if($conn->query($insertQuery)==TRUE){
                    echo "<script>alert('Registration is successful.');</script>";
                    header("location: LogReg.php");
                }
                else{
                    echo "Error:".$conn->error;
                }
            }
        } else {
            echo "<script>alert('Passwords don\'t match. Please try again.');</script>";
            echo "<script>window.location.href = 'LogReg.php';</script>";
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
    
            // Redirect based on user role
            switch ($user['Role']) {
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'stock_keeper':
                    header("Location: products.php");
                    break;
                case 'deliverer':
                    header("Location: delivery_person.php");
                    break;
                case 'customer':
                    header("Location: index.php");
                    break;
                case 'accountant':
                    header("Location: accountant.php");
                    break;
                default:
                    // Invalid role, redirect to login page with error message
                    header("Location: LogReg.php?error=invalid_role");
                    exit; // Add exit here to stop script execution
                    break;
        }
        } else {
    
            echo "<script>alert('Incorrect email or password. Please try again.');</script>";
            echo "<script>window.location.href = 'LogReg.php';</script>";
        }
    }


?>
<?php
include 'connect.php';

if(isset($_POST['recoverPassword'])){
    $email = $_POST['email'];
    
    $checkEmail = "SELECT * FROM users WHERE Email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];

        $password=md5($hashedPassword);
        
        // Send password to the user's email
        $to = $email;
        $subject = 'Your Password Recovery';
        $message = 'Your password is: ' . $password;
        $headers = 'From: your_email@example.com';
        
        // Send email
        if(mail($to, $subject, $message, $headers)){
            echo "Your password has been sent to your email address.";
        } else {
            echo "Failed to send password. Please try again later.";
        }
    } else {
        echo "Email address not found.";
    }
}
?>

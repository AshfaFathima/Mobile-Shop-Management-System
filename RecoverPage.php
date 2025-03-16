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
<div class="container" id="recoverPassword">
    <h1 class="formTitle">Recover Password</h1>
    <form method="post" action="PasswordRecover.php">
        <div class="inputGroup">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <input type="submit" class="btn" value="Recover Password" name="recoverPassword">
        <div class="links">
            <p>Remember your password? <a href="LogReg.php">Sign In</a></p>
        </div>
    </form>
</div>

</body>
</html>
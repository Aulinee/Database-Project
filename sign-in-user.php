<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>User Sign-In</title>
</head>
<body class="parallax container">
    <div class="main-page-div-1">
        <div class="col-100 main-logo-div">
            <img class="signin-logo" src="img/TMFLIX Background2-02.png" alt="logo">
        </div>  
    </div>
    <div class="sign-in-form">
        <form class="" action="">
            <h1 class="">Sign In For User</h1>
            <div class="username-div">
                <label for="uname">Username</label>
                <input type="text" placeholder="Enter Username" name="uname" required>
            </div>
            <br>
            <div class="password-div">
                <label for="psw">Password</label>
                <input type="password" placeholder="Enter Password" name="psw" required>
            </div>
            <br>
            <h2>New to TMFLIX? <a href="sign-up-user.php">Sign up now.</a></h2>
            <button class="sign-in sign-in-user" type="submit"><a href="">Sign In</a></button>
        </form>
    </div>
    <div class="admin-sign-in-label">
        <a href="sign-in-admin.php">Admin sign in here.</a>
    </div>
</body>
</html>
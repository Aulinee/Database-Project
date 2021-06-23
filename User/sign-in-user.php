<?php 
include '../database/dbConnection.php'; 
include 'UserClass.php';

$error ="";
$userObj = new User($conn);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // username and password sent from form 
    $myusername = $_POST['uname'];
    $mypassword = $_POST['psw']; 

    $authentication = $userObj->loginAuthentication($myusername,$mypassword);

    if(!$authentication){
        $error = "Your Login Name or Password is invalid";
    }else{
        // Set sessions
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['login_user'] = $myusername;
        $_SESSION['login_pass'] = $mypassword;

        // Login time is stored in a session variable 
        $_SESSION["login_time_stamp"] = time(); 
        
        header('location:main-page.php');
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
    <title>User Sign-In</title>
</head>
<body class="parallax container">
    <div class="main-page-div-1">
        <div class="col-100 main-logo-div">
            <img class="signin-logo" src="../img/TMFLIX Background2-02.png" alt="logo">
        </div>  
    </div>
    <div class="sign-in-form">
        <form name="login" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="">Sign In For User</h1>
            <div class="error-div">
                <p class="error-message"><?php echo $error; ?></p>
            </div>
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
            <button class="sign-in sign-in-user" name="login" type="submit">Sign In</button>
        </form>
    </div>
    <div class="admin-sign-in-label">
        <a href="sign-in-admin.php">Admin sign in here.</a>
    </div>
</body>
</html>
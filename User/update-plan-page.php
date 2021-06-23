<?php
include '../database/dbConnection.php'; 
include 'TVSeriesClass.php';
include 'sessionUser.php';

$error ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $plan_id = $_POST['subscription-plan'];
    $payment_method = $_POST['payment-method'];

    $userObj->makePayment($userid, $plan_id, $payment_method);
    $userObj->updateSubscription($subid, $plan_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Update Plan</title>
</head>
<body class="parallax">
    <header class="navbar-div" id="navbar">
        <div class="branding ">
            <img class="signup-logo" src="../img/TMFLIX Background2-02.png" alt="logo">
        </div>
        <div class="left-navbar ">
            <nav>
                <ul>
                    <li><a href="main-page.php#top-pick">Home</a></li>
                    <li><a href="main-page.php#series-genre">Series</a></li>
                    <li><a href="main-page.php#about-us">About Us</a></li>
                </ul>
            </nav>
        </div>
        <div class="right-navbar ">
            <nav>
                <ul>
                    <li><a href="account-detail-page.php"><i style="font-size:30px" class="fa fa-user" aria-hidden="true"></i>  <?php echo $username?></a></li>
                    <li><a href="logout.php"><i style="font-size:30px" class="fa">&#xf08b;</i>  Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="content container-95">
        <h2 class="update-plan-title">UPDATE PLAN</h2>
        <p class="error-message"><?php echo $error; ?></p>
        <div class="update-plan-content">
            <form name="update-plan" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="filter-container">
                    <input type="radio" id="standard-plan" name="subscription-plan" checked value="1">
                    <input type="radio" id="premium-plan" name="subscription-plan" value="2">
                    <div class="box-1">
                        <label for="standard-plan" class="standard-btn">
                            <h1>Standard Plan</h1>
                            <h3>One device and Good Quality (480p)</h3>
                            <h2>RM 17/month</h2>
                        </label>
                    </div>
                    <div class="box-2">
                        <label for="premium-plan" class="premium-btn">
                            <h1>Premium Plan</h1>
                            <h3>Multiple Device and Full HD (1080p)</h3>
                            <h2>RM 39/month</h2>
                        </label>
                    </div>
                </div>
                <div class="payment-method">
                    <label class="filter-payment-title">Payment Method: </label>
                    <select class="filter-payment" id="payment-method" name="payment-method" required>
                        <option value="Credit Card/Debit Card">Credit Card/Debit Card</option>
                        <option value="Online Banking">Online Banking</option>
                        <option value="E-Wallet Grab Pay">E-Wallet Grab Pay</option>
                        <option value="E-Wallet Touch 'n Go">E-Wallet Touch 'n Go</option>
                        <option value="E-Wallet Boost">E-Wallet Boost</option>
                    </select>
                </div>
                <div class="payment-btn">
                    <button class="payment-submit-btn" type="submit">Confirm</button>
                    <button class="payment-back-btn"><a href="account-detail-page.php">Go Back</a></button>
                </div>  
            </form>
        </div>
    </div>
</body>
</html>
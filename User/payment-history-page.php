<?php
include '../database/dbConnection.php'; 
include 'TVSeriesClass.php';
include 'sessionUser.php';
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
    <title>Payment History</title>
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
        <h1 class="payment">Payment History</h1>
        <div class="black-bg">
            <table class="payment-history-tb">
                <thead>
                    <tr class="bottom-border">
                        <th>Payment Date</th>
                        <th>Subscription Plan</th>
                        <th>Payment method</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $userObj->paymentHistory($userid) ?>
                    <!-- <tr class="bottom-border">
                        <td>Date</td>
                        <td>Description</td>
                        <td>Service period</td>
                        <td>Payment method</td>
                    </tr> -->
                </tbody>
            </table>
            <button class="button goback"><a href="account-detail-page.php">Go Back</a></button>
            <button class="button print"><a href="printPaymentReceipt.php">Print Latest Receipt</a></button>
        </div>
    </div>
</body>
</html>
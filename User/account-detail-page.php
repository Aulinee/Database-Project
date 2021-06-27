<?php
include '../database/dbConnection.php'; 
include '../class/TVSeriesClass.php';
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
    <title>Account Detail</title>
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
        <div class="account-detail-title">
            <h1>Account</h1>
            <h2>MEMBER SINCE <?php echo $memberdate; ?></h2>
        </div>
        <div class="account-detail-content">
            <div class="account-detail-content-justify">
                <hr>
                <div class="user-detail-row">
                    <div class="flexbox-1">
                        <h2>PROFILE DETAILS</h2>
                    </div>
                    <div class="flexbox-2">
                        <table class="user-detail-table">
                            <tr>
                                <td><h2 class="flexbox-2-1">Username</h2></td>
                                <td><h2 class="flexbox-2-2"><?php echo $username; ?></h2></td>
                            </tr>
                            <tr>
                                <td><h2 class="flexbox-2-1">Full Name</h2></td>
                                <td><h2 class="flexbox-2-2"><?php echo $fullname; ?></h2></td>
                            </tr>
                            <tr>
                                <td><h2 class="flexbox-2-1">Email</h2></td>
                                <td><h2 class="flexbox-2-2"><?php echo $email; ?></h2></td>
                            </tr>
                            <tr>
                                <td><h2 class="flexbox-2-1">Gender</h2></td>
                                <td><h2 class="flexbox-2-2"><?php echo $gender; ?></h2></td>
                            </tr>
                            <tr>
                                <td><h2 class="flexbox-2-1">Phone Number</h2></td>
                                <td><h2 class="flexbox-2-2"><?php echo $phonenum; ?></h2></td>
                            </tr>
                            <tr>
                                <td><h2 class="flexbox-2-1">Address</h2></td>
                                <td><h2 class="flexbox-2-2"><?php echo $address; ?></h2></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="user-detail-row">
                    <div class="flexbox-1">
                        <h2>SUBSCRIPTION DETAILS</h2>
                    </div>
                    <div class="flexbox-2">
                        <div class="subscription-detail">
                            <h2><?php echo $planType; ?></h2>
                            <h3><?php echo $planDesc; ?></h3>
                            <h3>Active Until <b><?php echo $enddate; ?></b></h3>
                            <h3>Day left: <b><?php echo $dayleft; ?> days</b></h3>
                        </div>
                    </div>
                    <div class="flexbox-3">
                        <button class="update-plan-btn"><a href="update-plan-page.php">Update Plan</a></button>
                        <button class="payment-history-btn"><a href="payment-history-page.php">Payment History</a></button>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <footer>
        <h5>&copy; Copyright 2021 MeowCat Team</h5>
    </footer>
</body>
</html>
<?php
include '../database/dbConnection.php'; 
include 'sessionAdmin.php';
if(isset($_SESSION['series_id'])){
    unset($_SESSION['series_id']);
}

$subs_overview = $userObj->displayOverviewSubscription();
$payment_overview = $userObj->displayOverviewPayment();

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
    <title>Admin Main Page</title>
    
</head>
<body class="parallax">
    <header class="navbar-div" id="navbar">
        <div class="branding-admin">
            <img class="admin-logo inline" src="../img/TMFLIX Background2-02.png" alt="logo">
            <h1 class="admin-title inline">Admin</h1>
        </div>
        <div class="right-admin-navbar">
            <nav>
                <ul>
                    <li><a href="main-admin-page.php"><i style="font-size:25px" class="fa">&#xf26c;</i>  TV Series</a></li>
                    <li><a class="current" href="subscription-page.php"><i style="font-size:25px" class="fa">&#xf155;</i>  Subscription</a></li>
                    <li><a href="#"><i style="font-size:25px" class="fa fa-user" aria-hidden="true"></i>  <?php echo $usernameAdmin?></a></li>
                    <li><a href="../User/logout.php"><i style="font-size:25px" class="fa">&#xf08b;</i>  Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-flex">
        <div class="flex" id="flexbox">
            <button class="nav-btn inline"><a href= "main-admin-page.php"><i class="fa fa-arrow-left"></i> Back To TV Series</a></button>
            <button class="nav-btn inline"><a href= "subscription-page.php#user-subscription">User Subscription</a></button>
            <button class="nav-btn inline"><a href= "subscription-page.php#payment">Payment</a></button>
        </div>
    </div>
    <div class="content container-95 bg-black padding-5" id="user-subscription">
        <br>
        <div class="flex-admin">
            <div class="overview-detail">
                <label class="overview-detail-label" for="">Total User</label>
                <i class="addicon-1"><?php echo $subs_overview[0]; ?></i>
            </div>
            <div class="overview-detail">
                <label class="overview-detail-label" for="">Trial Subscription</label>
                <i class="addicon-1"><?php echo $subs_overview[1]; ?></i>
            </div>
            <div class="overview-detail">
                <label class="overview-detail-label" for="">Basic Subscription</label>
                <i class="addicon-1"><?php echo $subs_overview[2]; ?></i>
            </div>
            <div class="overview-detail">
                <label class="overview-detail-label" for="">Premium Subscription</label>
                <i class="addicon-1"><?php echo $subs_overview[3]; ?></i>
            </div>
        </div>
        <h2 class="main-page-title font-white">LIST OF USER SUBSCRIPTION
            <button class="edit-series-btn inline" name="edit-series-poster"><a href="userSubscriptionReport.php"><i class="fa fa-download"></i> Download Report</a></button>
        </h2>
        <br>
        <div class="tbl-scroll">
            <table id="seriesTable" class="all-series-table">
                <tr>
                    <th>PLAN TYPE</th>
                    <th>START ACCESS</th>
                    <th>END ACCESS</th>
                    <th>USERNAME</th>
                    <th>FULL NAME</th>
                    <th>EMAIL</th>
                    <th>GENDER</th>
                    <th>ADDRESS</th>
                    <th>PHONE NO</th>
                </tr>
                <?php $userObj->displayAllSubscription(); ?>
            </table> 
        </div>  
    </div>
    <br>
    <br>
    <div class="content container-95 bg-black padding-5" id="payment">
        <br>
        <div class="flex-admin">
            <div class="overview-detail">
                <label class="overview-detail-label" for="">Total Receipt</label>
                <i class="addicon-1"><?php echo $payment_overview[0]; ?></i>
            </div>
            <div class="overview-detail">
                <label class="overview-detail-label" for="">Total Sales (RM)</label>
                <i class="addicon-1"><?php echo $payment_overview[1]; ?></i>
            </div>
            <div class="overview-detail">
                <label class="overview-detail-label" for="">Average Sales Monthly (RM)</label>
                <i class="addicon-1"><?php echo $payment_overview[2]; ?></i>
            </div>
        </div>
        <h2 class="main-page-title font-white">LIST OF PAYMENT TRANSACTION
            <button class="edit-series-btn inline" name="edit-series-poster"><a href="salesReport.php"><i class="fa fa-download"></i> Download Report</a></button>
        </h2>
        <br>
        <div class="tbl-scroll">
            <table id="seriesTable" class="all-series-table">
                <tr>
                    <th>PAYMENT DATE</th>
                    <th>PLAN TYPE</th>
                    <th>USERNAME</th>
                    <th>FULL NAME</th>
                    <th>EMAIL</th>
                    <th>GENDER</th>
                    <th>ADDRESS</th>
                    <th>PHONE NO</th>
                    <th>PAYMENT AMOUNT(RM)</th>
                </tr>
                <?php $userObj->displayAllPayment(); ?>
            </table> 
        </div>  
    </div>
    <script>
        // When the user scrolls the page, execute myFunction
        window.onscroll = function() {myFunction()};

        // Get the navbar
        var navbar = document.getElementById("flexbox");

        // Get the offset position of the navbar
        var sticky = navbar.offsetTop;

        // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky");
            } else {
                navbar.classList.remove("sticky");
            }
        }
    </script>
</body>
</html>
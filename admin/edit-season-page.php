<?php
include '../database/dbConnection.php'; 
include 'sessionAdmin.php';
include 'sessionSeries.php';

$seasonid_token = htmlentities($_GET["seasonid"]);

$session_series_data = $seriesObj->readSeriesDesc($_SESSION['series_id']);
$readSeason = $seriesObj->readSeason($seasonid_token); //read query based on season id to set data
$checkSeriesSeason = $seriesObj->checkSeriesGenre($currentSeriesId, $seasonid_token); //return true if the added genre already exist

if ($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST["edit-seasons"])) {
        $seasonid = $_POST['season-id'];
        $seasonnum = $_POST['season-number'];
        $seasontitle = $_POST['season-title'];

        if (empty($seasonid) || empty($seasonnum) || empty($seasontitle)) {
            echo "<script>
            alert('Empty field! Please complete the form before submiting!');
            window.location.href='edit-season-page.php?seasonid=".$seasonid."';
            </script>";
        }else{
            $updateSeason = $seriesObj->updateSeason($seasonid, $seasontitle, $seasonnum);

            if ($updateSeason ) {
                echo "<script>
                alert('Successfully edit series season!');
                window.location.href='edit-season-page.php?seasonid=".$seasonid."';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-season-page.php?seasonid=".$seasonid."';
                </script>";
            }
        } 
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
                    <li><a href="#"><i style="font-size:25px" class="fa">&#xf155;</i>  Subscription</a></li>
                    <li><a href="#"><i style="font-size:25px" class="fa fa-user" aria-hidden="true"></i>  <?php echo $usernameAdmin?></a></li>
                    <li><a href="../User/logout.php"><i style="font-size:25px" class="fa">&#xf08b;</i>  Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-flex">
        <div class="flex align-left" id="flexbox">
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-season"><i class="fa fa-arrow-left"></i> Back To TV Series</a></button>
        </div>
    </div>
    <div class="sub-display-form">
        <form class="display-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="titlecontainer">
                <h2 class="main-page-title white-font">EDIT SEASON DETAIL</h2>
                <h5 class="sub-title-main white-font">Title: <?php echo $session_series_data[1]; ?></h5>
            </div>
            <div class="contentcontainer">
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">SeasonID (Uneditable)</label>
                    <input id="season-id" type="number" placeholder="Season ID" name="season-id" value="<?php echo $readSeason[0]; ?>" readonly>
                    <br>
                </div>
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">
                        Season Number
                        <!-- <button onclick="enableNumber()" class="delete-btn inline" style="padding: 0 10px; color: black;"><i class="fa fa-edit"></i></button>
                        <button onclick="disableNumber()" class="delete-btn inline" style="padding: 0 10px; color: black;"><i class="fa fa-check"></i></button> -->
                    </label>
                    <br>
                    <input id="season-number" type="text" placeholder="Season Number" name="season-number" value="<?php echo $readSeason[1]; ?>" required>
                </div>
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">
                        Season Title
                        <!-- <button id="enable-title" class="delete-btn inline" style="padding: 0 10px; color: black;"><i class="fa fa-edit"></i></button>
                        <button id="disable-title" class="delete-btn inline" style="padding: 0 10px; color: black;"><i class="fa fa-check"></i></button> -->
                    </label>
                    <br>
                    <input id="season-title" type="text" placeholder="Season Title" name="season-title" value="<?php echo $readSeason[2]; ?>" required>
                </div>
                <br>
                <div class="hidden-div-btn">
                    <button class="submitbtn inline" type="submit" name='edit-seasons'>Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        // window.onload=function() {
        //     document.forms[0].elements["season-id"].disabled=true;
        //     document.forms[0].elements["season-title"].disabled=true;
        //     document.forms[0].elements["season-number"].disabled=true;
        // }
        // function enableNumber(){
        //     document.forms[0].elements["season-number"].disabled = false;
        // }

        // function disableNumber(){
        //     document.forms[0].elements["season-number"].disabled = true;
        // }
    </script>
</body>
</html>
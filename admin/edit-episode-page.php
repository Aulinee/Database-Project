<?php
include '../database/dbConnection.php'; 
include 'sessionAdmin.php';
include 'sessionSeries.php';

$episodeid_token = htmlentities($_GET["episodeid"]);

$session_series_data = $seriesObj->readSeriesDesc($_SESSION['series_id']);
$readEpisode = $seriesObj->readEpisode($episodeid_token); //read query based on episode id to set data
$checkSeriesEpisode = $seriesObj->checkSeriesGenre($currentSeriesId, $episodeid_token); //return true if the added genre already exist

if ($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST["edit-episodes"])) {
        $episodeid = $_POST['episode-id'];
        $episodenum = $_POST['episode-number'];
        $episodetitle = $_POST['episode-title'];
        $episdoesummary = $_POST['episode-summary'];
        $episodeduration = $_POST['episode-duration'];
        $episodedate = $_POST['episode-date'];

        if (empty($episodeid) || empty($episodenum) || empty($episodetitle) || empty($episdoesummary) || empty($episodeduration) || empty($episodedate) ) {
            echo "<script>
            alert('Empty field! Please complete the form before submiting!');
            window.location.href='edit-episode-page.php?episodeid=".$episodeid."';
            </script>";
        }else{
            $updateEpisode = $seriesObj->modifyEpisode($episodeid,  $episodenum, $episodetitle, $episdoesummary, $episodeduration,  $episodedate);

            if ($updateEpisode ) {
                echo "<script>
                alert('Successfully edit series episode!');
                window.location.href='edit-episode-page.php?episodeid=".$episodeid."';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-episode-page.php?episodeid=".$episodeid."';
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
                    <li><a class="current" href="main-admin-page.php"><i style="font-size:25px" class="fa">&#xf26c;</i>  TV Series</a></li>
                    <li><a href="subscription-page.php"><i style="font-size:25px" class="fa">&#xf155;</i>  Subscription</a></li>
                    <li><a href="#"><i style="font-size:25px" class="fa fa-user" aria-hidden="true"></i>  <?php echo $usernameAdmin?></a></li>
                    <li><a href="../User/logout.php"><i style="font-size:25px" class="fa">&#xf08b;</i>  Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-flex">
        <div class="flex align-left" id="flexbox">
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-episode"><i class="fa fa-arrow-left"></i> Back To TV Series</a></button>
        </div>
    </div>
    <div class="sub-display-form">
        <form class="display-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="titlecontainer">
                <h2 class="main-page-title white-font">EDIT EPISODE DETAIL</h2>
                <h5 class="sub-title-main white-font">Title: <?php echo $session_series_data[1]; ?></h5>
            </div>
            <div class="contentcontainer">
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">EpisodeID (Uneditable)</label>
                    <input id="episode-id" type="number" placeholder="Episode ID" name="episode-id" value="<?php echo $readEpisode[0]; ?>" readonly>
                    <br>
                </div>
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">
                        Episode Number
                    </label>
                    <br>
                    <input id="episode-number" type="text" placeholder="Episode Number" name="episode-number" value="<?php echo $readEpisode[1]; ?>" required>
                </div>
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">
                        Episode Title
                    </label>
                    <br>
                    <input id="episode-title" type="text" placeholder="Episode Title" name="episode-title" value="<?php echo $readEpisode[2]; ?>" required>
                </div>
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">
                        Episode Summary
                    </label>
                    <br>
                    <textarea id="episode-summary" type="text" placeholder="Episode Summary" name="episode-summary" cols="50" rows="10" required><?php echo $readEpisode[3]; ?></textarea>
                </div>
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">
                        Episode Duration (min)
                    </label>
                    <br>
                    <input id="episode-duration" type="number" placeholder="Episode Duration" name="episode-duration" value="<?php echo $readEpisode[4]; ?>" required>
                </div>
                <div class="editinfo-div editinfo-div-2">
                    <label for="add-genre">
                        Episode Airing Date
                    </label>
                    <br>
                    <input id="episode-date" type="date" placeholder="Episode Date" name="episode-date" value="<?php echo $readEpisode[5]; ?>" required>
                </div>
                <br>
                <div class="hidden-div-btn">
                    <button class="submitbtn inline" type="submit" name='edit-episodes'>Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
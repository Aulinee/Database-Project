<?php
include '../database/dbConnection.php'; 
include 'TVSeriesClass.php';
include 'sessionUser.php';

$seriesObj = new Series($conn);
$seriesid_token = htmlentities($_GET["id"]);
//$seriesObj->addSeriesLog($seriesid_token, $userid);

$_SESSION['series_id'] = $seriesid_token;
$session_series_data = $seriesObj->readSeriesDesc($_SESSION['series_id']);

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
    <title>TV Series</title>
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
        <div class="series-summary">
            <div class="series-img">
                <img class="series-logo" src="<?php echo $session_series_data[0]; ?>" alt="series poster">
            </div>
            <div class="series-description">
                <div class="display-block">
                    <h1 class="title-series"><?php echo $session_series_data[1]; ?></h1>
                </div>
                <div class="display-flex-row margin-detail">
                    <h2 class="date-series"><?php echo $session_series_data[2]; ?></h2>
                    <h2 class="total-season-series"><?php echo $session_series_data[8]; ?> Season(s)</h2>
                </div>
                <div class="display-block">
                    <button class="view-trailer-btn word-title">View Trailer</button>
                    <button class="watch-now-btn word-title">Watch Now</button>
                </div>
                <div class="display-block margin-detail">
                    <h2 class="cast-series word-title">Cast:</h2>
                    <h3 class="cast-series-detail word-detail"><?php echo $session_series_data[4]; ?></h3>
                </div>
                <div class="display-block margin-detail">
                    <h2 class="director-series word-title">Director: </h2>
                    <h3 class="director-series-detail word-detail"><?php echo $session_series_data[6]; ?></h3>
                </div>
                <div class="display-block margin-detail">
                    <h2 class="genre-series word-title">Genre: </h2>
                    <h3 class="genre-series-detail word-detail"><?php echo $session_series_data[5]; ?></h3>
                </div>
                <div class="display-block margin-detail">
                    <h2 class="award-series word-title">Award: </h2>
                    <h3 class="award-series-detail word-detail"><?php echo $session_series_data[7]; ?></h3>
                </div>
                <div class="display-block">
                    <h2 class="desc-series word-title">Description: </h2>
                    <h3 class="desc-series-detail word-detail"><?php echo $session_series_data[3]; ?></h3>
                </div>
            </div>
            <div class="line-separator"></div>
            <div class="series-season-detail">
                <?php $seriesObj->readSeriesSeason($_SESSION['series_id']); ?>
                <!-- <div class="series-season">
                    <h1 class="word-title red-title">Season 1</h1>
                    <table class="episode-table">
                        <tr>
                            <th>Episode Number</th>
                            <th>Summary</th>
                            <th>Duration</th>
                            <th>Released Date</th>
                        </tr>
                        <tr>
                            <td>Episode Number</td>
                            <td>Summary</td>
                            <td>Duration</td>
                            <td>Released Date</td>
                        </tr>
                    </table>
                </div> -->
            </div>
        </div>
    </div>
</body>
</html>
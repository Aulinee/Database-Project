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
    <title>Main Page</title>
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
    <div class="content container-95" id="top-pick">
        <div class="top-pick ">
            <h1 class="top-pick-title ">Top 5 Most Watch By You</h1>
            <div class="top-pick-display ">
                <?php 
                $seriesObj = new Series($conn);
                $seriesObj->displayTopSeries();
                ?>
                <!-- <div class="poster-desc">
                    <img class="poster-display " src="img/breaking_bad_poster.jpg" alt="tv-series">
                    <p class="series-title ">Breaking Bad</p>
                </div> -->
            </div>
        </div>
        <div class="series-genre" id="series-genre">
            <form name="genre" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="filter-label ">
                    <label class="filter-genre-title ">Series</label>
                    <select class="filter-genre" id="gender" name="genre" required>
                        <option value="All">All</option>
                        <?php
                            $seriesObj = new Series($conn);
                            $seriesObj->displayFilterOptions(); 
                        ?>
                    </select>
                    <input class="genre-submit" type="submit" value="Submit">
                </div>
            </form>
            <div class="filter-series">
                <?php 
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(isset($_POST['genre'])){
                            $genreValue =  $_POST['genre'];
                            $seriesObj = new Series($conn);
                            $seriesObj->displayFilterSeries($genreValue);
                        }
                    }else{
                        $seriesObj = new Series($conn);
                        $seriesObj->displayFilterSeries("All");
                    }
                    header("Location: main-page#series-genre.php");
                    
                ?>
                <!-- <div class="filter-poster-desc">
                    <img class="filter-display " src="img/breaking_bad_poster.jpg" alt="tv-series">
                    <p class="filter-series-title ">Breaking Bad</p>
                </div>-->
            </div>
        </div>
        <div class="about-us" id="about-us">
            <h1 class="about-us-title">About Us</h1>
            <div class="about-us-description">
                <div class="left-desc">
                    <h1>Stories move us.</h1>
                    <h1>They make us feel more emotion,</h1>
                    <h1>see new perspectives,</h1>
                    <h1>and bring us closer to each other.</h1>
                    <br>
                    <br>
                    <h5>At TMFlix, we want to entertain the world. Whatever your taste, and no matter where you live,</h5>
                    <h5>we give you access to best-in-class TV shows and documetaries.</h5>
                    <h5>Our member control what they want to watch, when they want it, with no ads,</h5>
                    <h5>in one simple subscription. We are your best entertainment service, and</h5>
                    <h5>we're always looking to help you find your next favourite story.</h5>
                    <br>
                    <br>
                    <h2>Contact Us</h2>
                    <p>
                        <img class="icon-contact" src="../img/facebook-07.png" alt="tv-series">
                        <img class="icon-contact" src="../img/twitter2-06.png" alt="tv-series">
                        <img class="icon-contact" src="../img/instagram2-08.png" alt="tv-series">
                    </p>
                </div>
                <div class="right-desc">
                    <img class="about-us-img" src="../img/TMFLIX about us-05.png" alt="tv-series">
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>
            <img class="icon-contact" src="../img/facebook-07.png" alt="tv-series">
            <img class="icon-contact" src="../img/twitter2-06.png" alt="tv-series">
            <img class="icon-contact" src="../img/instagram2-08.png" alt="tv-series">
        </p>
        <h5>&copy; Copyright 2021 MeowCat Team</h5>
    </footer>
    <script>
        // When the user scrolls the page, execute myFunction
        window.onscroll = function() {myFunction()};

        // Get the navbar
        var navbar = document.getElementById("navbar");

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
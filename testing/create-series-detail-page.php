<?php
include 'sessionAdmin.php';
$seriesid_token = htmlentities($_GET["id"]);
$_SESSION['series_id'] = $seriesid_token;

$session_series_data = $seriesObj->readSeriesDesc($_SESSION['series_id']);

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST["create-season"])){
        $title = $_POST['season-title'];
        $number = $_POST['season-number'];

        $addSeason = $seriesObj->addSeason($currentSeriesId, $title, $number); //return boolean 
        if($addSeason){
            echo "<script>
            alert('Successfully added new season!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }else{
            echo "<script>
            alert('Unsucessuful add query! Please try again!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }

    }else if(isset($_POST['create-episode'])){
        $season_id = $_POST['season-num'];
        $ep_no = $_POST['ep-num'];
        $ep_title = $_POST['ep-title'];
        $ep_desc = $_POST['ep-desc'];
        $ep_duration = $_POST['ep-duration'];
        $ep_date = $_POST['ep-date'];

        $addEpisode = $seriesObj->addEpisode($season_id, $ep_no ,$ep_title, $ep_desc, $ep_duration, $ep_date);

        if($addEpisode){
            echo "<script>
            alert('Successfully added new episode!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }else{
            echo "<script>
            alert('Unsucessuful add query! Please try again!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }

    }else if(isset($_POST['create-genre'])){
        $genre_name = $_POST['genre-name'];

        $addGenre = $genreObj->addGenre($genre_name);   

        if($addGenre){
            echo "<script>
            alert('Successfully added new genre!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }else{
            echo "<script>
            alert('Unsucessful add query! Please try again!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }
        
    }else if(isset($_POST['create-cast'])){
        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];
        $birth_date = $_POST['birth-date'];
        $gender = $_POST['gender'];

        $addCast = $castObj->addCast($first_name, $last_name, $birth_date, $gender);

        if($addCast){
            echo "<script>
            alert('Successfully added new cast!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }else{
            echo "<script>
            alert('Unsucessful add query! Please try again!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }
        
    }else if(isset($_POST['create-director'])){
        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];

        $addDirector = $directorObj->addDirector($first_name, $last_name); 

        if($addDirector){
            echo "<script>
            alert('Successfully added new director!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }else{
            echo "<script>
            alert('Unsucessful add query! Please try again!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }
        
    }else if(isset($_POST['create-award'])){
        $award_name = $_POST['award-name'];

        $addAward = $awardObj->addAward($award_name); 

        if($addAward){
            echo "<script>
            alert('Successfully added new genre!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }else{
            echo "<script>
            alert('Unsucessful add query! Please try again!');
            window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
            </script>";
        }
        
    }
    //header('location:create-series-page.php#new-series-season?id='.$_SESSION['series_id'].'');
}
?>
<?php  ?>
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
        <div class="flex" id="flexbox">
            <button class="nav-btn inline"><a href= "create-series-detail-page.php?id=<?php echo $currentSeriesId; ?>#navbar">Summary</a></button>
            <button class="nav-btn inline"><a href= "create-series-detail-page.php?id=<?php echo $currentSeriesId; ?>#new-series-season">Season and Episode</a></button>
            <button class="nav-btn inline"><a href= "create-series-detail-page.php?id=<?php echo $currentSeriesId; ?>#new-series-genre">Series Genre</a></button>
            <button class="nav-btn inline"><a href= "create-series-detail-page.php?id=<?php echo $currentSeriesId; ?>#new-series-cast">Series Cast</a></button>
            <button class="nav-btn inline"><a href= "create-series-detail-page.php?id=<?php echo $currentSeriesId; ?>#new-series-director">Series Director</a></button>
            <button class="nav-btn inline"><a href= "create-series-detail-page.php?id=<?php echo $currentSeriesId; ?>#new-series-award">Series Award</a></button>
        </div>
    </div>
    <div class="content container-95">
        <!-- Series Detail -->
        <h1 class="div-title">Add <?php echo $session_series_data[1]; ?> TV Series Detail</h1>
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
        </div>>
        <!-- Season and episode div -->
        <div class="new-series bg-black" id="new-series">
            <div class="new-series-season" id="new-series-season">
                <h1 class="div-title">TV SERIES SEASON AND EPISODE</h1>

                <div class="season-btn">
                    <button class="nav-btn inline" onclick="document.getElementById('season').style.display='block'">Add Season</button>
                    <div id="season" class="modal">
                        <form class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="imgcontainer">
                                <h1>Add New Season</h1>
                                <span onclick="document.getElementById('season').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="container">
                                <label for="season-title"><b>Season Title</b></label>
                                <input type="text" placeholder="Enter Season Title" name="season-title" required>
                                <label for="season-number"><b>Season Number</b></label>
                                <input type="number" placeholder="Enter Season Number" name="season-number" required>
                                <button type="submit" name="create-season">Create</button>
                            </div>
                            <div class="container">
                                <button type="button" onclick="document.getElementById('season').style.display='none'" class="cancelbtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <button class="nav-btn inline" onclick="document.getElementById('episode').style.display='block'">Add Episode</button>
                    <div id="episode" class="modal">
                        <form class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="imgcontainer">
                                <h1>Add New Episode</h1>
                                <span onclick="document.getElementById('episode').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="container">
                                <div class="block">
                                    <label for="season-id"><b>Season Number</b></label>
                                    <select id="season-num" name="season-num" required>
                                        <?php
                                            $seriesObj->displaySeasonOptions($_SESSION['series_id']); 
                                        ?>
                                    </select>
                                </div>
                                <div class="block">
                                    <label for="episode-no"><b>Episode Number</b></label>
                                    <input type="number" placeholder="Enter Episode Number" name="ep-num" required>
                                </div>
                                <div class="block">
                                    <label for="episode-title"><b>Episode Title</b></label>
                                    <input type="text" placeholder="Enter Episode Title" name="ep-title" required>
                                </div>
                                <div class="block">
                                    <label for="episode-desc"><b>Episode Description</b></label>
                                    <textarea name="ep-desc" cols="50" rows="10"></textarea>
                                </div>
                                <div class="block">
                                    <label for="episode-duration"><b>Episode Duration(min)</b></label>
                                    <input type="number" placeholder="Enter Episode Duration" name="ep-duration" required>
                                </div>
                                <div class="block">
                                    <label for="episode-date"><b>Airing Date</b></label>
                                    <input type="date" placeholder="Enter Episode Date" name="ep-date" required>
                                </div>
                                <div class="block">
                                    <button type="submit" name="create-episode">Create</button>
                                </div>
                            </div>

                            <div class="container">
                                <button type="button" onclick="document.getElementById('episode').style.display='none'" class="cancelbtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="series-season-detail">
                    <?php $seriesObj->readSeriesSeason($_SESSION['series_id']); ?>
                </div>
            </div>
            <!-- series genre div -->
            <div class="new-series-genre" id="new-series-genre">
                <h1 class="div-title">TV SERIES GENRE</h1>
                <div class="season-btn">
                    <button class="nav-btn inline" onclick="document.getElementById('genre').style.display='block'">Add Genre</button>
                    <div id="genre" class="modal">
                        <form class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="imgcontainer">
                                <h1>Add New Genre</h1>
                                <span onclick="document.getElementById('genre').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="container">
                                <label for="genre-name"><b>Genre Name</b></label>
                                <input type="text" placeholder="Enter New Genre" name="genre-name" required>
                                <button type="submit" name='create-genre'>Create</button>
                            </div>
                            <div class="container">
                                <button type="button" onclick="document.getElementById('genre').style.display='none'" class="cancelbtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="input-icons">
                        <i class="fa fa-search icon"></i>
                        <input class="input-field " type="text" id="genreInput" onkeyup="filterGenre()" placeholder="Search for genre name.." title="Type in a name">
                    </div>
                    <table id="genreTable" class="myTable">
                        <tr class="header">
                            <th style="width:30%;">Genre ID</th>
                            <th style="width:30%;">Genre Name</th>
                            <th style="width:40%;">Action</th>
                        </tr>
                        <?php $genreObj->displayAllGenre(); ?>
                    </table>
                </form>
            </div>
            <!-- series cast div -->
            <div class="new-series-cast" id="new-series-cast">
                <h1 class="div-title">TV SERIES CAST</h1>
                <div class="season-btn">
                    <button class="nav-btn inline" onclick="document.getElementById('cast').style.display='block'">Add Cast</button>
                    <div id="cast" class="modal">
                        <form class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="imgcontainer">
                                <h1>Add New Cast</h1>
                                <span onclick="document.getElementById('cast').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="container">
                                <label for="first-name"><b>First Name</b></label>
                                <input type="text" placeholder="Enter Cast First Name" name="first-name" required>
                                <label for="last-name"><b>Last Name</b></label>
                                <input type="text" placeholder="Enter Cast Last Name" name="last-name" required>
                                <label for="birth-date"><b>Birth Date</b></label>
                                <input type="date" placeholder="Enter New Birth date" name="birth-date" required>
                                <label for="gender"><b>Gender</b></label>
                                <select id="gender" name="gender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <button type="submit" name='create-cast'>Create</button>
                            </div>
                            <div class="container">
                                <button type="button" onclick="document.getElementById('cast').style.display='none'" class="cancelbtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="input-icons">
                        <i class="fa fa-search icon"></i>
                        <input class="input-field " type="text" id="castInput" onkeyup="filterCast()" placeholder="Search for cast name.." title="Type in a name">
                    </div>
                    <table id="castTable" class="myTable">
                        <tr class="header">
                            <th style="width:20%;">Cast ID</th>
                            <th style="width:30%;">Full Name</th>
                            <th style="width:20%;">Gender</th>
                            <th style="width:30%;">Action</th>
                        </tr>
                        <?php $castObj->displayAllCast(); ?>
                    </table>
                </form>
            </div>
            <!-- series director div -->
            <div class="new-series-director" id="new-series-director">
                <h1 class="div-title">TV SERIES DIRECTOR</h1>
                <div class="season-btn">
                    <button class="nav-btn inline" onclick="document.getElementById('director').style.display='block'">Add Director</button>
                    <div id="director" class="modal">
                        <form class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="imgcontainer">
                                <h1>Add New Director</h1>
                                <span onclick="document.getElementById('director').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="container">
                                <label for="first-name"><b>First Name</b></label>
                                <input type="text" placeholder="Enter Director First Name" name="first-name" required>
                                <label for="last-name"><b>Last Name</b></label>
                                <input type="text" placeholder="Enter Director First Name" name="last-name" required>
                                <button type="submit" name='create-director'>Create</button>
                            </div>
                            <div class="container">
                                <button type="button" onclick="document.getElementById('cast').style.display='none'" class="cancelbtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="input-icons">
                        <i class="fa fa-search icon"></i>
                        <input class="input-field " type="text" id="directorInput" onkeyup="filterDirector()" placeholder="Search for director name.." title="Type in a name">
                    </div>
                    <table id="directorTable" class="myTable">
                        <tr class="header">
                            <th style="width:30%;">Director ID</th>
                            <th style="width:30%;">Full Name</th>
                            <th style="width:40%;">Action</th>
                        </tr>
                        <?php $directorObj->displayAllDirector(); ?>
                    </table>
                </form>
            </div>
            <!-- series award div -->
            <div class="new-series-award" id="new-series-award">
                <h1 class="div-title">TV SERIES AWARD</h1>
                <div class="season-btn">
                    <button class="nav-btn inline" onclick="document.getElementById('award').style.display='block'">Add Award</button>
                    <div id="award" class="modal">
                        <form class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="imgcontainer">
                                <h1>Add New Award Name</h1>
                                <span onclick="document.getElementById('award').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="container">
                                <label for="award-name"><b>Award Title</b></label>
                                <input type="text" placeholder="Enter New Award" name="award-name" required>
                                <button type="submit" name='create-award'>Create</button>
                            </div>
                            <div class="container">
                                <button type="button" onclick="document.getElementById('award').style.display='none'" class="cancelbtn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="input-icons">
                        <i class="fa fa-search icon"></i>
                        <input class="input-field " type="text" id="awardInput" onkeyup="filterAward()" placeholder="Search for award name.." title="Type in a name">
                    </div>
                    <table id="awardTable" class="myTable">
                        <tr class="header">
                            <th style="width:30%;">Award ID</th>
                            <th style="width:40%;">Award Name</th>
                            <th style="width:30%;">Action</th>
                        </tr>
                        <?php $awardObj->displayAllAward(); ?>
                    </table>
                </form>
            </div>
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
        
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        function filterGenre() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("genreInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("genreTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }

        function filterCast() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("castInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("castTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }

        function filterDirector() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("directorInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("directorTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }

        function filterAward() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("awardInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("awardTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }
    </script>
</body>
</html>
<?php
include 'sessionAdmin.php';
include 'sessionSeries.php';
$session_series_data = $seriesObj->readSeriesDesc($_SESSION['series_id']);

//Set empty genre edit error
$genreidErr = $genrecolErr = $genredataErr = "";

if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST["edit-series-title"])) {
        $new_title = $_POST['new-series-title'];

        if (empty($new_title)) {
            echo "<script>
            alert('Empty field! Please write something before submiting!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."';
            </script>";
        } elseif ($new_title == $session_series_data[1]) {
            echo "<script>
            alert('Same data! Update cancel!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."';
            </script>";
        } else {
            $updateTitle = $seriesObj->updateSeriesTitle($currentSeriesId, $new_title); //return boolean
            if ($updateTitle) {
                echo "<script>
                alert('Successfully edit series title!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            }
        }
    } elseif (isset($_POST["edit-series-date"])) {
        $new_date = $_POST['new-series-date'];

        $date = date_create($new_date);

        $new_date_formatted = date_format($date, "M d, Y"); //use this to compare same date

        if (empty($new_date)) {
            echo "<script>
            alert('Empty field! Please write something before submiting!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."';
            </script>";
        } elseif ($new_date_formatted == $session_series_data[2]) {
            echo "<script>
            alert('Same data! Update cancel!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."';
            </script>";
        } else {
            $updateDate = $seriesObj->updateSeriesDate($currentSeriesId, $new_date); //return boolean
            if ($updateDate) {
                echo "<script>
                alert('Successfully edit series date!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            }
        }
    } elseif (isset($_POST["edit-series-desc"])) {
        $new_desc = $_POST['new-series-desc'];

        if (empty($new_desc)) {
            echo "<script>
            alert('Empty field! Please write something before submiting!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."';
            </script>";
        } elseif ($new_desc == $session_series_data[3]) {
            echo "<script>
            alert('Same data! Update cancel!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."';
            </script>";
        } else {
            $updateDesc = $seriesObj->updateSeriesDesc($currentSeriesId, $new_desc); //return boolean
            if ($updateDesc) {
                echo "<script>
                alert('Successfully edit series description!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            }
        }
    } else if(isset($_POST["edit-series-poster"])){
        $img = $_FILES['new-series-poster']['tmp_name'];

        if(empty($img)){
            echo "<script>
            alert('Choose poster image first before upload!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."';
            </script>";
        }else{
            $edit_poster = addslashes (file_get_contents($img));
            $updatePoster = $seriesObj->updateSeriesPoster($currentSeriesId, $edit_poster); //return boolean
            if ($updatePoster) {
                echo "<script>
                alert('Successfully edit series poster!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."';
                </script>";
            }

        }

        
    }elseif (isset($_POST["add-genre"])) {
        $new_genre = $_POST['new-genre'];
        $check_genre = $genreObj->checkGenre($new_genre);

        if (empty($new_genre)) {
            echo "<script>
            alert('Empty field! Please write something before submiting!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
            </script>";
        } elseif ($check_genre) {
            echo "<script>
            alert('Genre added already exist! Please add different genre name!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
            </script>";
        } else {
            $addGenre = $genreObj->addGenre($new_genre); //return boolean
            if ($addGenre) {
                echo "<script>
                alert('Successfully add new genre!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful add query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
                </script>";
            }
        }
    } elseif (isset($_POST["edit-genre"])) {
        $genre_id = $_POST['genre-id'];
        $genre_col = $_POST['genre-col'];
        $genre_value = $_POST['new-edit-genre'];

        if ($genre_id == 'none' || $genre_col == 'none' || empty($genre_value)) {
            echo "<script>
                alert('Empty field in edit genre!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-genre-div';
                </script>";
        } else {
            $updateGenre = $genreObj->modifyGenre($genre_id, $genre_col, $genre_value);

            if ($updateGenre) {
                echo "<script>
                alert('Successfully update genre!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-genre-div';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-genre-div';
                </script>";
            }
        }
    } elseif (isset($_POST['add-cast'])) {
        $castfname = $_POST['new-cast-fname'];
        $castlname = $_POST['new-cast-lname'];
        $castbirthdate = $_POST['new-cast-bdate'];
        $castgender = $_POST['new-cast-gender'];

        $checkCast = $castObj->checkCast($castfname, $castlname, $castbirthdate, $castgender);

        if ($castgender == 'none' || empty($castfname) || empty($castlname) || empty($castbirthdate)) {
            echo "<script>
            alert('Empty field in add cast form!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
            </script>";
        } elseif ($checkCast) {
            echo "<script>
            alert('Cast added already exist! Please add different cast detail!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
            </script>";
        } else {
            $addCast = $castObj->addCast($castfname, $castlname, $castbirthdate, $castgender); //return boolean

            if ($addCast) {
                echo "<script>
                alert('Successfully add new cast!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful add query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                </script>";
            }
        }
    } elseif (isset($_POST['edit-cast'])) {
        $castid = $_POST['cast-id'];
        $castcol = $_POST['cast-col'];
        $casttextinput = $_POST['new-edit-cast'];
        $castdateinput = $_POST['new-edit-cast-date'];
        $castoptinput = $_POST['new-edit-cast-gender'];
        
        if ($castid == "none" || $castcol == "none") {
            echo "<script>
            alert('Empty field in edit cast!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
            </script>";
        } else {
            if (!empty($casttextinput)) {
                $editCast = $castObj->modifyCast($castid, $castcol, $casttextinput);
                if ($editCast) {
                    echo "<script>
                    alert('Successfully edit cast!');
                    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                    </script>";
                } else {
                    echo "<script>
                    alert('Unsucessuful edit query! Please try again!');
                    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                    </script>";
                }
            } elseif (!empty($castdateinput)) {
                $editCast = $castObj->modifyCast($castid, $castcol, $castdateinput);
                if ($editCast) {
                    echo "<script>
                    alert('Successfully edit cast!');
                    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                    </script>";
                } else {
                    echo "<script>
                    alert('Unsucessuful edit query! Please try again!');
                    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                    </script>";
                }
            } elseif (!empty($castoptinput)) {
                $editCast = $castObj->modifyCast($castid, $castcol, $castoptinput);
                if ($editCast) {
                    echo "<script>
                    alert('Successfully edit cast!');
                    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                    </script>";
                } else {
                    echo "<script>
                    alert('Unsucessuful edit query! Please try again!');
                    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                    </script>";
                }
            } else {
                echo "<script>
                alert('Empty field in edit cast!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
                </script>";
            }
        }
    } elseif (isset($_POST['add-director'])) {
        $directorfname = $_POST['new-director-fname'];
        $directorlname = $_POST['new-director-lname'];

        $checkDirector = $directorObj->checkDirector($directorfname, $directorlname);

        if (empty($directorfname) || empty($directorlname)) {
            echo "<script>
            alert('Empty field in add director form!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
            </script>";
        } elseif ($checkDirector) {
            echo "<script>
            alert('Director added already exist! Please add different director detail!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
            </script>";
        } else {
            $addDirector = $directorObj->addDirector($directorfname, $directorlname); //return boolean

            if ($addDirector) {
                echo "<script>
                alert('Successfully add new director!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful add query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
                </script>";
            }
        }
    } elseif (isset($_POST['edit-director'])) {
        $directorid = $_POST['director-id'];
        $directorcol = $_POST['director-col'];
        $directortextinput = $_POST['new-edit-director'];

        if ($directorid == 'none' || $directorcol == 'none' || empty($directortextinput)) {
            echo "<script>
                alert('Empty field in edit director!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
                </script>";
        } else {
            $updateDirector = $directorObj->modifyDirector($directorid, $directorcol, $directortextinput);

            if ($updateDirector) {
                echo "<script>
                alert('Successfully update director!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
                </script>";
            }
        }
    }elseif(isset($_POST['add-award'])){
        $awardtitle = $_POST['new-award-title'];

        $checkAward = $awardObj->checkAward($awardtitle);

        if (empty($awardtitle)) {
            echo "<script>
            alert('Empty field! Please write something before submiting!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
            </script>";
        } elseif ( $checkAward) {
            echo "<script>
            alert('Award added already exist! Please add different award title!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
            </script>";
        } else {
            $addAward = $awardObj->addAward($awardtitle); //return boolean
            if ($addAward) {
                echo "<script>
                alert('Successfully add new award title!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful add query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
                </script>";
            }
        }
    }elseif(isset($_POST['edit-award'])){
        $awardid = $_POST['award-id'];
        $awardcol = $_POST['award-col'];
        $awardtextinput = $_POST['new-edit-award'];

        if ($awardid == 'none' || $awardcol == 'none' || empty($awardtextinput)) {
            echo "<script>
                alert('Empty field in edit award!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-award-div';
                </script>";
        } else {
            $updateAward = $awardObj->modifyAward($awardid, $awardcol, $awardtextinput);

            if ($updateAward) {
                echo "<script>
                alert('Successfully update award title!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-award-div';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful update query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-award-div';
                </script>";
            }
        }
    }elseif(isset($_POST['add-award-year'])){
        $awardid = $_POST['award-id'];
        $awarddate = $_POST['new-award-year'];

        if ($awardid == 'none' || empty($awarddate)) {
            echo "<script>
                alert('Empty field in add series award!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
                </script>";
        } else {
            $addSeriesAward = $seriesObj->addSeriesAward($currentSeriesId, $awardid, $awarddate);

            if ($addSeriesAward) {
                echo "<script>
                alert('Successfully add new series award!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
                </script>";
            } else {
                echo "<script>
                alert('Unsucessuful add query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
                </script>";
            }
        }

    }else if(isset($_POST["create-season"])){
        $title = $_POST['season-title'];
        $number = $_POST['season-number'];

        $check_season = $seriesObj->checkSeasonNumber($currentSeriesId, $number);

        if (empty($title) || empty($number)){
            echo "<script>
                alert('Empty field in add series season!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
                </script>";
        }else if($check_season){
            echo "<script>
            alert('Season number added already exist! Please add different season number!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
            </script>";
        }else{
            $addSeason = $seriesObj->addSeason($currentSeriesId, $title, $number); //return boolean
            if($addSeason){
                echo "<script>
                alert('Successfully added new season!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
                </script>";
            }else{
                echo "<script>
                alert('Unsucessuful add query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
                </script>";
            }

        }

    }else if(isset($_POST['create-episode'])){
        $season_id = $_POST['season-num'];
        $ep_no = $_POST['ep-num'];
        $ep_title = $_POST['ep-title'];
        $ep_desc = $_POST['ep-desc'];
        $ep_duration = $_POST['ep-duration'];
        $ep_date = $_POST['ep-date'];

        $check_episode = $seriesObj->checkEpisodeNumber($season_id, $ep_no);

        if ($season_id == "none" || empty($ep_no) || empty($ep_title) ||empty($ep_desc) ||empty($ep_duration) || empty($ep_date)){
            echo "<script>
                alert('Empty field in add series episode!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
                </script>";
        }else if($check_episode){
            echo "<script>
            alert('Episode number added already exist! Please add different episode detail!');
            window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
            </script>";
        }else{
            $addEpisode = $seriesObj->addEpisode($season_id, $ep_no ,$ep_title, $ep_desc, $ep_duration, $ep_date);
            if($addEpisode){
                echo "<script>
                alert('Successfully added new episode!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
                </script>";
            } else{
                echo "<script>
                alert('Unsucessuful add query! Please try again!');
                window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
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
    <title>Edit Series Page</title>
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
        <button class="nav-btn inline"><a href= "main-admin-page.php"><i class="fa fa-arrow-left"></i> Back To TV Series</a></button>
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#navbar">Overview</a></button>
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-season">Season & Episode</a></button>
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-genre">Genre</a></button>
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-cast">Cast</a></button>
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-director">Director</a></button>
            <button class="nav-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-award">Award</a></button>
        </div>
    </div>
    <div class="content container-95">
        <!-- Series Detail -->
        <h1 class="div-title"><span style="color: #d12a27;"><?php echo $session_series_data[1]; ?></span> TV Series Detail</h1>
        <div class="series-summary">
            <div class="series-img">
                <img class="edit-img" src="<?php echo $session_series_data[0]; ?>" alt="series poster">
                <form class="file-input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <input class="new-img-input inline red" type="file" id="file" name="new-series-poster">
                    <label for="file">
                        Select file
                        <p class="file-name"></p>
                    </label>
                    <div class="tooltip">
                        <button class="edit-series-btn inline" name="edit-series-poster"><i class="fa fa-upload"></i></button>
                        <span class="tooltiptext">Click Here To Upload Image</span>
                    </div>
                </form>
            </div>
            <div class="series-description">
                <!-- series title section -->
                <div class="display-block">
                    <h1 class="title-series"><?php echo $session_series_data[1]; ?>
                        <div class="tooltip">
                            <button class="edit-series-btn inline" onclick="document.getElementById('edit-title').style.display='block'"><i class="fa fa-edit"></i></button>
                            <span class="tooltiptext">Click To Edit Series Title</span>
                        </div>
                        <!-- hidden div inside h1 tag -->
                        <div id="edit-title" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title">EDIT SERIES TITLE</h2>
                                    <h5 class="sub-title-main">insert new series title</h5>
                                    <span class="close-btn" onclick="document.getElementById('edit-title').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div">
                                        <label for="new-series-title">New Series Title <br>(Old Title: <b style="color: black;"><?php echo $session_series_data[1]; ?></b>)</label>
                                        <input type="text" placeholder="Enter New Series Title" name="new-series-title" required>
                                    </div>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='edit-series-title'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('edit-title').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </h1>
                </div>
                <div class="display-flex-row margin-detail">
                    <!-- series release section -->
                    <h2 class="date-series"><?php echo $session_series_data[2]; ?>
                        <div class="tooltip">
                            <button class="edit-series-btn inline" onclick="document.getElementById('edit-date').style.display='block'"><i class="fa fa-edit"></i></button>
                            <span class="tooltiptext">Click To Edit Series Release Date</span>
                        </div>
                        <!-- hidden div inside h1 tag -->
                        <div id="edit-date" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title">EDIT SERIES RELEASE DATE</h2>
                                    <h5 class="sub-title-main">insert new series release date</h5>
                                    <span class="close-btn" onclick="document.getElementById('edit-date').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div">
                                        <label for="new-series-title">New Series Release Date <br>(Old Release Date: <b style="color: black;"><?php echo $session_series_data[2]; ?></b>)</label>
                                        <br>
                                        <br>
                                        <input type="date" placeholder="Enter New Series Date" name="new-series-date" required>
                                    </div>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='edit-series-date'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('edit-date').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </h2>
                    <!-- series season and episode section -->
                    <h2 class="total-season-series"><?php echo $session_series_data[8]; ?> Season(s)
                        <div class="tooltip">
                            <button class="edit-series-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-season"><i class="fa fa-edit"></i></a></button>
                            <span class="tooltiptext">Click To Edit Season</span>
                        </div>
                    </h2>
                </div>
                <hr class="no-margin">
                <!-- series description section -->
                <div class="display-block">
                    <h2 class="desc-series word-title">Description: 
                        <div class="tooltip">
                            <button class="edit-series-btn inline" onclick="document.getElementById('edit-desc').style.display='block'"><i class="fa fa-edit"></i></button>
                            <span class="tooltiptext">Click To Edit Description</span>
                        </div>
                        <!-- hidden div inside h1 tag -->
                        <div id="edit-desc" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title">EDIT SERIES DESCRIPTION</h2>
                                    <h5 class="sub-title-main">insert new series description</h5>
                                    <span class="close-btn" onclick="document.getElementById('edit-desc').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div">
                                        <label for="new-series-desc">New Series Description <br>(Old Description: <b style="color: black;"><?php echo $session_series_data[3]; ?></b>)</label>
                                        <br>
                                        <br>
                                        <textarea name="new-series-desc" cols="50" rows="10" required></textarea>
                                    </div>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='edit-series-desc'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('edit-desc').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </h2>
                    <h3 class="desc-series-detail word-detail"><?php echo $session_series_data[3]; ?></h3>
                </div>
                <hr class="no-margin">
                <!-- series cast section -->
                <div class="display-block">
                    <h2 class="desc-series word-title">Cast: 
                        <div class="tooltip">
                            <button class="edit-series-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-cast"><i class="fa fa-edit"></i></a></button>
                            <span class="tooltiptext">Click To Edit Cast Title</span>
                        </div>
                    </h2>
                    <h3 class="desc-series-detail word-detail"><?php echo $session_series_data[4]; ?></h3>
                </div>
                <hr class="no-margin">
                <!-- series director section -->
                <div class="display-block">
                    <h2 class="desc-series word-title">Director: 
                        <div class="tooltip">
                            <button class="edit-series-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-director"><i class="fa fa-edit"></i></a></button>
                            <span class="tooltiptext">Click To Edit Director</span>
                        </div>
                    </h2>
                    <h3 class="desc-series-detail word-detail"><?php echo $session_series_data[6]; ?></h3>
                </div>
                <hr class="no-margin">
                <!-- series genre section -->
                <div class="display-block">
                    <h2 class="desc-series word-title">Genre: 
                        <div class="tooltip">
                            <button class="edit-series-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-genre"><i class="fa fa-edit"></i></a></button>
                            <span class="tooltiptext">Click To Edit Genre</span>
                        </div>
                    </h2>
                    <h3 class="desc-series-detail word-detail"><?php echo $session_series_data[5]; ?></h3>
                </div>
                <hr class="no-margin">
                <!-- series award section -->
                <div class="display-block">
                    <h2 class="desc-series word-title">Award: 
                        <div class="tooltip">
                            <button class="edit-series-btn inline"><a href= "edit-series-page.php?id=<?php echo $currentSeriesId; ?>#new-series-award"><i class="fa fa-edit"></i></a></button>
                            <span class="tooltiptext">Click To Edit award</span>
                        </div>
                    </h2>
                    <h3 class="desc-series-detail word-detail"><?php echo $session_series_data[7]; ?></h3>
                </div>
            </div>
        </div>
        <!-- Season and episode div -->
        <div class="new-series bg-black" id="new-series-season">
            <h2 class="main-page-title font-white">Season & Episode Details</h2>
            <br>
            <div class="season-btn">
                <button class="create border-radius-10 margin-lr-1" onclick="document.getElementById('season').style.display='block'"><i class="fa fa-plus"></i> Add Season</button>
                <!-- hidden div inside button add season tag -->
                <div id="season" class="sub-hidden-form">
                    <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="titlecontainer">
                            <h2 class="main-page-title white-font">ADD SEASON DETAIL</h2>
                            <h5 class="sub-title-main white-font">Title: <?php echo $session_series_data[1]; ?></h5>
                            <span class="close-btn" onclick="document.getElementById('season').style.display='none'" title="Close Modal">&times;</span>
                        </div>
                        <div class="contentcontainer">
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">Season Number</label>
                                <br>
                                <input id="season-number" type="number" placeholder="Season Number" name="season-number" required>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">Season Title</label>
                                <br>
                                <input id="season-title" type="text" placeholder="Season Title" name="season-title" required>
                            </div>
                            <br>
                            <div class="hidden-div-btn">
                                <button class="submitbtn inline" type="submit" name='create-season'>Submit</button>
                                <button class="cancelbtn inline" type="button" onclick="document.getElementById('season').style.display='none'" >Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <button class="create border-radius-10 margin-lr-1" onclick="document.getElementById('episode').style.display='block'"><i class="fa fa-plus"></i> Add Episode</button>
                 <!-- hidden div inside button add episode tag -->
                <div id="episode" class="sub-hidden-form">
                    <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="titlecontainer">
                            <h2 class="main-page-title white-font">ADD EPISODE DETAIL</h2>
                            <h5 class="sub-title-main white-font">Title: <?php echo $session_series_data[1]; ?></h5>
                            <span class="close-btn" onclick="document.getElementById('episode').style.display='none'" title="Close Modal">&times;</span>
                        </div>
                        <div class="contentcontainer">
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">
                                    Season Number
                                </label>
                                <br>
                                <select class="state-select" id="season-num" name="season-num" required>
                                    <option value="none">Select Season</option>
                                    <?php
                                        $seriesObj->displaySeasonOptions($_SESSION['series_id']); 
                                    ?>
                                </select>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">
                                    Episode Number
                                </label>
                                <br>
                                <input id="episode-number" type="text" placeholder="Episode Number" name="ep-num" required>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">
                                    Episode Title
                                </label>
                                <br>
                                <input id="episode-title" type="text" placeholder="Episode Title" name="ep-title" required>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">
                                    Episode Summary
                                </label>
                                <br>
                                <textarea id="episode-summary" type="text" placeholder="Episode Summary" name="ep-desc" cols="50" rows="10" required></textarea>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">
                                    Episode Duration (min)
                                </label>
                                <br>
                                <input id="episode-duration" type="number" placeholder="Episode Duration" name="ep-duration" required>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-genre">
                                    Episode Airing Date
                                </label>
                                <br>
                                <input id="episode-date" type="date" placeholder="Episode Date" name="ep-date" required>
                            </div>
                            <br>
                            <div class="hidden-div-btn">
                                <button class="submitbtn inline" type="submit" name='create-episode'>Submit</button>
                                <button class="cancelbtn inline" type="button" onclick="document.getElementById('episode').style.display='none'" >Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="new-series-season tbl-bg">
                <div class="series-season-detail">
                    <?php $seriesObj->readSeriesSeasonAdmin($_SESSION['series_id']) ?>
                </div>
            </div>
        </div>
        <!-- series genre div -->
        <div class="new-series bg-black" id="new-series-genre">
            <h2 class="main-page-title font-white">Genre Detail</h2>
            <br>
            <div class="new-series-genre">
                <h2 class="main-page-title">LIST OF SERIES GENRE</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="genreSeriesInput" onkeyup="filterSeriesGenre()" placeholder="Search for genre name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view and delete</h5>
                    </div>
                    <div class="create-series-btn">
                        <i class="fa fa-plus addicon"></i>
                        <button class="create" onclick="document.getElementById('genre-div').style.display='block'"><a class="white-font" href="#genrepage">ADD GENRE</a></button>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="genreSeriesTable" class="all-series-table font-size-20">
                            <tr class="header">
                                <th style="width:30%;">Genre ID</th>
                                <th style="width:40%;">Genre Name</th>
                                <th style="width:30%;">Action</th>
                            </tr>
                            <?php $seriesObj->displayAllSeriesGenre($currentSeriesId); ?>
                        </table>
                    </form>
                </div>
                <br>
                <hr class="no-margin line-black">
                <br id="genrepage">
                <br>
                <!-- All genre table-->
                <h2 class="main-page-title">LIST OF ALL GENRE</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="genreInput" onkeyup="filterGenre()" placeholder="Search for genre name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view, add into series cast, edit and delete cast</h5>
                    </div>
                    <div class="create-series-btn">
                        <button class="create border-radius-10" onclick="document.getElementById('add-genre').style.display='block'"><i class="fa fa-plus"></i></button>
                        <!-- hidden div inside button add genre tag -->
                        <div id="add-genre" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">ADD NEW GENRE</h2>
                                    <h5 class="sub-title-main white-font">add new genre here</h5>
                                    <span class="close-btn" onclick="document.getElementById('add-genre').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-genre">Insert new genre name</label>
                                        <br>
                                        <input type="text" placeholder="Enter New Data" name="new-genre" required>
                                    </div>
                                    <br>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='add-genre'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('add-genre').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <span class="padding-left" id="edit-genre-div"></span>
                        <button class="create border-radius-10" onclick="document.getElementById('edit-genre').style.display='block'"><i class="fa fa-edit"></i></button>
                        <!-- hidden div inside button edit genre tag -->
                        <div id="edit-genre" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">EDIT GENRE</h2>
                                    <h5 class="sub-title-main white-font">edit your genre here</h5>
                                    <span class="close-btn" onclick="document.getElementById('edit-genre').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-genre">Choose genre ID</label>
                                        <br>
                                        <select class="state-select left" name="genre-id">
                                            <option value="none">Select Genre ID</option>
                                            <?php $genreObj->displayAllGenreID(); ?>
                                        </select>
                                        <span class="error"> <?php echo $genreidErr;?></span>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-genre">Choose data column to be edit</label>
                                        <br>
                                        <select class="state-select left" name="genre-col">
                                            <option value="none">Select Genre Column</option>
                                            <option value="GenreName">Genre Name</option>
                                        </select>
                                        <span class="error"> <?php echo $genrecolErr;?></span>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-genre">Insert new data</label>
                                        <br>
                                        <input type="text" placeholder="Enter New Data" name="new-edit-genre" required>
                                        <span class="error"> <?php echo $genredataErr;?></span>
                                    </div>
                                    <br>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='edit-genre'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('edit-genre').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="genreTable" class="all-series-table font-size-20">
                            <tr class="header">
                                <th style="width:30%;">Genre ID</th>
                                <th style="width:40%;">Genre Name</th>
                                <th style="width:30%;">Action <br>(Add into series genre)<br>(Delete genre from genre table)</th>
                            </tr>
                            <?php $genreObj->displayAllGenre("edit"); ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- series cast div-->
        <div class="new-series bg-black" id="new-series-cast">
            <h2 class="main-page-title font-white">Cast Detail</h2>
            <br>
            <div class="new-series-cast">
                <h2 class="main-page-title">LIST OF SERIES CAST</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="castSeriesInput" onkeyup="filterSeriesCast()" placeholder="Search for series cast name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view and delete</h5>
                    </div>
                    <div class="create-series-btn">
                        <i class="fa fa-plus addicon"></i>
                        <button class="create" onclick="document.getElementById('cast-div').style.display='block'"><a class="white-font" href="#castpage">ADD CAST</a></button>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="castSeriesTable" class="all-series-table font-size-20">
                            <tr class="header">
                            <th style="width:20%;">Cast ID</th>
                                <th style="width:20%;">Full Name</th>
                                <th style="width:10%;">Gender</th>
                                <th style="width:20%;">Birth Date</th>
                                <th style="width:30%;">Action</th>
                            </tr>
                            <?php $seriesObj->displayAllSeriesCast($currentSeriesId); ?>
                        </table>
                    </form>
                </div>
                <br>
                <hr  class="no-margin line-black">
                <br id="castpage">
                <br>
                <!-- All cast table-->
                <h2 class="main-page-title">LIST OF ALL CAST</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="castInput" onkeyup="filterCast()" placeholder="Search for cast name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view, add into series genre, edit and delete genre</h5>
                    </div>
                    <div class="create-series-btn" id="edit-cast-div">
                        <button class="create border-radius-10" onclick="document.getElementById('add-cast').style.display='block'"><i class="fa fa-plus"></i></button>
                        <!-- hidden div inside button add cast tag -->
                        <div id="add-cast" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">ADD NEW CAST</h2>
                                    <h5 class="sub-title-main white-font">add new cast here</h5>
                                    <span class="close-btn" onclick="document.getElementById('add-cast').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-cast">Insert Cast First Name</label>
                                        <br>
                                        <input type="text" placeholder="Enter Cast First Name" name="new-cast-fname" required>
                                    </div>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-cast">Insert Cast Last Name"</label>
                                        <br>
                                        <input type="text" placeholder="Enter Cast Last Name" name="new-cast-lname" required>
                                    </div>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-cast">Insert Cast Birth Date</label>
                                        <br>
                                        <input type="date" placeholder="Enter New Data" name="new-cast-bdate" required>
                                    </div>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-cast">Insert Cast Gender</label>
                                        <select class="state-select left" name="new-cast-gender">
                                            <option value="none">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="margin-5"></div>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='add-cast'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('add-cast').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <span class="padding-left" id="edit-cast-div"></span>
                        <button class="create border-radius-10" onclick="document.getElementById('edit-cast').style.display='block'"><i class="fa fa-edit"></i></button>
                        <!-- hidden div inside button edit cast tag -->
                        <div id="edit-cast" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">EDIT CAST</h2>
                                    <h5 class="sub-title-main white-font">edit your cast here</h5>
                                    <span class="close-btn" onclick="document.getElementById('edit-cast').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-cast">Choose cast ID</label>
                                        <br>
                                        <select class="state-select left" name="cast-id">
                                            <option value="none">Select Cast ID</option>
                                            <?php $castObj->displayAllCastID(); ?>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-cast">Choose data column to be edit</label>
                                        <br>
                                        <select class="state-select left" name="cast-col" id="cast-col">
                                            <option value="none">Select Cast Column</option>
                                            <option value="CastFirstName">Cast First Name</option>
                                            <option value="CastLastName">Cast Last Name</option>
                                            <option value="BirthDate">Cast Birth Date</option>
                                            <option value="Gender">Cast Gender</option>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2 none" id="text-div">
                                        <label for="edit-cast">Insert new data</label>
                                        <br>
                                        <input type="text" placeholder="Enter New Data" name="new-edit-cast" id="text-input" >
                                    </div>
                                    <div class="editinfo-div editinfo-div-2 none" id="date-div">
                                        <label for="edit-cast">Insert new data</label>
                                        <br>
                                        <input type="date" placeholder="Enter New Cast Date" name="new-edit-cast-date" id="date-input">
                                    </div>
                                    <div class="editinfo-div editinfo-div-2 none" id="opt-div">
                                        <label for="add-cast">Select New Cast Gender</label>
                                        <select class="state-select left" name="new-edit-cast-gender" id="opt-input">
                                            <option value="none">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='edit-cast'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('edit-cast').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="castTable" class="all-series-table font-size-20">
                            <tr class="header">
                                <th style="width:20%;">Cast ID</th>
                                <th style="width:20%;">Full Name</th>
                                <th style="width:10%;">Gender</th>
                                <th style="width:20%;">Birth Date</th>
                                <th style="width:30%;">Action <br>(Add into series cast)<br>(Delete cast from cast table)</th>
                            </tr>
                            <?php $castObj->displayAllCast("edit"); ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- series director div -->
        <div class="new-series bg-black" id="new-series-director">
            <h2 class="main-page-title font-white">Director Detail</h2>
            <br>
            <div class="new-series-cast">
                <h2 class="main-page-title">LIST OF SERIES DIRECTOR</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="directorSeriesInput" onkeyup="filterSeriesDirector()" placeholder="Search for series director name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view and delete</h5>
                    </div>
                    <div class="create-series-btn">
                        <i class="fa fa-plus addicon"></i>
                        <button class="create" onclick="document.getElementById('director-div').style.display='block'"><a class="white-font" href="#directorpage">ADD DIRECTOR</a></button>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="directorSeriesTable" class="all-series-table font-size-20">
                            <tr class="header">
                                <th style="width:30%;">Director ID</th>
                                <th style="width:40%;">Full Name</th>
                                <th style="width:30%;">Action</th>
                            </tr>
                            <?php $seriesObj->displayAllSeriesDirector($currentSeriesId); ?>
                        </table>
                    </form>
                </div>
                <br>
                <hr  class="no-margin line-black">
                <br id="directorpage">
                <br>
                <!-- All director table-->
                <h2 class="main-page-title">LIST OF ALL DIRECTOR</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="directorInput" onkeyup="filterDirector()" placeholder="Search for director name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view, add into series director, edit and delete director</h5>
                    </div>
                    <div class="create-series-btn" id="edit-cast-div">
                        <button class="create border-radius-10" onclick="document.getElementById('add-director').style.display='block'"><i class="fa fa-plus"></i></button>
                        <!-- hidden div inside button add director tag -->
                        <div id="add-director" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">ADD NEW DIRECTOR</h2>
                                    <h5 class="sub-title-main white-font">add new director here</h5>
                                    <span class="close-btn" onclick="document.getElementById('add-director').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-director">Insert Director First Name</label>
                                        <br>
                                        <input type="text" placeholder="Enter Director First Name" name="new-director-fname" required>
                                    </div>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-director">Insert Director Last Name"</label>
                                        <br>
                                        <input type="text" placeholder="Enter Director Last Name" name="new-director-lname" required>
                                    </div>
                                    <div class="margin-5"></div>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='add-director'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('add-director').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <span class="padding-left" id="edit-director-div"></span>
                        <button class="create border-radius-10" onclick="document.getElementById('edit-director').style.display='block'"><i class="fa fa-edit"></i></button>
                        <!-- hidden div inside button edit director tag -->
                        <div id="edit-director" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">EDIT CAST</h2>
                                    <h5 class="sub-title-main white-font">edit your cast here</h5>
                                    <span class="close-btn" onclick="document.getElementById('edit-director').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-director">Choose Director ID</label>
                                        <br>
                                        <select class="state-select left" name="director-id">
                                            <option value="none">Select Cast ID</option>
                                            <?php $directorObj->displayAllDirectorID(); ?>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-director">Choose data column to be edit</label>
                                        <br>
                                        <select class="state-select left" name="director-col" id="director-col">
                                            <option value="none">Select Cast Column</option>
                                            <option value="DirectorFirstName">Director First Name</option>
                                            <option value="DirectorLastName">Director Last Name</option>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-cast">Insert new data</label>
                                        <br>
                                        <input type="text" placeholder="Enter New Data" name="new-edit-director" >
                                    </div>
                                    <br>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='edit-director'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('edit-director').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="directorTable" class="all-series-table font-size-20">
                            <tr class="header">
                                <th style="width:30%;">Director ID</th>
                                <th style="width:40%;">Full Name</th>
                                <th style="width:30%;">Action <br>(Add into series director)<br>(Delete director from director table)</th>
                            </tr>
                            <?php $directorObj->displayAllDirector("edit"); ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!--series award div -->
        <div class="new-series bg-black" id="new-series-award">
            <h2 class="main-page-title font-white">Award Detail</h2>
            <br>
            <div class="new-series-cast">
                <h2 class="main-page-title">LIST OF SERIES AWARD</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="awardSeriesInput" onkeyup="filterSeriesAward()" placeholder="Search for series award name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view and delete</h5>
                    </div>
                    <div class="create-series-btn">
                        <i class="fa fa-plus addicon"></i>
                        <button class="create" onclick="document.getElementById('add-award-year').style.display='block'">ADD AWARD</button>
                        <!-- hidden div inside button add series award tag -->
                        <div id="add-award-year" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">ADD NEW SERIES AWARD</h2>
                                    <h5 class="sub-title-main white-font">add new series award here</h5>
                                    <span class="close-btn" onclick="document.getElementById('add-award-year').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-award">Choose Award ID</label>
                                        <br>
                                        <select class="state-select left" name="award-id">
                                            <option value="none">Select Award ID</option>
                                            <?php $awardObj->displayAllAwardID(); ?>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-award-year">Insert New Award Year</label>
                                        <br>
                                        <input type="date" placeholder="Insert New Award Title" name="new-award-year" required>
                                    </div>
                                    <br>
                                    <div class="margin-5"></div>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='add-award-year'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('add-award-year').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="awardSeriesTable" class="all-series-table font-size-20">
                            <tr class="header">
                                <th style="width:20%;">Award ID</th>
                                <th style="width:30%;">Award Title</th>
                                <th style="width:20%;">Year</th>
                                <th style="width:30%;">Action</th>
                            </tr>
                            <?php $seriesObj->displayAllSeriesAward($currentSeriesId); ?>
                        </table>
                    </form>
                </div>
                <br>
                <hr  class="no-margin line-black">
                <br id="awardpage">
                <br>
                <!-- All award table-->
                <h2 class="main-page-title">LIST OF ALL AWARD</h2>
                <div class="flex-admin">
                    <div class="seriesinput-icons">
                        <i class="fa fa-search seriesicon"></i>
                        <input class="seriesinput-field" type="text" id="awardInput" onkeyup="filterAward()" placeholder="Search for award name.." title="Type in a name">
                    </div>
                    <div class="col">
                        <h5 class="sub-title-main">search to view, add new award, edit and delete award</h5>
                    </div>
                    <div class="create-series-btn" id="edit-cast-div">
                        <button class="create border-radius-10" onclick="document.getElementById('add-award').style.display='block'"><i class="fa fa-plus"></i></button>
                        <!-- hidden div inside button add award tag -->
                        <div id="add-award" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title white-font">ADD NEW AWARD</h2>
                                    <h5 class="sub-title-main white-font">add new award here</h5>
                                    <span class="close-btn" onclick="document.getElementById('add-award').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="add-award">Insert New Award Title</label>
                                        <br>
                                        <input type="text" placeholder="Insert New Award Title" name="new-award-title" required>
                                    </div>
                                    <br>
                                    <div class="margin-5"></div>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='add-award'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('add-award').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <span class="padding-left" id="edit-award-div"></span>
                        <button class="create border-radius-10" onclick="document.getElementById('edit-award').style.display='block'"><i class="fa fa-edit"></i></button>
                        <!-- hidden div inside button edit award tag -->
                        <div id="edit-award" class="sub-hidden-form">
                            <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="titlecontainer">
                                    <h2 class="main-page-title">EDIT AWARD</h2>
                                    <h5 class="sub-title-main">edit your award here</h5>
                                    <span class="close-btn" onclick="document.getElementById('edit-award').style.display='none'" title="Close Modal">&times;</span>
                                </div>
                                <div class="contentcontainer">
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-award">Choose Award ID</label>
                                        <br>
                                        <select class="state-select left" name="award-id">
                                            <option value="none">Select Award ID</option>
                                            <?php $awardObj->displayAllAwardID(); ?>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-award">Choose data column to be edit</label>
                                        <br>
                                        <select class="state-select left" name="award-col" id="award-col">
                                            <option value="none">Select Award Column</option>
                                            <option value="AwardTitle">Award Title</option>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="editinfo-div editinfo-div-2">
                                        <label for="edit-award">Insert new data</label>
                                        <br>
                                        <input type="text" placeholder="Enter New Data" name="new-edit-award" >
                                    </div>
                                    <br>
                                    <div class="hidden-div-btn">
                                        <button class="submitbtn inline" type="submit" name='edit-award'>Submit</button>
                                        <button class="cancelbtn inline" type="button" onclick="document.getElementById('edit-award').style.display='none'" >Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tbl-scroll">
                    <form name="series-description red" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <table id="awardTable" class="all-series-table font-size-20">
                            <tr class="header">
                                <th style="width:30%;">Award ID</th>
                                <th style="width:40%;">Award Title</th>
                                <th style="width:30%;">Action <br>(Delete award from award table)</th>
                            </tr>
                            <?php $awardObj->displayAllAward('edit'); ?>
                        </table>
                    </form>
                </div>
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
        
        // Get the form modal
        var modal = document.getElementById('edit-title');
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        //Select image js property manipulation
        const file = document.querySelector('#file');
        file.addEventListener('change', (e) => {
        // Get the selected file
        const [file] = e.target.files;
        // Get the file name and size
        const { name: fileName, size } = file;
        // Convert size in bytes to kilo bytes
        const fileSize = (size / 1000).toFixed(2);
        // Set the text content
        const fileNameAndSize = `${fileName} - ${fileSize}KB`;
        document.querySelector('.file-name').textContent = fileNameAndSize;
        });

        //Filter function for search data
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

        function filterSeriesGenre() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("genreSeriesInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("genreSeriesTable");
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

        function filterSeriesEpisode() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("episodeSeriesInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("episodeSeriesTable");
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

        function filterSeriesCast() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("castSeriesInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("castSeriesTable");
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

        function filterSeriesDirector() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("directorSeriesInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("directorSeriesTable");
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

        function filterSeriesAward() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("awardSeriesInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("awardSeriesTable");
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

        //Edit Cast details selection trigger
        var castcol = document.getElementById('cast-col');
        var textdiv = document.getElementById('text-div');
        var datediv = document.getElementById('date-div');
        var optdiv = document.getElementById('opt-div');

        castcol.onchange = function(){
            switch(castcol.options.selectedIndex){
                case 0:
                    textdiv.style.display = "none";
                    datediv.style.display = "none";
                    optdiv.style.display = "none";
                    break;
                case 1:
                    textdiv.style.display = "block";
                    datediv.style.display = "none";
                    optdiv.style.display = "none";
                    break;
                case 2:
                    textdiv.style.display = "block";
                    datediv.style.display = "none";
                    optdiv.style.display = "none";
                    break;
                case 3:
                    textdiv.style.display = "none";
                    datediv.style.display = "block";
                    optdiv.style.display = "none";
                    break;
                case 4:
                    textdiv.style.display = "none";
                    datediv.style.display = "none";
                    optdiv.style.display = "block";
                    break;
            }
            
        }

        function displayAddAwardForm(){
            document.getElementById('add-award-year').style.display='block';
        }

    </script>
</body>
</html>
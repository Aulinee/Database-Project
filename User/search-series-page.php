<?php
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
    <title>Search Series Page</title>
    
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
                    <li><a href="search-series-page.php">Search Series</a></li>
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
    <div class="main-flex">
        <div class="flex" id="flexbox">
            <button class="nav-btn inline"><a href= "main-page.php"><i class="fa fa-arrow-left"></i> Back To Main Page</a></button>
            <button class="nav-btn inline"><a href= "search-series-page.php#series-genre">Search By Genre</a></button>
            <button class="nav-btn inline"><a href= "search-series-page.php#series-cast">Search By Cast</a></button>
        </div>
    </div>
    <div class="content container-95">
        <div class="top-pick bg-black padding-5" id="series-genre">
            <div class="series-genre">
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
                <!-- <h1 class="main-page-title-white">Display <?php echo $_SESSION['genre_filter']; ?> TV Series</h1> -->
                <div class="filter-series">
                    <?php
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            if(isset($_POST['genre'])){
                                $genreValue =  $_POST['genre'];
                                $seriesObj = new Series($conn);
                                $seriesObj->displayFilterSeries($genreValue);

                                echo "<script>
                                window.location.href='search-series-page.php#series-genre';
                                </script>";
                            }
                        }else{
                            $seriesObj = new Series($conn);
                            $seriesObj->displayFilterSeries("All");
                        }

                    ?>
                    <!-- <div class="filter-poster-desc">
                        <img class="filter-display " src="img/breaking_bad_poster.jpg" alt="tv-series">
                        <p class="filter-series-title ">Breaking Bad</p>
                    </div>-->
                </div>
            </div> 
        </div>
        <div class="top-pick bg-black padding-5" id="series-cast"> 
            <h2 class="main-page-title font-white">SEARCH TV SERIES BY CAST</h2>
            <br>
            <div class="flex-admin">
                <div class="seriesinput-icons align-center">
                    <i class="fa fa-search seriesicon"></i>
                    <input class="seriesinput-field" type="text" id="seriesInput" onkeyup="filterSeries()" placeholder="Search by cast name.." title="Type in a name">
                </div>
            </div>
            <div class="tbl-scroll">
                <table id="seriesTable" class="all-series-table">
                    <tr>
                        <th>SERIES IMAGE <i class="fa fa-image"></i></th>
                        <th>TITLE <i class="fa fa-desktop"></i></th>
                        <th>TOTAL SEASON</th>
                        <th>TOTAL EPISODE</th>
                        <th>GENRE </th>
                        <th>CAST <i class="fa fa-user"></i></th>
                        <th>DIRECTOR <i class="fa fa-user"></i></th>
                        <th>AWARD <i class="fa fa-trophy"></i></th>
                        <th>RELEASE DATE <i class="fa fa-calendar"></i></th>
                    </tr>
                    <?php $seriesObj->displaySeriesByCast(); ?>
                </table> 
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
        function filterSeries() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("seriesInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("seriesTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5];
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
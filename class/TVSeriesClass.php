<?php
include '../database/dbConnection.php'; 

class Series{
    //attribute
    private $conn;

    //Constructor
    public function __construct($DB_con)
	{
        $this->conn = $DB_con;
	}

    public function displayTopSeries(){
        $seriesid = 0;
        $topSeriesQuery = "SELECT SeriesID, count(*) FROM tvserieslog GROUP BY SeriesID ORDER BY count(*) DESC LIMIT 5";
        $result = $this->conn->query($topSeriesQuery);

		if($result){
            if ($result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)){
                    $seriesid = $row["SeriesID"];
                    $seriesQuery = "SELECT * FROM tvseries WHERE SeriesID = $seriesid";
                    $sqlQuery = $this->conn->query($seriesQuery);
                    if($sqlQuery){
                        if ($sqlQuery->num_rows > 0){
                            $seriesRow = mysqli_fetch_array($sqlQuery);
                            echo'<div>
                                    <img style="width: 200px; height: 270px;"src="data:image/jpeg;base64,'.base64_encode( $seriesRow['seriesImg'] ).'"/> alt="tv-series">
                                    <p style="text-align: center; color: white; font-size: 20px; margin-left: -30%;"><a style="color:#dbdbdb" href="series-detail-page.php?id='.$seriesRow['SeriesID'].'">'.$seriesRow['SeriesTitle'].'</a></p>
                                 </div>';
                        }
                    }
                }
            }else{
                echo "Record not found";
            }
        }else{
            echo "Error in ".$topSeriesQuery." ".$this->conn->error;
        }
    }

    public function displayTopSeriesByMonth(){
        $seriesid = 0;
        $current_date = date('m', time());
        $topSeriesQuery = "SELECT SeriesID, count(*) FROM tvserieslog WHERE MONTH(AccessTime) = $current_date GROUP BY SeriesID ORDER BY count(*) DESC LIMIT 5";
        $result = $this->conn->query($topSeriesQuery);

		if($result){
            if ($result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)){
                    $seriesid = $row["SeriesID"];
                    $seriesQuery = "SELECT * FROM tvseries WHERE SeriesID = $seriesid";
                    $sqlQuery = $this->conn->query($seriesQuery);
                    if($sqlQuery){
                        if ($sqlQuery->num_rows > 0){
                            $seriesRow = mysqli_fetch_array($sqlQuery);
                            echo '<div>
                                    <img style="width: 200px; height: 270px;"src="data:image/jpeg;base64,'.base64_encode( $seriesRow['seriesImg'] ).'"/> alt="tv-series">
                                     <p style="text-align: center; color: white; font-size: 20px; margin-left: -30%;"><a style="color:#dbdbdb" href="series-detail-page.php?id='.$seriesRow['SeriesID'].'">'.$seriesRow['SeriesTitle'].'</a></p>
                                 </div>';
                        }
                    }
                }
            }else{
                echo "Record not found";
            }
        }else{
            echo "Error in ".$topSeriesQuery." ".$this->conn->error;
        }
    }

    public function displayFilterOptions(){
        $genreOptionQuery = "SELECT DISTINCT GenreID FROM seriesgenre";
        $result = $this->conn->query($genreOptionQuery);

        if($result){
            if ($result->num_rows > 0){
                while($row = mysqli_fetch_array($result)){
                    $genreid = $row["GenreID"];
                    $genreQuery = "SELECT * FROM genre WHERE GenreID = $genreid";
                    $sqlQuery = $this->conn->query($genreQuery);
                    if($sqlQuery){
                        if ($sqlQuery->num_rows > 0){
                            $genrename = mysqli_fetch_array($sqlQuery);
                            echo '<option value="'.$genrename['GenreName'].'">'.$genrename['GenreName'].'</option>';
                        }
                    }
                }
            }
        }
    }

    public function displayFilterSeries(string $genre){
        if($genre != "All"){
            //Find genreID
            $genreQuery = mysqli_query($this->conn, "SELECT GenreID AS name FROM genre WHERE GenreName = '$genre'");
            $genreRow = mysqli_fetch_array($genreQuery);
            $genreid = $genreRow['name'];

            //Find which seriesid has that genreid
            $seriesgenre = mysqli_query($this->conn, "SELECT DISTINCT SeriesID AS ID FROM seriesgenre WHERE GenreID = '$genreid'");
            while($rowseriesgenre = mysqli_fetch_array($seriesgenre)){
                $seriesid = $rowseriesgenre['ID'];
                $seriesQuery = mysqli_query($this->conn, "SELECT * FROM tvseries WHERE SeriesID = $seriesid");
                while($rowSeries = mysqli_fetch_array($seriesQuery)){
                    echo '
                    <div style="width: 30%; display: flex; flex-direction: row;">
                        <img style="width: 200px; height: 270px;" src="data:image/jpeg;base64,'.base64_encode( $rowSeries['seriesImg'] ).'" alt="tv-series">
                        <p style="margin-left: 2%; width: 100%; height: 100%; margin-top: 0; text-align: center; color: white; font-size: 30px;"><a style="color:#dbdbdb" href="series-detail-page.php?id='.$seriesid.'">'.$rowSeries['SeriesTitle'].'</a></p>
                    </div>
                    ';
                }
            }
        }else{
            $seriesQuery = mysqli_query($this->conn, "SELECT * FROM tvseries");
            while($rowSeries = mysqli_fetch_array($seriesQuery)){
                echo '
                <div style="width: 30%; display: flex; flex-direction: row;">
                    <img style="width: 200px; height: 270px;" src="data:image/jpeg;base64,'.base64_encode( $rowSeries['seriesImg'] ).'" alt="tv-series">
                    <p style="margin-left: 2%; width: 100%; height: 100%; margin-top: 0; text-align: center; color: white; font-size: 30px;"><a style="color:#dbdbdb" href="series-detail-page.php?id='.$rowSeries['SeriesID'].'">'.$rowSeries['SeriesTitle'].'</a></p>
                </div>
                ';
            }
        }
    }

    /*====================Read TV series detail including season and its episode======================= */
    public function readSeriesDesc(string $seriesid){
        $seriesQuery = mysqli_query($this->conn, "SELECT * FROM tvseries WHERE SeriesID = $seriesid");
        $arrayData = array();

        while($rowdesc = mysqli_fetch_array($seriesQuery)){
            //Change date format
            $date = $rowdesc['ReleaseDate'];
            $tempDate = date_create($date);
            
            $title = $rowdesc['SeriesTitle'];
            $release_date = date_format($tempDate,"M d, Y");
            $img = "data:image/jpeg;base64,".base64_encode( $rowdesc['seriesImg'] );
            $description = $rowdesc['Description'];
            $allCastArray = array();
            $allGenreArray = array();
            $allDirectorArray = array();
            $allAwardArray = array();
            $totalSeason = 0;

            //Find cast list
            $castQuery = mysqli_query($this->conn, "SELECT DISTINCT CastID FROM seriescast WHERE SeriesID = $seriesid");
            while($rowcast = mysqli_fetch_array($castQuery)){
                $castid = $rowcast['CastID'];
                $castNameQuery = mysqli_query($this->conn, "SELECT * FROM cast WHERE CastID = $castid");
                while($rowcastname = mysqli_fetch_array($castNameQuery)){
                    $castName = $rowcastname['CastFirstName']." ".$rowcastname['CastLastName'];
                    array_push($allCastArray, $castName);
                }
            }
            $castName = join(", ",$allCastArray); //cast list in one string

            //Find genre list
            $genreQuery = mysqli_query($this->conn, "SELECT DISTINCT GenreID FROM seriesgenre WHERE SeriesID = $seriesid");
            while($rowgenre = mysqli_fetch_array($genreQuery)){
                $genreid = $rowgenre['GenreID'];
                $genreNameQuery = mysqli_query($this->conn, "SELECT * FROM genre WHERE GenreID = $genreid");
                while($rowgenrename = mysqli_fetch_array($genreNameQuery)){
                    $genresName = $rowgenrename['GenreName'];
                    array_push($allGenreArray, $genresName);
                }

            }
            $genreName = join(", ",$allGenreArray); //genre list in one string
        

            //Find director list
            $directorQuery = mysqli_query($this->conn, "SELECT DISTINCT DirectorID FROM seriesdirector WHERE SeriesID = $seriesid");
            while($rowdirector = mysqli_fetch_array($directorQuery)){
                $directorid = $rowdirector['DirectorID'];
                $directorNameQuery = mysqli_query($this->conn, "SELECT * FROM director WHERE DirectorID = $directorid");
                while($rowdirectorname = mysqli_fetch_array($directorNameQuery)){
                    $directorName = $rowdirectorname['DirectorFirstName']." ".$rowdirectorname['DirectorLastName'];
                    array_push($allDirectorArray,  $directorName);
                }
            }
            $directorName = join(", ",$allDirectorArray); //director list in one string
            
            //Find Award List
            $awardQuery = mysqli_query($this->conn, "SELECT DISTINCT AwardID FROM seriesaward WHERE SeriesID = $seriesid");
            while($rowaward= mysqli_fetch_array($awardQuery)){
                $awardid = $rowaward['AwardID'];
                $awardNameQuery = mysqli_query($this->conn, "SELECT * FROM award WHERE AwardID =  $awardid");
                while($rowawardname = mysqli_fetch_array($awardNameQuery)){
                    $awardName = $rowawardname['AwardTitle'];
                    array_push($allAwardArray,  $awardName);
                }
            }
            $awardName = join(", ",$allAwardArray); //award list in one string

            //Find total season
            $seasonCountQuery = mysqli_query($this->conn, "SELECT COUNT(*) AS totalseason FROM season WHERE SeriesID = $seriesid");
            while($rowseason= mysqli_fetch_array($seasonCountQuery)){
                $totalSeason = $rowseason['totalseason'];
            }

            //check for empty array 
            if(empty($allCastArray)){
                $castName = "No cast for this series";
            }
            
            if (empty($allGenreArray)){
                $genreName = "No genre for this series";
            }
            
            if(empty($allDirectorArray)){
                $directorName = "No director for this series";
            }
            
            if(empty($allAwardArray)){
                $awardName = "No award for this series";
            }

            $arrayData = array($img, $title, $release_date, $description, $castName, $genreName, $directorName, $awardName, $totalSeason);

            return $arrayData;
        }
        
    }

    /*====================Read TV series season and its episode for user page======================= */
    public function readSeriesSeason(string $seriesid){
        $seasonQuery = mysqli_query($this->conn, "SELECT * FROM season WHERE SeriesID = $seriesid ORDER BY SeasonNumber ASC");
        $totalSeason = 0;

        //Find total season
        $seasonCountQuery = mysqli_query($this->conn, "SELECT COUNT(*) AS totalseason FROM season WHERE SeriesID = $seriesid");
        while($rowseasoncount = mysqli_fetch_array($seasonCountQuery)){
            $totalSeason = $rowseasoncount['totalseason'];
        }

        for ($x = 0; $x <= $totalSeason; $x++) {
            while($rowseason = mysqli_fetch_array($seasonQuery)){
                $seasonid = $rowseason['SeasonID'];
                //$seasonnum = $rowseason['SeasonNumber'];
                $seasontitle = $rowseason['SeasonTitle'];

                //episode query based on season id
                $episodeQuery = mysqli_query($this->conn, "SELECT * FROM episode WHERE SeasonID = $seasonid ORDER BY EpisodeNo ASC");

                echo '<div style="margin: 5% 0 0 8%;">';
                    echo '<h1 style="text-transform: uppercase;letter-spacing: 2px;font-size: 20px;font-weight: 600;color: #d12a27;">'.$seasontitle.'</h1>';
                        echo '<table style="font-family: Roboto, sans-serif;width: 90%;border-collapse: collapse;">';
                            echo '<tr style="border-bottom: var(--blur-white) 1px solid; pointer-events: none;">';
                                echo '<th style="color: #dbdbdb;text-align: left;padding: 2% 0;font-size: 20px;font-weight: 600;letter-spacing: 2px;color: var(--blur-white); width: 20%;">Episode Number</th>';
                                echo '<th style="color: #dbdbdb;text-align: left;padding: 2% 0;font-size: 20px;font-weight: 600;letter-spacing: 2px;color: var(--blur-white); width: 50%;">Summary</th>';
                                echo '<th style="color: #dbdbdb;text-align: left;padding: 2% 0;font-size: 20px;font-weight: 600;letter-spacing: 2px;color: var(--blur-white); width: 10%;">Duration</th>';
                                echo '<th style="color: #dbdbdb;text-align: left;padding: 2% 0;font-size: 20px;font-weight: 600;letter-spacing: 2px;color: var(--blur-white); width: 20%;">Released Date</th>';
                            echo '</tr>';
                            if($episodeQuery){
                                while($rowepisode = mysqli_fetch_array($episodeQuery)){
                                    $episode_no = "Episode ".$rowepisode['EpisodeNo']. " ". $rowepisode['EpisodeTitle'];
                                    $ep_summary = $rowepisode['Summary'];
                                    $ep_duration = $rowepisode['Duration'];
                                    $ep_date = $rowepisode['AiringDate'];
                    
                                    //Change date format
                                    $tempDate = date_create($ep_date);
                                    $airing_date = date_format($tempDate,"M d, Y");
                    
                                    echo '<tr style="border-bottom: var(--blur-white) 1px solid; pointer-events: none;">';
                                        echo '<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);padding: 2% 1%;margin: auto;">'.$episode_no.'</td>';
                                        echo '<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);padding: 2% 1%;margin: auto;">'.$ep_summary.'</td>';
                                        echo '<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);padding: 2% 1%;margin: auto;">'.$ep_duration.' minutes</td>';
                                        echo '<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);padding: 2% 1%;margin: auto;">'.$airing_date.'</td>';
                                    echo '</tr>';
                                }
                            }else{
                                echo "Error in ".$episodeQuery." ".$this->conn->error;
                            }
                        echo '</table>';
                    echo '</div>';
            }
        }

    }

    /*====================Read TV series season and its episode for admin edit page======================= */
    public function readSeriesSeasonAdmin(string $seriesid){
        $seasonQuery = mysqli_query($this->conn, "SELECT * FROM season WHERE SeriesID = $seriesid ORDER BY SeasonNumber ASC");
        $totalSeason = 0;

        //Find total season
        $seasonCountQuery = mysqli_query($this->conn, "SELECT COUNT(*) AS totalseason FROM season WHERE SeriesID = $seriesid");
        while($rowseasoncount = mysqli_fetch_array($seasonCountQuery)){
            $totalSeason = $rowseasoncount['totalseason'];
        }

        for ($x = 0; $x <= $totalSeason; $x++) {
            while($rowseason = mysqli_fetch_array($seasonQuery)){
                $seasonid = $rowseason['SeasonID'];
                $seasonnum = $rowseason['SeasonNumber'];
                $seasontitle = $rowseason['SeasonTitle'];

                echo '';
                echo '<div class="season-bg-white">';
                    echo '<h5 class="sub-title-main align-left">Season Detail 
                        <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="edit-season-page.php?seasonid='.$seasonid.'"><i class="fa fa-edit"></i></a></p>
                        <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteSeason.php?seasonid='.$seasonid.'"><i class="fa fa-trash-o"></i></a></p>
                        </h5><br>';
                    echo '<div class="flex-season">';
                        echo '<div class="flex-season-detail align-left">';
                            echo '<h2 class="season-title inline">Season Number: </h2>';
                            echo '<h2 class="season-detail inline">'.$seasonnum.'</h2>';
                        echo '</div>';
                        echo '<div class="flex-season-detail align-center">';
                            echo '<h2 class="season-title inline align-center">Season Title: </h2>';
                            echo '<h2 class="season-detail inline">'.$seasontitle.'</h2>';
                        echo '</div>';
                        echo '<div class="flex-season-detail align-right">';
                            echo '<h2 class="season-title inline">Season ID: </h2>';
                            echo '<h2 class="season-detail inline">'.$seasonid.'</h2>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<h5 class="sub-title-main align-left width-90">Episode Detail</h5>';
                echo '<div class="tbl-scroll">';
                    echo '<table class="all-series-table font-size-15">';
                        echo '<tr>';
                            echo '<th style="width:10%;">Episode ID</th>';
                            echo '<th style="width:10%;">Episode Title</th>';
                            echo '<th style="width:45%;">Summary</th>';
                            echo '<th style="width:5%;">Duration</th>';
                            echo '<th style="width:10%;">Airing Date</th>';
                            echo '<th style="width:20%;">Action</th>';
                        echo '</tr>';
                        echo $this->displayAllSeriesEpisode($seasonid);
                    echo '</table>';
                echo '</div>';
                echo '<div class="margin-top-5"></div>';
                echo '<hr  class="no-margin line-black">';

            }
        }

    }

    /*====================Read TV series episode for admin edit page======================= */
    public function displayAllSeriesEpisode($seasonid){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM episode WHERE SeasonID = $seasonid ORDER BY `episode`.`EpisodeNo`  ASC");
        while($rowepisode = mysqli_fetch_array($stringQuery)){
            $ep_id = $rowepisode['EpisodeID'];
            $ep_no = $rowepisode['EpisodeNo'];
            $ep_title = $rowepisode['EpisodeTitle'];
            $ep_summary = $rowepisode['Summary'];
            $ep_duration = $rowepisode['Duration'];
            $ep_date = $rowepisode['AiringDate'];
                    
            //Change date format
            $tempDate = date_create($ep_date);
            $airing_date = date_format($tempDate,"M d, Y");

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$ep_id.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$ep_no.' - '.$ep_title.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$ep_summary.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$ep_duration.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$airing_date.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="edit-episode-page.php?episodeid='.$ep_id.'"><i class="fa fa-edit"></i></a></p>
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteEpisode.php?episodeid='.$ep_id.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }

    /*====================Display TV Series main admin page (call function only)======================= */
    public function displaySeriesByCast(){
        $seriesQuery = mysqli_query($this->conn, "SELECT * FROM tvseries");
        $arrayData = array();

        while($rowdesc = mysqli_fetch_array($seriesQuery)){
            //Change date format
            $date = $rowdesc['ReleaseDate'];
            $tempDate = date_create($date);
            
            $seriesid = $rowdesc['SeriesID'];
            $title = $rowdesc['SeriesTitle'];
            $release_date = date_format($tempDate,"M d, Y");
            $img = "data:image/jpeg;base64,".base64_encode( $rowdesc['seriesImg'] );
            $description = $rowdesc['Description'];
            $allCastArray = array();
            $allGenreArray = array();
            $allDirectorArray = array();
            $allAwardArray = array();
            $totalSeason = 0;
            $totalEpisode = 0;
            $totalView = 0;

            //Find cast list
            $castQuery = mysqli_query($this->conn, "SELECT DISTINCT CastID FROM seriescast WHERE SeriesID = $seriesid");
            while($rowcast = mysqli_fetch_array($castQuery)){
                $castid = $rowcast['CastID'];
                $castNameQuery = mysqli_query($this->conn, "SELECT * FROM cast WHERE CastID = $castid");
                while($rowcastname = mysqli_fetch_array($castNameQuery)){
                    $castName = $rowcastname['CastFirstName']." ".$rowcastname['CastLastName'];
                    array_push($allCastArray, $castName);
                }
            }

            //Find genre list
            $genreQuery = mysqli_query($this->conn, "SELECT DISTINCT GenreID FROM seriesgenre WHERE SeriesID = $seriesid");
            while($rowgenre = mysqli_fetch_array($genreQuery)){
                $genreid = $rowgenre['GenreID'];
                $genreNameQuery = mysqli_query($this->conn, "SELECT * FROM genre WHERE GenreID = $genreid");
                while($rowgenrename = mysqli_fetch_array($genreNameQuery)){
                    $genresName = $rowgenrename['GenreName'];
                    array_push($allGenreArray, $genresName);
                }

            }
        

            //Find director list
            $directorQuery = mysqli_query($this->conn, "SELECT DISTINCT DirectorID FROM seriesdirector WHERE SeriesID = $seriesid");
            while($rowdirector = mysqli_fetch_array($directorQuery)){
                $directorid = $rowdirector['DirectorID'];
                $directorNameQuery = mysqli_query($this->conn, "SELECT * FROM director WHERE DirectorID = $directorid");
                while($rowdirectorname = mysqli_fetch_array($directorNameQuery)){
                    $directorName = $rowdirectorname['DirectorFirstName']." ".$rowdirectorname['DirectorLastName'];
                    array_push($allDirectorArray,  $directorName);
                }
            }
            
            //Find Award List
            $awardQuery = mysqli_query($this->conn, "SELECT DISTINCT AwardID FROM seriesaward WHERE SeriesID = $seriesid");
            while($rowaward= mysqli_fetch_array($awardQuery)){
                $awardid = $rowaward['AwardID'];
                $awardNameQuery = mysqli_query($this->conn, "SELECT * FROM award WHERE AwardID =  $awardid");
                while($rowawardname = mysqli_fetch_array($awardNameQuery)){
                    $awardName = $rowawardname['AwardTitle'];
                    array_push($allAwardArray,  $awardName);
                }
            }

            //Find total season
            $seasonCountQuery = mysqli_query($this->conn, "SELECT COUNT(*) AS totalseason FROM season WHERE SeriesID = $seriesid");
            while($rowseason= mysqli_fetch_array($seasonCountQuery)){
                $totalSeason = $rowseason['totalseason'];
            }

            //Find total episode
            $episodeCountQuery = mysqli_query($this->conn, "SELECT COUNT(e.EpisodeTitle) AS totalep FROM episode e, season s WHERE s.SeriesID = $seriesid  AND s.SeasonID = e.SeasonID");
            while($rowepisode= mysqli_fetch_array($episodeCountQuery)){
                $totalEpisode = $rowepisode['totalep'];
            }

            //Find total series viewed by user
            $viewCountQuery = mysqli_query($this->conn, "SELECT COUNT(*) AS totalview FROM tvserieslog WHERE SeriesID = $seriesid");
            while($rowview= mysqli_fetch_array($viewCountQuery)){
                $totalView = $rowview['totalview'];
            }

            //check for empty array 
            if(empty($allCastArray)){
                $castName = "No cast";
                array_push($allCastArray, $castName);
            }
            
            if (empty($allGenreArray)){
                $genreName = "No genre";
                array_push($allGenreArray, $genreName);
            }
            
            if(empty($allDirectorArray)){
                $directorName = "No director";
                array_push($allDirectorArray, $directorName);
            }
            
            if(empty($allAwardArray)){
                $awardName = "No award";
                array_push($allAwardArray, $awardName);
            }

            //echo all series result
            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;"> <img style="width: 120px;height: 150px;margin: auto;" src="'.$img.'"></td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$title.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$totalSeason.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$totalEpisode.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allGenreArray as $genre){
                    echo $genre.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allCastArray as $cast){
                    echo $cast.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allDirectorArray as $director){
                    echo $director.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allAwardArray as $award){
                    echo $award.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$release_date.'</td>';
            echo '</tr>';
        }
    }

    /*====================Display TV Series main admin page (call function only)======================= */
    public function displayAllSeries(){
        $seriesQuery = mysqli_query($this->conn, "SELECT * FROM tvseries");
        $arrayData = array();

        while($rowdesc = mysqli_fetch_array($seriesQuery)){
            //Change date format
            $date = $rowdesc['ReleaseDate'];
            $tempDate = date_create($date);
            
            $seriesid = $rowdesc['SeriesID'];
            $title = $rowdesc['SeriesTitle'];
            $release_date = date_format($tempDate,"M d, Y");
            $img = "data:image/jpeg;base64,".base64_encode( $rowdesc['seriesImg'] );
            $description = $rowdesc['Description'];
            $allCastArray = array();
            $allGenreArray = array();
            $allDirectorArray = array();
            $allAwardArray = array();
            $totalSeason = 0;
            $totalEpisode = 0;
            $totalView = 0;

            //Find cast list
            $castQuery = mysqli_query($this->conn, "SELECT DISTINCT CastID FROM seriescast WHERE SeriesID = $seriesid");
            while($rowcast = mysqli_fetch_array($castQuery)){
                $castid = $rowcast['CastID'];
                $castNameQuery = mysqli_query($this->conn, "SELECT * FROM cast WHERE CastID = $castid");
                while($rowcastname = mysqli_fetch_array($castNameQuery)){
                    $castName = $rowcastname['CastFirstName']." ".$rowcastname['CastLastName'];
                    array_push($allCastArray, $castName);
                }
            }

            //Find genre list
            $genreQuery = mysqli_query($this->conn, "SELECT DISTINCT GenreID FROM seriesgenre WHERE SeriesID = $seriesid");
            while($rowgenre = mysqli_fetch_array($genreQuery)){
                $genreid = $rowgenre['GenreID'];
                $genreNameQuery = mysqli_query($this->conn, "SELECT * FROM genre WHERE GenreID = $genreid");
                while($rowgenrename = mysqli_fetch_array($genreNameQuery)){
                    $genresName = $rowgenrename['GenreName'];
                    array_push($allGenreArray, $genresName);
                }

            }
        

            //Find director list
            $directorQuery = mysqli_query($this->conn, "SELECT DISTINCT DirectorID FROM seriesdirector WHERE SeriesID = $seriesid");
            while($rowdirector = mysqli_fetch_array($directorQuery)){
                $directorid = $rowdirector['DirectorID'];
                $directorNameQuery = mysqli_query($this->conn, "SELECT * FROM director WHERE DirectorID = $directorid");
                while($rowdirectorname = mysqli_fetch_array($directorNameQuery)){
                    $directorName = $rowdirectorname['DirectorFirstName']." ".$rowdirectorname['DirectorLastName'];
                    array_push($allDirectorArray,  $directorName);
                }
            }
            
            //Find Award List
            $awardQuery = mysqli_query($this->conn, "SELECT DISTINCT AwardID FROM seriesaward WHERE SeriesID = $seriesid");
            while($rowaward= mysqli_fetch_array($awardQuery)){
                $awardid = $rowaward['AwardID'];
                $awardNameQuery = mysqli_query($this->conn, "SELECT * FROM award WHERE AwardID =  $awardid");
                while($rowawardname = mysqli_fetch_array($awardNameQuery)){
                    $awardName = $rowawardname['AwardTitle'];
                    array_push($allAwardArray,  $awardName);
                }
            }

            //Find total season
            $seasonCountQuery = mysqli_query($this->conn, "SELECT COUNT(*) AS totalseason FROM season WHERE SeriesID = $seriesid");
            while($rowseason= mysqli_fetch_array($seasonCountQuery)){
                $totalSeason = $rowseason['totalseason'];
            }

            //Find total episode
            $episodeCountQuery = mysqli_query($this->conn, "SELECT COUNT(e.EpisodeTitle) AS totalep FROM episode e, season s WHERE s.SeriesID = $seriesid  AND s.SeasonID = e.SeasonID");
            while($rowepisode= mysqli_fetch_array($episodeCountQuery)){
                $totalEpisode = $rowepisode['totalep'];
            }

            //Find total series viewed by user
            $viewCountQuery = mysqli_query($this->conn, "SELECT COUNT(*) AS totalview FROM tvserieslog WHERE SeriesID = $seriesid");
            while($rowview= mysqli_fetch_array($viewCountQuery)){
                $totalView = $rowview['totalview'];
            }

            //check for empty array 
            if(empty($allCastArray)){
                $castName = "No cast";
                array_push($allCastArray, $castName);
            }
            
            if (empty($allGenreArray)){
                $genreName = "No genre";
                array_push($allGenreArray, $genreName);
            }
            
            if(empty($allDirectorArray)){
                $directorName = "No director";
                array_push($allDirectorArray, $directorName);
            }
            
            if(empty($allAwardArray)){
                $awardName = "No award";
                array_push($allAwardArray, $awardName);
            }

            //echo all series result
            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;"> <img style="width: 120px;height: 150px;margin: auto;" src="'.$img.'"></td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$title.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$totalView.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$totalSeason.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$totalEpisode.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allGenreArray as $genre){
                    echo $genre.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allCastArray as $cast){
                    echo $cast.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allDirectorArray as $director){
                    echo $director.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">';
                foreach($allAwardArray as $award){
                    echo $award.'<br>';
                } 
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$release_date.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="edit-btn inline"><a href="edit-series-page.php?id='.$seriesid.'" style="color: white;"><i class="fa fa-edit"></i></a></p>
                <p class="delete-btn inline"><a href="deleteTVSeries.php?id='.$seriesid.'" style="color: white;"><i class="fa fa-trash-o"></i></a></p>
                </td>';
            echo '</tr>';
        }
    }

    /*====================Add TV series log======================= */
    public function addSeriesLog(int $userid, int $seriesid){
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $current_time = date('Y-m-d H:i:s', time());

        $query = mysqli_query($this->conn, "INSERT INTO tvserieslog (SeriesID, UserID, AccessTime) VALUES ($userid, $seriesid, '$current_time')");
        if ($query == true) {
            //echo "Successful add query";
        }else{
            echo "Error in ".$query." ".$this->conn->error;
            //echo "Unsuccessful add query. try again!";
        }
    }

    /*==================== Add a new series to the system and return its seriesID======================= */
    public function addSeries($img, $seriesTitle, $description, $releaseDate)
    {
        $tempdate = date_create($releaseDate);
        $current_time = date_format($tempdate, 'Y-m-d');

        /* Insert query template */
        $stringQuery = "INSERT INTO tvseries (seriesImg, SeriesTitle, Description, ReleaseDate) VALUES ('$img','$seriesTitle', '$description', '$current_time')";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            //echo "Successful add query";
            $last_id = $this->conn->insert_id;
            return $last_id;
        }else{
            echo "Error in ".$sqlQuery." ".$this->conn->error;
            //echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Modify TV series and set attribute again for modified detail======================= */
    public function updateSeries(int $seriesID, string $seriesTitle, string $description, string $releaseDate)
    {
        $seriesID = $this->conn->real_escape_string($seriesID);
        $seriesTitle = $this->conn->real_escape_string($seriesTitle);
        $description = $this->conn->real_escape_string($description);
        $releaseDate = $this->conn->real_escape_string($releaseDate);

        /* Insert query template */
        $stringQuery = "UPDATE tvseries SET SeriesTitle = '$seriesTitle',Description = '$description', ReleaseDate = '$releaseDate' WHERE SeriesID = '$seriesID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            echo "Successful update query";
        }else{
            echo "Unsuccessful update query. try again!";
        }
    }

    public function updateSeriesPoster(int $seriesID, string $poster){
        /* update query template */
        $stringQuery = "UPDATE tvseries SET seriesImg = '$poster' WHERE SeriesID = '$seriesID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    public function updateSeriesTitle(int $seriesID, string $seriesTitle){
        $seriesTitle = $this->conn->real_escape_string($seriesTitle);

        /* update query template */
        $stringQuery = "UPDATE tvseries SET SeriesTitle = '$seriesTitle' WHERE SeriesID = '$seriesID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    public function updateSeriesDate(int $seriesID, string $seriesDate){
        $seriesDate = $this->conn->real_escape_string($seriesDate);

        /* update query template */
        $stringQuery = "UPDATE tvseries SET ReleaseDate = '$seriesDate' WHERE SeriesID = '$seriesID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    public function updateSeriesDesc(int $seriesID, string $description){
        $description = $this->conn->real_escape_string($description);

        /* update query template */
        $stringQuery = "UPDATE tvseries SET Description = '$description' WHERE SeriesID = '$seriesID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete TV series along with its season, episode, seriescast, seriesaward, seriesgenre, seriesdirector and log details======================= */
    public function deleteSeriesById(int $seriesid){
        $query_tvseries = "DELETE FROM tvseries WHERE SeriesID = $seriesid";
        $sql_tvseries = $this->conn->query($query_tvseries);

		if ($sql_tvseries == true) {
            return true;
        }

        return false;
    }

    /*==================== Add a new series season to the system and return its seasonID for episode adding purposes=======================*/
    public function addSeason(string $seriesID, string $seasonTitle, string $seasonnum)
    {
        $newseriesID = $this->conn->real_escape_string($seriesID);
        $newseasonTitle = $this->conn->real_escape_string($seasonTitle);
        $newseasonnum = $this->conn->real_escape_string($seasonnum);

        /* Insert query template */
        $stringQuery = "INSERT INTO season (SeriesID, SeasonTitle, SeasonNumber) VALUES ('$newseriesID', '$newseasonTitle', '$newseasonnum')";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Check if episode number already exist================================== */
    public function checkSeasonNumber(string $seriesID, string $seasonNo)
    {
        /* Insert query template */
        $stringQuery = "SELECT * FROM season WHERE SeriesID = $seriesID AND SeasonNumber = $seasonNo";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    public function displaySeasonOptions($seriesid){
        $seasonOptionQuery = "SELECT * FROM season WHERE SeriesID = $seriesid ORDER BY SeasonNumber ASC";
        $result = $this->conn->query($seasonOptionQuery);

        if($result){
            if ($result->num_rows > 0){
                while($row = mysqli_fetch_array($result)){
                    $seasonid = $row["SeasonID"];
                    $seasonnum = $row["SeasonNumber"];
                    $seasontitle = $row["SeasonTitle"];
                    echo '<option value="'.$seasonid.'">'.$seasonnum.' - '.$seasontitle.'</option>';
                }
            }
        }
    }

     /*====================Read season detail=======================*/
     public function readSeason($seasonid){
        $seasonQuery = "SELECT * FROM season WHERE SeasonID = $seasonid";
        $result = $this->conn->query($seasonQuery);
        $season_data = array();

        if($result){
            if ($result->num_rows > 0){
                while($row = mysqli_fetch_array($result)){
                    $seasonid = $row["SeasonID"];
                    $seasontitle = $row["SeasonTitle"];
                    $seasonnumber =  $row["SeasonNumber"];

                    $season_data = array($seasonid, $seasonnumber, $seasontitle);
                }
            }
        }
        return $season_data;
     }

    /*====================Modify series season title======================= */
    public function updateSeason(int $seasonid, string $seasonTitle, string $seasonNum)
    {
        $newseasonID = $this->conn->real_escape_string($seasonid);
        $newseasonTitle = $this->conn->real_escape_string($seasonTitle);
        $newseasonNum = $this->conn->real_escape_string($seasonNum);

        /* Insert query template */
        $stringQuery = "UPDATE season SET SeasonTitle = '$newseasonTitle', SeasonNumber = '$newseasonNum' WHERE SeasonID = '$newseasonID'";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete series season along with its episode details======================= */
    public function deleteSeasonById(int $seasonid){
        $query = "DELETE FROM season WHERE SeasonID = $seasonid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
            return true;
        }

        return false;
    }

    /*====================Add a new series episode for each season to the system======================= */
    public function addEpisode(int $seasonid, int $ep_no, string $title, string $summary, string $duration, string $airingdate)
    {
        $newseasonid = $this->conn->real_escape_string($seasonid);
        $newepisodeno = $this->conn->real_escape_string($ep_no);
        $newtitle = $this->conn->real_escape_string($title);
        $newsummary = $this->conn->real_escape_string($summary);
        $newduration = $this->conn->real_escape_string($duration);
        $newairingdate = $this->conn->real_escape_string($airingdate);

        /* Insert query template */
        $stringQuery = "INSERT INTO episode (SeasonID, EpisodeNo, EpisodeTitle, Summary, Duration, AiringDate) VALUES ('$newseasonid','$newepisodeno','$newtitle','$newsummary','$newduration','$newairingdate')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Check if episode number already exist================================== */
    public function checkEpisodeNumber(string $seasonID, string $episodeNo)
    {
        /* Insert query template */
        $stringQuery = "SELECT * FROM episode WHERE SeasonID = $seasonID AND EpisodeNo = $episodeNo";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Read episode detail=======================*/
    public function readEpisode($episodeid){
        $episodeQuery = "SELECT * FROM episode WHERE EpisodeID = $episodeid";
        $result = $this->conn->query($episodeQuery);
        $episode_data = array();

        if($result){
            if ($result->num_rows > 0){
                while($rowepisode = mysqli_fetch_array($result)){
                    $ep_id = $rowepisode['EpisodeID'];
                    $ep_no = $rowepisode['EpisodeNo'];
                    $ep_title = $rowepisode['EpisodeTitle'];
                    $ep_summary = $rowepisode['Summary'];
                    $ep_duration = $rowepisode['Duration'];
                    $ep_date = $rowepisode['AiringDate'];

                    $episode_data = array($ep_id, $ep_no, $ep_title, $ep_summary, $ep_duration, $ep_date);
                }
            }
        }
        return $episode_data;
     }

    /*====================Modify series episode======================= */
    public function modifyEpisode(int $episodeid, int $episodeno, string $title, string $summary, string $duration, string $airingdate)
    {
        $newepisodeid = $this->conn->real_escape_string($episodeid);
        $newepisodeno = $this->conn->real_escape_string($episodeno);
        $newtitle = $this->conn->real_escape_string($title);
        $newsummary = $this->conn->real_escape_string($summary);
        $newduration = $this->conn->real_escape_string($duration);
        $newairingdate = $this->conn->real_escape_string($airingdate);

        /* Insert query template */
        $stringQuery = "UPDATE episode SET EpisodeNo = '$newepisodeno', EpisodeTitle = '$newtitle', Summary = '$newsummary', Duration = '$newduration', AiringDate = '$newairingdate' WHERE EpisodeID = ' $newepisodeid'";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete series episode=======================*/
    public function deleteEpisodeById(int $episodeid){
        $query = "DELETE FROM episode WHERE EpisodeID = $episodeid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
            return true;
        }

        return false;
    }

    /*==================== Display all series genre================================== */
    public function displayAllSeriesGenre($seriesid){
        $stringQuery = mysqli_query($this->conn, "SELECT DISTINCT s.GenreID , g.GenreName FROM genre g, seriesgenre s WHERE s.SeriesID = $seriesid  AND s.GenreID = g.GenreID");
        while($rowgenre = mysqli_fetch_array($stringQuery)){
            $genreid = $rowgenre['GenreID'];
            $genrename = $rowgenre['GenreName'];

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$genreid.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$genrename.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteSeriesGenre.php?genreid='.$genreid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }

    /*==================== Add a new series genre to the system================================== */
    public function addSeriesGenre(string $seriesID, string $genreID)
    {
        $newSeriesID = $this->conn->real_escape_string($seriesID);
        $newGenreID = $this->conn->real_escape_string($genreID);

        /* Insert query template */
        $stringQuery = "INSERT INTO seriesgenre (SeriesID, GenreID) VALUES ('$newSeriesID', '$newGenreID')";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Check if series genre already exist================================== */
    public function checkSeriesGenre(string $seriesID, string $genreID)
    {
        $newSeriesID = $this->conn->real_escape_string($seriesID);
        $newGenreID = $this->conn->real_escape_string($genreID);

        /* Insert query template */
        $stringQuery = "SELECT * FROM seriesgenre WHERE SeriesID = '$newSeriesID' AND GenreID = '$newGenreID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Delete seriesgenre======================= */
    public function deleteSeriesGenre(string $seriesID, string $genreID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriesgenre WHERE SeriesID = $seriesID AND GenreID = $genreID";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

     /*==================== Display all series cast================================== */
     public function displayAllSeriesCast($seriesid){
        $stringQuery = mysqli_query($this->conn, "SELECT DISTINCT s.CastID, c.CastFirstName, c.CastLastName, c.BirthDate, c.Gender FROM cast c, seriescast s WHERE s.SeriesID = $seriesid  AND s.CastID = c.CastID");
        while($rowcast = mysqli_fetch_array($stringQuery)){
            $castid = $rowcast['CastID'];
            $castname = $rowcast['CastFirstName']." ". $rowcast['CastLastName'];
            $castbirthdate = $rowcast['BirthDate'];
            $castgender = $rowcast['Gender'];

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castid.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castname.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castgender.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castbirthdate.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteSeriesCast.php?castid='.$castid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }

    /*==================== Add a new series cast to the system================================== */
    public function addSeriesCast(string $seriesID, string $castID)
    {
        $newSeriesID = $this->conn->real_escape_string($seriesID);
        $newCastID = $this->conn->real_escape_string($castID);

        /* Insert query template */
        $stringQuery = "INSERT INTO seriescast (SeriesID, CastID) VALUES ('$newSeriesID', '$newCastID')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Check if series genre already exist================================== */
    public function checkSeriesCast(string $seriesID, string $castID)
    {
        $newSeriesID = $this->conn->real_escape_string($seriesID);
        $newCastID = $this->conn->real_escape_string($castID);

        /* Insert query template */
        $stringQuery = "SELECT * FROM seriescast WHERE SeriesID = '$newSeriesID' AND CastID = '$newCastID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Delete seriescast=======================*/
    public function deleteSeriesCast(string $seriesID, string $castID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriescast WHERE SeriesID = $seriesID AND CastID = $castID";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*==================== Display all series director================================== */
    public function displayAllSeriesAward($seriesid){
        $stringQuery = mysqli_query($this->conn, "SELECT DISTINCT s.AwardID, s.Year , a.AwardTitle FROM award a, seriesaward s WHERE s.SeriesID = $seriesid  AND s.AwardID = a.AwardID ORDER BY s.Year DESC");
        while($rowaward = mysqli_fetch_array($stringQuery)){
            $awardid = $rowaward['AwardID'];
            $awardtitle = $rowaward['AwardTitle'];
            $awardyear = $rowaward['Year'];

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$awardid.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$awardtitle.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$awardyear.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteSeriesAward.php?awardid='.$awardid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }


    /*==================== Add a new series award to the system==================================*/
    public function addSeriesAward(string $seriesID, string $awardID, string $year)
    {
        $newSeriesID = $this->conn->real_escape_string($seriesID);
        $newAwardID = $this->conn->real_escape_string($awardID);
        $newYear = $this->conn->real_escape_string($year);

        //Change date format
        $tempDate = date_create($newYear);
        $newYearFormatted = date_format($tempDate,"Y");

        /* Insert query template */
        $stringQuery = "INSERT INTO seriesaward (SeriesID, AwardID, Year) VALUES ('$newSeriesID', '$newAwardID', '$newYearFormatted')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete seriesaward=======================*/
    public function deleteSeriesAward(string $seriesID, string $awardID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriesaward WHERE SeriesID = $seriesID AND AwardID = $awardID";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*==================== Display all series director================================== */
    public function displayAllSeriesDirector($seriesid){
        $stringQuery = mysqli_query($this->conn, "SELECT DISTINCT s.DirectorID , d.DirectorFirstName, d.DirectorLastName FROM director d, seriesdirector s WHERE s.SeriesID = $seriesid  AND s.DirectorID = d.DirectorID");
        while($rowdirector = mysqli_fetch_array($stringQuery)){
            $directorid = $rowdirector['DirectorID'];
            $directorname = $rowdirector['DirectorFirstName']." ".$rowdirector['DirectorLastName'];

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$directorid.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$directorname.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteSeriesDirector.php?directorid='.$directorid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }

    /*==================== Add a new series director to the system================================== */
    public function addSeriesDirector(string $seriesID, string $directorID)
    {
        $newSeriesID = $this->conn->real_escape_string($seriesID);
        $newDirectorID = $this->conn->real_escape_string($directorID);

        /* Insert query template */
        $stringQuery = "INSERT INTO seriesdirector (SeriesID, DirectorID) VALUES ('$newSeriesID', '$newDirectorID')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Check if series director already exist================================== */
    public function checkSeriesDirector(string $seriesID, string $directorID)
    {
        /*check query template */
        $stringQuery = "SELECT * FROM seriesdirector WHERE SeriesID = $seriesID AND DirectorID = $directorID";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Delete seriesdirector=======================*/
    public function deleteSeriesDirector(string $seriesID, string $directorID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriesdirector WHERE SeriesID = $seriesID AND DirectorID = $directorID";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }
}

class Genre{
    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
        $this->conn = $DB_con;
	}

    /*====================Add genre=======================*/
    public function addGenre(string $genreName)
    {
        $newGenreName = $this->conn->real_escape_string($genreName);

        /* Insert query template */
        $stringQuery = "INSERT INTO genre (GenreName) VALUES ('$newGenreName')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Display all genre=======================*/
    public function displayAllGenre($homepage){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM genre");
        while($rowgenre = mysqli_fetch_array($stringQuery)){
            $genreid = $rowgenre['GenreID'];
            $genrename = $rowgenre['GenreName'];

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$genreid.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$genrename.'';
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="'.$homepage.'SeriesGenre.php?genreid='.$genreid.'"><i class="fa fa-plus"></i></a></p>
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteGenre.php?genreid='.$genreid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }

    /*====================Display genreid option=======================*/
    public function displayAllGenreID(){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM genre");
        while($rowgenre = mysqli_fetch_array($stringQuery)){
            $genreid = $rowgenre['GenreID'];
            $genrename = $rowgenre['GenreName'];

            echo '<option value="'.$genreid.'">'.$genreid." - ".$genrename.'</option>';
        }
    }

    /*====================Check existing genre=======================*/
    public function checkGenre(string $genreName)
    {
        /* check query template */
        $stringQuery = "SELECT * FROM genre WHERE LOWER(genre.GenreName) LIKE '%$genreName%'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Modify genre=======================*/
    public function modifyGenre(string $genreID, string $genreCol, string $genreName)
    {
        /* Update query template */
        $stringQuery = "UPDATE genre SET $genreCol = '$genreName' WHERE GenreID = $genreID";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete genre by ID=======================*/
    public function deleteGenreById(int $genreid){
        $query = "DELETE FROM genre WHERE GenreID = $genreid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
            return true;
        }

        return false;
    }

}

class Cast{
    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
        $this->conn = $DB_con;
	}

    /*====================Add cast=======================*/
    public function addCast(string $firstName, string $lastName, string $birthdate, string $gender)
    {
        $newfirstName = $this->conn->real_escape_string($firstName);
        $newlastName = $this->conn->real_escape_string($lastName);
        $newbirthdate = $this->conn->real_escape_string($birthdate);
        $newgender = $this->conn->real_escape_string($gender);

        /* Insert query template */
        $stringQuery = "INSERT INTO cast (CastFirstName, CastLastName, BirthDate, Gender) VALUES ('$newfirstName','$newlastName','$newbirthdate','$newgender')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Check existing cast=======================*/
    public function checkCast(string $firstName, string $lastName, string $birthdate, string $gender)
    {
        $tempDate = date_create($birthdate);
        $new_date = date_format($tempDate,"Y-m-d");

        /* check query template */
        $stringQuery = "SELECT * FROM cast WHERE LOWER(CastFirstName) LIKE '%$firstName%'AND LOWER(CastLastName) LIKE '%$lastName%' AND BirthDate = '$new_date' AND LOWER(Gender) LIKE '$gender'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Display all genre=======================*/
    public function displayAllCast($homepage){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM cast");
        while($rowcast = mysqli_fetch_array($stringQuery)){
            $castid = $rowcast['CastID'];
            $castname = $rowcast['CastFirstName']." ".$rowcast['CastLastName'];
            $castgender = $rowcast['Gender'];
            $castbirthdate = $rowcast['BirthDate'];

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castid.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castname.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castgender.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$castbirthdate.'';
                echo '</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="'.$homepage.'SeriesCast.php?castid='.$castid.'"><i class="fa fa-plus"></i></a></p>
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteCast.php?castid='.$castid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }

    /*====================Display castid option=======================*/
    public function displayAllCastID(){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM cast");
        while($rowcast = mysqli_fetch_array($stringQuery)){
            $castid = $rowcast['CastID'];
            $castname = $rowcast['CastFirstName']." ".$rowcast['CastLastName'];

            echo '<option value="'.$castid.'">'.$castid." - ".$castname.'</option>';
        }
    }

    /*====================Modify cast=======================*/
    public function modifyCast(string $castId, string $castCol, string $castdata)
    {
        /* Update query template */
        $stringQuery = "UPDATE cast SET $castCol = '$castdata' WHERE CastID = $castId";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete cast by ID=======================*/
    public function deleteCastById(int $castid){
        $query = "DELETE FROM cast WHERE CastID = $castid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
            return true;
        }

        return false;
    }

}

class Director{
    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
        $this->conn = $DB_con;
	}

    /*====================Add director=======================*/
    public function addDirector(string $firstname, string $lastname)
    {
        $newfirstname = $this->conn->real_escape_string($firstname);
        $newlastname = $this->conn->real_escape_string($lastname);

        /* Insert query template */
        $stringQuery = "INSERT INTO director (DirectorFirstName, DirectorLastName) VALUES ('$newfirstname', '$newlastname')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Display directorid option=======================*/
    public function displayAllDirectorID(){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM director");
        while($rowdirector = mysqli_fetch_array($stringQuery)){
            $directorid = $rowdirector['DirectorID'];
            $directorname = $rowdirector['DirectorFirstName']." ".$rowdirector['DirectorLastName'];

            echo '<option value="'.$directorid.'">'.$directorid." - ".$directorname.'</option>';
        }
    }

    /*====================Check existing director=======================*/
    public function checkDirector(string $firstName, string $lastName)
    {
        /* check query template */
        $stringQuery = "SELECT * FROM director WHERE LOWER(DirectorFirstName) LIKE '%$firstName%'AND LOWER(DirectorLastName) LIKE '%$lastName%'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Display all director=======================*/
    public function displayAllDirector($homepage){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM director");
        while($rowcast = mysqli_fetch_array($stringQuery)){
            $directorid = $rowcast['DirectorID'];
            $directorname = $rowcast['DirectorFirstName']." ".$rowcast['DirectorLastName'];

            echo '<tr>';
                echo '<td style="text-align: left;padding: 12px;">'.$directorid.'</td>';
                echo '<td style="text-align: left;padding: 12px;">'. $directorname.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="'.$homepage.'SeriesDirector.php?directorid='.$directorid.'"><i class="fa fa-plus"></i></a></p>
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteDirector.php?directorid='.$directorid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';

        }
    }
    /*====================Modify director=======================*/
    public function modifyDirector(string $directorId, string $directorCol, string $directordata)
    {
        /* Update query template */
        $stringQuery = "UPDATE director SET $directorCol = '$directordata' WHERE DirectorID = $directorId";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete director by ID=======================*/
    public function deleteDirectorById(int $directorid){
        $query = "DELETE FROM director WHERE DirectorID = $directorid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
            return true;
        }

        return false;
    }
}

class Award{
    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
        $this->conn = $DB_con;
	}

     /*====================Display directorid option=======================*/
     public function displayAllAwardID(){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM award");
        while($rowaward = mysqli_fetch_array($stringQuery)){
            $awardid = $rowaward['AwardID'];
            $awardtitle = $rowaward['AwardTitle'];

            echo '<option value="'.$awardid.'">'.$awardid." - ".$awardtitle.'</option>';
        }
    }

    /*====================Add award=======================*/
    public function addAward(string $awardname)
    {
        $newawardname = $this->conn->real_escape_string($awardname);

        /* Insert query template */
        $stringQuery = "INSERT INTO award (AwardTitle) VALUES ('$newawardname')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Check existing genre=======================*/
    public function checkAward(string $awardTitle)
    {
        /* check query template */
        $stringQuery = "SELECT * FROM award WHERE LOWER(award.AwardTitle) LIKE '%$awardTitle%'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery) {
            if ($sqlQuery->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

    /*====================Display all award=======================*/
    public function displayAllAward($homepage){
        $stringQuery = mysqli_query($this->conn, "SELECT * FROM award");
        while($rowcast = mysqli_fetch_array($stringQuery)){
            $awardid = $rowcast['AwardID'];
            $awardname = $rowcast['AwardTitle'];

            echo '<tr>';
                echo '<td style="text-align: left;padding: 12px;">'.$awardid.'</td>';
                echo '<td style="text-align: left;padding: 12px;">'. $awardname.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">
                <p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="deleteAward.php?awardid='.$awardid.'"><i class="fa fa-trash-o"></i></a></p></td>';
            echo '</tr>';
        }
    }

    //<p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="'.$homepage.'SeriesAward.php?awardid='.$awardid.'"><i class="fa fa-plus"></i></a></p>
    
    /*====================Modify award=======================*/
    public function modifyAward(string $awardID, string $awardCol, string $awardTitle)
    {
        /* Update query template */
        $stringQuery = "UPDATE award SET $awardCol = '$awardTitle' WHERE AwardID = $awardID";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            return true;
        }

        return false;
    }

    /*====================Delete award by ID=======================*/
    public function deleteAwardById(int $awardid){
        $query = "DELETE FROM award WHERE AwardID = $awardid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
            return true;
        }

        return false;
    }
}

?>
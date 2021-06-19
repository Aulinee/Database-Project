<?php
include 'testing/dbConnection.php';

class Series{
    //attribute
    private $seriesID;
    private $seasonID;
    private $seriesTitle;
    private $description;
    private $releaseDate;
    private $conn;

    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
		$this->seriesID = NULL;
        $this->seasonID = NULL;
		$this->seriesTitle = "";
        $this->description = "";
        $this->releaseDate = "";
        $this->conn = $DB_con;
	}

    //Set and get attribute function
    public function setSeriesID(int $seriesid){
        $this->seriesID = $seriesid;
    }

    public function getSeriesID():int{
        return $this->seriesID;
    }
    
    public function setSeasonID(int $seasonid){
        $this->seasonID = $seasonid;
    }

    public function getSeasonID(): int{
        return $this->seasonID;
    }

    public function setTitle(string $title){
        $this->seriesTitle = $title;
    }

    public function getSeriesTitle(): string{
        return $this->seriesTitle;
    }

    public function setDescription(string $description){
        $this->seriesID = $description;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function setReleaseDate(string $date){
        $this->releaseDate = $date;
    }

    public function getReleaseDate(): string{
        return $this->releaseDate;
    }

    /*==================== Add a new series to the system and return its seriesID======================= */
    public function addSeries(string $seriesTitle, string $description, string $releaseDate)
    {
        $seriesTitle = $this->conn->real_escape_string($seriesTitle);
        $description = $this->conn->real_escape_string($description);
        $releaseDate = $this->conn->real_escape_string($releaseDate);

        /* Insert query template */
        $stringQuery = "INSERT INTO tvseries (SeriesTitle, Description, ReleaseDate, AverageRating) VALUES ('$seriesTitle', '$description', '$releaseDate', 0)";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
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

        //Set attribute again
        $this->seriesTitle = $seriesID;
        $this->description = $description;
        $this->releaseDate = $releaseDate;
    }

    /*====================Read TV series detail including season and its episode======================= */
    public function readSeriesByID(int $seriesid){
        $query = "SELECT * FROM tvseries WHERE SeriesID = $seriesid";
        $result = $this->conn->query($query);
		if($result){
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
            }else{
                echo "Record not found";
            }
        }else{
            echo "Error in ".$query." ".$this->conn->error;
        }
    }

    /*====================Delete TV series along with its season, episode, seriescast, seriesaward, seriesgenre, seriesdirector and log details======================= */
    public function deleteSeriesById(int $seriesid){
        $query_tvseries = "DELETE FROM tvseries WHERE SeriesID = $seriesid";
        $sql_tvseries = $this->conn->query($query_tvseries);

		if ($sql_tvseries == true) {
			echo "Successful delete query";
		}else{
			echo "Unsuccessful delete query. Try again!";
        }
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
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Modify series season title======================= */
    public function updateSeason(int $seasonid, string $seasonTitle)
    {
        $newseasonID = $this->conn->real_escape_string($seasonid);
        $newseasonTitle = $this->conn->real_escape_string($seasonTitle);

        /* Insert query template */
        $stringQuery = "UPDATE season SET SeasonTitle = '$newseasonTitle' WHERE GenreID = '$newseasonID'";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful update query";
        }else{
            echo "Unsuccessful update query. try again!";
        }
    }

    /*====================Delete series season along with its episode details======================= */
    public function deleteSeasonById(int $seasonid){
        $query = "DELETE FROM season WHERE SeasonID = $seasonid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
			echo "Successful delete query";
		}else{
			echo "Unsuccessful delete query. Try again!";
        }
    }

    /*====================Add a new series episode for each season to the system======================= */
    public function addEpisode(int $seasonid, string $title, string $summary, string $duration, string $airingdate)
    {
        $newseasonid = $this->conn->real_escape_string($seasonid);
        $newtitle = $this->conn->real_escape_string($title);
        $newsummary = $this->conn->real_escape_string($summary);
        $newduration = $this->conn->real_escape_string($duration);
        $newairingdate = $this->conn->real_escape_string($airingdate);

        /* Insert query template */
        $stringQuery = "INSERT INTO episode (SeasonID, EpisodeTitle, Summary, Duration, AiringDate) VALUES ('$newseasonid','$newtitle','$newsummary','$newduration','$newairingdate')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Modify series episode======================= */
    public function modifyEpisode(int $episodeid, string $title, string $summary, string $duration, string $airingdate)
    {
        $newepisodeid = $this->conn->real_escape_string($episodeid);
        $newtitle = $this->conn->real_escape_string($title);
        $newsummary = $this->conn->real_escape_string($summary);
        $newduration = $this->conn->real_escape_string($duration);
        $newairingdate = $this->conn->real_escape_string($airingdate);

        /* Insert query template */
        $stringQuery = "UPDATE episode SET EpisodeTitle = '$newtitle', Summary = '$newsummary', Duration = '$newduration', AiringDate = '$newairingdate' WHERE EpisodeID = ' $newepisodeid'";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Delete series episode=======================*/
    public function deleteEpisodeById(int $episodeid){
        $query = "DELETE FROM episode WHERE EpisodeID = $episodeid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
			echo "Successful delete query";
		}else{
			echo "Unsuccessful delete query. Try again!";
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
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Delete seriesgenre======================= */
    public function deleteSeriesGenre(string $seriesID, string $genreID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriesgenre WHERE SeriesID = $seriesID AND GenreID = $genreID";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            echo "Successful delete query";
        }else{
            echo "Unsuccessful delete query. try again!";
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
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Delete seriescast=======================*/
    public function deleteSeriesCast(string $seriesID, string $castID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriescast WHERE SeriesID = $seriesID AND CastID = $castID";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            echo "Successful delete query";
        }else{
            echo "Unsuccessful delete query. try again!";
        }
    }


    /*==================== Add a new series award to the system==================================*/
    public function addSeriesAward(string $seriesID, string $awardID)
    {
        $newSeriesID = $this->conn->real_escape_string($seriesID);
        $newAwardID = $this->conn->real_escape_string($awardID);

        /* Insert query template */
        $stringQuery = "INSERT INTO seriesaward (SeriesID, AwardID) VALUES ('$newSeriesID', '$newAwardID')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Delete seriesaward=======================*/
    public function deleteSeriesAward(string $seriesID, string $awardID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriesaward WHERE SeriesID = $seriesID AND AwardID = $awardID";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful delete query";
        }else{
            echo "Unsuccessful delete query. try again!";
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
            echo "Successful add query";
        }else{
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Delete seriesdirector=======================*/
    public function deleteSeriesDirector(string $seriesID, string $directorID)
    {
        /* Insert query template */
        $stringQuery = "DELETE FROM seriesdirector WHERE SeriesID = $seriesID AND AwardID = $directorID";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful delete query";
        }else{
            echo "Unsuccessful delete query. try again!";
        }
    }
}

class Genre{
    private $genreID;
    private $genreName;

    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
		$this->genreID = NULL;
        $this->genreName = "";
        $this->conn = $DB_con;
	}

    public function setGenreID(int $genreid){
        $this->genreID = $genreid;
    }

    public function getGenreID():int{
        return $this->genreID;
    }

    public function setGenreName(string $genreName){
        $this->genreName = $genreName;
    }

    public function getGenreName(): string{
        return $this->genreName;
    }

    /*====================Add genre=======================*/
    public function addGenre(string $genreName)
    {
        $newGenreName = $this->conn->real_escape_string($genreName);

        /* Insert query template */
        $stringQuery = "INSERT INTO genre (GenreName) VALUES ('$newGenreName')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful add query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Modify genre=======================*/
    public function modifyGenre(string $genreID, string $genreName)
    {
        $newGenreID = $this->conn->real_escape_string($genreID);
        $newGenreName = $this->conn->real_escape_string($genreName);

        /* Insert query template */
        $stringQuery = "UPDATE genre SET GenreName = '$newGenreName' WHERE GenreID = '$newGenreID'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            echo "Successful update query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful update query. try again!";
        }
    }

    /*====================Delete genre by ID=======================*/
    public function deleteGenreById(int $genreid){
        $query = "DELETE FROM genre WHERE GenreID = $genreid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
			echo "Successful delete query";
		}else{
			echo "Unsuccessful delete query. Try again!";
        }
    }

}

class Cast{
    private $castId;
    private $firstName;
    private $lastName;
    private $birthdate;
    private $gender;

    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
		$this->castId = NULL;
        $this->firstName = "";
        $this->lastName = "";
        $this->birthdate = "";
        $this->gender = "";
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
            echo "Successful add query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful add query. try again!";
        }
    }

    /*====================Modify cast=======================*/
    public function modifyCast(string $castId, string $firstName, string $lastName, string $birthdate, string $gender)
    {
        $newcastId = $this->conn->real_escape_string($castId);
        $newfirstName = $this->conn->real_escape_string($firstName);
        $newlastName = $this->conn->real_escape_string($lastName);
        $newbirthdate = $this->conn->real_escape_string($birthdate);
        $newgender = $this->conn->real_escape_string($gender);

        /* Insert query template */
        $stringQuery = "UPDATE cast SET CastFirstName = '$newfirstName', CastLastName = '$newlastName', BirthDate = '$newbirthdate', Gender = '$newgender' WHERE CastID = '$newcastId'";
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            echo "Successful update query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful update query. try again!";
        }
    }

    /*====================Delete cast by ID=======================*/
    public function deleteCastById(int $castid){
        $query = "DELETE FROM cast WHERE genreID = $castid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
			echo "Successful delete query";
		}else{
			echo "Unsuccessful delete query. Try again!";
        }
    }

}

class Director{
    private $directorId;
    private $firstName;
    private $lastName;

    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
		$this->castId = NULL;
        $this->firstName = "";
        $this->lastName = "";
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
            echo "Successful add query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful add query. try again!";
        }
    }
    /*====================Modify director=======================*/
    public function modifyDirector(string $directorId, string $firstName, string $lastName)
    {
        $newdirectorId = $this->conn->real_escape_string($directorId);
        $newfirstName = $this->conn->real_escape_string($firstName);
        $newlastName = $this->conn->real_escape_string($lastName);

        /* Insert query template */
        $stringQuery = "UPDATE director SET DirectorFirstName = '$newfirstName', DirectorLastName = '$newlastName' WHERE DirectorID = '$newdirectorId'";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful update query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful update query. try again!";
        }
    }

    /*====================Delete director by ID=======================*/
    public function deleteDirectorById(int $directorid){
        $query = "DELETE FROM director WHERE DirectorID = $directorid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
			echo "Successful delete query";
		}else{
			echo "Unsuccessful delete query. Try again!";
        }
    }
}

class Award{
    private $awardID;
    private $awardName;

    //Constructor
    public function __construct($DB_con)
	{
		/* Initialize variables to NULL */
		$this->awardID = NULL;
        $this->awardName = "";
        $this->conn = $DB_con;
	}

    /*====================Add award=======================*/
    public function addAward(string $awardname)
    {
        $newawardname = $this->conn->real_escape_string($awardname);

        /* Insert query template */
        $stringQuery = "INSERT INTO award (AwardTitle) VALUES ('$newawardname')";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful add query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful add query. try again!";
        }
    }
    
    /*====================Modify award=======================*/
    public function modifyAward(string $awardId, string $title)
    {
        $newtitle = $this->conn->real_escape_string($title);
        $newawardId = $this->conn->real_escape_string($awardId);

        /* Insert query template */
        $stringQuery = "UPDATE director SET AwardTitle = '$newtitle' WHERE AwardID = '$newawardId'";
        $sqlQuery = $this->conn->query($stringQuery);

        if ($sqlQuery == true) {
            echo "Successful update query";
        }else{
            echo "Error in ".$stringQuery." ".$this->conn->error;
            echo "Unsuccessful update query. try again!";
        }
    }

    /*====================Delete award by ID=======================*/
    public function deleteAwardById(int $awardid){
        $query = "DELETE FROM award WHERE AwardID = $awardid";
        $sql = $this->conn->query($query);

		if ($sql == true) {
			echo "Successful delete query";
		}else{
			echo "Unsuccessful delete query. Try again!";
        }
    }
}

?>
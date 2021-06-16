<?php

class Series{
    private $seriesID;
    private $seriesTitle;
    private $description;
    private $releaseDate;
    private $averageRating;

    public function __construct()
	{
		/* Initialize variables to NULL */
		$this->seriesID = NULL;
		$this->seriesTitle = NULL;
        $this->description = NULL;
        $this->releaseDate = NULL;
        $this->averageRating = NULL;
	}

    /* Add a new series to the system and return its seriesID */
    public function addSeries(string $seriesTitle, string $description, string $releaseDate): int
    {
        /* Global $pdo object */
        global $pdo;
        
        /* Insert query template */
        $query = 'INSERT INTO tv_series (SeriesTitle, Description, ReleaseDate, AverageRating) VALUES (:seriesTitle, :description, :releaseDate)';
        
        /* Values array for PDO */
        $values = array(':seriesTitle' => $seriesTitle, ':description' => $description, ':releaseDate' => $releaseDate);
        
        /* Execute the query */
        try
        {
            $result = $pdo->prepare($query);
            $result->execute($values);
        }
        catch (PDOException $e)
        {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
        }
        
        /* Return the new ID */
        return $pdo->lastInsertId();
    }




    
}

?>
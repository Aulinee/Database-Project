<?php 
include 'testing/dbConnection.php';
include 'TVSeriesClass.php';

$seriesObj = new Series($conn);
$genreObj = new Genre($conn);

//$genreObj->modifyGenre(200001, "Crime TV Shows");

?>
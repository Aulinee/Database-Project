<?php 
if(!isset($_SESSION['series_id'])){
    $seriesid_token = htmlentities($_GET["id"]);
    $_SESSION['series_id'] = $seriesid_token;
}

$currentSeriesId = $_SESSION['series_id'];

?>
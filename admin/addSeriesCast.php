<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$castid_token = htmlentities($_GET["castid"]);

$addSeriesCast = $seriesObj->addSeriesCast($currentSeriesId, $castid_token);

if($addSeriesCast){
    echo "<script>
    alert('Successfully added new cast!');
    window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful add query! Please try again!');
    window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
    </script>";
}

?>
<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$directorid_token = htmlentities($_GET["directorid"]);

$addSeriesDirector = $seriesObj->addSeriesDirector($currentSeriesId, $directorid_token);

if($addSeriesDirector){
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
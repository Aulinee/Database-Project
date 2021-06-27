<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$genreid_token = htmlentities($_GET["genreid"]);

$addSeriesGenre = $seriesObj->addSeriesGenre($currentSeriesId, $genreid_token);

if($addSeriesGenre){
    echo "<script>
    alert('Successfully added new genre!');
    window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful add query! Please try again!');
    window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
    </script>";
}

?>
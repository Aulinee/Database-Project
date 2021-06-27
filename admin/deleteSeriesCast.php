<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$castid_token = htmlentities($_GET["castid"]);
$deleteSeriesCast = $seriesObj->deleteSeriesCast($currentSeriesId, $castid_token);

if($deleteSeriesCast){
    echo "<script>
    alert('Successfully delete series cast!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-cast';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-cast';
    </script>";
}

?>
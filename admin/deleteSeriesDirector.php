<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$directorid_token = htmlentities($_GET["directorid"]);
$deleteSeriesDirector = $seriesObj->deleteSeriesDirector($currentSeriesId, $directorid_token);

if($deleteSeriesDirector){
    echo "<script>
    alert('Successfully delete series director!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-director';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-director';
    </script>";
}

?>
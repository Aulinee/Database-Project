<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$seasonid_token = htmlentities($_GET["seasonid"]);
$deleteSeason = $seriesObj->deleteSeasonById($seasonid_token);

if($deleteSeason){
    echo "<script>
    alert('Successfully delete season!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
    </script>";
}

?>
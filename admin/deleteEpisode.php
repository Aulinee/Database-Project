<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$episodeid_token = htmlentities($_GET["episodeid"]);
$deleteEpisode = $seriesObj->deleteEpisodeById($episodeid_token);

if($deleteEpisode){
    echo "<script>
    alert('Successfully delete episode!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-season';
    </script>";
}

?>
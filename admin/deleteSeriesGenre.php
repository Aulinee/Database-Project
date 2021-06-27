<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$genreid_token = htmlentities($_GET["genreid"]);
$deleteSeriesGenre = $seriesObj->deleteSeriesGenre($currentSeriesId, $genreid_token);

if($deleteSeriesGenre){
    echo "<script>
    alert('Successfully delete genre!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
    </script>";
}

?>
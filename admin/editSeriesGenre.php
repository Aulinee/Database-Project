<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$genreid_token = htmlentities($_GET["genreid"]);
$checkSeriesGenre = $seriesObj->checkSeriesGenre($currentSeriesId, $genreid_token); //return true if the added genre already exist

if($checkSeriesGenre){
    echo "<script>
    alert('Genre already exist! Update query cancel...');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
    </script>";
}else{
    $addSeriesGenre = $seriesObj->addSeriesGenre($currentSeriesId, $genreid_token);
    if($addSeriesGenre){
        echo "<script>
        alert('Successfully added new genre!');
        window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
        </script>";
    }else{
        echo "<script>
        alert('Unsucessuful add query! Please try again!');
        window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-genre';
        </script>";
    }
}

?>
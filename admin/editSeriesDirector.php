<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$directorid_token = htmlentities($_GET["directorid"]);
$checkSeriesDirector = $seriesObj->checkSeriesDirector($currentSeriesId, $directorid_token); //return true if the added genre already exist

if($checkSeriesDirector){
    echo "<script>
    alert('Director already exist! Update query cancel...');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-director';
    </script>";
}else{
    $addSeriesDirector = $seriesObj->addSeriesDirector($currentSeriesId, $directorid_token);
    if($addSeriesDirector){
        echo "<script>
        alert('Successfully added new series director!');
        window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-director';
        </script>";
    }else{
        echo "<script>
        alert('Unsucessuful add query! Please try again!');
        window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-director';
        </script>";
    }
}

?>
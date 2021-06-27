<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$castid_token = htmlentities($_GET["castid"]);
$checkSeriesCast = $seriesObj->checkSeriesCast($currentSeriesId, $castid_token); //return true if the added genre already exist

if($checkSeriesCast){
    echo "<script>
    alert('Cast already exist! Update query cancel...');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-cast';
    </script>";
}else{
    $addSeriesCast = $seriesObj->addSeriesCast($currentSeriesId, $castid_token);
    if($addSeriesCast){
        echo "<script>
        alert('Successfully added new series cast!');
        window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-cast';
        </script>";
    }else{
        echo "<script>
        alert('Unsucessuful add query! Please try again!');
        window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-cast';
        </script>";
    }
}

?>
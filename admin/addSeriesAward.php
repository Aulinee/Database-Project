<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$awardid_token = htmlentities($_GET["awardid"]);

$addSeriesAward = $seriesObj->addSeriesAward($currentSeriesId, $awardid_token, 2021);

if($addSeriesAward){
    echo "<script>
    alert('Successfully added new award!');
    window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful add query! Please try again!');
    window.location.href='create-series-detail-page.php?id=".$currentSeriesId."';
    </script>";
}

?>
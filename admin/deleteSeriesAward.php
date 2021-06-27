<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$awardid_token = htmlentities($_GET["awardid"]);
$deleteSeriesAward = $seriesObj->deleteSeriesAward($currentSeriesId, $awardid_token);

if($deleteSeriesAward){
    echo "<script>
    alert('Successfully delete series award!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#new-series-award';
    </script>";
}

?>
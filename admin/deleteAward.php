<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$awardid_token = htmlentities($_GET["awardid"]);
$deleteAward = $awardObj->deleteAwardById($awardid_token);

if($deleteAward){
    echo "<script>
    alert('Successfully delete award!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-award-div';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-award-div';
    </script>";
}

?>
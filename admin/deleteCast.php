<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$castid_token = htmlentities($_GET["castid"]);
$deleteCast = $castObj->deleteCastById($castid_token);

if($deleteCast){
    echo "<script>
    alert('Successfully delete cast!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-cast-div';
    </script>";
}

?>
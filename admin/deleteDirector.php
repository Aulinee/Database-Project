<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$directorid_token = htmlentities($_GET["directorid"]);
$deleteDirector = $directorObj->deleteDirectorById($directorid_token);

if($deleteDirector){
    echo "<script>
    alert('Successfully delete director!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-director-div';
    </script>";
}

?>
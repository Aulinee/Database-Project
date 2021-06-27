<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$seriesid_token = htmlentities($_GET["id"]);
$deleteGenre = $seriesObj->deleteSeriesById($seriesid_token);

if($deleteGenre){
    echo "<script>
    alert('Successfully delete series!');
    window.location.href='main-admin-page.php';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='main-admin-page.php';
    </script>";
}

?>
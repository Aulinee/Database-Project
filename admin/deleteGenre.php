<?php 
include 'sessionAdmin.php';
include 'sessionSeries.php';
$genreid_token = htmlentities($_GET["genreid"]);
$deleteGenre = $genreObj->deleteGenreById($genreid_token);

if($deleteGenre){
    echo "<script>
    alert('Successfully delete genre!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-genre-div';
    </script>";
}else{
    echo "<script>
    alert('Unsucessuful delete query! Please try again!');
    window.location.href='edit-series-page.php?id=".$currentSeriesId."#edit-genre-div';
    </script>";
}

?>
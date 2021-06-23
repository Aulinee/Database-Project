<?php 
include 'database/dbConnection.php';
include 'TVSeriesClass.php';
include 'UserClass.php';

$seriesObj = new Series($conn);
$userobj = new User($conn);
//$genreObj = new Genre($conn);

//$genreObj->modifyGenre(200001, "Crime TV Shows");
//$seriesObj->addSeriesLog(123456, 3);

// $date=date_create("2013-03-15");
// echo date_format($date,"M d, Y");

//$seriesObj->readSeriesDesc(123456);
//$seriesObj->readSeriesSeason(234567);

//$userobj->makePayment(1,1, "Online Banking");

$userobj->paymentHistory(3);

?>
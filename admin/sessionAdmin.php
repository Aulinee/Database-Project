<?php 
include '../database/dbConnection.php'; 
include '../class/TVSeriesClass.php';
include '../class/UserClass.php';

$seriesObj = new Series($conn);
$userObj = new User($conn);
$genreObj = new Genre($conn);
$castObj = new Cast($conn);
$directorObj = new Director($conn);
$awardObj = new Award($conn);

// Set sessions
if(!isset($_SESSION)) {
    session_start();
}
//1800

if(isset($_SESSION['login_admin']))  
{ 
    if(time()-$_SESSION["login_time_stamp"] >180000)   
    { 
        session_unset(); 
        session_destroy(); 
        header("Location:sign-in-admin.php"); 
    } 
}

// if(!isset($_SESSION['season_id'])){
//     $seasonid_token = htmlentities($_GET["seasonid"]);
//     $_SESSION['season_id'] = $seasonid_token;
// }

$usernameAdmin = $_SESSION['login_admin'];
$passwordAdmin = $_SESSION['login_admin_pass'];
// $currentSeasonId = $_SESSION['season_id'];

if(!isset($_SESSION['login_admin'])){
    header("Location:sign-in-admin.php"); 
    die();
}

?>
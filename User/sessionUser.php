<?php 
    include '../database/dbConnection.php'; 
    include '../class/UserClass.php';
    include '../class/TVSeriesClass.php';

    $seriesObj = new Series($conn);
    $userObj = new User($conn);

    // Set sessions
    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION['login_user']))  
    { 
        if(time()-$_SESSION["login_time_stamp"] >1800)   
        { 
            session_unset(); 
            session_destroy(); 
            header("Location:sign-in-user.php"); 
        } 
    } 

    $username = $_SESSION['login_user'];
    $password = $_SESSION['login_pass'];

    //Set session data
    $session_data = $userObj->setSessionData($username, $password);

    $userid = $session_data[0];
    $subid = $session_data[1];
    $username = $session_data[2];
    $fullname = $session_data[3];
    $email = $session_data[4];
    $gender = $session_data[5];
    $phonenum = $session_data[6];
    $address= $session_data[7];

    //Set subscription data
    $subscription_session_data = $userObj->readSubscription($subid);

    //Set Member date and Change $member_date format
    $member_date = $subscription_session_data[0];
    $tempDate = date_create($member_date);
    $memberdate = date_format($tempDate,"M Y");

    //Set plan type, plan description and day left
    $planType = $subscription_session_data[2];
    $planDesc = $subscription_session_data[3];
    $dayleft = $subscription_session_data[5];

    //Set end subscription date and Change $end_date format
    $end_date = $subscription_session_data[1];
    $tempEndDate = date_create($end_date);
    $enddate = date_format($tempEndDate,"d M Y");

    if(!isset($_SESSION['login_user'])){
        header("Location:sign-in-user.php"); 
        die();
    }

?>
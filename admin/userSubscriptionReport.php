<?php
    // Include autoloader 
    require_once '../dompdf/autoload.inc.php'; 
    
    // Reference the Dompdf namespace 
    use Dompdf\Dompdf; 
    
    // Instantiate and use the dompdf class 
    $dompdf = new Dompdf();

    //It is possible to include a file that outputs html and store it in a variable 
    //using output buffering.
    ob_start();

    //To open and connect database
    include '../database/dbConnection.php'; 
    include "sessionAdmin.php";

    //Get payment detail in user class
    $subs_summary = $userObj->displayOverviewSubscription();
    

    echo'
    <h1 style="color:red; text-transform:uppercase; text-align:center">Tmflix</h1>
    <h1 style="text-align:center"><u>TMFLIX Subscription Report</u></h1>
    <br>
    <table border="1" cellpadding="10px" cellspacing="0" style="width: 100%; margin: auto;">
      <tr>
        <th>PLAN TYPE</th>
        <th>START ACCESS</th>
        <th>END ACCESS</th>
        <th>USERNAME</th>
        <th>FULL NAME</th>
        <th>EMAIL</th>
        <th>GENDER</th>
        <th>ADDRESS</th>
        <th>PHONE NO</th>
      </tr style="color: black;">';
        echo $userObj->displayAllSubscriptionReport().'
    </table>
    <br>
    <h2 style="margin: 0;">Here is a summary of the subscription report</h2>
    <h3>Total User: '.$subs_summary[0].'</h3>
    <h3>Total Trial Subscription: '.$subs_summary[1].'</h3>
    <h3>Total Basic Subscription: '.$subs_summary[2].'</h3>
    <h3>Total Premium Subscription: '.$subs_summary[3].'</h3>
    ';

   // Load content from html file 
    $html = ob_get_clean();
    $dompdf->loadHtml($html); 
    
    // (Optional) Setup the paper size and orientation 
    $dompdf->setPaper('A4', 'landscape'); 
    
    // Render the HTML as PDF 
    $dompdf->render(); 
    
    // Output the generated PDF (1 = download and 0 = preview) 
    $dompdf->stream("TMFlix Subscription Report", array("Attachment" => 0));
?>
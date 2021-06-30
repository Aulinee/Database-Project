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
    $sales_summary = $userObj->displayOverviewPayment();
    

    echo'
    <h1 style="color:red; text-transform:uppercase; text-align:center">Tmflix</h1>
    <h1 style="text-align:center"><u>TMFLIX Payment Report</u></h1>
    <br>
    <table border="1" cellpadding="10px" cellspacing="0" style="width: 100%; margin: auto;">
      <tr>
          <th>PAYMENT DATE</th>
          <th>PLAN TYPE</th>
          <th>USERNAME</th>
          <th>FULL NAME</th>
          <th>EMAIL</th>
          <th>GENDER</th>
          <th>ADDRESS</th>
          <th>PHONE NO</th>
          <th>PAYMENT AMOUNT(RM)</th>
      </tr style="color: black;">';
        echo $userObj->displayAllPaymentReport().'
    </table>
    <br>
    <h2 style="margin: 0;">Here is a summary of the payment report</h2>
    <h3>Total Receipt: '.$sales_summary[0].'</h3>
    <h3>Total Sales: RM'.$sales_summary[1].'</h3>
    <h3>Average Sales Monthly: RM'.$sales_summary[2].'</h3>
    ';

   // Load content from html file 
    $html = ob_get_clean();
    $dompdf->loadHtml($html); 
    
    // (Optional) Setup the paper size and orientation 
    $dompdf->setPaper('A4', 'landscape'); 
    
    // Render the HTML as PDF 
    $dompdf->render(); 
    
    // Output the generated PDF (1 = download and 0 = preview) 
    $dompdf->stream("TMFlix Payment Report", array("Attachment" => 0));
?>
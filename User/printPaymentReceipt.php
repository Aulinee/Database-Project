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
    include "sessionUser.php";

    //Get payment detail in user class
    $paymentData = $userObj->readPaymentDetail($userid);

    if ($paymentData) {
        // Echo receipt layout
        echo '<table border="0" cellpadding="0" cellspacing="20px" width="auto" align="center" style:"padding: 30px;">
            <tr>
              <td align="center" >
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0 0; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                      <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; text-align: center; color: #d12a27;">TMFLIX</h1>
                    </td>
                  </tr>
              </td>
            </tr>
            <tr>
              <td align="center" >
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                  <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <h1>TMFLIX Payment Receipt</h1>
                      <p style="margin: 0;">Here is a summary of your recent subscription. If you have any questions or concerns about your subscription, please <a href="https://www.netflix.com/my-en/">contact us</a>.</p>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                      <table border="1" cellpadding="10px" cellspacing="0" width="100%">
                        <tr>
                          <td align="left" bgcolor="#D2C7BA" width="25%" style="padding: 12px;font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><strong>Payment ID</strong></td>
                          <td align="left" bgcolor="#D2C7BA" width="75%" style="padding: 12px;font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;"><strong>'.$paymentData[0].'</strong></td>
                        </tr>
                        <tr>
                          <td align="left" width="25%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Name</strong></td>
                          <td align="left" width="75%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>'.$fullname.'</strong></td>
                        </tr>
                        <tr>
                          <td align="left" width="25%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Email</strong></td>
                          <td align="left" width="75%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>'.$email.'</strong></td>
                        </tr>
                        <tr>
                          <td align="left" width="25%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Phone Number</strong></td>
                          <td align="left" width="75%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>'.$phonenum.'</strong></td>
                        </tr>
                        <tr>
                          <td align="left" width="25%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Subscription Plan</strong></td>
                          <td align="left" width="75%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>'.$paymentData[1].'</strong></td>
                        </tr>
                        <tr>
                          <td align="left" width="25%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Payment Method</strong></td>
                          <td align="left" width="75%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>'.$paymentData[3].'</strong></td>
                        </tr>
                        <tr>
                          <td align="left" width="25%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Payment Amount</strong></td>
                          <td align="left" width="75%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>RM '.$paymentData[4].'</strong></td>
                        </tr>
                        <tr>
                          <td align="left" width="25%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Payment Date</strong></td>
                          <td align="left" width="75%" style="padding: 12px; font-family: "Source Sans Pro", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>'.$paymentData[2].'</strong></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        ';

        // Load content from html file
        $html = ob_get_clean();
        $dompdf->loadHtml($html);
    
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
    
        // Render the HTML as PDF
        $dompdf->render();
    
        // Output the generated PDF (1 = download and 0 = preview)
        $dompdf->stream("TMFlix Payment Receipt", array("Attachment" => 0));
    }else{
      echo "<script>
      alert('Your payment history is empty!');
      window.location.href='payment-history-page.php';
      </script>";
    }
?>
<?php 
include '../database/dbConnection.php'; 

class User{
    /* Constructor */
	public function __construct($DB_con)
	{
        $this->conn = $DB_con;
	}

    public function checkExistUsername($username){
        //Create query string
        $checkUsernameQuery = "SELECT * FROM `user` WHERE Username = '$username'";
        $result = mysqli_query($this->conn, $checkUsernameQuery) or die("Error: ".mysqli_error($this->conn));
        $count = mysqli_num_rows($result);
    
        // If result matched $username, table row must be 1 row
        if($count == 1){
            return true;
        }else{
            return false;
        }

    }

    public function signUp($username, $firstname, $lastname, $email, $password, $mobileNum, $gender, $addressline, $postcode, $city, $state){
        $checkPostalQuery = "SELECT * FROM address WHERE PostalCode = $postcode";
        $resultPostal = mysqli_query($this->conn,  $checkPostalQuery) or die("Error: ".mysqli_error($this->conn));
        $countPostal = mysqli_num_rows($resultPostal);

        if($countPostal == 0){
            //Insert new postal address in address table
            $this->addNewAddress($postcode, $city, $state, "Malaysia");
        }

        //Insert trial subscription id = 3 for new user
        $subid = $this->addSubscription(3);

        //Insert user detail in user table
        $insertUserQuery = "INSERT INTO user(SubscriptionID, Username, UserFirstName, UserLastName, Email, Password, Gender, PhoneNumber, AddressLine, PostalCode)
        VALUES ($subid,'$username', '$firstname', '$lastname', '$email', '$password', '$gender', $mobileNum, '$addressline', $postcode)";
        $resultUser = mysqli_query($this->conn,  $insertUserQuery) or die("Error: ".mysqli_error($this->conn));
       
        if ($resultUser == true) {
            return true;
        }else{
            echo "Error in ".$resultUser." ".$this->conn->error;
            return false;
        }
        
    }

    public function loginAuthentication(string $username, string $password){
        $query = "SELECT * FROM user WHERE Username = '$username' AND Password = '$password'";
        $result = mysqli_query($this->conn, $query) or die("Error: ".mysqli_error($this->conn));
        $count = mysqli_num_rows($result);
    
        // If result matched $myusername and $mypassword, table row must be 1 row
        if($count == 1){
            return true;
        }else{
            echo "Record not found";
        }
        
        return false;
    }

    public function addNewAddress($postalcode, $city, $state, $country){
        $postalcode = $this->conn->real_escape_string($postalcode);
        $city = $this->conn->real_escape_string($city);
        $state = $this->conn->real_escape_string($state);
        $country = $this->conn->real_escape_string($country);

        /* Insert query template */
        $stringQuery = "INSERT INTO address(PostalCode, State, Area, Country) VALUES ('$postalcode', '$state', '$city', '$country')";
        
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            //echo "Successful update query";
            return true;
        }else{
            echo "Error in ". $sqlQuery." ".$this->conn->error;
            //echo "Unsuccessful update query. try again!";
        }

        return false;
    }

    public function setSessionData(string $username, string $password){
        $query = "SELECT * FROM user WHERE Username = '$username' AND Password = '$password'";
        $result = $this->conn->query($query);
        $arrayData = array();
		if($result){
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userid = $row['UserID'];
                $subid = $row['SubscriptionID'];
                $username = $row['Username'];
                $fullname = $row['UserFirstName']." ".$row['UserLastName'];
                $email = $row['Email'];
                $gender = $row['Gender'];
                $phonenum = "+60".$row['PhoneNumber'];

                //Query for postal code
                $addressline = $row['AddressLine'];
                $postalcode = $row['PostalCode'];
                $queryPC = "SELECT * FROM address WHERE PostalCode =  $postalcode";
                $resultPC = $this->conn->query($queryPC);

                if($resultPC){
                    if($resultPC->num_rows > 0){
                        $rowPC = $resultPC->fetch_assoc();
                        $address = $addressline.", ".$postalcode." ".$rowPC['Area'].", ".$rowPC['State'].", ".$rowPC['Country'];
                        $arrayData = array($userid, $subid, $username, $fullname, $email, $gender, $phonenum, $address);
                    }
                }
                return $arrayData;
            }else{
                echo "Record not found";
            }
        }else{
            echo "Error in ".$query." ".$this->conn->error;
        } 
    }

    public function displayOverviewSubscription(){
        $totalUserQuery = mysqli_query($this->conn,"SELECT COUNT(*) AS user FROM user");
        $totalTrialQuery = mysqli_query($this->conn,"SELECT COUNT(*) AS trial FROM `usersubscription` WHERE PlanID = 3");
        $totalBasicQuery = mysqli_query($this->conn,"SELECT COUNT(*) AS basic FROM `usersubscription` WHERE PlanID = 1");
        $totalPremiumQuery = mysqli_query($this->conn,"SELECT COUNT(*) AS premium FROM `usersubscription` WHERE PlanID = 2");

        //Declare variable
        $total_user = 0;
        $total_trial = 0;
        $total_basic = 0;
        $total_premium = 0;

        while($rowuser = mysqli_fetch_array($totalUserQuery)){
            $total_user = $rowuser['user'];
        }

        while($rowtrial = mysqli_fetch_array($totalTrialQuery)){
            $total_trial = $rowtrial['trial'];
        }

        while($rowbasic = mysqli_fetch_array($totalBasicQuery)){
            $total_basic = $rowbasic['basic'];
        }

        while($rowpremium = mysqli_fetch_array($totalPremiumQuery)){
            $total_premium = $rowpremium['premium'];
        }

        $overview_data = array($total_user, $total_trial, $total_basic, $total_premium); //to store all result data

        return $overview_data;

    }

    public function displayAllSubscription(){
        $subQuery = mysqli_query($this->conn, "SELECT u.Username, u.UserFirstName, u.UserLastName, u.Email, u.Gender, u.PhoneNumber, u.AddressLine, u.PostalCode, a.State, a.Area, a.Country, s.StartAccess, s.EndAccess, p.Type FROM user u, address a, usersubscription s, subscriptionplan p WHERE 
                u.PostalCode = a.PostalCode AND u.SubscriptionID = s.SubscriptionID AND s.PlanID = p.PlanID ORDER BY s.StartAccess DESC");
        while($rowsub = mysqli_fetch_array($subQuery)){
            $plan_type = $rowsub['Type'];
            $start_access = $rowsub['StartAccess'];
            $end_access = $rowsub['EndAccess'];
            $username = $rowsub['Username'];
            $fullname = $rowsub['UserFirstName']." ".$rowsub['UserLastName'];
            $email = $rowsub['Email'];
            $gender = $rowsub['Gender'];
            $address = $rowsub['AddressLine'].", ".$rowsub['PostalCode']." ".$rowsub['Area'].", ".$rowsub['State'].", ".$rowsub['Country'];
            $phone = $rowsub['PhoneNumber'];
            
            //Change date format
            $tempDate1 = date_create($start_access);
            $start_access = date_format($tempDate1,"M d, Y");
            $tempDate2 = date_create($end_access);
            $end_access = date_format($tempDate2,"M d, Y");

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$plan_type.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$start_access.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$end_access.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$username.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$fullname.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$email.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$gender.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$address.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">0'.$phone.'</td>';
            echo '</tr>';
        }
    }

    public function displayAllSubscriptionReport(){
        $subQuery = mysqli_query($this->conn, "SELECT u.Username, u.UserFirstName, u.UserLastName, u.Email, u.Gender, u.PhoneNumber, u.AddressLine, u.PostalCode, a.State, a.Area, a.Country, s.StartAccess, s.EndAccess, p.Type FROM user u, address a, usersubscription s, subscriptionplan p WHERE 
                u.PostalCode = a.PostalCode AND u.SubscriptionID = s.SubscriptionID AND s.PlanID = p.PlanID ORDER BY s.StartAccess DESC");
        while($rowsub = mysqli_fetch_array($subQuery)){
            $plan_type = $rowsub['Type'];
            $start_access = $rowsub['StartAccess'];
            $end_access = $rowsub['EndAccess'];
            $username = $rowsub['Username'];
            $fullname = $rowsub['UserFirstName']." ".$rowsub['UserLastName'];
            $email = $rowsub['Email'];
            $gender = $rowsub['Gender'];
            $address = $rowsub['AddressLine'].", ".$rowsub['PostalCode']." ".$rowsub['Area'].", ".$rowsub['State'].", ".$rowsub['Country'];
            $phone = $rowsub['PhoneNumber'];
            
            //Change date format
            $tempDate1 = date_create($start_access);
            $start_access = date_format($tempDate1,"M d, Y");
            $tempDate2 = date_create($end_access);
            $end_access = date_format($tempDate2,"M d, Y");

            echo '<tr>';
                echo '<td>'.$plan_type.'</td>';
                echo '<td>'.$start_access.'</td>';
                echo '<td>'.$end_access.'</td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$fullname.'</td>';
                echo '<td>'.$email.'</td>';
                echo '<td>'.$gender.'</td>';
                echo '<td>'.$address.'</td>';
                echo '<td>0'.$phone.'</td>';
            echo '</tr>';
        }
    }

    public function readSubscription(int $subid, $userid){
        $subQuery = mysqli_query($this->conn, "SELECT * FROM usersubscription WHERE SubscriptionID = $subid");
        $member_date = mysqli_query($this->conn, "SELECT PaymentDate FROM `payment` WHERE UserID = $userid ORDER BY PaymentDate ASC LIMIT 1");
        $subscriptionArray = array();
        
        while($rowsub = mysqli_fetch_array($subQuery)){
            $planid = $rowsub['PlanID'];
            $start_access = $rowsub['StartAccess'];
            $end_access = $rowsub['EndAccess'];

            date_default_timezone_set("Asia/Kuala_Lumpur"); //set time region
            $current_time = date('Y-m-d H:i:s', time()); //Get current time 

            //using date_create to convert string date to datetime object format
            $dateCurrent = date_create($current_time);
            $dateEnd = date_create($end_access);

            //Using date_diff to calculate subscription duration left
            $day_left = date_diff($dateCurrent, $dateEnd);
            $day_left_formatted = $day_left->format("%a"); //convert duration lefts into day left
            $day_left_status = $day_left->format("%r"); //check positive or negative value

            $planQuery = mysqli_query($this->conn, "SELECT * FROM subscriptionplan WHERE PlanID = $planid");

            while($rowplan = mysqli_fetch_array($planQuery)){
                $plan_type = $rowplan['Type'];
                $description = $rowplan['Description'];
                $price = $rowplan['Price'];
            }

            $membership_date = NULL;

            while($rowmember = mysqli_fetch_array($member_date)){
                $memberDate = $rowmember['PaymentDate'];
                $temp_date = date_create($memberDate);
                $membership_date = date_format($temp_date,"M Y");
            }

            $subscriptionArray = array($start_access, $end_access, $plan_type, $description, $price, $day_left_formatted, $membership_date, $day_left_status);
        }

        return $subscriptionArray;
    }

    public function addSubscription(int $planid){
        $planid = $this->conn->real_escape_string($planid);

        //Insert start date and end subscription with one month duration
        date_default_timezone_set("Asia/Kuala_Lumpur"); //set time region
        $current_time = date('Y-m-d H:i:s', time()); //Get current time and as start access value

        $start_date = date_create($current_time); //convert it to object time
        $date = date_add($start_date,date_interval_create_from_date_string("30 days")); //Add 30 days after start_date
        $end_date = date_format($date,"Y-m-d H:i:s"); //declare it as end date and pass as a string using date_format

        /* Insert query template */
        $stringQuery = "INSERT INTO usersubscription(PlanID, StartAccess, EndAccess) VALUES ('$planid', '$current_time', '$end_date')";
        
        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            $last_id = $this->conn->insert_id;
            return $last_id;
            //echo "Successful add query";
        }else{
            echo "Error in ". $sqlQuery." ".$this->conn->error;
            //echo "Unsuccessful add query. try again!";
        }

    }

    public function updateSubscription(int $subid, int $planid, int $userid){
        $subid = $this->conn->real_escape_string($subid);
        $planid = $this->conn->real_escape_string($planid);

        //check day left 
        $day_left = $this->readSubscription($subid, $userid);

        //check day_left status (empty string means positive)
        if($day_left[7] > ""){
            //Insert start date and end subscription with one month duration
            date_default_timezone_set("Asia/Kuala_Lumpur"); //set time region
            $current_time = date('Y-m-d H:i:s', time()); //Get current time and as start access value

            $start_date = date_create($current_time); //convert it to object time
            $date = date_add($start_date,date_interval_create_from_date_string("30 days")); //Add 30 days after start_date
            $end_date = date_format($date,"Y-m-d H:i:s"); //declare it as end date and pass as a string using date_format

            /* Insert query template */
            $stringQuery = "UPDATE usersubscription SET PlanID = '$planid', StartAccess = '$current_time', EndAccess = '$end_date' WHERE SubscriptionID = '$subid'";
            
            $sqlQuery = $this->conn->query($stringQuery);
            if ($sqlQuery == true) {
                return true;
                //echo "Successful update query";
            }else{
                return false;
                echo "Error in ". $sqlQuery." ".$this->conn->error;
                //echo "Unsuccessful update query. try again!";
            }
        }else{
            return false;
        }
    }

    public function displayOverviewPayment(){
        $totalReceiptQuery = mysqli_query($this->conn,"SELECT COUNT(*) AS sum FROM payment");
        $sumPaymentQuery = mysqli_query($this->conn,"SELECT SUM(s.Price) AS sum FROM payment p, subscriptionplan s WHERE p.PlanID = s.PlanID");
        $averagePaymentQuery = mysqli_query($this->conn,"SELECT SUM(s.Price) AS sum FROM payment p, subscriptionplan s WHERE p.PlanID = s.PlanID group by year(p.PaymentDate), month(p.PaymentDate)");

        //Declare variable
        $total_receipt = 0;
        $sum_payment = 0;
        $month_payment = 0.00;
        $average_payment = 0.00;
        $countMonth = 0;

        while($rowreceipt = mysqli_fetch_array($totalReceiptQuery)){
            $total_receipt = $rowreceipt['sum'];
        }

        while($rowsum = mysqli_fetch_array($sumPaymentQuery)){
            $sum_payment = $rowsum['sum'];
        }

        while($rowavg = mysqli_fetch_array($averagePaymentQuery)){
            $month_payment += $rowavg['sum'];
            $countMonth++;
        }
        $average_payment = sprintf('%.2f', intdiv($month_payment, $countMonth));//return number in 2 decimal places


        $overview_data = array($total_receipt, $sum_payment, $average_payment); //to store all result data

        return $overview_data;

    }

    public function displayAllPayment(){
        $subQuery = mysqli_query($this->conn, "SELECT p.PaymentDate, u.Username, u.UserFirstName, u.UserLastName, u.Email, u.Gender, 
        u.PhoneNumber, u.AddressLine, u.PostalCode, a.State, a.Area, a.Country, s.Type, s.Price FROM user u, address a, subscriptionplan s,
        payment p WHERE p.UserID = u.UserID AND u.PostalCode = a.PostalCode AND p.PlanID = s.PlanID ORDER BY p.PaymentDate DESC");

        while($rowsub = mysqli_fetch_array($subQuery)){
            $payment_date = $rowsub['PaymentDate'];
            $plan_type = $rowsub['Type'];
            $amount = $rowsub['Price'];
            $username = $rowsub['Username'];
            $fullname = $rowsub['UserFirstName']." ".$rowsub['UserLastName'];
            $email = $rowsub['Email'];
            $gender = $rowsub['Gender'];
            $address = $rowsub['AddressLine'].", ".$rowsub['PostalCode']." ".$rowsub['Area'].", ".$rowsub['State'].", ".$rowsub['Country'];
            $phone = $rowsub['PhoneNumber'];
            
            //Change date format
            $tempDate = date_create($payment_date);
            $payment_date = date_format($tempDate,"M d, Y");

            echo '<tr>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$payment_date.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$plan_type.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$username.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$fullname.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$email.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$gender.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$address.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">0'.$phone.'</td>';
                echo '<td style="padding: 10px;background-color: rgb(75, 70, 70);text-align: center;">'.$amount.'</td>';
            echo '</tr>';
        }
    }

    public function displayAllPaymentReport(){
        $subQuery = mysqli_query($this->conn, "SELECT p.PaymentDate, u.Username, u.UserFirstName, u.UserLastName, u.Email, u.Gender, 
        u.PhoneNumber, u.AddressLine, u.PostalCode, a.State, a.Area, a.Country, s.Type, s.Price FROM user u, address a, subscriptionplan s,
        payment p WHERE p.UserID = u.UserID AND u.PostalCode = a.PostalCode AND p.PlanID = s.PlanID ORDER BY p.PaymentDate DESC");

        while($rowsub = mysqli_fetch_array($subQuery)){
            $payment_date = $rowsub['PaymentDate'];
            $plan_type = $rowsub['Type'];
            $amount = $rowsub['Price'];
            $username = $rowsub['Username'];
            $fullname = $rowsub['UserFirstName']." ".$rowsub['UserLastName'];
            $email = $rowsub['Email'];
            $gender = $rowsub['Gender'];
            $address = $rowsub['AddressLine'].", ".$rowsub['PostalCode']." ".$rowsub['Area'].", ".$rowsub['State'].", ".$rowsub['Country'];
            $phone = $rowsub['PhoneNumber'];
            
            //Change date format
            $tempDate = date_create($payment_date);
            $payment_date = date_format($tempDate,"M d, Y");

            echo '<tr>';
                echo '<td>'.$payment_date.'</td>';
                echo '<td>'.$plan_type.'</td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$fullname.'</td>';
                echo '<td>'.$email.'</td>';
                echo '<td>'.$gender.'</td>';
                echo '<td>'.$address.'</td>';
                echo '<td>0'.$phone.'</td>';
                echo '<td>'.$amount.'</td>';
            echo '</tr>';
        }
    }

    public function makePayment(int $userid, int $planid, string $payment_method){
        $userid = $this->conn->real_escape_string($userid);
        $planid = $this->conn->real_escape_string($planid);
        $payment_method = $this->conn->real_escape_string($payment_method);

        //Insert current date for payment
        date_default_timezone_set("Asia/Kuala_Lumpur"); //set time region
        $payment_date = date('Y-m-d H:i:s', time()); //Get current time string

        /* Insert query template */
        $stringQuery = "INSERT INTO payment(UserID, PlanID, PaymentDate, PaymentMethod) VALUES ('$userid', '$planid', '$payment_date', '$payment_method')";

        $sqlQuery = $this->conn->query($stringQuery);
        if ($sqlQuery == true) {
            //echo "Successful update query";
        }else{
            echo "Error in ". $sqlQuery." ".$this->conn->error;
            //echo "Unsuccessful update query. try again!";
        }
    }

    public function paymentHistory($userid){
        $paymentQuery = mysqli_query($this->conn, "SELECT * FROM payment WHERE UserID = $userid ORDER BY PaymentDate DESC");

        while($rowpayment = mysqli_fetch_array($paymentQuery)){
            $paymentid = $rowpayment['PaymentID'];
            $planid = $rowpayment['PlanID'];

            //Change $paymentdate format
            $paymentdate = $rowpayment['PaymentDate'];
            $tempDate = date_create($paymentdate);
            $paymentdate = date_format($tempDate,"d M Y"); //Latest formatted payment date

            $paymentMethod = $rowpayment['PaymentMethod']; //Payment Method data

            $planQuery = mysqli_query($this->conn, "SELECT * FROM subscriptionplan WHERE PlanID = $planid");
            while($rowplan = mysqli_fetch_array($planQuery)){
                $plan_type = $rowplan['Type']." - ". $rowplan['Description'];
                $amount = $rowplan['Price'];

                echo'<tr style="border-bottom: var(--blur-white) 1px solid;text-align: center;margin: auto;">';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">'.$paymentdate.'</td>';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">'.$plan_type.'</td>';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">'.$paymentMethod.'</td>';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">RM '.$amount.'</td>';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">';
                    echo '<p class="delete-btn inline" style="padding: 0 10px"><a style="color:black;" href="printPaymentReceiptMonth.php?paymentid='.$paymentid.'"><i class="fa fa-download"></i></a></p>';
                    echo'</td>';
                echo'</tr>';
            }
        }
    }

    public function readPaymentDetail($userid){
        $paymentQuery = mysqli_query($this->conn, "SELECT * FROM payment WHERE UserID = $userid ORDER BY PaymentDate DESC LIMIT 1");
        $paymentDetailArray = array();

        if ($paymentQuery) {
            if ($paymentQuery->num_rows > 0) {
                while($rowpayment = mysqli_fetch_array($paymentQuery)){
                    $paymentid = $rowpayment['PaymentID'];
                    $planid = $rowpayment['PlanID'];
        
                    //Change $paymentdate format
                    $paymentdate = $rowpayment['PaymentDate'];
                    $tempDate = date_create($paymentdate);
                    $paymentdate = date_format($tempDate,"d M Y"); //Latest formatted payment date
        
                    $paymentMethod = $rowpayment['PaymentMethod']; //Payment Method data
        
                    $planQuery = mysqli_query($this->conn, "SELECT * FROM subscriptionplan WHERE PlanID = $planid");
                    while($rowplan = mysqli_fetch_array($planQuery)){
                        $plan_type = $rowplan['Type']." - ". $rowplan['Description'];
                        $amount = $rowplan['Price'];
        
                        $paymentDetailArray = array($paymentid, $plan_type, $paymentdate, $paymentMethod, $amount);
        
                    }
                }
        
                return $paymentDetailArray;

            }else{
                return false;
            }
        }
    }

    public function readPaymentDetailByMonth($userid, $paymentid){
        $paymentQuery = mysqli_query($this->conn, "SELECT * FROM payment WHERE UserID = $userid AND PaymentID = $paymentid");
        $paymentDetailArray = array();

        while($rowpayment = mysqli_fetch_array($paymentQuery)){
            $paymentid = $rowpayment['PaymentID'];
            $planid = $rowpayment['PlanID'];

            //Change $paymentdate format
            $paymentdate = $rowpayment['PaymentDate'];
            $tempDate = date_create($paymentdate);
            $paymentdate = date_format($tempDate,"d M Y"); //Latest formatted payment date

            $paymentMethod = $rowpayment['PaymentMethod']; //Payment Method data

            $planQuery = mysqli_query($this->conn, "SELECT * FROM subscriptionplan WHERE PlanID = $planid");
            while($rowplan = mysqli_fetch_array($planQuery)){
                $plan_type = $rowplan['Type']." - ". $rowplan['Description'];
                $amount = $rowplan['Price'];

                $paymentDetailArray = array($paymentid, $plan_type, $paymentdate, $paymentMethod, $amount);

            }
        }

        return $paymentDetailArray;
    }
	
}

?>
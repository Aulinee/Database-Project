<?php 
include '../database/dbConnection.php'; 

class User{
    /* Constructor */
	public function __construct($DB_con)
	{
        $this->conn = $DB_con;
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
            //echo "Successful add query";
            return true;
        }else{
            echo "Error in ".$resultUser." ".$this->conn->error;
            //echo "Unsuccessful add query. try again!";
        }
        
        return false;
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

    public function readSubscription(int $subid){
        $subQuery = mysqli_query($this->conn, "SELECT * FROM usersubscription WHERE SubscriptionID = $subid");
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

            $planQuery = mysqli_query($this->conn, "SELECT * FROM subscriptionplan WHERE PlanID = $planid");

            while($rowplan = mysqli_fetch_array($planQuery)){
                $plan_type = $rowplan['Type'];
                $description = $rowplan['Description'];
                $price = $rowplan['Price'];
            }

            $subscriptionArray = array($start_access, $end_access, $plan_type, $description, $price, $day_left_formatted);
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

    public function updateSubscription(int $subid, int $planid){
        $subid = $this->conn->real_escape_string($subid);
        $planid = $this->conn->real_escape_string($planid);

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
            //echo "Successful update query";
        }else{
            echo "Error in ". $sqlQuery." ".$this->conn->error;
            //echo "Unsuccessful update query. try again!";
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

                echo'<tr style="border-bottom: var(--blur-white) 1px solid;text-align: center;margin: auto;pointer-events: none;">';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">'.$paymentdate.'</td>';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">'.$plan_type.'</td>';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">'.$paymentMethod.'</td>';
                    echo'<td style="font-size: 15px;font-weight: 500;letter-spacing: 2px;color: var(--blur-white);text-align: center;padding: 2% 0;margin: auto;">RM '.$amount.'</td>';
                echo'</tr>';
            }
        }
    }

    public function readPaymentDetail($userid){
        $paymentQuery = mysqli_query($this->conn, "SELECT * FROM payment WHERE UserID = $userid ORDER BY PaymentDate DESC LIMIT 1");
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
	
}

?>
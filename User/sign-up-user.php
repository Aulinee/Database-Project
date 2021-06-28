<?php 
include '../database/dbConnection.php'; 
include '../class/UserClass.php';

$userObj = new User($conn);

$fnameErr = $lnameErr = $usernameErr = $emailErr = $mobileNumErr = $genderErr = $addressErr = $postcodeErr = $cityErr = $stateErr = $passwordErr = $confirmPassErr = $conditionErr = "";
$fname = $lname = $username = $email = $mobileNum = $gender = $address = $postcode = $city = $state = $password = $confirmPass = $condition = "";
$boolFname = $boolLname = $boolUsername = $boolEmail = $boolMobileNum = $boolGender = $boolAddress = $boolPostcode = $boolCity = $boolState = $boolPassword = $boolConfirmPass = $boolCondition = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //header('location:sign-in-user.php');
    //first name validation
    if (empty($_POST["firstname"])) {
        $fnameErr = "First name is required";
    } else {
        $fname = test_input($_POST["firstname"]);
        // check if first alphabet capitalise in first name
        if (!preg_match("/^([A-Z]){1}([a-z]){1,}$/", $fname)) {
            $fnameErr = "Only first alphabet in first name must be uppercase";
        } else {
            $boolFname = true;
        }
    }
    
    //last name validation
    if (empty($_POST["lastname"])) {
        $lnameErr = "Last name is required";
    } else {
        $lname = test_input($_POST["lastname"]);
        // check if first alphabet capitalise in last name
        if (!preg_match("/^([A-Z]){1}([a-z]){1,}$/", $lname)) {
            $lnameErr = "Only first alphabet in last name must be uppercase";
        } else {
            $boolLname = true;
        }
    }

    //username validation
    $username = $_POST["username"];
    if (empty($username)) {
        $usernameErr = "Username is required";
    }else if($userObj->checkExistUsername($username)){
        $usernameErr = "This username already exist!";
    }else {
        $boolUsername = true;
    }

    //email validation
    if (empty($_POST["emailaddress"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["emailaddress"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $boolEmail = true;
        }
    }

    //mobile number validation
    if (empty($_POST["phonenumber"])) {
        $mobileNumErr = "Mobile number is required";
    } else {
        $mobileNum = test_input($_POST["phonenumber"]);
        // check if phone number is valid
        if (!preg_match("/^(0)(1)[0-9]\d{7,8}$/", $mobileNum)) {
            $mobileNumErr = "Invalid mobile number format";
        } else {
            $boolMobileNum = true;
        }
    }

    //empty button validation
    //gender
    $gender = $_POST["gender"];
    if ($gender == "select") {
      $genderErr = "Gender is required";
    } else {
      $boolGender = true;
    }

    //address
    $address = $_POST["address"];
    if (empty($address)) {
      $addressErr = "Address Line is required!";
    } else {
      $boolAddress= true;
    }

    //postcode
    $postcode = $_POST["postcode"];
    if (empty($postcode)) {
      $postcodeErr = "Postcode is required";
    } else {
      $boolPostcode = true;
    }

    //city
    $city = $_POST["city"];
    if (empty($city)) {
        $cityErr = "City name is required";
    } else {
        $boolCity = true;
    }

    //state
    $state = $_POST['state'];
    if ($state == "select") {
        $stateErr = "Please select your state.";
    } else {
        $boolState = true;
    }

    //password validation
    if (empty($_POST["psw"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["psw"]);
        $boolPassword = true;
    }

    //confirm password validation
    if (empty($_POST["confirmpsw"])) {
        $confirmPassErr = "Confirm password is required";
    } else {
        // check if confirm password match with password
        $confirmPass = test_input($_POST["confirmpsw"]);
        if ($confirmPass != $password) {
            $confirmPassErr = "Your password does not match!";
        } else {
            $boolConfirmPass = true;
        }
    }

    //terms and condition
    if (empty($_POST['termsandcondition'])) {
        $conditionErr = "Please tick Terms and Condition to proceed.";
    } else {
        $boolCondition = true;
    }

    //confirmation feedback
    if (isset($_POST["register"]) && $boolFname == true && $boolLname == true && $boolUsername == true && $boolEmail == true && $boolMobileNum == true && $boolGender == true && $boolAddress == true && $boolPostcode == true && $boolCity == true && $boolState == true && $boolPassword == true && $boolConfirmPass == true && $boolCondition == true) {
        $signUpStatus = $userObj->signUp($username, $fname, $lname, $email, $password, $mobileNum, $gender, $address, $postcode, $city, $state);

        if ($signUpStatus){
            echo "<script>
            alert('Successfully sign up! Redirecting to sign in page');
            window.location.href='sign-in-user.php';
            </script>";
        } else {
            echo "<script>
            alert('Unsucessuful sign up! Please try again!');
            window.location.href='sign-up-user.php';
            </script>";
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>TMFLIX User Sign Up</title>
</head>
<body class="parallax container">
    <div class="signup-header">
        <img class="signup-logo" src="../img/TMFLIX Background2-02.png" alt="logo">
        <h1 class="signup-label1">Sign up for user</h1>
        <h2 class="signup-label2">Fill up your details</h2>
    </div>
    <div class="signup-form">
        <form name = "register" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="detail-block">
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="fname">First Name</label>
                    <input class="detail-form" type="text" id="fname" name="firstname" placeholder="William" value="<?php echo $fname; ?>" required>
                    <span class="error"><?php echo $fnameErr; ?></span>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="lname">Last Name</label>
                    <input class="detail-form" type="text" id="lname" name="lastname" placeholder="Brown" value="<?php echo $lname; ?>" required>
                    <span class="error"><?php echo $lnameErr; ?></span>
                </div>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="uname">Username</label>
                    <input class="detail-form" type="text" placeholder="Enter Username" name="username" value="<?php echo $username; ?>" required>
                    <span class="error"><?php echo $usernameErr; ?></span>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="phone">Mobile</label>
                    <input class="detail-form" type="tel" id="phone" name="phonenumber" placeholder="01114095674" value="<?php echo $mobileNum; ?>" required>
                    <span class="error"><?php echo $mobileNumErr; ?></span>
                </div>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-65">
                    <label class="detail-label" for="email">Email Address</label>
                    <input class="detail-form" type="text" id="email" name="emailaddress" placeholder="williambrown@gmail.com" value="<?php echo $email; ?>" required>
                    <span class="error"><?php echo $emailErr; ?></span>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-30">
                    <label class="gender-label" for="gender">Gender</label>
                    <select class="gender-select" id="gender" name="gender" required>
                        <option value="select">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <span class="error"><?php echo $genderErr; ?></span>
                </div>
            </div>
            <div class="detail-block one-detail-block">
                <label class="detail-label" for="address">Address Line</label>
                <input class="detail-form" type="text" name="address" id="address" placeholder="Enter address line" value="<?php echo $address; ?>" required>
                <span class="error"><?php echo $addressErr; ?></span>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-20">
                    <label class="postcode-label" for="address">Postcode</label>
                    <input class="postcode-input" type="number" name="postcode" id="pst" placeholder="Enter postcode" value="<?php echo $postcode; ?>" required>
                    <span class="error"><?php echo $postcodeErr; ?></span>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-35">
                    <label class="city-label" for="address">City</label>
                    <input class="city-input" type="text" name="city" id="cty" placeholder="Enter city" value="<?php echo $city; ?>" required>
                    <span class="error"><?php echo $cityErr; ?></span>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-35">
                    <label class="state-label" for="state">State</label>
                    <select class="state-select" id="state" name="state" required>
                        <option value="select">Select State</option>
                        <option value="kuala lumpur">Kuala Lumpur</option>
                        <option value="labuan">Labuan</option>
                        <option value="putrajaya">Putrajaya</option>
                        <option value="johor">Johor</option>
                        <option value="kedah">Kedah</option>
                        <option value="kelantan">Kelantan</option>
                        <option value="Malacca">Malacca</option>
                        <option value="negeri sembilan">Negeri Sembilan</option>
                        <option value="pahang">Pahang</option>
                        <option value="perak">Perak</option>
                        <option value="perlis">Perlis</option>
                        <option value="penang">Penang</option>
                        <option value="sabah">Sabah</option>
                        <option value="sarawak">Sarawak</option>
                        <option value="selangor">Selangor</option>
                        <option value="terengganu">Terangganu</option>
                    </select>
                    <span class="error"><?php echo $stateErr; ?></span>
                </div>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="psw">Password</label>
                    <input class="detail-form" type="password" id="psw" name="psw" placeholder="Your password" value="<?php echo $password; ?>" required>
                    <span class="error"><?php echo $passwordErr; ?></span>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="confirmpsw">Confirm Password</label>
                    <input class="detail-form" type="password" id="confirmpsw" name="confirmpsw" placeholder="Your confirm password" value="<?php echo $confirmPass; ?>" required>
                    <span class="error"><?php echo $confirmPassErr; ?></span>
                </div>
            </div>
            <div class="tnc-block">
                <input type="checkbox" id="termsandcondition" name="termsandcondition" value="termsandcondition" required>
                <label for="termsandcondition" class="tnc-label1">I accept the terms and condition for signing up to this service, and hereby confirm I have read the privacy policy.</label>
                <span class="error"><?php echo $conditionErr; ?></span>
            </div>
            <div class="signin-label">
                <button class="btn-register align-center" type="submit" name="register" value="Sign Up">Sign Up</button>
                <h2>Have an account? <a href="sign-in-user.php">Sign in here.</a></h2>
            </div>
        </form>
    </div>
    <br>
    <br>
</body>
</html>
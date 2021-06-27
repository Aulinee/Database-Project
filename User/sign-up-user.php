<?php 
include '../database/dbConnection.php'; 
include 'UserClass.php';

$error ="";
$userObj = new User($conn);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //header('location:sign-in-user.php');
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
                    <input class="detail-form" type="text" id="fname" name="firstname" placeholder="William" required>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="lname">Last Name</label>
                    <input class="detail-form" type="text" id="lname" name="lastname" placeholder="Brown" required>
                </div>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="uname">Username</label>
                    <input class="detail-form" type="text" placeholder="Enter Username" name="uname" required>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="phone">Mobile</label>
                    <input class="detail-form" type="tel" id="phone" name="phonenumber" placeholder="+601114095674" required>
                </div>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-65">
                    <label class="detail-label" for="email">Email Address</label>
                    <input class="detail-form" type="text" id="email" name="emailaddress" placeholder="williambrown@gmail.com" required>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-30">
                    <label class="gender-label" for="gender">Gender</label>
                    <select class="gender-select" id="gender" name="gender" required>
                        <option value="select">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <div class="detail-block one-detail-block">
                <label class="detail-label" for="address">Address Line</label>
                <input class="detail-form" type="text" name="addressline" id="address" placeholder="Enter address line" required>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-20">
                    <label class="postcode-label" for="address">Postcode</label>
                    <input class="postcode-input" type="number" name="post" id="pst" placeholder="Enter postcode" required>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-35">
                    <label class="city-label" for="address">City</label>
                    <input class="city-input" type="text" name="city" id="cty" placeholder="Enter city" required>
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
                </div>
            </div>
            <div class="detail-block">
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="psw">Password</label>
                    <input class="detail-form" type="password" id="psw" name="psw" placeholder="Your password" required>
                </div>
                <div class="col-5"></div>
                <div class="one-detail-block col-45-7">
                    <label class="detail-label" for="confirmpsw">Confirm Password</label>
                    <input class="detail-form" type="password" id="confirmpsw" name="confirmpsw" placeholder="Your confirm password" required>
                </div>
            </div>
            <div class="tnc-block">
                <input type="checkbox" id="termsandcondition" name="termsandcondition" value="termsandcondition" required>
                <label for="termsandcondition" class="tnc-label1">I accept the terms and condition for signing up to this service, and hereby confirm I have read the privacy policy.</label>
            </div>
            <div class="signin-label">
                <button class="btn-register align-center" type="submit" value="Sign Up" onclick="return feedback()">Sign Up</button>
                <h2>Have an account? <a href="sign-in-user.php">Sign in here.</a></h2>
            </div>
        </form>
    </div>
    <br>
    <br>
    <script>
        function feedback(){
            var uname= document.getElementById("uname").value;
            var fname= document.getElementById("fname").value;
            var lname= document.getElementById("lname").value;
            var email= document.getElementById("email").value;
            var phone= document.getElementById("phone").value;
            var address1= document.getElementById("address").value;
            var postc= document.getElementById("pst").value;
            var city= document.getElementById("cty").value;
            var state1= document.getElementById("state").value; 
            var gender= document.forms["register"]["gender"].value;
            var pwd= document.getElementById("psw").value;			
            var cpwd= document.getElementById("confirmpsw").value;
            var termcon= document.getElementById("termsandcondition").checked;

            //regex expression code
            var pwd_expression = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!"#$%&'()*+,-.:;<=>?@[\]^_`{|}~])[A-Za-z\d!"#$%&'()*+,-.:;<=>?@[\]^_`{|}~]{6,6}$/;
            var usrname = /^[A-Za-z]+$/;
            var names = /^([A-Z]){1}([a-z]){1,}$/;
            var mobile = /^[\+][6][0][1]\d{8,9}$/;
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if(uname=='')
            {
                alert('Please enter your username');
                return false;
            }
            else if(!usrname.test(uname))
            {
                alert('Name field required only alphabet characters');
                return false;
            }
            else if(fname=='')
            {
                alert('Please enter your first name');
                return false;
            }
            else if(!names.test(fname))
            {
                alert('Name field required only alphabet characters and uppercase first letter');
                return false;
            }
            else if(lname=='')
            {
                alert('Please enter your last name');
                return false;
            }
            else if(!names.test(lname))
            {
                alert('Name field required only alphabet characters');
                return false;
            }
            else if(email=='')
            {
                alert('Please enter your user email');
                return false;
            }
            else if (!filter.test(email))
            {
                alert('Invalid email');
                return false;
            }
            else if(phone=='')
            {
                alert('Please enter phone number.');
                return false;
            }
            else if(!mobile.test(phone))
            {
                alert('Phone no. field requires +60 and only numbers');
                return false;
            }
            else if(address1=='')
            {
                alert('Please enter your address line 1');
                return false;
            }
            else if(postc=='')
            {
                alert('Please enter your postcode');
                return false;
            }
            else if(document.getElementById("pst").value.length < 5)
            {
                alert ('Postcode digit length is 5');
                return false;
            }
            else if(city=='')
            {
                alert('Please enter your city');
                return false;
            }
            else if(state1=='')
            {
                alert("Please select your state");
                return false;
            }
            else if(document.forms["register"]["male"].checked==false && document.forms["register"]["female"].checked==false)
            {
                alert("You must select male or female");
                return false;
            }
            else if(pwd=='')
            {
                alert('Please enter Password');
                return false;
            }
            else if(cpwd=='')
            {
                alert('Enter Confirm Password');
                return false;
            }
            else if(!pwd_expression.test(pwd))
            {
                alert ('At least ONE Uppercase, ONE Lowercase, ONE Special character, ONE Numeric letter and 6 DIGITS LENGTH are required in Password filed');
                return false;
            }
            else if(pwd != cpwd)
            {
                alert ('Password not Matched');
                return false;
            }
            else if(document.getElementById("terms").checked==false)
            {
                alert('Please agree on the terms and conditions!');
                return false;
            }
            else if(gender.checked==false)
            {
                alert('Please agree on the terms and conditions!');
                return false;
            }
            else
            {
                alert('Thank You for Registering & Please Login'); 
            }
        }
    </script>
</body>
</html>
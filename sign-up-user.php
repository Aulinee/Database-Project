<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>TMFLIX User Sign Up</title>
</head>
<body class="parallax container">
    <div class="signup-header">
        <img class="signup-logo" src="img/TMFLIX Background2-02.png" alt="logo">
        <h1 class="signup-label1">Sign up for user</h1>
        <h2 class="signup-label2">Fill up your details</h2>
    </div>
    <div class="signup-form">
        <form action="">
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
                <label for="termsandcondition" class="tnc-label1">I accept the terms and condition for signing up to this service, and hereby confirm I have</label>
                <label for="termsandcondition" class="tnc-label2">read the privacy policy.</label>
            </div>
            <div class="signin-label">
                <button class="btn-register" type="submit" value="Sign Up" onclick="">Sign Up</button>
                <h2>Have an account? <a href="sign-in-user.php">Sign in here.</a></h2>
            </div>
        </form>
    </div>
    <br>
    <br>
</body>
</html>
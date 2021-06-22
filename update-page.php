<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style1.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Update Plan</title>
    </head>

    <body>
        <header>
            <img class="logo" src="TMFLIX Background2-02.png" alt="logo" width="80px" height="25px">
            <nav>
                <ul class="nav_links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Series</a></li>
                    <li><a href="#">About Us</a></li>
                    <input type="text" placeholder="Search..">
                </ul>
            </nav>

            <a class="user" href="#"><i img="user" src="user2.png" alt="user" width="20px" height="20px"></i>Gsebi</a>
            <a class="signout" href="#">Sign Out</a>
        </header>

        <h1 class="update">Update Plan</h1>

        <div class="standard-container">
            <div class="col"><h3>Standard Plan</h3></div>
            <div class="col"><p>One device & Good Quality (480p)</p></div>
            <div class="col"><h2>RM 17/month</h2></div>
        </div>
        <br>
        <div class="premium-container">
            <div class="col"><h3>Premium Plan</h3></div>
            <div class="col"><p>Multiple devices & Full HD (1080p)</p></div>
            <div class="col"><h2>RM 39/month</h2></div>
        </div>
        <br>
        <h2>Payment Method: </h2>
        <div class="select">
            <select name="method" id="method">
                <option selected disabled>Select method</option>
                <option value="pdf">Credit Card</option>
                <option value="txt">Online Banking</option>
                <option value="epub">PayPal</option>
            </select>
        </div>
    </body>
</html>
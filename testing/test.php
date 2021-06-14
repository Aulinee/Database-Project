<?php 
    include 'User.php';
    $newUser = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Main Page</title>
</head>
<body class="parallax" method="">
    <div class="actor-div">
        <div class="actor-div-title">
            <h1 class="actor-div-title-h1">Season 1</h1>
        </div>
        <div class="actor-div-content">
            <h1 class="actor-div-title-h1">Season 1</h1>
        </div>
    </div>
    <div class="actor-div">
        <?php include 'season-div.php'; ?>
    </div>
    <div class="series-actor-div" id="hidden-div">
        <div class="actor-div-title" id="hidden-div-1">
            <h1 class="actor-div-title-h1">Season 2</h1>
        </div>
        <div class="actor-div-content" id="hidden-div-2">
            <h1 class="actor-div-title-h1">Season 2</h1>
        </div>
    </div>
    <button onclick="myFunction()">Click me</button>

    <br>
    First Name:<input type="text" name="fname" id="fname"><br><br>
    Last Name:<input type="text" name="lname" id="lname"><br><br>
    Age:<input type="text" name="age" id="age"><br><br>
    <table id="table" border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
        </tr>
        <tr>
            <td>FN1</td>
            <td>LN1</td>
            <td>10</td>
        </tr>
        <tr>
            <td>FN2</td>
            <td>LN2</td>
            <td>20</td>
        </tr>
        <tr>
            <td>FN3</td>
            <td>LN3</td>
            <td>30</td>
        </tr>
        <tr>
            <td>FN4</td>
            <td>LN4</td>
            <td>40</td>
        </tr>
        <tr>
            <td>FN5</td>
            <td>LN5</td>
            <td>50</td>
        </tr>
    </table>
    <script>
        function myFunction(){
            var x = document.getElementById("hidden-div");
            var y = document.getElementById("hidden-div-1");
            var z = document.getElementById("hidden-div-2");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "block";
                z.style.display = "block";
            } else {
                x.style.display = "none";
                y.style.display = "none";
                z.style.display = "none";
            }
        }

        var table = document.getElementById('table');   
        for(var i = 1; i < table.rows.length; i++)
        {
            table.rows[i].onclick = function()
            {
                //rIndex = this.rowIndex;
                document.getElementById("fname").value = this.cells[0].innerHTML;
                document.getElementById("lname").value = this.cells[1].innerHTML;
                document.getElementById("age").value = this.cells[2].innerHTML;
            };
        }
    </script>
</body>
</html>
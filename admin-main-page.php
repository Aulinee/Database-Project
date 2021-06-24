<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Database Project/admin-main-page.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
    <title>Admin Main Page</title>
</head>
<body class="parallax container">
    <header>
        <ul>
            <li><img src="TMFLIX logo admin.png" alt="logo"></li>
            <li id="admin"><h1>Admin</h1></li>
            <li id="logout"><a href="#"><img class="logout" src="logout2.png"> &nbspSign Out</img></a></li>
            <li id="user"><a href="#"><img class="user" src="user2.png"> &nbspGsebi</img></a></li>
            <li id="subscription"><a href="#"><img class="subscription" src="subscription white.png"> &nbspSubscription</img></a></li>
            <li id="tv"><a href="#"><img class="tv" src="television white.png"> &nbspTV Series</img></a></li>   
        </ul>
    </header>   
    <br>
    <div class="container">
        <div class="col">
            <button type="search" class="search-btn"><img class="search-icon" src="search2.png"></button>
            <input type="text" name="box" placeholder="Search title" class="input">
        </div>
        <div class="col"><h2 class="a">LIST OF TV SERIES</h2><br><p class="a">select row to view and edit</p></div>
        <div class="col">
            <button type="icon" class="create-icon"><img class="create-btn" src="create.png"></button>
            <button type="create" class="create">CREATE</button>
        </div>
        

        <table>
            <tr>
                <th>SERIES IMAGE</th>
                <th>TITLE</th>
                <th>TOTAL SEASON</th>
                <th>TOTAL EPISODE</th>
                <th>GENRE</th>
                <th>CAST</th>
                <th>DIRECTOR</th>
                <th>AWARD</th>
                <th>RELEASE DATE</th>
                <th>ACTION</th>
            </tr>

            <tr>
                <td> <img class="girl" src="girl from nowhere.jpg"></td>
                <td> Girl From Nowhere</td>
                <td> 2</td>
                <td> 21</td>
                <td> Crime<br>Drama<br>Fantasy</td>
                <td> Chica Amatayakul<br>Tris Ren<br>Naomi Amante<br>Rich Ting<br>Kayli Tran<br>Chanya McClary<br>Yuuki Luna</td>
                <td> Komqrit<br>Jatupong Rungrueangdechaphat<br>Pairach Khumwan</td>
                <td> </td>
                <td> May 7, 2020</td>
                <td> <button type="edit" class="edit-btn"><img class="edit" src="pen.png"></button><button type="delete" class="delete-btn"><img class="delete" src="delete.png"></button></td>
            </tr>

            <tr>
                <td> <img class="mirror" src="black mirror.jpg"></td>
                <td> Black Mirror</td>
                <td> 6</td>
                <td> 30</td>
                <td> Crime<br>Drama<br>Fantasy</td>
                <td> Chica Amatayakul<br>Tris Ren<br>Naomi Amante<br>Rich Ting<br>Kayli Tran<br>Chanya McClary<br>Yuuki Luna</td>
                <td> Komqrit<br>Jatupong Rungrueangdechaphat<br>Pairach Khumwan</td>
                <td> </td>
                <td> May 7, 2020</td>
                <td> <button type="edit" class="edit-btn"><img class="edit" src="pen.png"></button><button type="delete" class="delete-btn"><img class="delete" src="delete.png"></button></td>
            </tr>

            <tr>
                <td> <img class="bad" src="breaking bad.jpg"></td>
                <td> Breaking Bad</td>
                <td> 12</td>
                <td> 60</td>
                <td> Crime<br>Drama<br>Fantasy</td>
                <td> Chica Amatayakul<br>Tris Ren<br>Naomi Amante<br>Rich Ting<br>Kayli Tran<br>Chanya McClary<br>Yuuki Luna</td>
                <td> Komqrit<br>Jatupong Rungrueangdechaphat<br>Pairach Khumwan</td>
                <td> </td>
                <td> May 7, 2020</td>
                <td> <button type="edit" class="edit-btn"><img class="edit" src="pen.png"></button><button type="delete" class="delete-btn"><img class="delete" src="delete.png"></button></td>
            </tr>
        </table>
    </div>
    <br>
    <footer class="footer">
        <div class="inner-footer">
            <ul>
                <li class="fb"><a href="#"><img class="fb" src="facebook-07.png"></img></a></li>
                <li class="twt"><a href="#"><img class="twt" src="twitter2-06.png"></a></li>
                <li class="ig"><a href="#"><img class="ig" src="instagram2-08.png"></a></li>
            </ul>
        </div>

        <div class="outer-footer">
            <p>Copyright by Meow 2.0</p>
        </div>      
    </footer>
</body>
</html>


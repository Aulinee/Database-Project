<?php
include '../database/dbConnection.php'; 
include 'sessionAdmin.php';
if(isset($_SESSION['series_id'])){
    unset($_SESSION['series_id']);
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST["add-series"])){
        $image = $_FILES['img-upload']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        $series_title = $_POST['series-title'];
        $series_desc = $_POST['description'];
        $series_date = $_POST['release-date'];

        $seriesid = $seriesObj->addSeries($imgContent, $series_title, $series_desc, $series_date);

        echo "<script>
            alert('Successfully add new series! Please insert other details in edit page!');
            window.location.href='edit-series-page.php?id=".$seriesid."';
            </script>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin Main Page</title>
    
</head>
<body class="parallax">
    <header class="navbar-div" id="navbar">
        <div class="branding-admin">
            <img class="admin-logo inline" src="../img/TMFLIX Background2-02.png" alt="logo">
            <h1 class="admin-title inline">Admin</h1>
        </div>
        <div class="right-admin-navbar">
            <nav>
                <ul>
                    <li><a href="main-admin-page.php"><i style="font-size:25px" class="fa">&#xf26c;</i>  TV Series</a></li>
                    <li><a href="#"><i style="font-size:25px" class="fa">&#xf155;</i>  Subscription</a></li>
                    <li><a href="#"><i style="font-size:25px" class="fa fa-user" aria-hidden="true"></i>  <?php echo $usernameAdmin?></a></li>
                    <li><a href="../User/logout.php"><i style="font-size:25px" class="fa">&#xf08b;</i>  Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="content container-95 bg-black padding-5">
        <h2 class="main-page-title font-white">LIST OF TV SERIES</h2>
        <div class="flex-admin">
            <div class="seriesinput-icons">
                <i class="fa fa-search seriesicon"></i>
                <input class="seriesinput-field" type="text" id="seriesInput" onkeyup="filterSeries()" placeholder="Search for series name.." title="Type in a name">
            </div>
            <div class="col">
                <h5 class="sub-title-main font-white">select row to view and edit</h5>
            </div>
            <div class="create-series-btn">
                <i class="fa fa-plus addicon"></i>
                <button class="create" onclick="document.getElementById('add-series').style.display='block'">CREATE</button>
                <!-- hidden div inside button add award tag -->
                <div id="add-series" class="sub-hidden-form">
                    <form class="hidden-form animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="titlecontainer">
                            <h2 class="main-page-title white-font">ADD NEW SERIES</h2>
                            <h5 class="sub-title-main white-font">add new series here</h5>
                            <span class="close-btn" onclick="document.getElementById('add-series').style.display='none'" title="Close Modal">&times;</span>
                        </div>
                        <div class="contentcontainer">
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-series">New Series Title</label>
                                <br>
                                <input type="text" placeholder="Enter Series Title" name="series-title" required>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-series">New Series Release Date</label>
                                <br>
                                <input type="date" placeholder="Enter Series Release Date" name="release-date" required>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-series">New Series Summary</label>
                                <br>
                                <textarea name="description" id="description" cols="80" rows="10"></textarea>
                            </div>
                            <div class="editinfo-div editinfo-div-2">
                                <label for="add-series">Upload Series Poster</label>
                                <input type="file" id="file" name="img-upload">
                            </div>
                            <br>
                            <div class="margin-5"></div>
                            <div class="hidden-div-btn">
                                <button class="submitbtn inline" type="submit" name='add-series'>Submit</button>
                                <button class="cancelbtn inline" type="button" onclick="document.getElementById('add-series').style.display='none'" >Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tbl-scroll">
            <table id="seriesTable" class="all-series-table">
                <tr>
                    <th>SERIES IMAGE <i class="fa fa-image"></i></th>
                    <th>TITLE <i class="fa fa-desktop"></i></th>
                    <th>VIEW <i class="fa fa-eye"></i></th>
                    <th>TOTAL SEASON</th>
                    <th>TOTAL EPISODE</th>
                    <th>GENRE </th>
                    <th>CAST <i class="fa fa-user"></i></th>
                    <th>DIRECTOR <i class="fa fa-user"></i></th>
                    <th>AWARD <i class="fa fa-trophy"></i></th>
                    <th>RELEASE DATE <i class="fa fa-calendar"></i></th>
                    <th>ACTION <i class="fa fa-file-o"></i></th>
                </tr>
                <!-- <tr>
                    <td> <img class="seriesimg" src="girl from nowhere.jpg"></td>
                    <td> Girl From Nowhere</td>
                    <td> </td>
                    <td> 2</td>
                    <td> 21</td>
                    <td> Crime<br>Drama<br>Fantasy</td>
                    <td> Chica Amatayakul<br>Tris Ren<br>Naomi Amante<br>Rich Ting<br>Kayli Tran<br>Chanya McClary<br>Yuuki Luna</td>
                    <td> Komqrit<br>Jatupong Rungrueangdechaphat<br>Pairach Khumwan</td>
                    <td> </td>
                    <td> May 7, 2020</td>
                    <td><button type="submit" class="edit-btn inline"><i class="fa fa-edit"></i></button><button type="submit" class="delete-btn inline"><i class="fa fa-trash-o"></i></button></td>
                </tr> -->
                <?php $seriesObj->displayAllSeries(); ?>
            </table> 
        </div>   
    </div>
    <script>
        function filterSeries() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("seriesInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("seriesTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }
    </script>
</body>
</html>
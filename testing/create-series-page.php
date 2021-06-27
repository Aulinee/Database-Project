<?php
include 'sessionAdmin.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST["add-series"])){
        $image = $_FILES['img-upload']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        $series_title = $_POST['series-title'];
        $series_desc = $_POST['description'];
        $series_date = $_POST['release-date'];

        $seriesid = $seriesObj->addSeries($imgContent, $series_title, $series_desc, $series_date);

        $_SESSION['series_id'] = $seriesid;

        header('location:create-series-detail-page.php?id='.$_SESSION['series_id'].'');
    }
    
}
?>
<?php  ?>
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
    <div class="content container-95">
        <h1 class="div-title">CREATE NEW TV SERIES</h1>
        <div class="new-series bg-black" id="new-series">
            <div class="new-series-description">
                <h1 class="div-title">TV SERIES DESCRIPTION</h1>
                <form name="series-description" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="new-series-img-div red">
                        <p><img id="output" width="200" /></p>
                        <p><input type="file"  accept="image/*" name="img-upload" id="file"  onchange="loadFile(event)" style="display: none;"></p>
                        <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
                    </div>
                    <div class="new-series-desc-div red">
                        <table class="new-series-desc-div-2">
                            <tr class="new-series-desc-detail-div red">
                                <td><label for="series-title">Series Title</label></td>
                                <td><input type="text" placeholder="Enter Title" name="series-title"  value=""></td>
                            </tr>
                            <tr class="new-series-desc-detail-div red">
                                <td><label for="description">Description</label></td>
                                <td><textarea name="description" id="description" cols="80" rows="10"></textarea></td>
                            </tr>
                            <tr class="new-series-desc-detail-div red">
                                <td><label for="release-date">Release Date</label></td>
                                <td><input type="date" placeholder="Enter Release" name="release-date"  value=""></td>
                            </tr>
                        </table>
                        <button class="btn-register" type="submit" name="add-series">Add Series</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
</body>
</html>
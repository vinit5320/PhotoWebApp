<?php
include 'library.php';

$usrname= $_SESSION['sessionVar'];

$sql="SELECT name FROM photoApp_user WHERE username = '$usrname'";
$result=mysqli_query($connection, $sql);

while($row= mysqli_fetch_array( $result ))
{
    $mainname= $row['name'];
}
if($mainname == ""){
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Welcome, <?php echo $mainname; ?></title>

    <!--Angular Bootstrap -->
    <script src="angularjs/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
    <link rel="stylesheet" href="angularjs/bootstrap/dist/css/bootstrap.min.css">

    <!--Style Sheet-->
    <link rel="stylesheet" href="css/style.css">
    <!---->

</head>
<body ng-controller="MainController as MainCtrl">
<br><br>
<nav class="navbar navbar-default" style="margin: 0px 15px 0px 15px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
            </a>
        </div>
        <ul class="nav nav-pills" style="margin-left: 5%; margin-top: 5px;">
            <li role="presentation" style="margin-right: 1%;"><a href="home.php">Home</a></li>
            <li role="presentation" class=""><a href="addphoto.php">Add Photo</a></li>
            <li role="presentation" class="active" class="dropdown" style="margin-left: 1%;">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $mainname; ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="#">Profile</a></li>
                    <li role="presentation"><a href="logout.php">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<br><br>
<div class="container-fluid">

    <div class="row">
        <?php
        $q=mysqli_query($connection, "SELECT * FROM `photoApp_photos` ORDER BY `photoApp_photos`.`timestamp` DESC");
        while($row=mysqli_fetch_assoc($q)){
            if($row['username']== $_SESSION['sessionVar']){


                if($row['imageName']==""){

                    echo "<img width='500' height='500' src='uploads/800.png'>";

                }
                else{
                    echo "<div class='col-lg-4 col-sm-6'>";
                    echo "<div class='thumbnail''>";
                    echo "<img style='height: 188px;' src='uploads/".$row['imageName']."'>";
                    echo"<br>";
                    echo "<hr>";
                    if($row['caption'] == ""){
                        echo "<span>No Caption</span>";
                    } else {
                        echo "<span>" . $row['caption'] . "</span>";
                    }
                    echo "</div>";
                    echo "</div>";


                }

            }
        }
        ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
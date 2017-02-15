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

$allowed =  array('gif','png' ,'jpg', 'jpeg');


if(isset($_POST['submit'])){

    $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    if(in_array($ext,$allowed) ) {
        $insertQuery = "INSERT INTO photoApp_photos (username,imageName,caption) VALUES ('$usrname','".$_FILES['file']['name']."','".$_POST['caption']."')";
        $result=mysqli_query($connection, $insertQuery);
        move_uploaded_file($_FILES['file']['tmp_name'],"uploads/".$usrname_."".$_FILES["file"]["name"]);
        $message = "Image uploaded successfully!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $message = "Image extension not valid.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
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
<body>
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
            <li role="presentation" class="active"><a href="addphoto.php">Add Photo</a></li>
            <li role="presentation" class="dropdown" style="margin-left: 1%;">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $mainname; ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="profile.php">Profile</a></li>
                    <li role="presentation"><a href="logout.php">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<br><br>

<section style="margin-left: 3%;">
    Add only .jpg, .png, .gif images.
    <br><br>
    <form action=""  method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <br>
        <input type="text" name="caption">
        <input type="submit" name="submit" value="Add Photo">
    </form>
</section>
<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
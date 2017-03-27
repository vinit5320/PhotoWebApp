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

$limit = 10; // Limited number of Images per page
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $limit;

$sql = "SELECT * FROM `photoApp_photos` ORDER BY `photoApp_photos`.`timestamp` DESC LIMIT $start_from, $limit";
$result = mysqli_query ($connection,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Welcome, <?php echo strip_tags($mainname); ?></title>
    <!--Style Sheet-->
    <link rel="stylesheet" href="angularjs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!---->

    <script>
        function imgchange(num){
            $("#imgs").attr('src',$('img')[num].src);
            $("#captionText").text("Caption: "+$('#caption')[num].text());
        }
    </script>

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
            <li role="presentation" class="active" style="margin-right: 1%;"><a href="home.php">Home</a></li>
            <li role="presentation" class=""><a href="addphoto.php">Add Photo</a></li>
            <li role="presentation" class="dropdown" style="margin-left: 1%;">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo strip_tags($mainname); ?> <span class="caret"></span>
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
<div class="container-fluid">

    <div class="row">
        <?php
        $i=0;
        while($row=mysqli_fetch_assoc($result)){
            echo "<div class='col-lg-4 col-sm-6'>";
            echo "<div class='thumbnail'>";
            echo "<a href='#' data-toggle='modal' data-target='#myModal' onclick='imgchange(".$i.")'>";
            echo "<img style='height: 188px;' id='mainImg' src='uploads/".strip_tags($row['imageName'])."'>";
            echo "</a>";
            echo "<hr>";
            if($row['caption'] == ""){
                echo "<span>No Caption</span><p style='float: right; color:#000;'>".$row['username']."</p>";
            } else {
                echo "<span id='caption'>Caption: " . strip_tags($row['caption'], '') . "</span><p style='float: right; color:#000;'>".strip_tags($row['username'])."</p>";
            }
            echo "</div>";
            echo "</div>";
            $i++;
        }
        ?>
    </div>
</div>
<!-- MODAL VIEW -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p id="captionText"></p>
                <img id="imgs" style="width: 100%;"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<?php
$sql = "SELECT COUNT(username) FROM photoApp_photos";
$countResult = mysqli_query($connection,$sql);
$row = mysqli_fetch_row($countResult);
$total = $row[0];
$pages = ceil($total / $limit);
if($pages != 1) {
    $pageLink = "<ul style='margin-left: 1%;' class=\"pagination\">";
    for ($i = 1; $i <= $pages; $i++) {
        if ($page == $i) {
            $pageLink .= "<li class='active'><a href='home.php?page=" . $i . "'>" . $i . "<span class=\"sr-only\">(current)</span></a></li>";
        } else {
            $pageLink .= "<li><a href='home.php?page=" . $i . "'>" . $i . "</a></li>";
        }

    };
    echo $pageLink . "</ul>";
}
?>
<br><br>
<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include 'library.php';

$usrname= $_SESSION['sessionVar'];

$sql="SELECT name FROM photoApp_user WHERE username = '$usrname'";
$result=mysqli_query($connection, $sql);

while($row= mysqli_fetch_array( $result ))
{
    $mainname= $row['name'];
}


?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <!--Style Sheet-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="angularjs/bootstrap/dist/css/bootstrap.min.css">
    <!---->
</head>
<body>
<br>
<section class="container">
    <div class="login">
        <h1>Log in to the network</h1>
        <form method="post" action="checklogin.php">
            <p><input type="text" name="myusername" value="" placeholder="Username"></p>
            <p><input type="password" name="mypassword" value="" placeholder="Password"></p>
            <p class="submit"><input type="submit" name="submit" value="Login"></p>
        </form>
    </div>

    <div class="login-help">
        <span style="font-size: small; ">To Register as a new user <a href="register.php">click here.</a></span>
    </div>

</section>
</body>
</html>

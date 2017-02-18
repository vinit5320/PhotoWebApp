<?php
include 'library.php';

// username and password sent from login page
$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];


$sql = "SELECT * FROM photoApp_user WHERE username='$myusername' and password='$mypassword'";
$result = mysqli_query($connection, $sql);

//If user is found the count will be equal to 1, else wrong username or password
$count = mysqli_num_rows($result);

if ($count == 1) {
    $_SESSION['sessionVar'] = $myusername;

    header("location:home.php");
} else {
    $message = "Wrong Username or Password";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo '<body><a href="index.php" style="margin: 1% 1% 0% 0%;">Back to Login Page</a></body>';

}
?>

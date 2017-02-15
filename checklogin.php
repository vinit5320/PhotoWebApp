<?php
include 'library.php';

// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];


$sql="SELECT * FROM photoApp_user WHERE username='$myusername' and password='$mypassword'";
$result=mysqli_query($connection, $sql);


$count=mysqli_num_rows($result);


if($count==1){
  $x = $myusername;
  $_SESSION['sessionVar'] = $x;

  header("location:home.php");
}
else {
  echo "Wrong Username or Password";
}
?>

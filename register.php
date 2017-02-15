<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Register Form</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body  id="backgroundTest">
  <section class="container">
    <div class="login">
      <h1>Fill in details to register</h1>
      <form method="post" action="?act=register">
        <p><input type='text' name='name' size='30' placeholder='Full Name'></p>
        <p><input type='text' name='username' size='30' placeholder='Desired Username'></p>
        <p><input type='password' name='password' size='30' placeholder='Password'></p>
        <p><input type='password' name='password_conf' size='30' placeholder='Retype Password'></p>
        <p><input type='text' name='email' size='30' placeholder='Email Address'></p>
        
		<p class="submit"><input type="submit" name="commit" value="Register User"></p>
      </form>
    </div>

    <div class="login-help">
      <p>To Login as an existing user <a href="index.php">click here</a>.</p>
    </div>
  </section>

  
</body>
</html>

<?php

//This function will register users data
function register(){

//Connecting to database
    $connection = mysqli_connect('localhost', 'root', 'root', 'photoApp');

//Collecting info
$name = $_REQUEST['name'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$pass_conf = $_REQUEST['password_conf'];
$email = $_REQUEST['email'];

$guess = $_POST['captcha'];
$phone= $_REQUEST['phone'];
$dob=$_REQUEST['dob'];

//Here we will check do we have all inputs filled

if(empty($username)){
die("Please enter your username!<br>");
}

if(empty($password)){
die("Please enter your password!<br>");
}

if(empty($pass_conf)){
die("Please confirm your password!<br>");
}

if(empty($email)){
die("Please enter your email!");
}

$real = (isset($_SESSION['real'])) ? $_SESSION['real'] : "";

//Let's check if this username is already in use

    $sql="SELECT username FROM photoApp_user WHERE username='$username'";
    $user_check=mysqli_query($connection, $sql);
$do_user_check = mysql_num_rows($user_check);
if($do_user_check==1){
echo "username alredy exist";
}

//Now if email is already in use
    $sql="SELECT email FROM photoApp_user WHERE email='$email'";
    $email_check=mysqli_query($connection, $sql);
$do_email_check = mysql_num_rows($email_check);


//Now display errors

if($do_user_check > 0){
die("Username is already in use!<br>");
}

if($do_email_check > 0){
die("Email is already in use!");
}

//Now let's check does passwords match

if($password != $pass_conf){
die("Passwords don't match!");
}


//If everything is okay let's register this user

$insertQuery = "INSERT INTO photoApp_user (username,password,email,name) VALUES ('$username','$password','$email','$name')";

if(!mysqli_query($connection, $insertQuery)){
die("There's little problem: ".mysqli_error());
}
else
{
header("location:thanks.php?name=$name&username=$username");
}

}
$act = isset($_GET['act']) ? $_GET['act'] : '';
switch($act){

default;
register_form();
break;

case "register";
register();
break;

}
 
?> 
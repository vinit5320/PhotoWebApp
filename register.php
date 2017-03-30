<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Register Form</title>
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--Style Sheet-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="angularjs/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!---->
</head>
<body  id="backgroundTest">


<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-wrap">
                    <h1>Fill in details to register</h1>
                    <form role="form" action="?act=register" method="post" id="login-form" autocomplete="off">
                        <?php echo '<input type="hidden" name="registercsrf" value="'. $csrf->getToken() .'" />'; ?>
                        <div class="form-group">
                            <label for="email" class="sr-only">Full Name</label>
                            <input type="text" name="name" id="email" size="30" class="form-control" placeholder="full name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Desired Username</label>
                            <input type="text" name="username" id="email" size="30" class="form-control" placeholder="username">
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input type="password" name="mypassword" id="key" size="30" class="form-control" placeholder="password">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="abc@xyz.com">
                        </div>
                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" name="commit" value="Register">
                    </form>
                    <div class="login-help">
                        <p>To Login as an existing user <a href="index.php">click here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
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

//Here we will check do we have all inputs filled

    if(empty($username)){
        $message = "Please enter your username!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    if(empty($password)){
        $message = "Please enter your password!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    if(empty($pass_conf)){
        $message = "Please confirm your password!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    if(empty($email)){
        $message = "Please enter your email!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

//Let's check if this username is already in use

    $sql="SELECT username FROM photoApp_user WHERE username='$username'";
    $user_check=mysqli_query($connection, $sql);
    $do_user_check = mysql_num_rows($user_check);
    if($do_user_check>0){
        $message = "Username already exists, please use a different username";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

//Now if email is already in use
    $sql="SELECT email FROM photoApp_user WHERE email='$email'";
    $email_check=mysqli_query($connection, $sql);
    $do_email_check = mysql_num_rows($email_check);
    if($do_email_check>0){
        $message = "Email is already in use!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

//Now let's check does passwords match

    if($password != $pass_conf){
        $message = "Passwords don't match!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }


//If everything is okay let's register this user
    $password = md5($password);
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
<?php
include 'library.php';

// username and password sent from login page
$myusername = clean($_POST['myusername']);
$mypassword = clean($_POST['mypassword']);
$redirectLocation = $_POST['redirect'];

if (!$csrf->isTokenValid($_POST['csrf']))
{
    echo 'CSRF Attack detected!';
}
else
{
    $mypassword = md5($mypassword);
    $sql = "SELECT * FROM photoApp_user WHERE username='$myusername' AND password='$mypassword'";
    $result = mysqli_query($connection, $sql);

//If user is found the count will be equal to 1, else wrong username or password
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION['sessionVar'] = md5($myusername);

        header("location:".$redirectLocation);
    } else {
        $message = "Wrong Username or Password";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo '<body><a href="index.php" style="margin: 1% 1% 0% 0%;">Back to Login Page</a></body>';

    }
}

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>

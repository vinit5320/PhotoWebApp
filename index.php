<?php
include 'library.php';

if(isset($_SESSION['sessionVar'])){
    header("location:home.php");
}

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <!--Style Sheet-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="angularjs/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!---->
    <script>
        function showPassword() {
            var key_attr = $('#key').attr('type');

            if(key_attr != 'text') {

                $('.checkbox').addClass('show');
                $('#key').attr('type', 'text');

            } else {

                $('.checkbox').removeClass('show');
                $('#key').attr('type', 'password');

            }

        }
    </script>
</head>
<body>
<br>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-wrap">
                    <h1>Log in to the network</h1>
                    <form role="form" action="checklogin.php" method="post" id="login-form" autocomplete="off">
                        <?php echo '<input type="hidden" name="csrf" value="'. $csrf->getToken() .'" />'; ?>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="text" name="myusername" id="email" class="form-control" placeholder="username">
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input type="password" name="mypassword" id="key" class="form-control" placeholder="password">
                        </div>
                        <div class="checkbox">
                            <span class="character-checkbox" onclick="showPassword()"></span>
                            <span class="label">Show password</span>
                        </div>
                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" name="submit" value="Log in">
                    </form>
                    <div class="login-help">
                        <span style="font-size: small; ">To Register as a new user <a href="register.php">click here.</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>

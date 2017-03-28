<?php
require 'CSRF_Protect.php';
$connection = mysqli_connect('localhost', 'root', 'root', 'photoApp');
session_start();
$csrf = new CSRF_Protect();
?>
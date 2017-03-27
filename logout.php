<?php
include 'library.php';
unset($_SESSION['sessionVar']);
session_destroy();
header("location:index.php");
?>
<?php 
session_start();
if (isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in']=false;
}
include("landing.html");
if(isset($_POST['signup'])){
    header("Location: signup.php");
    exit();
}
if(isset($_POST['login'])){
    header("Location: login.php");
    exit();
}
if(isset($_POST['adminlogin'])){
    header("Location: adminlogin.php");
    exit();
}

?>
<?php
$pwd=$_POST["pwd"];
$email=$_POST["email"];
$user_name=$_POST["user_name"];
$pwd=password_hash($pwd, PASSWORD_BCRYPT);
require_once('../Models/user.class.php');
$user=new User();
$user->user_name=$user_name;
$user->email=$email;
$user->pwd=$pwd;
$user->new();
?>

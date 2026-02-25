<?php
require_once('../Utils/auth.php');
$_SESSION['req_page']="../../View/adminpanel.php";
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:../../View/login.php");
}
$pwd=$_POST["pwd"];
$email=$_POST["email"];
$user_name=$_POST["user_name"];
$pwd=password_hash($pwd, PASSWORD_BCRYPT);
require_once('../Models/user.class.php');
$user=new User();
$user->user_name=$user_name;
$user->email=$email;
$user->pwd=$pwd;
$user->admin=True;
if($user->email_used()){
	$_SESSION["ERROR"]="Email name is used.";
	header("location:../../View/newadmin_form.php");
}
elseif($user->user_name_used()){
	$_SESSION["ERROR"]="User name is used.";
	header("location:../../View/newadmin_form.php");
}else{
	$user->new();
	header("location:../../View/adminpanel.php");
}
?>

<?php
require_once('../../config.php');
$pwd=$_POST["pwd"];
$email=$_POST["email"];
$user_name=$_POST["user_name"];
$pwd=password_hash($pwd, PASSWORD_BCRYPT);
require_once('../Models/user.class.php');
$user=new User();
$user->user_name=$user_name;
$user->email=$email;
$user->pwd=$pwd;

require_once('../Utils/start_session.php');
if($user->email_used()){
	$_SESSION["ERROR"]="Email is used.";
	header("location:../../View/signup.php");
}
elseif($user->user_name_used()){
	$_SESSION["ERROR"]="User name is used.";
	header("location:../../View/signup.php");
}else{
	if($config["USER_EMAIL_VERF"]){
		$user->generate_activation_code();
		$user->send_activation_email();
	}
	$user->create();
	if($config["USER_EMAIL_VERF"])
		header("location:../../View/activate_your_account.php?user_name=$user_name");
	else
		header("location:../../View/login.php");

}
?>

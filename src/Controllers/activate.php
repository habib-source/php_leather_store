<?php
require_once('../Models/user.class.php');
require_once('../../config.php');
$user = new User();
$user->email=$_GET["email"];
$user_data=$user->get();
if($user->email_used() AND $user_data["activation_expiry"]>time() AND $user_data["activation_code"]==$_GET["activation_code"]){
	$user->activate_user();
	header("location:../../View/user_activated.php?user_name=".$user_data["user_name"]);
}elseif($user->email_used() AND $user->get()["activation_expiry"]>=time()){
	echo "Acrivation link expired <a href='/View/login.php'>log in</a> to get a new activation link.";
}else
	echo "Acrivation link not valid.";
?>

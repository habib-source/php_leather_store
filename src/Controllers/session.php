<?php
require_once('../Utils/start_session.php');
$pwd=$_POST["pwd"];
$email=$_POST["email"];
require_once('../Models/user.class.php');
$user=new User();
$user->email=$email;
$user->pwd=$pwd;
$v=$user->verify();
if($v){
	$_SESSION["connecte"]=TRUE;
	$data=$user->get();
	$_SESSION["user"]=$data["user_name"];
	$_SESSION["admin"]=$data["admin"];
	$_SESSION["active"]=$data["active"];
	if(isset($_SESSION['req_page'])
		header("location:".$_SESSION['req_page']);
	else{
		if($_SESSION["admin"])
			header("location:../../View/adminpanel.php");
		else
			header("location:../../View/leather_list.php");
	}
	exit();
}
else{
	$_SESSION["ERROR"]="Incorrect Email or Password";
	header("location:../../View/login.php");

}
?>

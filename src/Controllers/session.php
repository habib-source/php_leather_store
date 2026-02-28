<?php
require_once('../Utils/start_session.php');
$pwd=$_POST["pwd"];
$email=$_POST["email"];
require_once('../Models/user.class.php');
$user=new User();
$user->email=$email;
$user->pwd=$pwd;
if($user->email_used()){
	$v=$user->verify();
	if($v){
		$data=$user->get();
		if($data["active"]){
			$_SESSION["connecte"]=TRUE;
			$_SESSION["user"]=$data["user_name"];
			$_SESSION["admin"]=$data["admin"];
			$_SESSION["active"]=$data["active"];
			if(isset($_SESSION['req_page']))
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
			$user->generate_activation_code();
			$user->pwd='';
			$user->mod();
			$user->send_activation_email();
			header("location:../../View/activate_your_account.php?user_name=".$data["user_name"]);
		}

	}
	else{
		$_SESSION["ERROR"]="Incorrect Email or Password";
		header("location:../../View/login.php");

	}
}else{
	$_SESSION["ERROR"]="Incorrect Email or Password";
	header("location:../../View/login.php");

}
?>

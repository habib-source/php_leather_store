<?php
require_once('../Utils/auth.php');
Authentication();

require_once('../../config.php');
require_once('../Models/user.class.php');
$user=new User();
$user->user_name=$_SESSION["user"];
$data=$user->get();
$id=$data["id"];
if($id != $_POST["id"])
	exit("Operation not permetted", 1);
$user->id=$id;
$user->user_name=$_POST["user_name"] ?? null;
$user->first_name=$_POST["first_name"] ?? null;
$user->last_name=$_POST["last_name"] ?? null;
$user->email=$_POST["email"] ?? null;
$user->user_sex=$_POST["user_sex"] ?? null;
$user->birthday=$_POST["birthday"] ?? null;
if(!is_null($user->email) AND $user->email!=$data["email"] AND $user->email_used()){
	$_SESSION["ERROR"]="Email is used.";
	header("location:../../View/my_account.php");
}
elseif($user->user_name!=$data["user_name"] AND $user->user_name_used()){
	$_SESSION["ERROR"]="User name is used.";
	header("location:../../View/my_account.php");
}
if(!is_null($user->email) AND $user->email!=$data["email"] AND $config["USER_EMAIL_VERF"]){
	$user->active='FALSE';
	$_SESSION["active"]=FALSE;
	$user->generate_activation_code();
	$user->send_activation_email();
}
if($_FILES['photo']['size']!=0){
	if(isset($data["img_path"]) AND $data["img_path"]!='')
		unlink(__DIR__."/../../media/".$data["img_path"]);
	$im_name=$_FILES["photo"]["name"];
	$img_path=date("ymd_His").$im_name;
	$user->img_path= $img_path;
	move_uploaded_file($_FILES["photo"]["tmp_name"], __DIR__ ."/../../media/".$img_path);
}
$user->mod();
header("location:../../View/my_account.php");
?>

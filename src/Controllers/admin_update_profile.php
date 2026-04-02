<?php
require_once('../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../../config.php');
require_once('../Models/user.class.php');
$user=new User();
$user->id=$_POST["id"];
$id=$_POST["id"];
$data=$user->get();
$user->user_name=$_POST["user_name"] ?? null;
$user->active=$_POST["active"] ?? null;
$user->admin=$_POST["admin"] ?? null;
$user->first_name=$_POST["first_name"] ?? null;
$user->last_name=$_POST["last_name"] ?? null;
$user->email=$_POST["email"] ?? null;
$user->user_sex=$_POST["user_sex"] ?? null;
$user->birthday=$_POST["birthday"] ?? null;
if(!is_null($user->email) AND $user->email!=$data["email"] AND $user->email_used()){
	$_SESSION["ERROR"]="Email is used.";
	header("location:../../View/admin_modify_user.php?id=$id");
}
elseif($user->user_name!=$data["user_name"] AND $user->user_name_used()){
	$_SESSION["ERROR"]="User name is used.";
	header("location:../../View/admin_modify_user.php?id=$id");
}
if(!is_null($user->email) AND $user->email!=$data["email"] AND $config["USER_EMAIL_VERF"]){
	$user->active='FALSE';
}
if($_FILES['photo']['size']!=0){
	if(isset($data["img_path"]) AND $data["img_path"]!='')
		unlink(__DIR__."/../../media/".$data["img_path"]);
	$dest="img/";
	$im_name=$_FILES["photo"]["name"];
	$img_path=date("ymd_His").$im_name;
	$user->img_path= $img_path;
	move_uploaded_file($_FILES["photo"]["tmp_name"], __DIR__ ."/../../media/".$img_path);
}
$user->update();
header("location:../../View/list_users.php");
?>

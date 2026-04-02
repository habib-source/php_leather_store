<?php
require_once(__DIR__ .'/../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
require_once(__DIR__ .'/../Models/user.class.php');
$user=new User();
$id=$_GET["id"];
$img_path=$user->dynamic_get("img_path", array("id" => $id));
if(!is_null($img_path))
	unlink(__DIR__."/../../media/".$img_path);
$user->delete($id);
header('location:../../View/list_users.php');
?>

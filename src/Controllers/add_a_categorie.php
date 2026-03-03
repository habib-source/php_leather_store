<?php
require_once(__DIR__ .'/../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
require_once(__DIR__ .'/../Models/prod.class.php');
$prod=new Prod();
$id=$_GET['id'];
$prod->($id);
header('location:../../View/admin_list_products.php');
?>

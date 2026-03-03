<?php
require_once(__DIR__ .'/../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
require_once(__DIR__ .'/../Models/prod.class.php');
$prod=new Prod();
$prod->id=$_POST['id'];
$category_id=$_POST["category_id"];
if($prod->categorie_used($category_id)){
	$_SESSION['ERROR']="This categorie is alredy added";
	header('location:../../View/add_a_categorie.php?id='.$_POST["id"]);
}else{
	$prod->add_categorie($category_id);
	header('location:../../View/admin_list_products.php');
}
?>

<?php
require_once('../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:../../View/login.php");
}
require_once('../Models/categorie.class.php');
$categ=new Categorie();
$categ->name=$_POST["name"];
$categ->description=$_POST["description"];
if(!is_null($categ->name) AND $categ->name_used()){
	$_SESSION["ERROR"]="name is used.";
	header("location:../../View/admin_modify_categ.php?id=$id");
}
$categ->create();
header("location:../../View/admin_list_categories.php");
#}
?>

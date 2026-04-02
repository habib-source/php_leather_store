<?php
require_once('../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../../config.php');
require_once('../Models/categorie.class.php');
$categ=new Categorie();
$categ->id=$_POST["id"];
$id=$_POST["id"];
$data=$categ->get();
$categ->name=$_POST["name"] ?? null;
$categ->description=$_POST["description"] ?? null;
if(!is_null($categ->name) AND $categ->name!=$data["name"] AND $categ->name_used()){
	$_SESSION["ERROR"]="name is used.";
	header("location:../../View/admin_modify_categ.php?id=$id");
}
$categ->update();
header("location:../../View/admin_list_categories.php");
?>

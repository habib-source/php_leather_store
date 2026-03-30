<?php
require_once('../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:../../View/login.php");
}
require_once('../Models/prod.class.php');
$prod=new Prod();
$prod->name=$_POST["name"];
$prod->sku=$_POST["sku"];
$prod->description=$_POST["description"];
$prod->price=$_POST["price"];
$prod->stock_quantity=$_POST["stock_quantity"];
if(!is_null($prod->sku) AND $prod->sku_used()){
	$_SESSION["ERROR"]="sku is used.";
	header("location:../../View/admin_modify_prod.php?id=$id");
}
if($_FILES['photo']['size']!=0){
	$im_name=$_FILES["photo"]["name"];
	$img_path=date("ymd_His").$im_name;
	$prod->img_path= $img_path;
	move_uploaded_file($_FILES["photo"]["tmp_name"], __DIR__ ."/../../media/".$img_path);
}
$prod->create();
header("location:../../View/admin_list_products.php");
#}
?>

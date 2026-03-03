<?php
require_once('../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../../config.php');
require_once('../Models/prod.class.php');
$prod=new Prod();
$prod->id=$_POST["id"];
$id=$_POST["id"];
$data=$prod->get();
$prod->sku=$_POST["sku"] ?? null;
$prod->name=$_POST["name"] ?? null;
$prod->description=$_POST["description"] ?? null;
$prod->price=$_POST["price"] ?? null;
$prod->stock_quantity=$_POST["stock_quantity"] ?? null;
$prod->img_path=$_POST["img_path"] ?? null;
if(!is_null($prod->sku) AND $prod->sku!=$data["sku"] AND $prod->sku_used()){
	$_SESSION["ERROR"]="sku is used.";
	header("location:../../View/admin_modify_prod.php?id=$id");
}
if($_FILES['photo']['size']!=0){
	if(isset($data["img_path"]) AND $data["img_path"]!='')
		unlink(__DIR__."/../../media/".$data["img_path"]);
	$im_name=$_FILES["photo"]["name"];
	$img_path=date("ymd_His").$im_name;
	$prod->img_path= $img_path;
	move_uploaded_file($_FILES["photo"]["tmp_name"], __DIR__ ."/../../media/".$img_path);
}
$prod->mod();
header("location:../../View/admin_list_products.php");
?>

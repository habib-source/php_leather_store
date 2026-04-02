<?php
require_once(__DIR__ .'/../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
require_once(__DIR__ .'/../Models/order.class.php');
$order=new order();
$order->id=$_GET['id'];
$order->delete();
header('location:../../View/admin_list_orders.php');
?>

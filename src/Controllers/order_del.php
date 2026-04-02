<?php
require_once(__DIR__ .'/../Utils/auth.php');
Authentication();
require_once(__DIR__ .'/../Models/user.class.php');
$user=new User();
$user->user_name=$_SESSION['user'];
$user->id=$user->dynamic_get("id", array("user_name" => $user->user_name));
require_once(__DIR__ .'/../Models/order.class.php');
$order=new order();
$order->id=$_GET['id'];
$order->user_id=$order->get_target("user_id");
if($order->user_id==$user->id)
	$order->delete();
else
	setcookie('ERROR', "a User can only delete he's own orders");
header('location:../../View/user_orders_list.php');
?>

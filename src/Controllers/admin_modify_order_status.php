<?php
require_once('../Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../../config.php');
require_once('../Models/order.class.php');
$order=new Order();
$order->id=$_POST["id"];
$id=$_POST["id"];
$data=$order->get();
$order->status=$_POST["status"] ?? null;
$order->update();
require_once('../Models/user.class.php');
$user=new user();
$user->id=$data["user_id"];
$user->email=$user->dynamic_get("email", array("id" => $user->id));
$user->send_Status_update_email($order->status);
header("location:../../View/admin_list_orders.php");
?>

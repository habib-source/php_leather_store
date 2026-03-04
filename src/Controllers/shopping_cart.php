<?php
require_once(__DIR__ .'/../Utils/auth.php');
Authentication();
require_once(__DIR__ .'/../Models/user.class.php');
$user=new User();
$user->user_name=$_SESSION['user'];
$user->id=$user->dynamic_get("id", array("user_name" => $user->user_name));
$action=$_POST['action'];
if($action=='ADD to cart'){
$product_id=$_POST["id"];
$quantity=$_POST["quantity"];
if($user->exist_in_shopping_cart($product_id))
	$user->update_increment_prod_in_shopping_cart($product_id, $quantity);
else
	$user->add_to_shopping_cart($product_id, $quantity);
header('location:../../View/leather_list.php');
}elseif($action=='delete'){
$product_id=$_GET['id'];
if($user->exist_in_shopping_cart($product_id))
	$user->delete_from_shopping_cart($product_id);
header('location:../../View/leather_list.php');

}elseif($action=='update'){
$quantity=$_POST['quantity'];
foreach ($quantity as $product_id => $new_qty) {
	if($user->exist_in_shopping_cart($product_id))
		$user->update_prod_in_shopping_cart($product_id, $new_qty);
}
header('location:../../View/leather_list.php');
}elseif($action=='checkout'){
$quantity=$_POST['quantity'];
foreach ($quantity as $product_id => $new_qty) {
	if($user->exist_in_shopping_cart($product_id))
		$user->update_prod_in_shopping_cart($product_id, $new_qty);
	require_once(__DIR__ .'/../Models/prod.class.php');
	$prod=new Prod();
	$prod->id=$product_id;
	$prod_data=$prod->get();
	if($prod_data['stock_quantity']<$new_qty){
		setcookie('ERROR', "Only ".$prod_data['stock_quantity']." items available of ".$prod_data['name'].".", path: '/');
		header('location:../../View/leather_list.php');
		exit();
	}
}
header('location:../../View/leather_list.php');
}
?>

<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/adminpanel.php";
Authentication();
require_once(__DIR__ .'/../src/Models/user.class.php');
$user=new User();
$user->user_name=$_SESSION['user'];
$user->id=$user->dynamic_get("id", array("user_name" => $user->user_name));
require_once(__DIR__ .'/../src/Models/order.class.php');
$order=new order();
$order->id=$_GET['id'];
$order->user_id=$order->get_target("user_id");
if($order->user_id!=$user->id){
	setcookie('ERROR', "a User can only view he's own orders", path: '/');
	header('location:../../View/user_orders_list.php');
}
if(isset($_COOKIE['ERROR'])){
$ERROR=$_COOKIE['ERROR'];
setcookie('ERROR', '', time() - 3600, "/");
}
require_once(__DIR__.'/static/header.php');
?>
<h1><a href="./user_orders_list.php">Back to orders list</a></h1>
<table>
<caption>
<h1>Your order items:</h1>
</caption>
<?php
if(isset($ERROR)){
echo "<span style='color:red'>$ERROR</span><br>";
}
$order_items=$order->get_order_items();
?>
<tr>
<th>Image</th>
<th>Product</th>
<th>quantity</th>
<th>Price at purchase</th>
</tr>
<?php
foreach ($order_items as $i) {
require_once('../src/Models/prod.class.php');
$prod=new Prod();
$prod->id=$i["product_id"];
$prod_data=$prod->get();
echo "<tr>";
echo "<th><img width='200' src='/media/".$prod_data['img_path']."'></th>";
echo "<th>".$prod_data['name']."</th>";
echo "<th>".$i['quantity']."</th>";
echo "<th>".$i['price_at_purchase']."</th>";
echo "</tr>";
}
?>
</table>

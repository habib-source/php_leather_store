<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/adminpanel.php";
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
require_once(__DIR__.'/static/header.php');
?>
<table>
<caption>
<h1>CLients Orders list:</h1>
</caption>
<tr>
<th>Order ID</th>
<th>Client UserName</th>
<th>Total</th>
<th>Shipping addres</th>
<th>Status</th>
<th>Delete</th>
<th>Update</th>
</tr>
<?php

require_once('../src/Models/order.class.php');
$orders=new Order();
$res=$orders->get_all();

require_once('../src/Models/user.class.php');
$user=new user();

foreach ($res as $o) {
	$user_name=$user->dynamic_get("user_name", array("id" => $o['user_id']));
	echo "<tr>";
	echo "<td>".($o['id'] ?? 'NULL')."</td>";
	echo "<td>".($user_name ?? 'NULL')."</td>";
	echo "<td>".($o['total_amount'] ?? 'NULL')."</td>";
	echo "<td>".($o['shipping_address'] ?? 'NULL')."</td>";
	echo "<td>".($o['status'] ?? 'NULL')."</td>";
	echo "<td><a href='/src/Controllers/admin_order_del.php?id=".$o["id"]."'>Delete</a></td>";
	echo "<td><a href='admin_modify_order_status.php?id=".$o["id"]."'> Modify Status</a></td>";
	echo "<tr>";
}
?>
</table>

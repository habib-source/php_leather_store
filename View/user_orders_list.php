<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/adminpanel.php";
Authentication();
if(isset($_COOKIE['ERROR'])){
$ERROR=$_COOKIE['ERROR'];
setcookie('ERROR', '', time() - 3600, "/");
}
require_once(__DIR__.'/static/header.php');
?>
<table>
<caption>
<h1>Your orders:</h1>
</caption>
<?php
if(isset($ERROR)){
echo "<span style='color:red'>$ERROR</span><br>";
}
?>
<tr>
<th>Status</th>
<th>Sipping address</th>
<th>Total amount</th>
<th>Operation</th>
</tr>
<?php

require_once('../src/Models/user.class.php');
$user=new User();
$user->user_name=$_SESSION['user'];
$user->id=$user->dynamic_get("id", array("user_name" => $user->user_name));
$res=$user->get_orders();
foreach ($res as $o) {
	echo "<tr>";
	echo "<td>".($o['status'] ?? 'NULL')."</td>";
	echo "<td>".($o['shipping_address'] ?? 'NULL')."</td>";
	echo "<td>".($o['total_amount'] ?? 'NULL')."</td>";
	echo "<td><a href='/src/Controllers/order_del.php?id=".$o["id"]."'>Delete</a> <a href='order_details.php?id=".$o["id"]."'> Details</a>";
	echo "<tr>";
}
?>
</table>

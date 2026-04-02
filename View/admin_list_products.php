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
<h1>Products list:</h1>
</caption>
<tr>
<th>Product Picture</th>
<th>ID</th>
<th>SKU</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Stock quantity</th>
<th>Categories</th>
<th>Operation</th>
</tr>
<?php

require_once('../src/Models/prod.class.php');
$prod=new Prod();
$res=$prod->getAll();


foreach ($res as $p) {
	echo "<tr>";
	echo "<td><img width='200' src='../media/".$p['img_path']."'></td>";
	echo "<td>".($p['id'] ?? 'NULL')."</td>";
	echo "<td>".($p['sku'] ?? 'NULL')."</td>";
	echo "<td>".($p['name'] ?? 'NULL')."</td>";
	echo "<td>".($p['description'] ?? 'NULL')."</td>";
	echo "<td>".($p['price'] ?? 'NULL')."</td>";
	echo "<td>".($p['stock_quantity'] ?? 'NULL')."</td>";
	echo "<td>";
	foreach ($prod->get_categories($p['id']) as $c) {
		echo $c["name"]."<br>";
	}
	echo "</td>";
	echo "<td><a href='/src/Controllers/prod_del.php?id=".$p["id"]."'>Delete</a> <a href='admin_modify_prod.php?id=".$p["id"]."'> Modify</a> <br> <a href='add_a_categorie.php?id=".$p["id"]."'> Add a categorie</a>";
	echo "<tr>";
}
?>
</table>

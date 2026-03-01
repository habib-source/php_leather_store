<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/leather_list.php";
Authentication();
require_once(__DIR__.'/static/header.php');
?>
<table>
<caption>
<h1> Aur leather collection:</h1>
</caption>
<tr>
<th>Product Picture</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
</tr>
<?php

require_once('../src/Models/prod.class.php');
$prod=new Prod();
$res=$prod->get_all();


foreach ($res as $u) {
	echo "<tr>";
	echo "<td><img width='200' src='../media/".$u['img_path']."'></td>";
	echo "<td>".($u['name'] ?? 'NULL')."</td>";
	echo "<td>".($u['description'] ?? 'NULL')."</td>";
	echo "<td>".($u['price'] ?? 'NULL')."</td>";
	echo "<tr>";
}
?>
</table>

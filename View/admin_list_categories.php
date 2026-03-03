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
<h1>Categories list:</h1>
</caption>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Operation</th>
</tr>
<?php

require_once('../src/Models/categorie.class.php');
$categ=new Categorie();
$res=$categ->get_all();


foreach ($res as $p) {
	echo "<tr>";
	echo "<td>".($p['id'] ?? 'NULL')."</td>";
	echo "<td>".($p['name'] ?? 'NULL')."</td>";
	echo "<td>".($p['description'] ?? 'NULL')."</td>";
	echo "<td><a href='/src/Controllers/categorie_del.php?id=".$p["id"]."'>Delete</a> <a href='admin_modify_categorie.php?id=".$p["id"]."'> Modify</a>";
	echo "<tr>";
}
?>
</table>

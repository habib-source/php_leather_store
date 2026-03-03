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
<h2>Filtering And Sorting:</h2>
<form action="./leather_list.php" method="post">
	<label for="sort">Sort by:</label><br>
	<select name="sort" id="sort">
		<option value='price_DESC'>Prise high to low</option>
		<option value='price_ASC'>Prise low to high</option>
	</select>
	<label for="categories">Filter by categories:</label><br>
	<?php
	require_once('../src/Models/categorie.class.php');
	$categ=new Categorie();
	$res=$categ->get_all();
	foreach ($res as $c) {
		echo "<input type='checkbox' id='categories' name='categories[]' value='".$c['name']."'>".$c['name']."<br>";
	}
	?>
	<input type="submit"><br>
</form>
<tr>
<th>Product Picture</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
</tr>
<?php

require_once('../src/Models/prod.class.php');
$prod=new Prod();
$res=$prod->get_filtered_sorted($_POST["sort"] ?? null ,$_POST["categories"] ?? null );


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

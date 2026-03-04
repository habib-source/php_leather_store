<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/leather_list.php";
Authentication();
if(isset($_COOKIE['ERROR'])){
$ERROR=$_COOKIE['ERROR'];
setcookie('ERROR', '', time() - 3600, "/");
}
require_once(__DIR__.'/static/header.php');
?>
<h1> Shopping Cart:</h1>
<?php
require_once(__DIR__ .'/../src/Models/user.class.php');
$user=new User();
$user->user_name=$_SESSION['user'];
$user->id=$user->dynamic_get("id", array("user_name" => $user->user_name));
$cart_items=$user->get_shopping_cart();

?>
<form action="../src/Controllers/shopping_cart.php" method="post">
<?php
if(isset($ERROR)){
echo "<span style='color:red'>$ERROR</span><br>";
}
$total=0;
foreach ($cart_items as $i) {
require_once('../src/Models/prod.class.php');
$prod=new Prod();
$prod->id=$i["product_id"];
$data=$prod->get();
$total+=$data['price']*$i['quantity'];
echo "<b>".$data['name'].":</b>";
echo "<p>".$data['price']." USD</p>";
?>
	<label for="quantity">quantity:</label>
	<input type="number" name="quantity[<?php echo $i['product_id'];?>]" value="<?php echo $i['quantity']; ?>">
	<button type="submit" name="action" value="delete" formaction="../src/Controllers/shopping_cart.php?id=<?php echo $i['product_id']; ?>">X</button><br>
	<br>
<?php
}
?>
	<br>
	<b><?php echo $total?> USD</b>
	<input  type='hidden' id='total' name='total' value='<?php echo $total ?>'>
	<br>
	<br>
	<button type="submit" name="action" value="update">Update</button>
	<button type="submit" name="action" value="checkout">Checkout</button>
</form>
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
<th>Quantity</th>
<th></th>
</tr>
<?php

require_once('../src/Models/prod.class.php');
$prod=new Prod();
$res=$prod->get_filtered_sorted($_POST["sort"] ?? null ,$_POST["categories"] ?? null );


foreach ($res as $p) {
	echo "<tr>";
	echo "<td><img width='200' src='../media/".$p['img_path']."'></td>";
	echo "<td>".($p['name'] ?? 'NULL')."</td>";
	echo "<td>".($p['description'] ?? 'NULL')."</td>";
	echo "<td>".($p['price'] ?? 'NULL')." USD</td>";
	echo "<form action='../src/Controllers/shopping_cart.php' method='post'>";
	echo "<td><input type='number' id='quantity' name='quantity' min='1' max='100' value=1></td>";
	echo "<input  type='hidden' id='id' name='id' value=".$p['id'].">";
	echo "<td><input type='submit' name='action' value='ADD to cart'>";
	echo "</form>";
	echo "<tr>";
}
?>
</table>

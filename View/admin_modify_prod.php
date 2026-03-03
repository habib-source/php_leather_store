<?php
require_once('../src/Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../src/Models/prod.class.php');
$prod=new Prod();
$prod->id=$_GET["id"];
$prod_data=$prod->get();
require_once(__DIR__.'/static/header.php');
?>
<h1>Account informations:</h1>
<?php if(isset($_SESSION["ERROR"])){
  	$ERROR=$_SESSION["ERROR"];
	echo "<span style='color:red'>$ERROR</span>";
	unset($_SESSION['ERROR']);} ?>
<form action="../src/Controllers/admin_update_prod.php" method="post" enctype="multipart/form-data">
	<label for="id">ID: <?php echo $prod_data["id"]?></label><br>
	<input  type="hidden" id="id" name="id" <?php echo "value='".$prod_data["id"]."'"?> ><br>
      	<label for="name">Product name:</label><br>
	<input type="text" id="name" name="name" <?php if(!empty($prod_data["name"])) echo "value='".$prod_data["name"]."'"?>><br>
	<label for="sku">SKU:</label><br>
	<input type="text" id="sku" name="sku" <?php if(!empty($prod_data["sku"])) echo "value='".$prod_data["sku"]."'"?>><br>
	<label for="description">Description:</label><br>
	<textarea id="description" name="description"  rows="4" cols="50"> <?php if(!empty($prod_data["description"])) echo $prod_data["description"]; ?></textarea><br>
      	<label for="price">Price:</label><br>
      	<input type="number" id="price" name="price" <?php if(!empty($prod_data["price"])) echo "value='".$prod_data["price"]."'"?>><br>
	<label for="photo">Product Picture:</label><br>
	<?php if(isset($prod_data["img_path"])) echo "<img id='photo' width='300' src='../media/".$prod_data["img_path"]."'><br>"?>
	<label for="photo">Change the product Picture:</label><br>
	<input type="file" id="photo" name="photo"><br>
	<input type="submit" value="Update"><br>
</form>

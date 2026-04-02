<?php
require_once('../src/Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../src/Models/prod.class.php');
$prod=new Prod();
$id=$_GET["id"];
$prod_name=$prod->dynamic_get("name", array("id" => $id))->fetchColumn();
require_once('../src/Models/categorie.class.php');
$categ=new Categorie();
$res=$categ->getAll();
require_once(__DIR__.'/static/header.php');
echo "<h1>Add $prod_name to categorie:</h1>"
?>
<?php if(isset($_SESSION["ERROR"])){
  	$ERROR=$_SESSION["ERROR"];
	echo "<span style='color:red'>$ERROR</span>";
	unset($_SESSION['ERROR']);} ?>
<form action="../src/Controllers/add_categorie.php" method="post">
	<input  type="hidden" id="id" name="id" <?php echo "value='".$id."'"?> ><br>
      	<label for="category_id">Categorie:</label><br>
	<select name="category_id" id="category_id">
	<?php
	foreach ($res as $c) {
		echo "<option value='".$c["id"]."'>".$c["name"]."</option>";
	}
	?>
	</select>
	<input type="submit" value="Update"><br>
</form>

<?php
require_once('../src/Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}

require_once('../src/Models/categorie.class.php');
$categ=new Categorie();
$categ->id=$_GET["id"];
$categ_data=$categ->get();
require_once(__DIR__.'/static/header.php');
?>
<h1>Account informations:</h1>
<?php if(isset($_SESSION["ERROR"])){
  	$ERROR=$_SESSION["ERROR"];
	echo "<span style='color:red'>$ERROR</span>";
	unset($_SESSION['ERROR']);} ?>
<form action="../src/Controllers/admin_update_categorie.php" method="post" enctype="multipart/form-data">
	<label for="id">ID: <?php echo $categ_data["id"]?></label><br>
	<input  type="hidden" id="id" name="id" <?php echo "value='".$categ_data["id"]."'"?> ><br>
      	<label for="name">Categorie name:</label><br>
	<input type="text" id="name" name="name" <?php if(!empty($categ_data["name"])) echo "value='".$categ_data["name"]."'"?>><br>
	<label for="description">Description:</label><br>
	<textarea id="description" name="description"  rows="4" cols="50"> <?php if(!empty($categ_data["description"])) echo $categ_data["description"]; ?></textarea><br>
	<input type="submit" value="Update"><br>
</form>

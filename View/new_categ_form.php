<?php
require_once('../src/Utils/auth.php');
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
?>
<body>

<?php
require_once(__DIR__.'/static/header.php');
?>
  <h1>New Product:</h1>
      <form action="../src/Controllers/newcategorie.php" method="post">
      	<label for="name">Categorie name:</label><br>
      	<input type="text" id="name" name="name" ><br>
      	<label for="description">Description:</label><br>
	<textarea id="description" name="description" rows="4" cols="50">
	</textarea><br>
      	<input type="submit"><br>
      </form>
</body>

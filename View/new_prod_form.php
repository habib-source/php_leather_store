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
      <form action="../src/Controllers/newproduct.php" method="post" enctype="multipart/form-data">
      	<label for="name">Product name:</label><br>
      	<input type="text" id="name" name="name" ><br>
      	<label for="sku">Product sku:</label><br>
      	<input type="text" id="sku" name="sku" ><br>
      	<label for="description">Description:</label><br>
	<textarea id="description" name="description" rows="4" cols="50">
	</textarea><br>
      	<label for="price">Price:</label><br>
      	<input type="number" id="price" name="price" ><br>
      	<label for="stock_quantity">Stock quantity:</label><br>
      	<input type="number" id="stock_quantity" name="stock_quantity" ><br>
	<label for="photo">Product Picture:</label><br>
	<input type="file" id="photo" name="photo"><br>
      	<input type="submit"><br>
      </form>
</body>

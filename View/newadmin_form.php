<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/adminpanel.php";
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
?>
<body>
  <h1>New Admin user:</h1>
      <form action="../src/Controllers/newadmin.php" method="post" enctype="multipart/form-data">
      	<label for="user_name">User name:</label><br>
      	<input type="text" id="user_name" name="user_name" ><br>
      	<label for="email">Email:</label><br>
      	<input type="email" id="email" name="email" ><br>
      	<label for="pwd">Password:</label><br>
      	<input type="password" id="pwd" name="pwd" ><br>
      	<input type="submit" value="Envoyer"><br>
      </form>
</body>

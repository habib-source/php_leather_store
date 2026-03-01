<?php require_once('../src/Utils/start_session.php');
?>
<body>
<?php
require_once(__DIR__.'/static/header.php');
?>
  <h1>Login:</h1>
<?php if(isset($_SESSION["ERROR"])){
  	$ERROR=$_SESSION["ERROR"];
	echo "<span style='color:red'>$ERROR</span>";
	unset($_SESSION['ERROR']);} ?>
      <form action="../src/Controllers/session.php" method="post" enctype="multipart/form-data">
      	<label for="email">Email:</label><br>
      	<input type="email" id="email" name="email" ><br>
      	<label for="pwd">Password:</label><br>
      	<input type="password" id="pwd" name="pwd" ><br>
      	<input type="submit" value="Envoyer"><br>
      </form>
</body>

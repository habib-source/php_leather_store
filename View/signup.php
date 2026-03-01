<?php require_once('../src/Utils/start_session.php');?>
<body>
  <h1>Sign UP:</h1>
<?php
if(isset($_SESSION["ERROR"])){
$ERROR=$_SESSION["ERROR"];
echo "<span style='color:red'>$ERROR</span>";
unset($_SESSION['ERROR']);
}
require_once(__DIR__.'/static/header.php');
?>
      <form action="../src/Controllers/newuser.php" method="post" enctype="multipart/form-data">
      	<label for="user_name">User name:</label><br>
      	<input type="text" id="user_name" name="user_name" ><br>
      	<label for="email">Email:</label><br>
      	<input type="email" id="email" name="email" ><br>
      	<label for="pwd">Password:</label><br>
      	<input type="password" id="pwd" name="pwd" ><br>
      	<input type="submit" value="Envoyer"><br>
      </form>
</body>

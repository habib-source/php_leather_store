<?php
if(!isset($_GET["user_name"]))
	header("location:signup.php");
?>
<p>Thank you <?php echo $_GET["user_name"] ?> for activating your accoutnt you can new <a href=login.php>Login</a></p>

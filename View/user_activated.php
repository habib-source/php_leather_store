<?php
if(!isset($_GET["user_name"]))
	header("location:signup.php");
require_once(__DIR__.'/static/header.php');
?>
<p>Thank you <?php echo $_GET["user_name"] ?> for activating your accoutnt you can new <a href=login.php>Login</a></p>

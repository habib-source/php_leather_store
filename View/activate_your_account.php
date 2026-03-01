<?php
if(!isset($_GET["user_name"]))
	header("location:signup.php");
require_once(__DIR__.'/static/header.php');
?>
<p>Thank you <?php echo $_GET["user_name"] ?> for Joining the Leather store where you will find only the highest quality Wilde hide leather products</p>
<p>Please check your email inbox for the activation link to contunie using our store.</p>

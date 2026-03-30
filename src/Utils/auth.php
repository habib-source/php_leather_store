<?php
function Authentication (){
	$config = require_once(__DIR__ .'/../../config.php');
	require_once('start_session.php');
	if (!isset($_SESSION['connecte']) OR !$_SESSION['connecte'] OR (!$_SESSION["active"] AND $config["USER_EMAIL_VERF"])) {
	    header("Location: login.php");
	    exit();
	}
}

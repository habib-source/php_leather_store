<?php
function Authentication (){
	require_once('start_session.php');
	if (!isset($_SESSION['connecte']) OR !$_SESSION['connecte'] OR !$_SESSION["active"]) {
	    header("Location: login.php");
	    exit();
	}
}

<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/adminpanel.php";
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
?>
<h1>Welcome to the admine panel</p>
<a href="./list_users.php">Manage users</a><br>
<a href="./newadmin_form.php">New Admin account</a>

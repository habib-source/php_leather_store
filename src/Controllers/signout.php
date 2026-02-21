<?php
require_once('../Utils/start_session.php');
session_destroy();
header("location:../../View/login.php");
?>

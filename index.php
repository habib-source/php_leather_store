<?php
require_once('./src/Utils/start_session.php');
if(isset($_SESSION["connecte"]) AND $_SESSION["connecte"]){
?>
<a href="./src/Controllers/signout.php">Sign out</a><br>
<a href="./View/my_account.php">My Account</a><br>
<a href="./View/user_orders_list.php">My Orders</a><br>
<?php if($_SESSION["admin"]){ ?>
<br>
<br>
<a href="./View/adminpanel.php">Admin panel</a><br>
<br>
<br>
<?php
}
}else{
?>
<h1><a href="./View/signup.php">Sign up</a></h1><br>
<h1><a href="./View/login.php">Login</a></h1>
<?php
}
?>
<h2>i love leather</h2>
<h1><a href="./View/leather_list.php">View our leather collection</a></h1>

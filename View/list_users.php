<?php
require_once('../src/Utils/auth.php');
$_SESSION['req_page']="../../View/adminpanel.php";
Authentication();
if(!$_SESSION["admin"]){
	$_SESSION["ERROR"]="Unauthorized you must use a admin accaunt.";
	header("location:login.php");
}
require_once(__DIR__.'/static/header.php');
?>
<table>
<caption>
<h1>Users list:</h1>
</caption>
<tr>
<th>Profile Picture</th>
<th>ID</th>
<th>Email</th>
<th>User name</th>
<th>Active</th>
<th>Admin</th>
<th>First name</th>
<th>Last name</th>
<th>User sexe</th>
<th>Birthday</th>
<th>Operation</th>
</tr>
<?php

require_once('../src/Models/user.class.php');
$user=new User();
$res=$user->getAll();


foreach ($res as $u) {
	echo "<tr>";
	echo "<td><img width='200' src='../media/".$u['img_path']."'></td>";
	echo "<td>".$u['id']."</td>";
	echo "<td>".$u['email']."</td>";
	echo "<td>".$u['user_name']."</td>";
	echo "<td>".($u['active'] ? 1:0)."</td>";
	echo "<td>".($u['admin'] ? 1:0)."</td>";
	echo "<td>".($u['first_name'] ?? 'NULL')."</td>";
	echo "<td>".($u['last_name'] ?? 'NULL')."</td>";
	echo "<td>".($u['user_sex'] ?? 'NULL')."</td>";
	echo "<td>".($u['birthday'] ?? 'NULL')."</td>";
	echo "<td><a href='/src/Controllers/user_del.php?id=".$u["id"]."'>Delete</a> <a href='admin_modify_user.php?id=".$u["id"]."'> Modify</a>";
	echo "<tr>";
}
?>
</table>

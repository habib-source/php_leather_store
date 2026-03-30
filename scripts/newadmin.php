<?php
if (php_sapi_name() !== 'cli') {
    header("HTTP/1.1 403 Forbidden");
    exit("This script can only be run from the command line.");
}
$user_name=$argv[1];
$email=$argv[2];
$pwd=$argv[3];
$pwd=password_hash($pwd, PASSWORD_BCRYPT);
require_once(__DIR__ .'/../src/Models/user.class.php');
$user=new User();
$user->user_name=$user_name;
$user->email=$email;
$user->pwd=$pwd;
$user->admin=True;
$user->active=True;
if($user->email_used() OR $user->user_name_used()){
	exit("--user exist--");
}else{
	$user->create();
}
?>

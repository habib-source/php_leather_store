<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class User{
public $id;
public $user_name;
public $email;
public $pwd;
public $active;
public $admin;
public $first_name;
public $last_name;
public $user_sex;
public $birthday;
public $img_path;
private $activation_code;
private $activation_expiry;
private $config;
function __construct() {
	include(__DIR__ ."/../../config.php");
	$this->config = $config;
}

function new(){
	$data = [
		'user_name'  		=> $this->user_name,
		'email'      		=> $this->email,
		'pwd'        		=> $this->pwd,
		'active'     		=> $this->active,
		'activation_code'	=> $this->activation_code,
		'activation_expiry'	=> $this->activation_expiry,
		'admin'      		=> $this->admin,
		'first_name' 		=> $this->first_name,
		'last_name'  		=> $this->last_name,
		'user_sex'   		=> $this->user_sex,
		'birthday' 		=> $this->birthday,
		'img_path'   		=> $this->img_path
	];
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$filtered = array_filter($data, fn($value) => !is_null($value) && $value !== '');
	$columns = implode(', ', array_keys($filtered));
	$placeholders = ':' . implode(', :', array_keys($filtered));
	$req = "INSERT INTO users ($columns) VALUES ($placeholders)";
	$sth=$pdo->prepare($req);
        $sth->execute($filtered) or print_r($pdo->errorInfo());
}

function verify(){
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT pwd FROM users where email='$this->email'";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$p=$res->fetch(PDO::FETCH_LAZY);
	$v=password_verify($this->pwd,$p["pwd"]);
	return $v;
}

function list(){
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM users";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function dynamic_get($target, $ident){
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	reset($ident);
	$req="SELECT ".$target." FROM users where ".key($ident)."='".current($ident)."'";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$data= $res->fetch(PDO::FETCH_LAZY);
	return $data[$target];
}

function get(){
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	if(!is_null($this->id) AND $this->id!='')
		$req="SELECT * FROM users where id='$this->id'";
	elseif(!is_null($this->email) AND $this->email!='')
		$req="SELECT * FROM users where email='$this->email'";
	elseif(!is_null($this->user_name) AND $this->user_name!='')
		$req="SELECT * FROM users where user_name='$this->user_name'";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$data= $res->fetch(PDO::FETCH_LAZY);
	return $data;
}

function get_all(){
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM users";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function mod(){
	$this->id=$this->get()["id"];
	$data = [
		'user_name'  		=> $this->user_name,
		'email'      		=> $this->email,
		'pwd'        		=> $this->pwd,
		'active'     		=> $this->active,
		'activation_code'	=> $this->activation_code,
		'activation_expiry'	=> $this->activation_expiry,
		'admin'      		=> $this->admin,
		'first_name' 		=> $this->first_name,
		'last_name'  		=> $this->last_name,
		'user_sex'   		=> $this->user_sex,
		'birthday' 		=> $this->birthday,
		'img_path'   		=> $this->img_path
	];
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$filtered = array_filter($data, fn($value) => !is_null($value) && $value !== '');
	$setPart = [];
   	foreach (array_keys($filtered) as $key) {
   		$setPart[] = "$key = :$key";
   	}
   	$setString = implode(', ', $setPart);
	$req = "UPDATE users SET $setString WHERE id=$this->id";
	$sth=$pdo->prepare($req);
        $sth->execute($filtered) or print_r($pdo->errorInfo());
}

function del($id){
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="DELETE FROM users WHERE id=$id";
	$pdo->exec($req);
}

function email_used()
{
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req= "SELECT count(*) FROM users WHERE email='$this->email' " ;
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res->fetchColumn(0)==1;
}

function user_name_used()
{
	require_once(__DIR__ .'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req= "SELECT count(*) FROM users WHERE user_name='$this->user_name' " ;
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res->fetchColumn(0)==1;
}
function generate_activation_code(){
	$this->activation_code = bin2hex(random_bytes(16));
	$this->activation_expiry = date('Y-m-d H:i:s',  time() + $this->config["ACTIVATION_EXPIRY_PERIOD"]);
}

function send_activation_email(){
	$activation_link = $this->config["URL"] . "src/Controllers/activate.php?email=".$this->email."&activation_code=".$this->activation_code;
    	require  __DIR__ ."/../../".$this->config["VENDOR_DIR"].'/autoload.php';
    	$mail = new PHPMailer(true);
	try {
		$mail->isSMTP();
		$mail->Host = $this->config["EMAIL_HOST"];
		$mail->Port = $this->config["EMAIL_HOST_PORT"];
		if($this->config["EMAIL_HOST_PORT"]==465 OR
			(isset($this->config["EMAIL_HOST_TLS_OPTION"]) AND $this->config["EMAIL_HOST_TLS_OPTION"]=="SMTPS"))
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		elseif($this->config["EMAIL_HOST_PORT"]==587 OR $this->config["EMAIL_HOST_TLS_OPTION"]=="STARTTLS")
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->SMTPAuth = true;
		$mail->Username = $this->config["EMAIL"];
		$mail->Password = $this->config["EMAIL_PASSWORD"];
		$mail->setFrom($this->config["EMAIL"], $this->config["EMAIL_SENDER_NAME"]);
		$mail->addAddress($this->email, $this->user_name);
		$mail->Subject = 'Activate your account';
		$mail->Body    = "Click <a href=".$activation_link.">HERE</a> to activate your account";
    		$mail->AltBody = 'Click the following link to activate your account:'.$activation_link;
		$mail->send();
	} catch (Exception) {
	    	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
function activate_user(){
	$this->active=TRUE;
	$this->mod();
}
} ?>

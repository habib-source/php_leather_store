<?php
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
public $date_naiss;
public $img_path;

function new(){
	$data = [
		'user_name'  => $this->user_name,
		'email'      => $this->email,
		'pwd'        => $this->pwd,
		'active'     => $this->active,
		'admin'      => $this->admin,
		'first_name' => $this->first_name,
		'last_name'  => $this->last_name,
		'user_sex'   => $this->user_sex,
		'date_naiss' => $this->date_naiss,
		'img_path'   => $this->img_path
	];
	require_once('../Utils/pdo.php');
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
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT pwd FROM users where email='$this->email'";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$p=$res->fetch(PDO::FETCH_LAZY);
	$v=password_verify($this->pwd,$p["pwd"]);
	return $v;
}

function list(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM users";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}


function get(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM users where email='$this->email'";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$data= $res->fetch(PDO::FETCH_LAZY);
	return $data;
}

function mod($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="UPDATE users SET user_name='$this->user_name',email='$this->email',pws='$this->pwd',admin='$this->admin',first_name='$this->first_name',
		last_name='$this->last_name',user_sex='$this->user_sex',date_naiss'$this->date_naiss','$this->img_path' WHERE id=$id";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function del($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();

	$req="DELETE FROM etudiant WHERE id=$id";
	$pdo->exec($req);
}
} ?>

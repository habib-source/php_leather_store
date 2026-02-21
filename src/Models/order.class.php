<?php
class Order{
public $id;
public $total_amount;
public $status;
public $shipping_address;
public $user_id;
function new(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="INSERT INTO orders (total_amount,status,shipping_address,user_id) VALUES
		($this->total_amount,'$this->status','$this->shipping_address',$this->user_id)";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function list(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM orders";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}


function get($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM orders where id=$id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function mod($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="UPDATE orders SET total_amount=$this->total_amount,status='$this->status',
		shipping_address='$this->shipping_address',user_id=$this->user_id WHERE id=$id";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function del($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="DELETE FROM orders WHERE id=$id";
	$pdo->exec($req);
}
} ?>

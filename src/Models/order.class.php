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
		($this->total_amount,'$this->status','$this->shipping_address',$this->user_id) RETURNING id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$this->id=$res->fetchColumn();
}

function add_a_item($product_id, $quantity, $price_at_purchase){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req = "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES ($this->id,$product_id,$quantity, $price_at_purchase)";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function get_target($target){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT ".$target." FROM orders where id=$this->id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$data= $res->fetch(PDO::FETCH_LAZY);
	return $data[$target];
}


function get_all(){
	require_once(__DIR__.'/../Utils/pdo.php');
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

function get_order_items(){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req = "SELECT * from order_items where order_id =".$this->id;
	$data=$pdo->query($req) or print_r($pdo->errorInfo());
	return $data;
}

function del(){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="DELETE FROM orders WHERE id=$this->id";
	$pdo->exec($req);
}
} ?>

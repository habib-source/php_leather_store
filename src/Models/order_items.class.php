<?php
class OrderItems{
public $id;
public $order_id;
public $product_id;
public $quantity;
public $price_at_purchase;
function new(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="INSERT INTO order_items (order_id,product_id,quantity,price_at_purchase) VALUES
		($this->order_id,$this->product_id,$this->quantity,$this->price_at_purchase)";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function list(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM order_items";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}


function get($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM order_items where id=$id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function mod($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="UPDATE order_items SET order_id=$this->order_id,product_id=$this->product_id,
		quantity=$this->quantity,price_at_purchase=$this->price_at_purchase WHERE id=$id";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function del($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="DELETE FROM order_items WHERE id=$id";
	$pdo->exec($req);
}
} ?>

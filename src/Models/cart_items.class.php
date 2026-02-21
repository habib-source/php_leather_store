<?php
class CartItems{
public $id;
public $user_id;
public $product_id;
public $quantity;
function new(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="INSERT INTO cart_items (user_id,product_id,quantity) VALUES
		($this->user_id,$this->product_id,$this->quantity)";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function list(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM cart_items";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}


function get($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM cart_items where id=$id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function mod($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="UPDATE cart_items SET user_id=$this->user_id,product_id=$this->product_id,
		quantity=$this->quantity WHERE id=$id";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function del($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="DELETE FROM cart_items WHERE id=$id";
	$pdo->exec($req);
}
} ?>

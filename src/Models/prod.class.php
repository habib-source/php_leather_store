<?php
class Prod{
public $id;
public $sku;
public $name;
public $description;
public $price;
public $stock_quantity;
public $category_id;
function new(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="INSERT INTO products (sku,name,description,price,stock_quantity,category_id) VALUES
		('$this->sku','$this->name','$this->description',$this->price,$this->stock_quantity,$this->category_id)";

	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function list(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM products";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}


function get($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM products where id=$id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function mod($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="UPDATE products SET sku='$this->sku',name='$this->name',description='$this->description',price=$this->price,stock_quantity=$this->stock_quantity,category_id=$this->category_id WHERE id=$id";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function del($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();

	$req="DELETE FROM products WHERE id=$id";
	$pdo->exec($req);
}
} ?>

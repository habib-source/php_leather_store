<?php
class Categorie{
public $id;
public $name;
public $description;
function new(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="INSERT INTO categories (name,description) VALUES
		('$this->name','$this->description')";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function list(){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM categories";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}


function get($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM categories where id=$id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function mod($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="UPDATE categories SET name='$this->name',description='$this->description' WHERE id=$id";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function del($id){
	require_once('../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="DELETE FROM categories WHERE id='$id'";
	$pdo->exec($req);
}
} ?>

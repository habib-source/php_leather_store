<?php
class Categorie{
public $id;
public $name;
public $description;
public function getData() {
        return [
            	'name'           => $this->name,
            	'description'    => $this->description,
        ];
}
function new(){
	$data =$this->getData();
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$filtered = array_filter($data, fn($value) => !is_null($value) && $value !== '');
	$columns = implode(', ', array_keys($filtered));
	$placeholders = ':' . implode(', :', array_keys($filtered));
	$req = "INSERT INTO categories ($columns) VALUES ($placeholders)";
	$sth=$pdo->prepare($req);
        $sth->execute($filtered) or print_r($pdo->errorInfo());
}

function list(){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM categories";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function dynamic_get($target, $ident){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	reset($ident);
	$req="SELECT ".$target." FROM categories where ".key($ident)."='".current($ident)."'";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function get(){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM categories where id=$this->id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function get_all(){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM categories";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function get_column($column){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT $column FROM categories";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function mod(){
	$this->id=$this->get()["id"];
	$data = $this->getData();
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$filtered = array_filter($data, fn($value) => !is_null($value) && $value !== '');
	$setPart = [];
   	foreach (array_keys($filtered) as $key) {
   		$setPart[] = "$key = :$key";
   	}
   	$setString = implode(', ', $setPart);
	$req = "UPDATE categories SET $setString WHERE id=$this->id";
	$sth=$pdo->prepare($req);
        $sth->execute($filtered) or print_r($pdo->errorInfo());
}

function del($id){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="DELETE FROM categories WHERE id='$id'";
	$pdo->exec($req);
}

function name_used(){
	$res=$this->dynamic_get("name", array("name" => $this->name));
	return $res->rowCount()==1;
}
} ?>

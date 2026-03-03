<?php
class Prod{
public $id;
public $sku;
public $name;
public $description;
public $price;
public $stock_quantity;
public $img_path;
public function getData() {
        return [
        	'sku'            => $this->sku,
            	'name'           => $this->name,
            	'description'    => $this->description,
            	'price'          => $this->price,
            	'stock_quantity' => $this->stock_quantity,
            	'img_path'       => $this->img_path
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
	$req = "INSERT INTO products ($columns) VALUES ($placeholders)";
	$sth=$pdo->prepare($req);
        $sth->execute($filtered) or print_r($pdo->errorInfo());
}

function list(){
	require_once(__DIR__.'/.../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM products";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function dynamic_get($target, $ident){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	reset($ident);
	$req="SELECT ".$target." FROM products where ".key($ident)."='".current($ident)."'";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function get(){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM products where id=$this->id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	$data= $res->fetch(PDO::FETCH_LAZY);
	return $data;
}

function get_all(){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT * FROM products";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res;
}

function get_filtered_sorted($sort, $categories) {
    require_once(__DIR__.'/../Utils/pdo.php');
    $cnx = new connexion();
    $pdo = $cnx->CNXbase();
    $params = [];
    $has_categories = !empty($categories);
    if ($has_categories) {
        $placeholders = implode(',', array_fill(0, count($categories), '?'));
        $sql = "SELECT p.* FROM products p
                JOIN products_categories pc ON p.id = pc.product_id
                JOIN categories c ON pc.category_id = c.id
                WHERE c.name IN ($placeholders)
                GROUP BY p.id
                HAVING COUNT(DISTINCT c.name) = ?";
        $params = array_values($categories);
        $params[] = count($categories);
    } else {
        $sql = "SELECT * FROM products";
    }
    if (isset($sort)) {
        if ($sort === "price_DESC") {
            $sql .= " ORDER BY price DESC";
        } elseif ($sort === "price_ASC") {
            $sql .= " ORDER BY price ASC";
        }
    }
    if ($has_categories) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } else {
        return $pdo->query($sql);
    }
}

function add_categorie($category_id){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req = "INSERT INTO products_categories (category_id, product_id) VALUES ($category_id,".$this->id.")";
	$pdo->exec($req) or print_r($pdo->errorInfo());
}

function categorie_used($id){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req= "SELECT count(*) FROM products_categories WHERE category_id=$id AND product_id=$this->id";
	$res=$pdo->query($req) or print_r($pdo->errorInfo());
	return $res->fetchColumn()==1;
}

function get_categories($id){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();
	$req="SELECT DISTINCT c.name FROM products p, products_categories pc, categories c where p.id=pc.product_id AND pc.category_id=c.id AND p.id=$id";
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
	$req = "UPDATE products SET $setString WHERE id=$this->id";
	$sth=$pdo->prepare($req);
        $sth->execute($filtered) or print_r($pdo->errorInfo());
}

function del($id){
	require_once(__DIR__.'/../Utils/pdo.php');
	$cnx=new connexion();
	$pdo=$cnx->CNXbase();

	$req="DELETE FROM products WHERE id=$id";
	$pdo->exec($req);
}

function sku_used(){
	$res=$this->dynamic_get("name", array("sku" => $this->sku));
	return $res->rowCount()==1;
}
} ?>

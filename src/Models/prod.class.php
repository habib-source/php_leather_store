<?php
require_once(__DIR__ .'/../Utils/pdo.php');
class Prod{
public ?int $id = NULL;
public ?string $sku = NULL;
public ?string $name = NULL;
public ?string $description = NULL;
public ?int $price = NULL;
public ?int $stock_quantity = NULL;
public ?string $img_path = NULL;
private PDO $pdo;

public function __construct(?PDO $pdo = null) {
	$this->pdo ??= (new connexion())->CNXbase();
}

private function getData(): ?array {
        return  array_filter([
        	'sku'            => $this->sku,
            	'name'           => $this->name,
            	'description'    => $this->description,
            	'price'          => $this->price,
            	'stock_quantity' => $this->stock_quantity,
            	'img_path'       => $this->img_path
        ], fn($value) => !is_null($value) && $value !== '');
}

public function create(){
	$data =$this->getData();
	$columns = implode(', ', array_keys($data));
	$placeholders = ':' . implode(', :', array_keys($data));
	$req = "INSERT INTO products ($columns) VALUES ($placeholders)";
	$sth=$this->pdo->prepare($req);
        $sth->execute($data);
}

public function dynamic_get($target, $ident): ?string {
        $column = key($ident);
        $value = current($ident);
        $stmt = $this->pdo->prepare("SELECT $target FROM products WHERE $column = :val");
        $stmt->execute(['val' => $value]);
        return $stmt;
}

public function get(): ?array {
	$req="SELECT * FROM products where id = :id";
	$stmt=$this->pdo->prepare($req);
	$stmt->execute(['id' => $this->id]);
	return $stmt->fetch();
}

public function get_all(): ?array{
	$req="SELECT * FROM products";
	$res=$this->pdo->query($req);
	return $res->fetchAll();
}

public function get_filtered_sorted($sort, $categories): ?array {
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
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } else {
        return $this->pdo->query($sql)->fetchAll();
    }
}

public function add_categorie($category_id){
	$req = "INSERT INTO products_categories (category_id, product_id) VALUES (:category_id, :id)";
	$stmt=$this->pdo->prepare($req);
    	$stmt->execute([
    		'id'    => $this->id,
    		'category_id' => $category_id
    	]);
}

public function categorie_used($category_id): bool {
	$req= "SELECT count(*) FROM products_categories WHERE category_id = :category_id AND product_id = :id";
	$stmt=$this->pdo->prepare($req);
    	$stmt->execute([
    		'category_id' => $category_id,
    		'id'    => $this->id
    	]);
	return $stmt->fetchColumn()==1;
}

public function get_categories($id): ?array {
	$req="SELECT DISTINCT c.name FROM products p, products_categories pc, categories c where p.id=pc.product_id AND pc.category_id=c.id AND p.id = :id";
	$stmt=$this->pdo->prepare($req);
	$stmt->execute(['id' => $id]);
	return $stmt->fetchAll();
}

public function mod(){
	$this->id=$this->get()["id"];
	$data = $this->getData();
	$setPart = [];
   	foreach (array_keys($data) as $key) {
   		$setPart[] = "$key = :$key";
   	}
   	$setString = implode(', ', $setPart);
	$req = "UPDATE products SET $setString WHERE id = :id";
	$params = array_merge($data, ['id' => $this->id]);
	$sth=$this->pdo->prepare($req);
        $sth->execute($params);
}

public function del($id) {

	$req="DELETE FROM products WHERE id = :id";
	$stmt=$this->pdo->prepare($req);
	$stmt->execute(['id' => $id]);
}

public function sku_used(): bool {
	$res=$this->dynamic_get("name", array("sku" => $this->sku));
	return $res->rowCount()==1;
}
} ?>

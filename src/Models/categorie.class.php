<?php
require_once(__DIR__ .'/../Utils/pdo.php');
class Categorie{
public ?int $id = NULL;
public ?string $name = NULL;
public ?string $description = NULL;
private PDO $pdo;

public function __construct(?PDO $pdo = null) {
	$this->pdo ??= (new connexion())->CNXbase();
}

private function getData(): ?array {
        return array_filter([
            	'name'           => $this->name,
            	'description'    => $this->description,
        ], fn($value) => !is_null($value) && $value !== '');
}

public function create(){
	$data =$this->getData();
	$columns = implode(', ', array_keys($data));
	$placeholders = ':' . implode(', :', array_keys($data));
	$req = "INSERT INTO categories ($columns) VALUES ($placeholders)";
	$sth=$this->pdo->prepare($req);
        $sth->execute($data);
}

public function list(): ?array {
	$req="SELECT * FROM categories";
	$res=$this->pdo->query($req);
	return $res->fetchAll();
}

public function dynamic_get($target, $ident): ?array {
        $column = key($ident);
        $value = current($ident);
        $stmt = $this->pdo->prepare("SELECT $target FROM categories WHERE $column = :val");
        $stmt->execute(['val' => $value]);
        return $stmt->fetchAll();
}

public function get(): ?array {
	$req="SELECT * FROM categories where id = :id";
	$stmt=$this->pdo->prepare($req);
	$stmt->execute(['id' => $id]);
	return $stmt->fetchAll();
}

public function get_all(): ?array{
	$req="SELECT * FROM categories";
	$res=$this->pdo->query($req);
	return $res->fetchAll();
}

public function get_column($column): ?array{
	$req="SELECT $column FROM categories";
	$res=$this->pdo->query($req);
	return $res->fetchAll();
}

public function mod(){
	$this->id=$this->get()["id"];
	$data = $this->getData();
	$setPart = [];
   	foreach (array_keys($data) as $key) {
   		$setPart[] = "$key = :$key";
   	}
   	$setString = implode(', ', $setPart);
	$req = "UPDATE categories SET $setString WHERE id = :id";
	$params = array_merge($data, ['id' => $this->id]);
	$sth=$this->pdo->prepare($req);
        $sth->execute($params);
}

public function del($id){
	$req="DELETE FROM categories WHERE id = :id";
	$stmt=$this->pdo->prepare($req);
	$stmt->execute(['id' => $id]);
}

public function name_used(): bool{
	$res=$this->dynamic_get("name", array("name" => $this->name));
	return $res->rowCount()==1;
}
} ?>

<?php
require_once(__DIR__ .'/../Utils/pdo.php');
class Order{
public ?int $id = NULL;
public ?int $total_amount = NULL;
public ?string $status = NULL;
public ?string $shipping_address = NULL;
public ?int $user_id = NULL;
private PDO $pdo;

public function __construct(?PDO $pdo = null) {
	$this->pdo ??= (new connexion())->CNXbase();
}
public function create() {
        $sql = "INSERT INTO orders (total_amount, status, shipping_address, user_id)
                VALUES (:total, :status, :address, :user_id) RETURNING id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':total'    => $this->total_amount,
            ':status'   => $this->status,
            ':address'  => $this->shipping_address,
            ':user_id'  => $this->user_id
        ]);
        $this->id = $stmt->fetchColumn();
}

public function update() {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':status' => $this->status,
            ':id'     => $this->id
        ]);
}

public function add_a_item($productId, $quantity, $price) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
                VALUES (:order_id, :product_id, :qty, :price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':order_id'   => $this->id,
            ':product_id' => $productId,
            ':qty'        => $quantity,
            ':price'      => $price
        ]);
}

public function get_order_items(): ?array{
	$req = "SELECT * from order_items where order_id = :id";
	$stmt=$this->pdo->prepare($req);
        $stmt->execute([':id' => $this->id]);
	return $stmt->fetchAll();
}

public function get_target($target): ?string {
        $sql = "SELECT $target FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $this->id]);
        return $stmt->fetch()[$target];
}

public function get(): ?array {
	$req = "SELECT * FROM orders where id = :id";
	$stmt = $this->pdo->prepare($req);
        $stmt->execute([':id' => $this->id]);
	$data = $stmt->fetch();
	return $data;
}

public function getAll(): ?array {
        return $this->pdo->query("SELECT * FROM orders")->fetchAll();
}


public function delete() {
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $this->id]);
}

} ?>

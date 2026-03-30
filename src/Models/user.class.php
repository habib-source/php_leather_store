<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once(__DIR__ .'/../Utils/pdo.php');
class User{
public ?int $id = NULL;
public ?string $user_name = NULL;
public ?string $email = NULL;
public ?string $pwd = NULL;
public ?bool $active = NULL;
public ?bool $admin = NULL;
public ?string $first_name = NULL;
public ?string $last_name = NULL;
public ?string $user_sex = NULL;
public ?string $birthday = NULL;
public ?string $img_path = NULL;
private ?string $activation_code = NULL;
private ?string $activation_expiry = NULL;
private array $config;
private PDO $pdo;

public function __construct(?array $config = null, ?PDO $pdo = null) {
	$this->config ??= require(__DIR__ ."/../../config.php");
	$this->pdo ??= (new connexion())->CNXbase();
}

private function getData(): ?array  {
        return array_filter([
		'user_name'  		=> $this->user_name,
		'email'      		=> $this->email,
		'pwd'        		=> $this->pwd,
		'active'     		=> $this->active,
		'activation_code'	=> $this->activation_code,
		'activation_expiry'	=> $this->activation_expiry,
		'admin'      		=> $this->admin,
		'first_name' 		=> $this->first_name,
		'last_name'  		=> $this->last_name,
		'user_sex'   		=> $this->user_sex,
		'birthday' 		=> $this->birthday,
		'img_path'   		=> $this->img_path
	], fn($value) => !is_null($value) && $value !== '');
}

public function create(){
	$data = $this->getData();
	$columns = implode(', ', array_keys($data));
	$placeholders = ':' . implode(', :', array_keys($data));
	$req = "INSERT INTO users ($columns) VALUES ($placeholders)";
	$sth=$this->pdo->prepare($req);
        $sth->execute($data);
}

public function verify(): bool{
	$req = "SELECT pwd FROM users WHERE email = :email";
    	$sth = $this->pdo->prepare($req);
    	$sth->execute(['email' => $this->email]);
	$p = $sth->fetch(PDO::FETCH_LAZY);
    	return ($p && password_verify($this->pwd, $p["pwd"]));
}

public function dynamic_get($target, $ident): ?string {
        $column = key($ident);
        $value = current($ident);
        $stmt = $this->pdo->prepare("SELECT $target FROM users WHERE $column = :val");
        $stmt->execute(['val' => $value]);
        $data = $stmt->fetch();
        return $data ? $data[$target] : null;
}

public function get_target($target): ?string {
	return $this->dynamic_get($target, array('id' => $this->id));
}

public function get(): ?array {
        $sql = "SELECT * FROM users WHERE ";
        $params = [];

        if (!empty($this->id)) {
            $sql .= "id = :id";
            $params['id'] = $this->id;
        } elseif (!empty($this->email)) {
            $sql .= "email = :email";
            $params['email'] = $this->email;
        } elseif (!empty($this->user_name)) {
            $sql .= "user_name = :user_name";
            $params['user_name'] = $this->user_name;
        } else {
            return null;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
}

public function get_all(): ?array {
	$req="SELECT * FROM users";
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
	$req = "UPDATE users SET $setString WHERE id = :id";
	$params = array_merge($data, ['id' => $this->id]);
	$sth = $this->pdo->prepare($req);
    	$sth->execute($params);
}

public function del($id) {
    $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

public function email_used(): bool {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $this->email]);
    return $stmt->fetchColumn() == 1;
}

public function user_name_used(): bool {
    	$stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE user_name = :user_name");
    	$stmt->execute(['user_name' => $this->user_name]);
    	return $stmt->fetchColumn() ==1;
}

public function generate_activation_code(){
	$this->activation_code = bin2hex(random_bytes(16));
	$this->activation_expiry = date('Y-m-d H:i:s',  time() + $this->config["ACTIVATION_EXPIRY_PERIOD"]);
}

private function send_email($sub, $body, $alt_body){
    	require  __DIR__ ."/../../".$this->config["VENDOR_DIR"].'/autoload.php';
    	$mail = new PHPMailer(true);
	try {
		$mail->isSMTP();
		$mail->SMTPDebug = $this->config["DEBUG"] ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
		$mail->Host = $this->config["EMAIL_HOST"];
		$mail->Port = $this->config["EMAIL_HOST_PORT"];
		if($this->config["EMAIL_HOST_PORT"]==465 OR
			(isset($this->config["EMAIL_HOST_TLS_OPTION"]) AND $this->config["EMAIL_HOST_TLS_OPTION"]=="SMTPS"))
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		elseif($this->config["EMAIL_HOST_PORT"]==587 OR $this->config["EMAIL_HOST_TLS_OPTION"]=="STARTTLS")
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->SMTPAuth = true;
		$mail->Username = $this->config["EMAIL"];
		$mail->Password = $this->config["EMAIL_PASSWORD"];
		$mail->setFrom($this->config["EMAIL"], $this->config["EMAIL_SENDER_NAME"]);
		$mail->addAddress($this->email, $this->user_name);
		$mail->Subject = $sub;
		$mail->Body    = $body;
    		$mail->AltBody = $alt_body;
		$mail->send();
	} catch (Exception) {
	    	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

public function send_activation_email(){
	$activation_link = $this->config["URL"] . "src/Controllers/activate.php?email=".$this->email."&activation_code=".$this->activation_code;
	$Subject = 'Activate your account';
	$Body    = "Click <a href='" . htmlspecialchars($activation_link) . "'>HERE</a> to activate your account";
    	$AltBody = 'Click the following link to activate your account:'.$activation_link;
	$this->send_email($Subject, $Body, $AltBody);
}

public function send_Status_update_email($status){
	$Subject = 'Order Status update';
	$Body    = "Your order is  " . htmlspecialchars($status);
    	$AltBody = $Body;
	$this->send_email($Subject, $Body, $AltBody);
}

public function activate_user(){
	$this->active=TRUE;
	$this->mod();
}

public function get_orders(): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM orders where user_id = :id");
        $stmt->execute(['id' => $this->id]);
	return $stmt->fetchAll();
}

public function clean_chopping_cart(){
        $stmt = $this->pdo->prepare("DELETE FROM cart_items where user_id = :id");
        $stmt->execute(['id' => $this->id]);
}

public function exist_in_shopping_cart($product_id): bool {
	$stmt = $this->pdo->prepare("SELECT COUNT(*) FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
    	$stmt->execute([
    		'user_id'    => $this->id,
    		'product_id' => $product_id
    	]);
	return $stmt->fetchColumn()==1;
}

public function add_to_shopping_cart($product_id, $quantity) {
    	$stmt = $this->pdo->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
    	$stmt->execute([
    	    	'user_id'    => $this->id,
    	    	'product_id' => $product_id,
    	    	'quantity'   => $quantity
    	]);
}

public function update_increment_prod_in_shopping_cart($product_id, $quantity) {
    	$stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
    	$stmt->execute([
    		'quantity'   => $quantity,
    	    	'user_id'    => $this->id,
    	    	'product_id' => $product_id
    	]);
}

public function update_prod_in_shopping_cart($product_id, $quantity) {
   	 $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
   	 $stmt->execute([
   		'quantity'   => $quantity,
   	    	'user_id'    => $this->id,
   	    	'product_id' => $product_id
   	 ]);
}

public function get_shopping_cart(): ?array {
	$stmt = $this->pdo->prepare("SELECT * FROM cart_items WHERE user_id = :user_id");
    	$stmt->execute(['user_id' => $this->id]);
	return $stmt->fetchAll();
}

public function delete_from_shopping_cart($product_id) {
    	$stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
    	$stmt->execute([
    	    	'user_id'    => $this->id,
    	    	'product_id' => $product_id
    	]);
}
} ?>

<?php
class connexion{
private $config;
function __construct() {
    include(__DIR__ ."/../../config.php");
    $this->config = $config;
}
public function CNXbase(){
	try{
		$dsn = "pgsql:host={$this->config['DB_HOST']};dbname={$this->config['DB_NAME']};port={$this->config['DB_PORT']}";
	    	$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    	];
	    return new PDO($dsn, $this->config['DB_USER'], $this->config['DB_PASSWORD'], $options);

	}
	catch(PDOException  $e){
		throw new Exception("Database connection failed: ".$e->getMessage());
	}
}
}
?>
<?php
?>

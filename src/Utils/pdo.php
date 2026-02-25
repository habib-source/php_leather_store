<?php
class connexion{
private $config;
function __construct() {
    include(__DIR__ ."/../../config.php");
    $this->config = $config;
}
public function CNXbase(){
	try{
		$dbc=new PDO("pgsql:host=".$this->config['DB_HOST'].";dbname=".$this->config['DB_NAME'].";port=".$this->config['DB_PORT'],$this->config['DB_USER'],$this->config['DB_PASSWORD']);

	}
	catch(PDOException  $e){
		print "Erreur !: " . $e->getMessage() ;
	}
	return $dbc;
}
}
?>
<?php
?>

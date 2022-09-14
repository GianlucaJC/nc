<?php
class Database{
	//locale
	
	private $nomehost='localhost';
	private $db_name = "nc";
	private $nomeuser='root';
	private $password='';	
	
	private $nomehostT='localhost';
	private $db_nameT = "LIOFILCHEM";
	private $nomeuserT='root';
	private $passwordT='';
	

	public $conn;
	
	public function getConnection() {
		$this->conn = null;
		try
			{
				$this->conn = new mysqli($this->nomehost,$this->nomeuser,$this->password,$this->db_name);
			}
		catch(mysqli $exception)
			{
			echo "Errore di connessione: " . $exception->getMessage();
			}
		return $this->conn;
		
	}
	
	public function getConnTarget() {
		$this->conn = null;
		try
			{
				$this->conn = new mysqli($this->nomehostT,$this->nomeuserT,$this->passwordT,$this->db_nameT);
			}
		catch(mysqli $exception)
			{
			echo "Errore di connessione: " . $exception->getMessage();
			}
		return $this->conn;
		
	}	
}

	
?>

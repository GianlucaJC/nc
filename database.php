<?php
class Database{
	//locale
	
	private $nomehost='localhost';
	private $db_name = "nc";
	private $nomeuser='root';
	private $password='giatongia6971';	
	
	private $nomehostT='localhost';
	private $db_nameT = "LIOFILCHEM";
	private $nomeuserT='root';
	private $passwordT='giatongia6971';

	//Liofilchem
	/*	
	private $nomehost='192.168.129.30';
	private $db_name="nc";
	private $nomeuser='sysadmin';
	private $password='Password01.';


	private $nomehostT='192.168.129.20';
	private $db_nameT = "LIOFILCHEM";
	private $nomeuserT='jolly';
	private $passwordT='zxcvbnm';
	
	
	*/
	
	
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
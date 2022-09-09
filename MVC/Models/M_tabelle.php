<?php
class Main_tabelle
	{
	private $conn;

	
	// costruttore
	public function __construct($db){
		$this->conn = $db;
		$this->conn->set_charset("utf8");
	}

	function remove_rep($id_rep) {
		$sql="UPDATE reparti 
				SET dele=1 
				WHERE id=$id_rep";
		$result=$this->conn->query($sql);	
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
	}
	
	function remove_attr($id_attr) {
		$sql="UPDATE attrezzature 
				SET dele=1 
				WHERE id=$id_attr";
		$result=$this->conn->query($sql);	
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		return $resp;
	}

	function remove_tiponc_pr($id_tipo) {
		$sql="UPDATE tipo_nc 
				SET dele=1 
				WHERE id=$id_tipo";
		$result=$this->conn->query($sql);	
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		return $resp;
	}

	function remove_classificazione($id_remove) {
		$sql="UPDATE classificazioni_nc 
				SET dele=1 
				WHERE id=$id_remove";
		$result=$this->conn->query($sql);	
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		return $resp;
	}

	function new_rep($edit) {
		$resp=array();
		$stab=$_POST['stab'];
		$new_rep=$_POST['new_rep'];
		$new_rep=addslashes($new_rep);
		if ($edit==0) 
			$sql="INSERT INTO reparti 
				(`reparto`, `id_stabilimento`)
				VALUES 
				('$new_rep', '$stab')
			";
		else 
			$sql="UPDATE reparti
					SET `reparto`='$new_rep', `id_stabilimento`='$stab'
					WHERE id=$edit
				";	
		$result=$this->conn->query($sql);
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		return $resp;

	}

	function new_attr($edit) {
		$resp=array();
		$reparto=$_POST['reparto'];
		
		$new_attr=$_POST['new_attr'];
		$reparto=$_POST['reparto'];
		$list_rep=implode(";",$reparto);
		
		$new_attr=addslashes($new_attr);
		if ($edit==0) {
			
			$sql="INSERT INTO attrezzature 
				(`id_reparto`, `attrezzatura`)
				VALUES 
				('$list_rep' , '$new_attr')
			";
		}	
		else 
			$sql="UPDATE attrezzature
					SET `id_reparto`='$list_rep', `attrezzatura`='$new_attr'
					WHERE id=$edit
				";	
		$result=$this->conn->query($sql);
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		return $resp;

	}


	function new_tipo_nc($tipo,$edit) {
		$resp=array();
		
		$descr_tipo=$_POST['descr_tipo'];
		$descr_tipo=addslashes($descr_tipo);
		if ($edit==0) 
			$sql="INSERT INTO tipo_nc 
				(`id_tipo`, `descrizione`)
				VALUES 
				($tipo, '$descr_tipo')
			";
		else 
			$sql="UPDATE tipo_nc
					SET `descrizione`='$descr_tipo'
					WHERE id=$edit
				";	
		$result=$this->conn->query($sql);
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		return $resp;

	}
	
	function new_class($edit) {
		$resp=array();
		
		$descr_class=$_POST['descr_class'];
		$descr_class=addslashes($descr_class);
		if ($edit==0) 
			$sql="INSERT INTO classificazioni_nc 
				( `descrizione`)
				VALUES 
				('$descr_class')
			";
		else 
			$sql="UPDATE classificazioni_nc
					SET `descrizione`='$descr_class'
					WHERE id=$edit
				";	
		$result=$this->conn->query($sql);
		if ($result) {
			$resp['header']="OK";$resp['error']="";
		} else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		return $resp;

	}
	

}
?>
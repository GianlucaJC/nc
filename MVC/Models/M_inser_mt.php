<?php
class Main_new_mt {
	private $conn;

	
	// costruttore
	public function __construct($db){
		$this->conn = $db;
		$this->conn->set_charset("utf8");
	}


	
	function inser_nc_mt($id_ref=0) {
		/*
			esempio codice lotto liofilchem: 044972D22
			Array ( [nc_access] => 3 [id_ref] => 0 [id_ref_temp] => 624eabf7b44f0 [data_nc] => 2022-04-07 [lotto_liofilchem] => 044972D22 [cod_art] => D15864 [descr_art] => CEFSULODIN GR [cod_cf] => 003751 [fornitore] => APOLLO SCIENTIFIC LIMITED [lotto_cf] => [qta_fornita] => [qta_nc] => 1 [tipo_nc] => 12 [descrizione_nc] => sdfsdfgsdff [btn_ins_nc_mt] => ) 
		*/
		$id_user=$_SESSION['id_user'];
		
		$id_ref_temp=$_POST['id_ref_temp'];
		$data_nc=$_POST['data_nc'];
		$cod_art=$_POST['cod_art'];
		$descr_art=$_POST['descr_art'];		
		$descr_art=addslashes($descr_art);
		$lotto_liofilchem=$_POST['lotto_liofilchem'];
		$lotto_cf=$_POST['lotto_cf'];
		$cod_cf=$_POST['cod_cf'];
		$fornitore=$_POST['fornitore'];
		$fornitore=addslashes($fornitore);

		$qta_fornita=$_POST['qta_fornita'];
		if (strlen($qta_fornita)==0) $qta_fornita=0;
		$qta_nc=$_POST['qta_nc'];
		
		$tipo_nc=$_POST['tipo_nc'];
		$descrizione_nc=$_POST['descrizione_nc'];
		$descrizione_nc=addslashes($descrizione_nc);
		
		
		if ($id_ref==0)
			$sql="INSERT INTO `nc_materiale`(`id_oper`, `data_nc`, `cod_art`, `descr_art`, `lotto_liof`, `lotto_cf`, `cod_cf`, `fornitore`, `qta_fornita`, `qta_nc`, `tipo_nc`, `descrizione_nc`) VALUES ($id_user, '$data_nc', '$cod_art','$descr_art','$lotto_liofilchem', '$lotto_cf', '$cod_cf', '$fornitore', $qta_fornita, $qta_nc , $tipo_nc , '$descrizione_nc')
			";
		else { 
			//modifica non prevista: agisco io come admin direttamente sulle tabelle
			return;	
		}	
	

		$resp=array();
		if ($result = $this->conn->query($sql)) {
			$last_id=$this->conn->insert_id;
			//$id_ref_temp -->indica la cartella temporanea per gli allegati: se presente la rinomino con $last_id
			
			if(is_dir("allegati/".$id_ref_temp)) rename("allegati/".$id_ref_temp, "allegati/".$last_id);
				
			//assegnazione protocollo
			$d=date('Y');
			$sql = "SELECT protocollo_nc FROM nc_materiale WHERE (dele=0 and substr(protocollo_nc,7,4)='$d') ORDER BY id desc LIMIT 0,1;";
										
			$last_prot="";
			if ($result = $this->conn->query($sql)) {
				$res = $result->fetch_row();
				$last_prot=$res[0];
			}

			
			if (strlen($last_prot)==0) $last_prot=0;
			else {
				$last_prot=substr($last_prot,1,4);
				$last_prot=intval($last_prot);
			}	
			$last_prot++;
			$stx="";
			for ($st=strlen($last_prot);$st<4;$st++) {
				$stx.="0";
			}

			$protocollo_nc="M".$stx.$last_prot."/".date("Y");

			$sql="UPDATE `nc_materiale`
					SET protocollo_nc='$protocollo_nc'
					WHERE id=$last_id";
			$result = $this->conn->query($sql);

			//creazione contestuale anche nella tabella recensioni
			$sql="INSERT INTO `recensione_materiale` (`id_mt`) VALUES ($last_id)";
			$result = $this->conn->query($sql);
			
			

			$resp['header']="OK";$resp['error']="";$resp['last_id']=$last_id;
			$resp['info']['protocollo_nc']=$protocollo_nc;
			$resp['info']['codice']=$cod_art;
			$resp['info']['descrizione']=$descr_art;
			
		}	
		else {
			$resp['header']="KO";$resp['error']=$this->conn->error;$resp['last_id']="";
			$resp['info']['protocollo_nc']="";
			$resp['info']['codice']="";
			$resp['info']['descrizione']="";
		}
		return $resp;
		
	}

}
?>
<?php
class Main_new_pr {
	private $conn;

	
	// costruttore
	public function __construct($db){
		$this->conn = $db;
		$this->conn->set_charset("utf8");
	}


	
	function inser_nc_pr($id_ref=0) {
		/*
			Array ( [data_nc] => 2022-03-04 [protocollo] => 2012-OP2-0000002 [reparto] => 12 [cod_art] => $15375H [descr_art] => VIOLET RED BILE GLUCOSE AGAR [attr_sn] => S [attrezzature] => 0 [lotto] => sdfdf [qta_ric] => 0 [qta_prod] => 1 [qta_nc] => 2 [qta_dele] => 3 [tipo_nc] => [descrizione_nc] => sdfgsgf [btn_ins_nc_pr] => ) 		
		*/
		$id_user=$_SESSION['id_user'];
		$data_nc=$_POST['data_nc'];
		$protocollo=$_POST['protocollo'];
		$reparto_where_nc=$_POST['reparto_where_nc'];
		$id_reparto_view=$_POST['id_reparto_view'];
		$tipo_prodotto=$_POST['tipo_prodotto'];
		$cod_art=$_POST['cod_art'];
		$descr_art=$_POST['descr_art'];
		$descr_art=addslashes($descr_art);
		$attr_sn=$_POST['attr_sn'];
		if (!isset($_POST['attrezzature']) || strlen($_POST['attrezzature'])==0) $attrezzature=0;
		else $attrezzature=$_POST['attrezzature'];
		$lotto=$_POST['lotto'];
		$qta_ric=$_POST['qta_ric'];
		$qta_prod=$_POST['qta_prod'];
		$qta_nc=$_POST['qta_nc'];
		$qta_dele=$_POST['qta_dele'];
		$tipo_nc=$_POST['tipo_nc'];
		$descrizione_nc=$_POST['descrizione_nc'];
		$descrizione_nc=addslashes($descrizione_nc);
		
		if ($id_ref==0)
			$sql="INSERT INTO `nc_prodotto`
				(`id_oper`, `data_nc`, `protocollo`, `reparto_where_nc`, `id_reparto_view`, `codice`, `descrizione`, `attr_sn`, `attrezzature`, `lotto`, `qta_ric`, `qta_prod`, `qta_nc`, `qta_dele`, `tipo_nc`, `descrizione_nc`) VALUES ($id_user, '$data_nc' ,'$protocollo',$reparto_where_nc, $id_reparto_view, '$cod_art','$descr_art','$attr_sn',$attrezzature,'$lotto',$qta_ric,$qta_prod,$qta_nc,$qta_dele,$tipo_nc,'$descrizione_nc')
			";
		else
			$sql="UPDATE `nc_prodotto` 
					SET `data_nc`='$data_nc', `protocollo`='$protocollo', `reparto_where_nc`=$reparto_where_nc,  `id_reparto_view`=$id_reparto_view, `codice`='$cod_art', `descrizione`='$descr_art', `attr_sn`='$attr_sn', `attrezzature`='$attrezzature', `lotto`='$lotto', `qta_ric`=$qta_ric, `qta_prod`=$qta_prod, `qta_nc`=$qta_nc, `qta_dele`=$qta_dele, `tipo_nc`=$tipo_nc, `descrizione_nc`='$descrizione_nc'
					WHERE id=$id_ref";		


		$resp=array();
		if ($result = $this->conn->query($sql)) {
			$last_id=0;
			if ($id_ref==0) {
				$last_id=$this->conn->insert_id;

				//assegnazione protocollo
				$d=date('Y');
				$sql = "SELECT protocollo_nc FROM nc_prodotto WHERE (dele=0 and substr(protocollo_nc,7,4)='$d') ORDER BY id desc LIMIT 0,1;";
											
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

				$protocollo_nc="P".$stx.$last_prot."/".date("Y");

				$sql="UPDATE `nc_prodotto`
						SET protocollo_nc='$protocollo_nc'
						WHERE id=$last_id";
				$result = $this->conn->query($sql);

				//in caso di creazione nuova NC creo contestualmente anche il record nella tabella recensioni
				$sql="INSERT INTO `recensione_prodotto` (`id_pr`) VALUES ($last_id)";
				$result = $this->conn->query($sql);
				
				
				
			}	
			else $last_id=$id_ref;
			//eventuale invio di mail notifica
				//if ($id_ref==0) {
					
				//}
			//
			$resp['header']="OK";$resp['error']="";$resp['last_id']=$last_id;
			$resp['info']['protocollo_nc']=$protocollo_nc;
			$resp['info']['lotto']=$lotto;
			$resp['info']['codice']=$cod_art;
			$resp['info']['descrizione']=$descr_art;
			
		}	
		else {
			$resp['header']="KO";$resp['error']=$this->conn->error;$resp['last_id']="";
			$resp['info']['protocollo_nc']="";
			$resp['info']['lotto']="";
			$resp['info']['codice']="";
			$resp['info']['descrizione']="";
		}
		return $resp;
		
	}
	
	public function notifica_segnalatori() {
		$elenco="srepetto@liofilchem.com;mnallira@liofilchem.com;sscapellato@liofilchem.com;fdemetrio@liofilchem.com";
		return $elenco;
	}
	

}
?>
<?php
class Analisi_mt
	{
	private $conn;

	
	// costruttore
	public function __construct($db){
		$this->conn = $db;
		$this->conn->set_charset("utf8");
	}
	
	public function info_nc_mt($id_mt) {
		$sql="SELECT r.*,nc.protocollo_nc,nc.lotto_liof,nc.cod_art,nc.descr_art FROM recensione_materiale r
				INNER JOIN nc_materiale nc ON r.id_mt=nc.id
				WHERE id_mt=$id_mt";
		
		$this->conn->set_charset("utf8");
		$result=$this->conn->query($sql);	
		
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		//presa visione: solo se il primo a visualizzare 
		$nc_access=$_SESSION['nc_access'];
		if ($resp[0]['stato']==0 && $nc_access=="3") {
			$sql="UPDATE recensione_materiale
					SET stato=1
					WHERE id_mt=$id_mt";
			$result=$this->conn->query($sql);	
		}
		return $resp;		
	}
	

	
	public function sign_valutazione($id_ref) {
		$id_user=$_SESSION['id_user'];

		$data_valutazione=$_POST['data_valutazione'];
		$nc_rilevata=$_POST['nc_rilevata'];
		$invio_reclamo_fornitore=$_POST['invio_reclamo_fornitore'];
		$ref_prot_reclamo=addslashes($_POST['ref_prot_reclamo']);
		
		$sql="UPDATE recensione_materiale
			SET nc_rilevata=$nc_rilevata, invio_reclamo_fornitore=$invio_reclamo_fornitore, firma_valutazione=$id_user,data_valutazione='$data_valutazione', ref_prot_reclamo='$ref_prot_reclamo', stato=2 
			WHERE id_mt=$id_ref";


		$resp=array();
		if ($this->conn->query($sql)) {
			$resp['status']="OK";
			$resp['error']="";
		}	
		else {
			 
			$err="$sql\n".$this->conn->error;
			$resp['status']="KO";
			$resp['error']=$err;
		}		
	}
	
	public function sign_ris($id_ref,$from) {
			$id_user=$_SESSION['id_user'];
			$stato=2;

			//
			$attivita=null;
			if (isset($_POST['attivita'])) {
				$attivita=$_POST['attivita'];
				$attivita=addslashes($attivita);$attivita=htmlspecialchars($attivita);				
			}
			$note=null;
			if (isset($_POST['note'])) {
				$note=$_POST['note'];
				$note=addslashes($note);$note=htmlspecialchars($note);
			}			
			$str_team=null;
			if (isset($_POST['team'])) {
				$str_team=implode(";",$_POST['team']);
			}			
			$informazione_organizzazioni=null;
			if (isset($_POST['informazione_organizzazioni'])) {
				$informazione_organizzazioni=$_POST['informazione_organizzazioni'];
				$informazione_organizzazioni=addslashes($informazione_organizzazioni);$informazione_organizzazioni=htmlspecialchars($informazione_organizzazioni);
			}			


			$arr_dati=array();
			
			
			
			if ($attivita!=null) $arr_dati[]="attivita=$attivita";
			if ($note!=null) $arr_dati[]="note='$note'";
			if ($str_team!=null) $arr_dati[]="team='$str_team'";
			if ($informazione_organizzazioni!=null) $arr_dati[]="informazione_organizzazioni='$informazione_organizzazioni'";
	

			$eliminato_magazzino_virtuale=null;
			if (isset($_POST['eliminato_magazzino_virtuale'])) 
				$arr_dati[]="eliminato_magazzino_virtuale=1";		

			$eliminato_magazzino_fisico=null;
			if (isset($_POST['eliminato_magazzino_fisico'])) 
				$arr_dati[]="eliminato_magazzino_fisico=1";		

			
			if ($from=="1") {
				$data_sezione_ris1=$_POST['data_sezione_ris1'];
				$arr_dati[]="data_sezione_ris1='$data_sezione_ris1', sign_ris1=$id_user";
			}
			if ($from=="2") {
				$data_sezione_ris2=$_POST['data_sezione_ris2'];
				$arr_dati[]="data_sezione_ris2='$data_sezione_ris2', sign_ris2=$id_user";
			}
			
			if ($from=="3") {
				$data_eliminazione_mv=$_POST['data_eliminazione_mv'];
				$arr_dati[]="data_eliminazione_mv='$data_eliminazione_mv', sign_eliminazione_mv=$id_user";
			}
			if ($from=="4") {
				$data_eliminazione_mf=$_POST['data_eliminazione_mf'];
				$arr_dati[]="data_eliminazione_mf='$data_eliminazione_mf', sign_eliminazione_mf=$id_user";
			}			
			if ($from=="40") {
				$data_eliminazione_na=$_POST['data_eliminazione_na'];
				$arr_dati[]="data_eliminazione_na='$data_eliminazione_na', sign_eliminazione_na=$id_user,eliminato_na=1";
			}			
			if ($from=="5") {
				$stato=3;
				$data_chiusura_nc=$_POST['data_chiusura_nc'];
				$arr_dati[]="data_chiusura_nc='$data_chiusura_nc', sign_chiusura_nc=$id_user";
			}
			
			$azione_correttiva=null;
			if (isset($_POST['azione_correttiva']) && (strlen($_POST['azione_correttiva'])!=0)) {
				$azione_correttiva=$_POST['azione_correttiva'];
				$arr_dati[]="azione_correttiva='$azione_correttiva'";
			}

			$motivazione_azione=null;
			if (isset($_POST['motivazione_azione'])) {
				$motivazione_azione=$_POST['motivazione_azione'];
				$motivazione_azione=addslashes($motivazione_azione);$motivazione_azione=htmlspecialchars($motivazione_azione);
				$arr_dati[]="motivazione_azione='$motivazione_azione'";
			}	
			
			$dati=implode(",",$arr_dati);
			
			$sql="UPDATE recensione_materiale
					SET $dati,stato=$stato
					WHERE id_mt=$id_ref";			


			$resp=array();
			if ($this->conn->query($sql)) {
				$resp['status']="OK";
				$resp['error']="";
			}	
			else {
				 
				$err="$sql\n".$this->conn->error;
				$resp['status']="KO";
				$resp['error']=$err;
			}		
	}

	public function elenco_mail_team($str) {
		$ids=explode(";",$str);
		$cond="";
		for ($sca=0;$sca<=count($ids)-1;$sca++) {
			$id=$ids[$sca];
			if (strlen($cond)!=0) $cond.=" or ";
			$cond.="id_user=$id";
		}
		$sql="SELECT email FROM team WHERE $cond";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;
	}
	
	

}
?>
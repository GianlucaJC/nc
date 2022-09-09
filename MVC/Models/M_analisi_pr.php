<?php
class Analisi_pr
	{
	private $conn;

	
	// costruttore
	public function __construct($db){
		$this->conn = $db;
		$this->conn->set_charset("utf8");
	}
	
	public function info_nc_pr($id_pr) {
		$sql="SELECT r.*,nc.protocollo_nc,nc.lotto,nc.codice,nc.descrizione FROM recensione_prodotto r
				INNER JOIN nc_prodotto nc ON r.id_pr=nc.id
				WHERE id_pr=$id_pr";
		
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		//presa visione: solo se il primo a visualizzare 
		$nc_access=$_SESSION['nc_access'];
		if ($resp[0]['stato']==0 && $nc_access=="3") {
			$sql="UPDATE recensione_prodotto
					SET stato=1
					WHERE id_pr=$id_pr";
			$result=$this->conn->query($sql);	
		}
		return $resp;		
	}
	
	public function update_recensione_pr() {
		$id_ref=0;
		$tipo_prodotto=null;
		$nc_rilevata=null;$classificazione_nc=null;
		$txt_man=null;$man_sn=null;$txt_method=null;$method_sn=null;
		$txt_material=null;$material_sn=null;$txt_machine=null;$machine_sn=null;
		$txt_enviroment=null;$enviroment_sn=null;
		if (isset($_POST['id_ref'])) $id_ref=$_POST['id_ref'];
		if (isset($_POST['tipo_prodotto'])) $tipo_prodotto=$_POST['tipo_prodotto'];
		if (isset($_POST['nc_rilevata'])) $nc_rilevata=$_POST['nc_rilevata'];
		if (isset($_POST['classificazione_nc'])) $classificazione_nc=$_POST['classificazione_nc'];
		if (isset($_POST['txt_man'])) $txt_man=addslashes(htmlspecialchars($_POST['txt_man']));
		if (isset($_POST['man_sn'])) $man_sn=$_POST['man_sn'];
		if (isset($_POST['txt_method'])) $txt_method=addslashes(htmlspecialchars($_POST['txt_method']));
		if (isset($_POST['method_sn'])) $method_sn=$_POST['method_sn'];
		if (isset($_POST['txt_material'])) $txt_material=addslashes(htmlspecialchars($_POST['txt_material']));
		if (isset($_POST['material_sn'])) $material_sn=$_POST['material_sn'];
		if (isset($_POST['txt_machine'])) $txt_machine=addslashes(htmlspecialchars($_POST['txt_machine']));
		if (isset($_POST['machine_sn'])) $machine_sn=$_POST['machine_sn'];
		if (isset($_POST['txt_enviroment'])) $txt_enviroment=addslashes(htmlspecialchars($_POST['txt_enviroment']));
		if (isset($_POST['enviroment_sn'])) $enviroment_sn=$_POST['enviroment_sn'];
		

		$arr_dati=array();
		
		if ($nc_rilevata!=null) $arr_dati[]="nc_rilevata=$nc_rilevata"; else $arr_dati[]="nc_rilevata=NULL";
		if ($tipo_prodotto!=null) $arr_dati[]="tipo_prodotto=$tipo_prodotto"; else $arr_dati[]="tipo_prodotto=NULL";
		if ($classificazione_nc!=null) $arr_dati[]="classificazione_nc=$classificazione_nc"; else $arr_dati[]="classificazione_nc=NULL";
		if ($txt_man!=null) $arr_dati[]="txt_man='$txt_man'"; else $arr_dati[]="txt_man=NULL";
		if ($man_sn!=null) $arr_dati[]="man_sn=$man_sn"; else $arr_dati[]="man_sn=NULL";
		if ($txt_method!=null) $arr_dati[]="txt_method='$txt_method'"; else $arr_dati[]="txt_method=NULL";
		if ($method_sn!=null) $arr_dati[]="method_sn=$method_sn"; else $arr_dati[]="method_sn=NULL";
		if ($txt_material!=null) $arr_dati[]="txt_material='$txt_material'"; else $arr_dati[]="txt_material=NULL";
		if ($material_sn!=null) $arr_dati[]="material_sn=$material_sn"; else $arr_dati[]="material_sn=NULL";	
		if ($txt_machine!=null) $arr_dati[]="txt_machine='$txt_machine'"; else $arr_dati[]="txt_machine=NULL";
		if ($machine_sn!=null) $arr_dati[]="machine_sn=$machine_sn"; else $arr_dati[]="machine_sn=NULL";
		if ($txt_enviroment!=null) $arr_dati[]="txt_enviroment='$txt_enviroment'"; else $arr_dati[]="txt_enviroment=NULL";
		if ($enviroment_sn!=null) $arr_dati[]="enviroment_sn=$enviroment_sn"; else $arr_dati[]="enviroment_sn=NULL";
		
		$dati=implode(",",$arr_dati);
		
		$sql="UPDATE recensione_prodotto
				SET $dati,stato=2
				WHERE id_pr=$id_ref";


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
	
	public function sign_valutazione($id_ref,$from) {
		$id_user=$_SESSION['id_user'];
		if ($from=="1")  {
			$data_valutazione1_nc=$_POST['data_valutazione1_nc'];
			$sql="UPDATE recensione_prodotto
				SET firma_valutazione1=$id_user,data_valutazione1_nc='$data_valutazione1_nc' 
				WHERE id_pr=$id_ref";
		}
		if ($from=="2")  {
			$data_valutazione2_nc=$_POST['data_valutazione2_nc'];
			$sql="UPDATE recensione_prodotto
				SET firma_valutazione2=$id_user,data_valutazione2_nc='$data_valutazione2_nc' 
				WHERE id_pr=$id_ref";
		}
		
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
			
			//POST eventuale rilavorazione
			$new_lotto=null;
			if (isset($_POST['new_lotto'])) {
				$new_lotto=$_POST['new_lotto'];
				$new_lotto=addslashes($new_lotto);
				$new_lotto=htmlspecialchars($new_lotto);
			}
			$scadenza=null;
			if (isset($_POST['scadenza'])) {
				$scadenza=$_POST['scadenza'];
			}
			
			$attivita_sul_prodotto=null;
			if (isset($_POST['attivita_sul_prodotto'])) {
				$attivita_sul_prodotto=$_POST['attivita_sul_prodotto'];
				$attivita_sul_prodotto=addslashes($attivita_sul_prodotto);$attivita_sul_prodotto=htmlspecialchars($attivita_sul_prodotto);
			}
			$effetti_avversi=null;
			if (isset($_POST['effetti_avversi'])) {
				$effetti_avversi=$_POST['effetti_avversi'];
				$effetti_avversi=addslashes($effetti_avversi);$effetti_avversi=htmlspecialchars($effetti_avversi);
			}
			$attivita_controllo=null;
			if (isset($_POST['attivita_controllo'])) {
				$attivita_controllo=$_POST['attivita_controllo'];
				$attivita_controllo=addslashes($attivita_controllo);$attivita_controllo=htmlspecialchars($attivita_controllo);
			}
			$istruzioni_operative=null;
			if (isset($_POST['istruzioni_operative'])) {
				$istruzioni_operative=$_POST['istruzioni_operative'];
				$istruzioni_operative=addslashes($istruzioni_operative);$istruzioni_operative=htmlspecialchars($istruzioni_operative);
			}
			
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
			
			if ($new_lotto!=null) $arr_dati[]="new_lotto='$new_lotto'";
			if ($scadenza!=null) $arr_dati[]="scadenza='$scadenza'";
			if ($attivita_sul_prodotto!=null) $arr_dati[]="attivita_sul_prodotto='$attivita_sul_prodotto'";
			if ($effetti_avversi!=null) $arr_dati[]="effetti_avversi='$effetti_avversi'";			
			if ($attivita_controllo!=null) $arr_dati[]="attivita_controllo='$attivita_controllo'";
			if ($istruzioni_operative!=null) $arr_dati[]="istruzioni_operative='$istruzioni_operative'";

			
			
			
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
			
			$sql="UPDATE recensione_prodotto
					SET $dati,stato=$stato
					WHERE id_pr=$id_ref";			


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
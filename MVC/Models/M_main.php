<?php
class Main_all
	{
	private $conn;

	
	// costruttore
	public function __construct($db){
		$this->conn = $db;
		$this->conn->set_charset("utf8");
	}

	public function login() {
		$datx=date("Y-m-d");
		$ora = date('H:i:s', time());
		$user=$_POST['user'];
		$pass=$_POST['pass'];
		//INNER JOIN `nc`.`reparti` r ON u.vest_id_rep=r.id
		$sql ="SELECT u.userid,u.passkey,u.operatore,u.id,nc_access FROM `Sql58368_4`.`utenti` u
				WHERE userid='$user' and passkey='$pass' and nc_access>0";
		$rows=array();
		$rows['header']['error']="";

		if ($result = $this->conn->query($sql)) {
			$row_cnt = $result->num_rows;
			if ($row_cnt==0 || $row_cnt>1) {
				$rows['header']['login']="KO";	
				$rows['header']['error']="Nome utente o password errata";
				print json_encode($rows);
				exit;
			}
			$res = $result->fetch_row();
			$operatore=$res[2];
			$id_user=$res[3];
			$nc_access=$res[4];

			if ($result) {
				$_SESSION['user_nc'] = $user;
				$_SESSION['id_user'] = $id_user;
				$_SESSION['operatore_nc'] = $operatore;
				$_SESSION['nc_access'] = $nc_access;
				$rows['header']['login']="OK";
			} else {
				$rows['header']['login']="KO";	
				$rows['header']['error']="Utente o password errata";				
			}
			/*
			$t_oper="Accesso archivio Impegno Lotti";
			$sql="INSERT INTO log_fo(ip,data,sezione,operazione,utente,ora) VALUES('$ip','$datx','IMPEGNOLOTTI','$t_oper','$operatore','$ora')";
			$result = $mysqli->query($sql);
			*/

			
		} else  {
			$rows['header']['login']="KO";	
			$rows['header']['error']="Nome utente o password errata o accesso non consentito per l'utenza";	
		}
		return $rows;		
	}

	function array_utenti() {
		$sql="SELECT id,nome signer FROM `Sql58368_4`.`utenti`";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$id=$results['id'];
			$resp[$id]=$results['signer'];
		}
		return $resp;
	}


	function array_utenti_bis() {
		$sql="SELECT id,operatore FROM `Sql58368_4`.`utenti`";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$id=$results['id'];
			$resp[$id]=$results;
		}
		return $resp;
	}
	
	function segnalatori_nc_pr() {
		$sql="SELECT u.id,u.operatore FROM 
				`nc`.`nc_prodotto` nc
				LEFT OUTER JOIN `Sql58368_4`.`utenti` u ON nc.id_oper=u.id
				WHERE nc.dele=0";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$id=$results['id'];
			$resp[$id]=$results;
		}
		return $resp;
		
	}
	
	function stabilimenti() {
		$stab=array();
		$stab[0]="S1";
		$stab[1]="S2";
		$stab[2]="S3";
		$stab[3]="S4";
		$stab[4]="S5";
		$stab[5]="S1b";
		return $stab;
	}

	function classificazioni($id=0) {
		$cond="1";
		if ($id!=0 && strlen($id)!=0) $cond.=" and id=$id"; 
		$sql="SELECT * FROM classificazioni_nc 
				WHERE dele=0 and $cond
				ORDER BY descrizione";
		
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}

		return $resp;
				
	}

	function reparti($id=0) {
		$cond="";
		if ($id!=0) $cond=" and id=$id";
		$sql="SELECT * FROM reparti 
			WHERE dele=0 $cond
			ORDER BY id_stabilimento,reparto";
		
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}

		return $resp;
				
	}
	
	function reparti_from_array($string_reparti="") {
		$arr_id=explode(";",$string_reparti);
		$cond="";
		for ($sca=0;$sca<=count($arr_id)-1;$sca++) {
			if (strlen($cond)!=0) $cond.=" or "; 
			$cond.=" r.id=".$arr_id[$sca];
		}
		$sql="SELECT reparto FROM reparti r
			WHERE dele=0 and ($cond)
			ORDER BY r.reparto";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results['reparto'];
		}

		return $resp;
	}
	
	
	function list_attrezzature($id_attr=0,$id_rep=0) {
		$cond="";
		if ($id_attr!=0) $cond=" and a.id=$id_attr";
		$sql="SELECT a.* FROM attrezzature a
				WHERE a.dele=0 $cond
				ORDER BY attrezzatura";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			if ($id_rep!=0) {
				$id_reparti=$results['id_reparto'];
				$arr_rep=explode(";",$id_reparti);
				if (in_array($id_rep,$arr_rep)) $resp[]=$results;
			} else 
				$resp[]=$results;
			
		}
		return $resp;
	}
	
	function attrezzature_movimentate() {
		$sql="SELECT a.* FROM attrezzature a
				INNER JOIN nc_prodotto nc ON a.id=nc.attrezzature 
				WHERE nc.dele=0
				GROUP BY a.id
				ORDER BY a.attrezzatura";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;
	}

	function reparti_where_nc() {
		$sql="SELECT r.* FROM reparti r
				INNER JOIN nc_prodotto nc ON r.id=nc.reparto_where_nc 
				WHERE nc.dele=0
				GROUP BY r.id
				ORDER BY r.reparto";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;
	}

	function classificazioni_in_nc() {
		$sql="SELECT c.* FROM classificazioni_nc c
				INNER JOIN recensione_prodotto re ON c.id=re.classificazione_nc 
				GROUP BY c.id
				ORDER BY c.descrizione";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;
	}




	function fornitori_in_nc() {
		$sql="SELECT nc.cod_cf,nc.fornitore FROM nc_materiale nc
				GROUP BY nc.cod_cf
				ORDER BY nc.fornitore";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;
	}
	
	
	
	
	function tipo_prodotto_in_nc($periodo="",$count_tipo=0) {
		$cond="nc.dele=0 and re.stato=3";
		if (strlen($periodo)>0) {
			if (strlen($periodo)==7) {
				//mese-anno
				$info=explode("-",$periodo);
				$mese=$info[0];$anno=$info[1];
				$cond.=" and MONTH(nc.data_nc)='$mese' and YEAR(nc.data_nc)='$anno' ";
			}
			elseif (strlen($periodo)==10) {
				$cond.=" and nc.data_nc='$periodo' ";
			} else {
				$arr=explode(" ",$periodo);
				$cond.=" and nc.data_nc>='".$arr[0]."' and nc.data_nc<='".$arr[1]."' ";
			}
			
		}		
		$campi="t.*,re.tipo_prodotto";
		if ($count_tipo==1) $campi.=",count(t.id) q"; 
		$sql="SELECT $campi FROM tipo_prodotti t
				INNER JOIN recensione_prodotto re ON t.id=re.tipo_prodotto 
				INNER JOIN nc_prodotto nc ON re.id_pr=nc.id
				WHERE $cond
				GROUP BY t.id
				ORDER BY t.descrizione";

		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;
	}
	

	function lista_tipo_prodotti() {
		$sql="SELECT t.* FROM tipo_prodotti t
				WHERE t.dele=0
				ORDER BY t.descrizione";
		$result=$this->conn->query($sql);	
		$resp=array();
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;
	}

	//riferita al DB TARGET
	function get_code($protocollo) {
		$sql="SELECT cod_art,des_prod,quant_iniziale quant_da_prod FROM `ORP_EFF` WHERE doc_id='$protocollo'";
		$result=$this->conn->query($sql);	
		$resp=array();
		$resp['header']="KO";$resp['error']="nocode";
		if ($result = $this->conn->query($sql)) {
			$resp = $result->fetch_array();
			if (count($resp)!=0) {
				$resp['header']="OK";$resp['error']="";
			}	
			else {
				$resp['header']="KO";$resp['error']="nocode";
			}	
			
		}
		return $resp;
	}

	//riferita al DB TARGET
	function get_info_materiali($lotto) {
		
		$sql="SELECT it.doc_riga_id,it.nome_table,ana.cod_art,ana.des_art,CF.cod_cf,CF.rag_soc_cf
				FROM IT_CQ_SCHEDA it 
				JOIN ART_ANA ana ON it.cod_art=ana.cod_art 
				JOIN CF ON it.cod_cf=CF.cod_cf
				WHERE it.cod_lot='$lotto'";
	
		$resp=array();
		$resp['header']="KO";$resp['error']="nocode";
		if ($result = $this->conn->query($sql)) {
			$ris = $result->fetch_array();
			$nome_table=$ris['nome_table']."_RIGHE";
			$doc_riga_id=$ris['doc_riga_id'];
			
			$resp['header']="OK";
			$resp['cod_art']=$ris['cod_art'];
			$resp['des_art']=$ris['des_art'];
			$resp['cod_cf']=$ris['cod_cf'];
			$resp['rag_soc_cf']=$ris['rag_soc_cf'];
			
			
			$sql="SELECT mid(note,1,50) lotto_cf FROM  ART_LOT WHERE cod_art='".$ris['cod_art']."' and cod_lot='$lotto'";
			
			$resp['lotto_cf']="";
			if ($result = $this->conn->query($sql)) {
				$ris = $result->fetch_array();
				$resp['lotto_cf']=$ris['lotto_cf'];
			}
			
			/*
				In IT_CQ_SCHEDA c'è doc_riga_id ed anche nome_table (es: DDT_FOR) ---> vado su DD_FOR_{RIGHE} e con doc_riga_id vado a leggere la riga del doc di carico: quant_riga
				Siccome in locale la tabella potrebbe non esistere provvedo a fare un check sulla esistenza...in produzione dovrebbe sempre dare esiste==1
			*/
	
			$sql="SELECT EXISTS (
				SELECT 
					TABLE_NAME
				FROM 
				information_schema.TABLES 
				WHERE 
				TABLE_SCHEMA LIKE 'LIOFILCHEM' AND 
					TABLE_TYPE LIKE 'BASE TABLE' AND
					TABLE_NAME = '$nome_table'
				) esiste";
			$result = $this->conn->query($sql);
			$ris = $result->fetch_array();
			
			$resp['sql_esiste_tab']=$sql;
			$resp['esiste_tab_ref_righe']=$ris['esiste'];
			$resp['qta_fornita']="";
			if ($ris['esiste']=="1") {
				$sql="SELECT quant_riga qta_fornita FROM $nome_table WHERE doc_riga_id='$doc_riga_id'";
				$result = $this->conn->query($sql);
				$ris = $result->fetch_array();
				$resp['qta_fornita']=$ris['qta_fornita'];
			}
			
			
			
			
		}
		return $resp;
	}


	function tipo_nc($tipo,$id_ref=0) {
		$cond=" 1=1 ";
		if ($id_ref!=0) $cond.=" and id=$id_ref ";
		$sql="SELECT * FROM `tipo_nc` 
				WHERE id_tipo=$tipo and dele=0 and $cond
				ORDER BY descrizione";

		$resp=array();
		$result=$this->conn->query($sql);	
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}

		return $resp;	
	
	}
	
	function lista_nc($tipo=1,$periodo_ref="",$id_ref=0) {
		$tab="nc_prodotto";
		if ($tipo==1) $tab="nc_prodotto";
		if ($tipo==2) $tab="nc_materiale";
		$cond="1=2";
		
		if (strlen($periodo_ref)!=0)  {
			if (strlen($periodo_ref)>10) {
				$arr_p=explode(" ",$periodo_ref);
				$data1=$arr_p[0];$data2=$arr_p[1];
				$cond=" nc.data_nc>='$data1' and nc.data_nc<='$data2' ";
			}
			elseif (strlen($periodo_ref)==4) $cond=" mid(nc.data_nc,1,4)='$periodo_ref' ";			
			else {
				$periodo=substr($periodo_ref,0,4)."-".substr($periodo_ref,4);
				$cond=" mid(nc.data_nc,1,7)='$periodo' ";
			}	
		}
		if ($id_ref!=0 && strlen($id_ref)!=0) {
			$cond="(";
			$arr_id=explode("-",$id_ref);
			for ($sca=0;$sca<=count($arr_id)-1;$sca++) {
				if ($cond!="(") $cond.=" or ";
				$cond.=" nc.id=".$arr_id[$sca];
			}
			$cond.=")";
		}	

		//verifica dati POST in caso di ricerca
		$tipo_filtro="0";
		if (isset($_POST['tipo_filtro'])) $tipo_filtro=$_POST['tipo_filtro'];
		if (isset($_POST['btn_cerca']) && ($tipo_filtro=="1" || $tipo_filtro=="2")) {
			$tipo_filtro=$_POST['tipo_filtro'];			
			if ($tipo_filtro=="1" || $tipo_filtro=="2") {
				$str_cerca=$_POST['str_cerca'];
				$str_cerca=htmlspecialchars($str_cerca);
				$str_cerca=addslashes($str_cerca);
				
				if ($tipo_filtro=="1") {
					$field="nc.codice";
					if ($tipo==2) $field="nc.cod_art";
					$cond=" $field='$str_cerca' ";
				}
				if ($tipo_filtro=="2") {
					$field="nc.lotto";
					if ($tipo==2) $field="nc.lotto_liof";
					$cond=" $field='$str_cerca' ";
				}
			}
		}
		if (isset($_POST['filtro_segnalatore']) && $tipo_filtro=="3") {
			$filtro_segnalatore=$_POST['filtro_segnalatore'];
			$cond=" nc.id_oper='$filtro_segnalatore' ";
		}
		if (isset($_POST['filtro_reclamo_fornitore']) && $tipo_filtro=="3") {
			$filtro_reclamo_fornitore=$_POST['filtro_reclamo_fornitore'];
			$cond=" re.invio_reclamo_fornitore='$filtro_reclamo_fornitore' ";
		}
		if (isset($_POST['filtro_tipologia']) && $tipo_filtro=="4") {
			$filtro_tipologia=$_POST['filtro_tipologia'];
			$cond=" nc.tipo_nc='$filtro_tipologia' ";
		}
		if (isset($_POST['filtro_attrezzatura']) && $tipo_filtro=="5") {
			$filtro_attrezzatura=$_POST['filtro_attrezzatura'];
			$cond=" nc.attrezzature='$filtro_attrezzatura' ";
		}	
		if (isset($_POST['filtro_fornitore']) && $tipo_filtro=="5") {
			$filtro_fornitore=$_POST['filtro_fornitore'];
			$cond=" nc.cod_cf='$filtro_fornitore' ";
		}	

		if (isset($_POST['filtro_stato']) && $tipo_filtro=="6") {
			$filtro_stato=$_POST['filtro_stato'];
			$cond=" re.stato='$filtro_stato' ";
		}
		if (isset($_POST['filtro_reparto']) && $tipo_filtro=="7") {
			$filtro_reparto=$_POST['filtro_reparto'];
			$cond=" nc.reparto_where_nc='$filtro_reparto' ";
		}			
		if (isset($_POST['filtro_classificazioni']) && $tipo_filtro=="8") {
			$filtro_classificazioni=$_POST['filtro_classificazioni'];
			$cond=" re.classificazione_nc='$filtro_classificazioni' ";
		}			
		if (isset($_POST['filtro_tipo_prodotti']) && $tipo_filtro=="9") {
			$filtro_tipo_prodotti=$_POST['filtro_tipo_prodotti'];
			$cond=" re.tipo_prodotto='$filtro_tipo_prodotti' ";
		}
		if (isset($_POST['filtro_attivita']) && $tipo_filtro=="10") {
			$filtro_attivita=$_POST['filtro_attivita'];
			$cond=" re.attivita='$filtro_attivita' ";
		}
		if (isset($_POST['nuove'])) $cond=" re.stato='0' ";
		if (isset($_POST['visionate'])) $cond=" re.stato='1' ";
		if (isset($_POST['lavorazione'])) $cond=" re.stato='2' ";
		if (isset($_POST['concluse'])) $cond=" re.stato='3' ";
		//
		
		
		
		if ($tipo==1) {
			$desc="desc";
			if (strlen($periodo_ref)>10) $desc="";
			$campi_re="re.tipo_prodotto,re.stato,firma_valutazione1,data_valutazione1_nc,firma_valutazione2,data_valutazione2_nc,data_sezione_ris1,sign_ris1,data_sezione_ris2,sign_ris2,data_eliminazione_mv,sign_eliminazione_mv,data_eliminazione_mf,sign_eliminazione_mf,data_eliminazione_na,sign_eliminazione_na,data_chiusura_nc,sign_chiusura_nc";
			
			$sql="SELECT nc.*,r.reparto,$campi_re
					FROM $tab nc
					INNER JOIN reparti r ON nc.id_reparto_view=r.id
					INNER JOIN recensione_prodotto re ON re.id_pr=nc.id
					WHERE nc.dele=0 and $cond
					GROUP BY nc.id
					ORDER BY id $desc";
		}
		
		if ($tipo==2) {
			$desc="desc";
			if (strlen($periodo_ref)>10) $desc="";
			$campi_re="re.stato,re.firma_valutazione,re.data_valutazione,data_sezione_ris1,sign_ris1,data_sezione_ris2,sign_ris2,data_eliminazione_mv,sign_eliminazione_mv,data_eliminazione_mf,sign_eliminazione_mf,data_eliminazione_na,sign_eliminazione_na,data_chiusura_nc,sign_chiusura_nc";			
			$sql="SELECT nc.*,$campi_re
					FROM $tab nc
					INNER JOIN recensione_materiale re ON re.id_mt=nc.id
					WHERE nc.dele=0 and $cond
					GROUP BY nc.id
					ORDER BY id $desc";
		}

		$resp=array();
		$result=$this->conn->query($sql);	
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}

		return $resp;	
	}
	
	
	

	public function elenco_utenti($id=0,$team=0) {
		$cond="";
		if ($team==1) $cond="and t.abilitato=1";
		$sql ="SELECT u.id,u.operatore,u.nc_access,t.email,t.abilitato FROM `Sql58368_4`.`utenti` u
				LEFT OUTER JOIN `nc`.team t ON u.id=t.id_user
				WHERE u.id>1 $cond
				ORDER BY operatore";
		$resp=array();
		$result=$this->conn->query($sql);	
		while($results = $result->fetch_assoc()){
			$resp[]=$results;
		}
		return $resp;	
	}
	
	public function set_utenti($id_u,$service,$team,$txt_mail) {
		$email=addslashes($email);
		$resp=array();
		$sql="SELECT COUNT(id) q 
				FROM `nc`.team 
				WHERE id_user=$id_u";

		$result = $this->conn->query($sql);
		$res = $result->fetch_row();
		$q=$res[0];
		
		if ($q!=0) {
			$sql="UPDATE `nc`.team 
					SET abilitato=$team, email='$txt_mail' 
					WHERE id_user=$id_u";
			
			if (!$result = $this->conn->query($sql)) {
				$resp['header']="KO";$resp['error']=$this->conn->error;
				return $resp;
			}
		} else {
			$sql="INSERT INTO `nc`.team (id_user, abilitato, email) VALUES($id_u, $team,'$txt_mail')";
			$result = $this->conn->query($sql);
		}
		

		$sql="UPDATE `Sql58368_4`.`utenti` 
		SET nc_access=$service
		WHERE id=$id_u";

		if ($result = $this->conn->query($sql)) {
			$resp['header']="OK";$resp['error']="";
		}	
		else {
			$resp['header']="KO";$resp['error']=$this->conn->error;
		}
		
		return $resp;
	}


	public function info_stat_tipo($id_tipo,$periodo) {
		$cond="re.stato=3 and nc.dele=0 and re.tipo_prodotto=$id_tipo";
		if (strlen($periodo)>0) {
			if (strlen($periodo)==10) {
				$cond.=" and nc.data_nc='$periodo'";
			} else {
				$arr=explode(" ",$periodo);
				$cond.=" and nc.data_nc>='".$arr[0]."' and nc.data_nc<='".$arr[1]."' ";
			}
			
		}

		$resp=array();
		
		$sql="SELECT COUNT(re.id) q FROM `recensione_prodotto` re
				INNER JOIN nc_prodotto nc ON re.id_pr=nc.id
				WHERE $cond";
		$result = $this->conn->query($sql);
		$res = $result->fetch_row();
		$q=$res[0];if ($q==0) $q="";
		$resp['num_nc']=$q;
		
		/*
			1 Accettare il prodotto
			2 Rilavorare il prodotto
			3 Selezionare ed eliminare i pezzi non conformi
			4 Eliminare l'intero lotto
		*/
		for ($sca=1;$sca<=4;$sca++) {
			$sql="SELECT COUNT(re.id) q FROM `recensione_prodotto` re
					INNER JOIN nc_prodotto nc ON re.id_pr=nc.id
					WHERE $cond and attivita=$sca";

			$result = $this->conn->query($sql);
			$res = $result->fetch_row();
			$q=$res[0];if ($q==0) $q="";
			if ($sca==1) $resp['att1']=$q; 
			if ($sca==2) $resp['att2']=$q; 
			if ($sca==3) $resp['att3']=$q; 
			if ($sca==4) $resp['att4']=$q; 
		}


		
		
		return $resp;
	}

	///////////////////////////////// function per le statistiche
	function classificazioni_in_nc_extra($periodo="",$tipo_prodotto="") {
		$cond="nc.dele=0 and re.stato=3";
		if (strlen($tipo_prodotto)!=0) {
			$cond.=" and tipo_prodotto='$tipo_prodotto'";
		}

		if (strlen($periodo)>0) {
			if (strlen($periodo)==10) {
				$cond.=" and nc.data_nc='$periodo' ";
			} else {
				$arr=explode(" ",$periodo);
				$cond.=" and nc.data_nc>='".$arr[0]."' and nc.data_nc<='".$arr[1]."' ";
			}
			
		}		
		$sql="SELECT re.attivita,c.id id_class,c.descrizione,count(c.id) q FROM classificazioni_nc c
				INNER JOIN recensione_prodotto re ON c.id=re.classificazione_nc 
				INNER JOIN nc_prodotto nc ON nc.id=re.id_pr
				WHERE $cond
				GROUP BY c.id
				ORDER BY c.descrizione";
		$result=$this->conn->query($sql);	
		$resp=array();
		
		while($results = $result->fetch_assoc()){
			$q_periodo=$results['q'];
			$results['q_periodo']=$q_periodo;
			$id_class=$results['id_class'];
			$sql="SELECT nc.id FROM classificazioni_nc c
					INNER JOIN recensione_prodotto re ON c.id=re.classificazione_nc 
					INNER JOIN nc_prodotto nc ON nc.id=re.id_pr
					WHERE $cond and re.classificazione_nc=$id_class";
			$res1=$this->conn->query($sql);	
			$id_ref_nc="";	
			while($resx = $res1->fetch_assoc()){
				if (strlen($id_ref_nc)!=0) $id_ref_nc.="-";
				$id_ref_nc.=$resx['id'];
			}
			$results['id_ref_nc']=$id_ref_nc;
			/*
				1 Accettare il prodotto
				2 Rilavorare il prodotto
				3 Selezionare ed eliminare i pezzi non conformi
				4 Eliminare l'intero lotto
			*/
			for ($sca=1;$sca<=4;$sca++) {
				$sql="SELECT COUNT(re.id) q FROM `recensione_prodotto` re
						INNER JOIN nc_prodotto nc ON re.id_pr=nc.id
						WHERE $cond and attivita=$sca and re.classificazione_nc=$id_class";

				$res2 = $this->conn->query($sql);
				$resy = $res2->fetch_row();
				$q=$resy[0];if ($q==0) $q="";
				if ($sca==1) $results['att1']=$q; 
				if ($sca==2) $results['att2']=$q; 
				if ($sca==3) $results['att3']=$q; 
				if ($sca==4) $results['att4']=$q; 
			}		

			$resp['info_class'][]=$results;

		}

		return $resp;
	}	
	
	function analisi_anno($tipo_analisi) {
		$anno=date("Y");		
		if ($tipo_analisi=="2") $anno=$anno-1;
		if ($tipo_analisi=="3") $anno=$anno-2;
		$cond="YEAR(data_nc)='$anno' and nc.dele=0 and re.stato=3";
		$sql="SELECT COUNT(nc.id) q FROM nc_prodotto nc
				INNER JOIN recensione_prodotto re ON re.id_pr=nc.id
				WHERE $cond";

		$result = $this->conn->query($sql);
		$res = $result->fetch_row();
		$q=$res[0];
		$resp['num_nc_anno']=$q;

		$sql="SELECT nc.data_nc FROM nc_prodotto nc
				INNER JOIN recensione_prodotto re ON re.id_pr=nc.id				
				WHERE $cond
				ORDER BY nc.id desc
				LIMIT 0,1";

		$result = $this->conn->query($sql);
		$res = $result->fetch_row();
		$data_ultimo_ins=$res[0];
		$resp['data_ultimo_ins']=$data_ultimo_ins;

		for ($sca=1;$sca<=12;$sca++) {
			$cond="MONTH(nc.data_nc)=$sca and YEAR(nc.data_nc)='$anno' and nc.dele=0 and re.stato=3";
			$sql="SELECT COUNT(nc.id) q FROM nc_prodotto nc
					INNER JOIN recensione_prodotto re ON re.id_pr=nc.id
					WHERE $cond";
					
			$result = $this->conn->query($sql);
			$res = $result->fetch_row();
			$q=$res[0];if ($q==0) $q="";
			$pref="";
			if ($sca<=9) $pref="0";
			$indice="nc_".$pref.$sca;
			$resp[$indice]=$q;
				
				

			$sql="SELECT nc.id FROM nc_prodotto nc
					INNER JOIN recensione_prodotto re ON re.id_pr=nc.id
					WHERE $cond";
					
			$res1=$this->conn->query($sql);	
			
			
			$id_ref="";
			while($resx = $res1->fetch_assoc()){
				if (strlen($id_ref)!=0) $id_ref.="-";
				$id_ref.=$resx['id'];
			}
			$resp[$indice."_id"]=$id_ref;

			
			$periodo_ref=$pref.$sca."-".$anno;
			$tipo_prodotto_in_nc=$this->tipo_prodotto_in_nc($periodo_ref,1);
			$resp['analisi_prodotto'][$sca]=$tipo_prodotto_in_nc;
			
			$elenco_lotti=$this->elenco_lotti($periodo_ref);
			$resp['elenco_lotti'][$sca]=$elenco_lotti;
		}

		return $resp;		
	}
	
	function elenco_lotti($periodo) {
		$periodo=explode("-",$periodo);
		$mese=$periodo[0];$anno=$periodo[1];
		$cond="DBcontrollo<>'!' and MONTH(DBdata)=$mese and YEAR(DBdata)=$anno";
		$sql="SELECT COUNT(id) q 
				FROM `Sql58368_4`.impegnolotti i 
				WHERE $cond";
		$result = $this->conn->query($sql);
		$res = $result->fetch_row();
		$q=$res[0];
		return $q;
	}
	


}
?>
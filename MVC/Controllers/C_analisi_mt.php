<?php

	$main_all = new Main_all($db);
	$classificazioni=$main_all->classificazioni(0);

	$id_ref=0;
	if (isset($_GET['id_ref'])) $id_ref=$_GET['id_ref'];
	
	$analisi_mt = new Analisi_mt($db);
	

	$sign_valutazione=array();
	if (isset($_POST['submit_sign_valutazione'])) 
		$sign_valutazione=$analisi_mt->sign_valutazione($id_ref); 



	if (isset($_POST['btn_sign_sezione_ris1']) || isset($_POST['btn_sign_sezione_ris2'])) {		
		$info_nc_mt=$analisi_mt->info_nc_mt($id_ref);

		/*
			invio mail di notifica al team se precedentemente non inviato
			basta che si apponga una delle due firme nella sezione Risoluzione
			N.B.
			Faccio questa verifica per l'invio mail in questo preciso punto del flusso perchè altrimenti poi la firma viene apposta e non entra nella condizione successiva
		*/
		$str_team=null;
		if (isset($_POST['team'])) {
			$str_team=implode(";",$_POST['team']);
		}			
		

		if (($info_nc_mt[0]['sign_ris1']==0 && $info_nc_mt[0]['sign_ris2']==0)) {
			if ($str_team!=null) {
				
				
				$ref=$id_ref;
				//recupero tutte le Email associate agli operatore del Team
				$elenco_mail_team=$analisi_mt->elenco_mail_team($str_team);
				$protocollo_nc=$info_nc_mt[0]['protocollo_nc'];
				$lotto=$info_nc_mt[0]['lotto_liof'];
				$cod_art=$info_nc_mt[0]['cod_art'];
				$ref_lnk="nc_mt=$ref";
				$descr_art=$info_nc_mt[0]['descr_art'];
				$subject="Invito alla risoluzione della NC di materiale";
				include("send_notifica_team.php");
			}
		}

		
	}

	$sign_ris1=array();
	if (isset($_POST['btn_sign_sezione_ris1'])) $sign_ris1=$analisi_mt->sign_ris($id_ref,1); 
	
	$sign_ris2=array();
	if (isset($_POST['btn_sign_sezione_ris2'])) $sign_ris2=$analisi_mt->sign_ris($id_ref,2); 

	$sign_eliminazione_mv=array();
	if (isset($_POST['btn_sign_eliminazione_mv'])) $sign_eliminazione_mv=$analisi_mt->sign_ris($id_ref,3); 
	
	$sign_eliminazione_mf=array();
	if (isset($_POST['btn_sign_eliminazione_mf'])) $sign_eliminazione_mf=$analisi_mt->sign_ris($id_ref,4); 

	$sign_eliminazione_na=array();
	if (isset($_POST['btn_sign_eliminazione_na'])) $sign_eliminazione_na=$analisi_mt->sign_ris($id_ref,40); 

	$sign_chiusura_nc=array();
	if (isset($_POST['btn_sign_chiusura_nc'])) $sign_chiusura_nc=$analisi_mt->sign_ris($id_ref,5); 



	$info_nc_mt=$analisi_mt->info_nc_mt($id_ref);

	
	$check_sign_valutazione=false;
	if ($info_nc_mt[0]['nc_rilevata']==null) $check_sign_valutazione=true;
	
	$check_sign_ris1=true;
	if ($info_nc_mt[0]['sign_ris1']!=0) $check_sign_ris1=false;

	$check_sign_ris2=true;
	if ($info_nc_mt[0]['sign_ris2']!=0) $check_sign_ris2=false;

	$check_sign_eliminazione_mv=true;
	if ($info_nc_mt[0]['sign_eliminazione_mv']!=0) $check_sign_eliminazione_mv=false;

	$check_sign_eliminazione_mf=true;
	if ($info_nc_mt[0]['sign_eliminazione_mf']!=0) $check_sign_eliminazione_mf=false;

	$check_sign_eliminazione_na=true;
	if ($info_nc_mt[0]['sign_eliminazione_na']!=0) $check_sign_eliminazione_na=false;


	$check_sign_chiusura_nc=true;
	if ($info_nc_mt[0]['sign_chiusura_nc']!=0) $check_sign_chiusura_nc=false;

	$elenco_team=$main_all->elenco_utenti(0,1);



?>
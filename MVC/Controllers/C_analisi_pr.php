<?php

	$main_all = new Main_all($db);
	$classificazioni=$main_all->classificazioni(0);

	$id_ref=0;
	if (isset($_GET['id_ref'])) $id_ref=$_GET['id_ref'];
	
	$analisi_pr = new Analisi_pr($db);
	if (isset($_POST['btn_ins_nc_pr'])) {
		$resp_ins=$analisi_pr->update_recensione_pr();
	}		

	$sign_valutazione=array();
	if (isset($_POST['submit_sign_valutazione']) && ($_POST['submit_sign_valutazione']=="1" || $_POST['submit_sign_valutazione']=="2")) 
		$sign_valutazione=$analisi_pr->sign_valutazione($id_ref,$_POST['submit_sign_valutazione']); 




	if (isset($_POST['btn_sign_sezione_ris1']) || isset($_POST['btn_sign_sezione_ris2'])) {		
		$info_nc_pr=$analisi_pr->info_nc_pr($id_ref);

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
		

		if (($info_nc_pr[0]['sign_ris1']==0 && $info_nc_pr[0]['sign_ris2']==0)) {
			if ($str_team!=null) {
				$ref=$id_ref;
				//recupero tutte le Email associate agli operatore del Team
				$elenco_mail_team=$analisi_pr->elenco_mail_team($str_team);
				$protocollo_nc=$info_nc_pr[0]['protocollo_nc'];
				$lotto=$info_nc_pr[0]['lotto'];
				$cod_art=$info_nc_pr[0]['codice'];
				$ref_lnk="nc=$ref";
				$descr_art=$info_nc_pr[0]['descrizione'];
				$subject="Invito alla risoluzione della NC di prodotto";
				include("send_notifica_team.php");
			}
		}

		if (($info_nc_pr[0]['sign_ris1']!=0 || $info_nc_pr[0]['sign_ris2']!=0)) {
			//creazione pdf per eventuale rilavorazione
			if ($info_nc_pr[0]['attivita']==2) {
				require('../../fpdi/fpdf.php'); 
				require('../../fpdi/fpdi.php');
				class PDF extends FPDI{

				}	
				$pdf = new PDF('L', 'mm');
				$pdf->SetAutoPageBreak(false);
				$pdf->SetAuthor('Liofilchem srl');
				$pdf->SetTitle('Modulo Rilavorazione');
				
				$pdf->AddPage('P'); 
				$pdf->SetMargins(0,0,0);

				$pdf->setSourceFile('schema1.pdf'); 
				// set the sourcefile 
				// import page 1 
				$tplIdx = $pdf->importPage(1); 
				// use the imported page as the template 
				$pdf->useTemplate($tplIdx, 0, 0); 
				$pdf->SetFont('Times','B',12);
				//$pdf->SetTextColor(255,0,0); 
				$pdf->SetXY(70,40);
				$pdf->Write(0, $info_nc_pr[0]['codice']);
				$pdf->SetXY(70,45);
				$pdf->Write(0, $info_nc_pr[0]['descrizione']);
				$pdf->SetXY(70,50);
				$pdf->Write(0, $info_nc_pr[0]['lotto']);
				$pdf->SetXY(70,55);
				$pdf->Write(0, $info_nc_pr[0]['new_lotto']);
				$pdf->SetXY(70,60);
				$pdf->Write(0, $info_nc_pr[0]['scadenza']);
				$pdf->SetXY(18,75);
				$pdf->SetFont('Times','B',9);
				$pdf->MultiCell(172,5,$info_nc_pr[0]['attivita_sul_prodotto'],0,'L');				
				$pdf->SetXY(18,111);
				$pdf->MultiCell(172,5,$info_nc_pr[0]['effetti_avversi'],0,'L');				
				$pdf->SetXY(18,135);
				$pdf->MultiCell(172,4,$info_nc_pr[0]['attivita_controllo'],0,'L');				
				$pdf->SetXY(18,172);
				$pdf->MultiCell(172,5,$info_nc_pr[0]['istruzioni_operative'],0,'L');				
				
				$pdf->AddPage('P'); 
				$pdf->SetMargins(0,0,0);
				// set the sourcefile 
				// import page 2 
				$tplIdx = $pdf->importPage(2); 
				$pdf->useTemplate($tplIdx, 0, 0); 

				$pdf->Output("pdf_rilavorazioni/$id_ref.pdf","F");	
			}
		}
		
	}

	$sign_ris1=array();
	if (isset($_POST['btn_sign_sezione_ris1'])) $sign_ris1=$analisi_pr->sign_ris($id_ref,1); 
	
	$sign_ris2=array();
	if (isset($_POST['btn_sign_sezione_ris2'])) $sign_ris2=$analisi_pr->sign_ris($id_ref,2); 

	$sign_eliminazione_mv=array();
	if (isset($_POST['btn_sign_eliminazione_mv'])) $sign_eliminazione_mv=$analisi_pr->sign_ris($id_ref,3); 
	
	$sign_eliminazione_mf=array();
	if (isset($_POST['btn_sign_eliminazione_mf'])) $sign_eliminazione_mf=$analisi_pr->sign_ris($id_ref,4); 

	$sign_eliminazione_na=array();
	if (isset($_POST['btn_sign_eliminazione_na'])) $sign_eliminazione_na=$analisi_pr->sign_ris($id_ref,40); 

	$sign_chiusura_nc=array();
	if (isset($_POST['btn_sign_chiusura_nc'])) $sign_chiusura_nc=$analisi_pr->sign_ris($id_ref,5); 



	$info_nc_pr=$analisi_pr->info_nc_pr($id_ref);

	
	$check_sign=true;
	if ($info_nc_pr[0]['tipo_prodotto']==null || $info_nc_pr[0]['nc_rilevata']==null || $info_nc_pr[0]['classificazione_nc']==null || $info_nc_pr[0]['txt_man']==null || $info_nc_pr[0]['man_sn'] ==null || $info_nc_pr[0]['txt_method']==null || $info_nc_pr[0]['method_sn']==null || $info_nc_pr[0]['txt_material']==null || $info_nc_pr[0]['material_sn']==null || $info_nc_pr[0]['txt_machine']==null || $info_nc_pr[0]['machine_sn']==null || $info_nc_pr[0]['txt_enviroment']==null || $info_nc_pr[0]['enviroment_sn'] ==null) $check_sign=false;
	
	$check_sign_ris1=true;
	if ($info_nc_pr[0]['sign_ris1']!=0) $check_sign_ris1=false;

	$check_sign_ris2=true;
	if ($info_nc_pr[0]['sign_ris2']!=0) $check_sign_ris2=false;

	$check_sign_eliminazione_mv=true;
	if ($info_nc_pr[0]['sign_eliminazione_mv']!=0) $check_sign_eliminazione_mv=false;

	$check_sign_eliminazione_mf=true;
	if ($info_nc_pr[0]['sign_eliminazione_mf']!=0) $check_sign_eliminazione_mf=false;

	$check_sign_eliminazione_na=true;
	if ($info_nc_pr[0]['sign_eliminazione_na']!=0) $check_sign_eliminazione_na=false;


	$check_sign_chiusura_nc=true;
	if ($info_nc_pr[0]['sign_chiusura_nc']!=0) $check_sign_chiusura_nc=false;

	$elenco_team=$main_all->elenco_utenti(0,1);
	$lista_tipo_prodotti=$main_all->lista_tipo_prodotti();


?>
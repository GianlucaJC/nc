<?php
session_start();
include_once '../../database.php';

$database = new Database();
$db = $database->getConnection();
$dbT = $database->getConnTarget();
include_once '../../MVC/Models/M_main.php';
include_once '../../MVC/Models/M_analisi_pr.php';
include_once '../../MVC/Models/M_analisi_mt.php';

$main = new Main_all($db);
$analisi_pr = new Analisi_pr($db);
$analisi_mt = new Analisi_mt($db);
$main_T = new Main_all($dbT);

	
$operazione=$_POST['operazione'];
$dominio="http://liojls01.ad.liofilchem.net/nc/pages";
if (isLocalhost()) $dominio="http://localhost/servizi_liofilchem/nc/pages";

if ($operazione=="prepara_pdf") {
	$id_ref=$_POST['id_ref'];
	@unlink("rapporti/".$id_ref.".pdf");

	$info_nc_pr=$main->lista_nc(1,$periodo_ref="",$id_ref);
	$info_nc_pr_analisi=$analisi_pr->info_nc_pr($id_ref);
	
	require('../../fpdi/fpdf.php'); 
	require('../../fpdi/fpdi.php');
	class PDF extends FPDI{
		protected $B = 0;
		protected $I = 0;
		protected $U = 0;
		protected $HREF = '';		
		function SetStyle($tag, $enable){
			// Modify style and select corresponding font
			$this->$tag += ($enable ? 1 : -1);
			$style = '';
			foreach(array('B', 'I', 'U') as $s)
			{
				if($this->$s>0)
					$style .= $s;
			}
			$this->SetFont('',$style);
		}
								
		function PutLink($URL, $txt){
			// Put a hyperlink
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}

	}	
	$elenco_utenti=$main->array_utenti_bis();

	$pdf = new PDF('L', 'mm');
	$pdf->SetAutoPageBreak(false);
	$pdf->SetAuthor('Liofilchem srl');
	$pdf->SetTitle('MOD_52');
	
	$pdf->AddPage('P'); 
	$pdf->SetMargins(0,0,0);

	$pdf->setSourceFile('mod52_prodotto.pdf'); 
	// set the sourcefile 
	// import page 1 
	$tplIdx = $pdf->importPage(1); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0); 
	$pdf->SetFont('Times','',11);
	//$pdf->SetTextColor(255,0,0); 

	$protocollo_nc=$info_nc_pr[0]['protocollo_nc'];
	$pdf->SetXY(163,35.2);
	$pdf->Write(0, $protocollo_nc );
	
	$data_nc=$info_nc_pr[0]['data_nc'];
	$data_nc=date("d-m-Y",strtotime($data_nc));
	$pdf->SetXY(31,47.5);
	$pdf->Write(0, $data_nc );
	
	
	$reparto_where_nc=$info_nc_pr[0]['reparto_where_nc'];
	$arr_risp=$main->reparti($reparto_where_nc);
	$descr_reparto=$arr_risp[0]['reparto'];
	$descr_reparto = iconv('UTF-8', 'windows-1252', $descr_reparto);
	$pdf->SetXY(96,54);
	$pdf->Write(0, $descr_reparto);
	
	$id_reparto_view=$info_nc_pr[0]['id_reparto_view'];
	$arr_risp=$main->reparti($id_reparto_view);
	$descr_reparto=$arr_risp[0]['reparto'];
	$descr_reparto = iconv('UTF-8', 'windows-1252', $descr_reparto);
	$pdf->SetXY(92,60.5);
	$pdf->Write(0, $descr_reparto);


	$pdf->SetXY(36,67.5);
	$pdf->Write(0, $info_nc_pr[0]['codice']);


	$pdf->SetXY(103,64.5);
	$descrizione=$info_nc_pr[0]['descrizione'];
	$descrizione = iconv('UTF-8', 'windows-1252', $descrizione);
	$pdf->MultiCell(70,4,stripslashes($descrizione),0,'L');


	$pdf->SetXY(33,74);
	$pdf->Write(0, $info_nc_pr[0]['lotto']);
	
	$id_attrezzatura=$info_nc_pr[0]['attrezzature'];
	$arr_risp=$main->list_attrezzature($id_attrezzatura,0);
	$attrezzatura=$arr_risp[0]['attrezzatura'];
	$attrezzatura = iconv('UTF-8', 'windows-1252', $attrezzatura);
	
	$pdf->SetXY(120,74);
	$pdf->Write(0, $attrezzatura);	
	
	$pdf->SetXY(53,81);
	$pdf->Write(0, $info_nc_pr[0]['qta_ric']);

	$pdf->SetXY(113,81);
	$pdf->Write(0, $info_nc_pr[0]['qta_prod']);

	$pdf->SetXY(61,87.5);
	$pdf->Write(0, $info_nc_pr[0]['qta_nc']);

	$pdf->SetXY(114,87.5);
	$pdf->Write(0, $info_nc_pr[0]['qta_dele']);
	
	$tipo_nc=$info_nc_pr[0]['tipo_nc'];
	$arr_risp=$main->tipo_nc(1,$tipo_nc);
	$descrizione=$arr_risp[0]['descrizione'];
	$pdf->SetXY(69,92.2);
	$descrizione = iconv('UTF-8', 'windows-1252', $descrizione);
	//$pdf->Write(0, $descrizione);
	$pdf->MultiCell(122,4,stripslashes($descrizione),0,'L');
	
	$pdf->SetXY(20,103);
	$pdf->SetFont('Times','',9);
	$descrizione=$info_nc_pr[0]['descrizione_nc'];
	$descrizione = iconv('UTF-8', 'windows-1252', $descrizione);
	$pdf->MultiCell(172,5,$descrizione,0,'L');
	
	$pdf->SetFont('Times','',11);
	$id_oper=$info_nc_pr[0]['id_oper'];
	$segnalato_da=$elenco_utenti[$id_oper]['operatore'];
	$pdf->SetXY(48,120);
	$pdf->Write(0, $segnalato_da);	


	///ANALISI
	$pdf->SetFont('Times','',9);
	$nc_rilevata=$info_nc_pr_analisi[0]['nc_rilevata'];
	if ($nc_rilevata=="1" || $nc_rilevata=="2") {
		if ($nc_rilevata=="1")
			$pdf->SetXY(73,134.5);		
		if ($nc_rilevata=="2")
			$pdf->SetXY(135.5,134.5);
		$pdf->Write(0, "X");	
	}
	
	
	$classificazione_nc=$info_nc_pr_analisi[0]['classificazione_nc'];
	$arr_risp=$main->classificazioni($classificazione_nc);
	$descrizione="";
	if (isset($arr_risp[0]['descrizione'])) $descrizione=stripcslashes($arr_risp[0]['descrizione']);
	$descrizione = iconv('UTF-8', 'windows-1252', $descrizione);
	
	$pdf->SetXY(83,141);
	$pdf->Write(0, $descrizione);	
	
	
	$pdf->SetFont('Times','',11);
	
	$pdf->SetXY(64,155);
	$txt_man=$info_nc_pr_analisi[0]['txt_man'];
	$txt_man = iconv('UTF-8', 'windows-1252', $txt_man);
	
	$pdf->MultiCell(100,5,stripslashes($txt_man),0,'L');	

	$sn=$info_nc_pr_analisi[0]['man_sn'];
	if ($sn=="1" || $sn=="0") {
		if ($sn=="1")
			$pdf->SetXY(165,165);		
		if ($sn=="0")
			$pdf->SetXY(177,165);
		$pdf->Write(0, "X");	
	}


	$pdf->SetXY(64,175);
	
	$txt_method=stripslashes($info_nc_pr_analisi[0]['txt_method']);
	$txt_method = iconv('UTF-8', 'windows-1252', $txt_method);
	$pdf->MultiCell(100,5,$txt_method,0,'L');	

	$sn=$info_nc_pr_analisi[0]['method_sn'];
	if ($sn=="1" || $sn=="0") {
		if ($sn=="1")
			$pdf->SetXY(165,185);		
		if ($sn=="0")
			$pdf->SetXY(177,185);
		$pdf->Write(0, "X");	
	}

	$pdf->SetXY(64,195);
	$txt_material=stripslashes($info_nc_pr_analisi[0]['txt_material']);
	$txt_material = iconv('UTF-8', 'windows-1252', $txt_material);
	
	$pdf->MultiCell(100,5,$txt_material,0,'L');	

	$sn=$info_nc_pr_analisi[0]['material_sn'];
	if ($sn=="1" || $sn=="0") {
		if ($sn=="1")
			$pdf->SetXY(165,205.5);		
		if ($sn=="0")
			$pdf->SetXY(177,205.5);
		$pdf->Write(0, "X");	
	}



	$pdf->SetXY(64,215);
	$txt_machine=stripslashes($info_nc_pr_analisi[0]['txt_machine']);
	$txt_machine = iconv('UTF-8', 'windows-1252', $txt_machine);
		
	$pdf->MultiCell(100,5,$txt_machine,0,'L');	

	$sn=$info_nc_pr_analisi[0]['machine_sn'];
	if ($sn=="1" || $sn=="0") {
		if ($sn=="1")
			$pdf->SetXY(165,225.5);		
		if ($sn=="0")
			$pdf->SetXY(177,225.5);
		$pdf->Write(0, "X");	
	}
	

	$pdf->SetXY(64,235);
	$txt_enviroment=stripslashes($info_nc_pr_analisi[0]['txt_enviroment']);
	$txt_enviroment = iconv('UTF-8', 'windows-1252', $txt_enviroment);

	$pdf->MultiCell(100,5,$txt_enviroment,0,'L');	

	$sn=$info_nc_pr_analisi[0]['enviroment_sn'];
	if ($sn=="1" || $sn=="0") {
		if ($sn=="1")
			$pdf->SetXY(165,245.5);
		if ($sn=="0")
			$pdf->SetXY(177,245.5);
		$pdf->Write(0, "X");	
	}	
	

	
	$pdf->SetXY(37,256);
	$pdf->SetTextColor(0,0,255);
	$pdf->SetStyle('U',true);
	$perc="../analisi_pr/allegati/$id_ref";
	$files = glob("$perc/*.{JPG,JPEG,PNG,GIF,PDF,DOC,DOCX,ODT,jpg,jpeg,png,gif,pdf,doc,docx,odt}", GLOB_BRACE);
	$cont=0;
	foreach($files as $file) {
		$cont++;
		$url=$dominio.$file;
		$url=str_replace("../","/",$url);
		
		$t1="Allegato $cont";
	
		$pdf->Cell(21,3,$t1,'LR',0,'L',false,$url);
	}
	$pdf->SetStyle('U',false);
	$pdf->SetTextColor(0);	
	
	
	$pdf->SetFont('Times','',11);
	$data_valutazione1_nc=$info_nc_pr_analisi[0]['data_valutazione1_nc'];
	if ($data_valutazione1_nc!=null) {
		$data_valutazione1_nc=date("d-m-Y",strtotime($data_valutazione1_nc));
		$pdf->SetXY(31,264);
		$pdf->Write(0, $data_valutazione1_nc);
	}
	$firma_valutazione1=$info_nc_pr_analisi[0]['firma_valutazione1'];
	if ($firma_valutazione1!=0) {
		$firma_estesa=$elenco_utenti[$firma_valutazione1]['operatore'];	
		$pdf->SetXY(77,264);
		$pdf->Write(0, $firma_estesa);
	}
	

	$data_valutazione2_nc=$info_nc_pr_analisi[0]['data_valutazione2_nc'];
	if ($data_valutazione1_nc!=null) {
		$data_valutazione2_nc=date("d-m-Y",strtotime($data_valutazione2_nc));
		$pdf->SetXY(31,271);
		$pdf->Write(0, $data_valutazione2_nc);
	}
	
	$firma_valutazione2=$info_nc_pr_analisi[0]['firma_valutazione2'];
	if ($firma_valutazione1!=0) {
		$firma_estesa=$elenco_utenti[$firma_valutazione2]['operatore'];
		$pdf->SetXY(77,271);
		$pdf->Write(0, $firma_estesa);
	}
	
	
	$pdf->AddPage('P'); 
	$pdf->SetMargins(0,0,0);

	$pdf->setSourceFile('mod52_prodotto.pdf'); 
	$tplIdx = $pdf->importPage(2); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0); 
	$pdf->SetFont('Times','',11);	
	
	$attivita=$info_nc_pr_analisi[0]['attivita'];
	if ($attivita!=0) {
		if ($attivita=="1") $pdf->SetXY(20.5,42);
		if ($attivita=="2") $pdf->SetXY(109.3,42);
		if ($attivita=="3") $pdf->SetXY(20.5,49);
		if ($attivita=="4") $pdf->SetXY(109.6,49);
		
		$pdf->Write(0, "x");
	}
	
	
	$pdf->SetXY(20,58);
	$pdf->SetFont('Times','',9);
	$note=stripslashes($info_nc_pr_analisi[0]['note']);
	$note = iconv('UTF-8', 'windows-1252', $note);
	
	$pdf->MultiCell(170,5,$note,0,'L');
	
	
	
	$str_team=$info_nc_pr_analisi[0]['team'];
	$arr_team=explode(";",$str_team);
	$pdf->SetXY(20,86);
	$elem_t="";
	for ($sca=0;$sca<=count($arr_team)-1;$sca++) {
		$tx=$arr_team[$sca];
		if (isset($elenco_utenti[$tx]['operatore'])) {
			if (strlen($elem_t)!=0) $elem_t.=", ";
			$elem_t.=$elenco_utenti[$tx]['operatore'];
		}
	}
	$pdf->SetFont('Times','',11);
	$pdf->MultiCell(170,5,stripslashes($elem_t),0,'L');

	$pdf->SetXY(20,105);
	$pdf->SetFont('Times','',11);
	$informazione_organizzazioni=stripslashes($info_nc_pr_analisi[0]['informazione_organizzazioni']);
	$informazione_organizzazioni = iconv('UTF-8', 'windows-1252', $informazione_organizzazioni);	
	$pdf->MultiCell(170,5,$informazione_organizzazioni,0,'L');

	
	$pdf->SetFont('Times','',11);
	$data_sezione_ris1=$info_nc_pr_analisi[0]['data_sezione_ris1'];
	if ($data_sezione_ris1!=null) {
		$data_sezione_ris1=date("d-m-Y",strtotime($data_sezione_ris1));
		$pdf->SetXY(31,122);
		$pdf->Write(0, $data_sezione_ris1);
	}
	$sign_ris1=$info_nc_pr_analisi[0]['sign_ris1'];
	if ($sign_ris1!=0) {
		$firma_estesa=$elenco_utenti[$sign_ris1]['operatore'];	
		$pdf->SetXY(91,122);
		$pdf->Write(0, $firma_estesa);
	}
		
	$azione_correttiva=$info_nc_pr_analisi[0]['azione_correttiva'];
	if ($azione_correttiva!=null) {
		if ($azione_correttiva=="1") $pdf->SetXY(91,129);
		if ($azione_correttiva=="0") $pdf->SetXY(103,129);
		//if ($azione_correttiva=="0") $pdf->SetXY(109.3,42);
		$pdf->Write(0, "x");
	}		
	$pdf->SetXY(20,139);
	$pdf->SetFont('Times','',11);
	$pdf->MultiCell(170,5,stripslashes($info_nc_pr_analisi[0]['motivazione_azione']),0,'L');
	


	$pdf->SetFont('Times','',11);
	$data_sezione_ris2=$info_nc_pr_analisi[0]['data_sezione_ris2'];
	if ($data_sezione_ris2!=null) {
		$data_sezione_ris2=date("d-m-Y",strtotime($data_sezione_ris2));
		$pdf->SetXY(31,156);
		$pdf->Write(0, $data_sezione_ris2);
	}
	$sign_ris2=$info_nc_pr_analisi[0]['sign_ris2'];
	if ($sign_ris2!=0) {
		$firma_estesa=$elenco_utenti[$sign_ris2]['operatore'];	
		$pdf->SetXY(91,156);
		$pdf->Write(0, $firma_estesa);
	}	
	
	$eliminato_magazzino_virtuale=$info_nc_pr_analisi[0]['eliminato_magazzino_virtuale'];
	if ($eliminato_magazzino_virtuale!=null) {
		if ($eliminato_magazzino_virtuale=="1") {
			$pdf->SetXY(20.5,172.5);
			$pdf->Write(0, "x");

			$data_eliminazione_mv=$info_nc_pr_analisi[0]['data_eliminazione_mv'];
			if ($data_eliminazione_mv!=null) {
				$data_eliminazione_mv=date("d-m-Y",strtotime($data_eliminazione_mv));
				$pdf->SetXY(92,172.5);
				$pdf->Write(0, $data_eliminazione_mv);
			}
			$sign_eliminazione_mv=$info_nc_pr_analisi[0]['sign_eliminazione_mv'];
			if ($sign_eliminazione_mv!=0) {
				$firma_estesa=$elenco_utenti[$sign_eliminazione_mv]['operatore'];	
				$pdf->SetXY(140,172.5);
				$pdf->Write(0, $firma_estesa);
			}
		}
	}	
	

	$eliminato_magazzino_fisico=$info_nc_pr_analisi[0]['eliminato_magazzino_fisico'];
	if ($eliminato_magazzino_fisico!=null) {
		if ($eliminato_magazzino_fisico=="1") {
			$pdf->SetXY(20.5,179);
			$pdf->Write(0, "x");

			$data_eliminazione_mf=$info_nc_pr_analisi[0]['data_eliminazione_mf'];
			if ($data_eliminazione_mf!=null) {
				$data_eliminazione_mf=date("d-m-Y",strtotime($data_eliminazione_mf));
				$pdf->SetXY(92,179);
				$pdf->Write(0, $data_eliminazione_mv);
			}
			$sign_eliminazione_mf=$info_nc_pr_analisi[0]['sign_eliminazione_mf'];
			if ($sign_eliminazione_mf!=0) {
				$firma_estesa=$elenco_utenti[$sign_eliminazione_mf]['operatore'];	
				$pdf->SetXY(140,179);
				$pdf->Write(0, $firma_estesa);
			}
		}
	}	

	$eliminato_na=$info_nc_pr_analisi[0]['eliminato_na'];
	if ($eliminato_na!=null) {
		if ($eliminato_na=="1") {
			$pdf->SetXY(20.5,186);
			$pdf->Write(0, "x");

			$data_eliminazione_na=$info_nc_pr_analisi[0]['data_eliminazione_na'];
			if ($data_eliminazione_na!=null) {
				$data_eliminazione_na=date("d-m-Y",strtotime($data_eliminazione_na));
				$pdf->SetXY(92,186);
				$pdf->Write(0, $data_eliminazione_na);
			}
			$sign_eliminazione_na=$info_nc_pr_analisi[0]['sign_eliminazione_na'];
			if ($sign_eliminazione_na!=0) {
				$firma_estesa=$elenco_utenti[$sign_eliminazione_na]['operatore'];	
				$pdf->SetXY(140,186);
				$pdf->Write(0, $firma_estesa);
			}
		}
	}

	$pdf->SetXY(37,202);
	$pdf->SetTextColor(0,0,255);
	$pdf->SetStyle('U',true);
	$perc="../analisi_pr/allegati_ris/$id_ref";
	$files = glob("$perc/*.{JPG,JPEG,PNG,GIF,PDF,DOC,DOCX,ODT,jpg,jpeg,png,gif,pdf,doc,docx,odt}", GLOB_BRACE);
	$cont=0;
	foreach($files as $file) {
		$cont++;
		$url=$dominio.$file;
		$url=str_replace("../","/",$url);
		
		$t1="Allegato $cont";
	
		$pdf->Cell(21,3,$t1,'LR',0,'L',false,$url);
	}
	$pdf->SetStyle('U',false);
	$pdf->SetTextColor(0);	

	$pdf->SetFont('Times','',11);
	$data_chiusura_nc=$info_nc_pr_analisi[0]['data_chiusura_nc'];
	if ($data_chiusura_nc!=null) {
		$data_chiusura_nc=date("d-m-Y",strtotime($data_chiusura_nc));
		$pdf->SetXY(31,210);
		$pdf->Write(0, $data_chiusura_nc);
	}
	$sign_chiusura_nc=$info_nc_pr_analisi[0]['sign_chiusura_nc'];
	if ($sign_chiusura_nc!=0) {
		$firma_estesa=$elenco_utenti[$sign_chiusura_nc]['operatore'];	
		$pdf->SetXY(100,210);
		$pdf->Write(0, $firma_estesa);
	}


	
	
	print json_encode($info_nc_pr_analisi);
	/*	
	$pdf->AddPage('P'); 
	$pdf->SetMargins(0,0,0);
	// set the sourcefile 
	// import page 2 
	$tplIdx = $pdf->importPage(2); 
	$pdf->useTemplate($tplIdx, 0, 0); 
	*/

	$pdf->Output("rapporti/".$id_ref.".pdf","F");		
	
	
	//print json_encode($info_nc_pr);
	//$get_code=$main_T->get_code($protocollo);
	//print json_encode($get_code);
}


if ($operazione=="prepara_pdf_mt") {
	$id_ref=$_POST['id_ref'];
	@unlink("rapporti_mt/".$id_ref.".pdf");

	$info_nc_mt=$main->lista_nc(2,$periodo_ref="",$id_ref);
	$info_nc_mt_analisi=$analisi_mt->info_nc_mt($id_ref);
	
	require('../../fpdi/fpdf.php'); 
	require('../../fpdi/fpdi.php');
	class PDF extends FPDI{
		protected $B = 0;
		protected $I = 0;
		protected $U = 0;
		protected $HREF = '';		
		function SetStyle($tag, $enable){
			// Modify style and select corresponding font
			$this->$tag += ($enable ? 1 : -1);
			$style = '';
			foreach(array('B', 'I', 'U') as $s)
			{
				if($this->$s>0)
					$style .= $s;
			}
			$this->SetFont('',$style);
		}
								
		function PutLink($URL, $txt){
			// Put a hyperlink
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}

	}	
	$elenco_utenti=$main->array_utenti_bis();

	$pdf = new PDF('L', 'mm');
	$pdf->SetAutoPageBreak(false);
	$pdf->SetAuthor('Liofilchem srl');
	$pdf->SetTitle('MOD_52B');
	
	$pdf->AddPage('P'); 
	$pdf->SetMargins(0,0,0);

	$pdf->setSourceFile('mod52b_materiale.pdf'); 
	// set the sourcefile 
	// import page 1 
	$tplIdx = $pdf->importPage(1); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0); 
	$pdf->SetFont('Times','',11);
	//$pdf->SetTextColor(255,0,0); 

	$protocollo_nc=$info_nc_mt[0]['protocollo_nc'];
	$pdf->SetXY(163,35.2);
	$pdf->Write(0, $protocollo_nc );
	
	$data_nc=$info_nc_mt[0]['data_nc'];
	$data_nc=date("d-m-Y",strtotime($data_nc));
	$pdf->SetXY(31,47.5);
	$pdf->Write(0, $data_nc );
	
	/*
	$reparto_where_nc=$info_nc_mt[0]['reparto_where_nc'];
	$arr_risp=$main->reparti($reparto_where_nc);
	$descr_reparto=$arr_risp[0]['reparto'];
	$pdf->SetXY(96,54);
	$pdf->Write(0, $descr_reparto);
	
	$id_reparto_view=$info_nc_mt[0]['id_reparto_view'];
	$arr_risp=$main->reparti($id_reparto_view);
	$descr_reparto=$arr_risp[0]['reparto'];
	$pdf->SetXY(92,60.5);
	$pdf->Write(0, $descr_reparto);
	
	*/

	$pdf->SetXY(34,54);
	$pdf->Write(0, $info_nc_mt[0]['cod_art']);


	$pdf->SetXY(104,50);
	$descr_art=stripslashes($info_nc_mt[0]['descr_art']);
	$descr_art = iconv('UTF-8', 'windows-1252', $descr_art);	
	$pdf->MultiCell(70,4,stripslashes($descr_art),0,'L');
	

	$pdf->SetXY(50,60.5);
	$pdf->Write(0, $info_nc_mt[0]['lotto_liof']);
	
	$pdf->SetXY(110,60.5);
	$pdf->Write(0, $info_nc_mt[0]['lotto_cf']);	
	
	$pdf->SetXY(38,67.5);
	$fornitore=stripslashes($info_nc_mt[0]['fornitore']);
	$fornitore = iconv('UTF-8', 'windows-1252', $fornitore);
	
	$pdf->Write(0, $fornitore);	

	$pdf->SetXY(49,74.5);
	$pdf->Write(0, $info_nc_mt[0]['qta_fornita']);

	$pdf->SetXY(123,74.5);
	$pdf->Write(0, $info_nc_mt[0]['qta_nc']);

	
	$tipo_nc=$info_nc_mt[0]['tipo_nc'];
	$arr_risp=$main->tipo_nc(2,$tipo_nc);
	$descrizione=$arr_risp[0]['descrizione'];
	
	$descrizione = iconv('UTF-8', 'windows-1252', $descrizione);
	
	$pdf->SetXY(69,79);
	//$pdf->Write(0, $descrizione);	
	$pdf->MultiCell(123,4,stripslashes($descrizione),0,'L');
	

	
	$pdf->SetXY(20,90);
	$pdf->SetFont('Times','',9);
	$descrizione_nc=stripslashes($info_nc_mt[0]['descrizione_nc']);
	$descrizione_nc = iconv('UTF-8', 'windows-1252', $descrizione_nc);	
	
	$pdf->MultiCell(172,5,$descrizione_nc,0,'L');


	$pdf->SetXY(37,112.5);
	$pdf->SetTextColor(0,0,255);
	$pdf->SetStyle('U',true);
	$perc="../insert_mt/allegati/$id_ref";
	$files = glob("$perc/*.{JPG,JPEG,PNG,GIF,PDF,DOC,DOCX,ODT,jpg,jpeg,png,gif,pdf,doc,docx,odt}", GLOB_BRACE);
	$cont=0;
	foreach($files as $file) {
		$cont++;
		$url=$dominio.$file;
		$url=str_replace("../","/",$url);
		
		$t1="Allegato $cont";
	
		$pdf->Cell(21,3,$t1,'LR',0,'L',false,$url);
	}
	$pdf->SetStyle('U',false);
	$pdf->SetTextColor(0);	
	
	$pdf->SetFont('Times','',11);
	$id_oper=$info_nc_mt[0]['id_oper'];
	$segnalato_da=$elenco_utenti[$id_oper]['operatore'];
	$pdf->SetXY(48,121);
	$pdf->Write(0, $segnalato_da);	


	///ANALISI
	$pdf->SetFont('Times','',9);
	$nc_rilevata=$info_nc_mt_analisi[0]['nc_rilevata'];
	if ($nc_rilevata=="1" || $nc_rilevata=="2") {
		if ($nc_rilevata=="1")
			$pdf->SetXY(71.6,136.8);		
		if ($nc_rilevata=="2")
			$pdf->SetXY(134.2,136.8);
		$pdf->Write(0, "X");	
	}
	
	$invio_reclamo_fornitore=$info_nc_mt_analisi[0]['invio_reclamo_fornitore'];
	if ($invio_reclamo_fornitore=="1" || $invio_reclamo_fornitore=="2") {
		if ($invio_reclamo_fornitore=="1")
			$pdf->SetXY(64.3,143.4);		
		if ($invio_reclamo_fornitore=="2")
			$pdf->SetXY(77,143.4);
		$pdf->Write(0, "X");	
	}

	$pdf->SetFont('Times','',11);
	$pdf->SetXY(150,143);
	$pdf->Write(0, $info_nc_mt_analisi[0]['ref_prot_reclamo']);


	
	$data_valutazione=$info_nc_mt_analisi[0]['data_valutazione'];
	if ($data_valutazione!=null) {
		$data_valutazione=date("d-m-Y",strtotime($data_valutazione));
		$pdf->SetXY(31,150);
		$pdf->Write(0, $data_valutazione);
	}
	$firma_valutazione=$info_nc_mt_analisi[0]['firma_valutazione'];
	if ($firma_valutazione!=0) {
		$firma_estesa=$elenco_utenti[$firma_valutazione]['operatore'];	
		$pdf->SetXY(82,150);
		$pdf->Write(0, $firma_estesa);
	}

	$attivita=$info_nc_mt_analisi[0]['attivita'];
	if ($attivita!=0) {
		if ($attivita=="1") $pdf->SetXY(19.3,168.5);
		if ($attivita=="2") $pdf->SetXY(91.6,168.5);
		if ($attivita=="3") $pdf->SetXY(19.3,175.2);
		if ($attivita=="4") $pdf->SetXY(91.6,175.2);
		
		$pdf->Write(0, "x");
	}

	$pdf->SetXY(20,184);
	$pdf->SetFont('Times','',9);
	$note=stripslashes($info_nc_mt_analisi[0]['note']);
	$note = iconv('UTF-8', 'windows-1252', $note);	
	
	
	$pdf->MultiCell(170,5,$note,0,'L');
	
	
	$str_team=$info_nc_mt_analisi[0]['team'];
	$arr_team=explode(";",$str_team);
	$pdf->SetXY(20,198);
	$elem_t="";
	for ($sca=0;$sca<=count($arr_team)-1;$sca++) {
		$tx=$arr_team[$sca];
		if (isset($elenco_utenti[$tx]['operatore'])) {
			if (strlen($elem_t)!=0) $elem_t.=", ";
			$elem_t.=$elenco_utenti[$tx]['operatore'];
		}
	}
	$pdf->SetFont('Times','',11);
	$pdf->MultiCell(170,5,stripslashes($elem_t),0,'L');

	$pdf->SetXY(20,218);
	$pdf->SetFont('Times','',11);
	$informazione_organizzazioni=stripslashes($info_nc_mt_analisi[0]['informazione_organizzazioni']);
	$informazione_organizzazioni = iconv('UTF-8', 'windows-1252', $informazione_organizzazioni);	
		
	$pdf->MultiCell(170,5,$informazione_organizzazioni,0,'L');

	$pdf->SetFont('Times','',11);
	$data_sezione_ris1=$info_nc_mt_analisi[0]['data_sezione_ris1'];
	if ($data_sezione_ris1!=null) {
		$data_sezione_ris1=date("d-m-Y",strtotime($data_sezione_ris1));
		$pdf->SetXY(31,228.5);
		$pdf->Write(0, $data_sezione_ris1);
	}
	$sign_ris1=$info_nc_mt_analisi[0]['sign_ris1'];
	if ($sign_ris1!=0) {
		$firma_estesa=$elenco_utenti[$sign_ris1]['operatore'];	
		$pdf->SetXY(82,228.5);
		$pdf->Write(0, $firma_estesa);
	}
	
	$azione_correttiva=$info_nc_mt_analisi[0]['azione_correttiva'];
	if ($azione_correttiva!=null) {
		if ($azione_correttiva=="1") $pdf->SetXY(89.8,240);
		if ($azione_correttiva=="0") $pdf->SetXY(102.3,240);
		//if ($azione_correttiva=="0") $pdf->SetXY(109.3,42);
		$pdf->Write(0, "x");
	}		
	$pdf->SetXY(20,250);
	$pdf->SetFont('Times','',11);
	$motivazione_azione=stripslashes($info_nc_mt_analisi[0]['motivazione_azione']);
	$motivazione_azione = iconv('UTF-8', 'windows-1252', $motivazione_azione);	
	
	$pdf->MultiCell(170,5,$motivazione_azione,0,'L');
	


	$pdf->SetFont('Times','',11);
	$data_sezione_ris2=$info_nc_mt_analisi[0]['data_sezione_ris2'];
	if ($data_sezione_ris2!=null) {
		$data_sezione_ris2=date("d-m-Y",strtotime($data_sezione_ris2));
		$pdf->SetXY(31,267);
		$pdf->Write(0, $data_sezione_ris2);
	}
	$sign_ris2=$info_nc_mt_analisi[0]['sign_ris2'];
	if ($sign_ris2!=0) {
		$firma_estesa=$elenco_utenti[$sign_ris2]['operatore'];	
		$pdf->SetXY(91,267);
		$pdf->Write(0, $firma_estesa);
	}	
	

	$pdf->AddPage('P'); 
	$pdf->SetMargins(0,0,0);

	$pdf->setSourceFile('mod52b_materiale.pdf'); 
	$tplIdx = $pdf->importPage(2); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0); 
	$pdf->SetFont('Times','',11);	
	

	
	
	

	
	$eliminato_magazzino_virtuale=$info_nc_mt_analisi[0]['eliminato_magazzino_virtuale'];
	if ($eliminato_magazzino_virtuale!=null) {
		if ($eliminato_magazzino_virtuale=="1") {
			$pdf->SetXY(19.5,42);
			$pdf->Write(0, "x");

			$data_eliminazione_mv=$info_nc_mt_analisi[0]['data_eliminazione_mv'];
			if ($data_eliminazione_mv!=null) {
				$data_eliminazione_mv=date("d-m-Y",strtotime($data_eliminazione_mv));
				$pdf->SetXY(92,42);
				$pdf->Write(0, $data_eliminazione_mv);
			}
			$sign_eliminazione_mv=$info_nc_mt_analisi[0]['sign_eliminazione_mv'];
			if ($sign_eliminazione_mv!=0) {
				$firma_estesa=$elenco_utenti[$sign_eliminazione_mv]['operatore'];	
				$pdf->SetXY(140,42);
				$pdf->Write(0, $firma_estesa);
			}
		}
	}	
	

	$eliminato_magazzino_fisico=$info_nc_mt_analisi[0]['eliminato_magazzino_fisico'];
	if ($eliminato_magazzino_fisico!=null) {
		if ($eliminato_magazzino_fisico=="1") {
			$pdf->SetXY(19.5,49);
			$pdf->Write(0, "x");

			$data_eliminazione_mf=$info_nc_mt_analisi[0]['data_eliminazione_mf'];
			if ($data_eliminazione_mf!=null) {
				$data_eliminazione_mf=date("d-m-Y",strtotime($data_eliminazione_mf));
				$pdf->SetXY(92,49);
				$pdf->Write(0, $data_eliminazione_mv);
			}
			$sign_eliminazione_mf=$info_nc_mt_analisi[0]['sign_eliminazione_mf'];
			if ($sign_eliminazione_mf!=0) {
				$firma_estesa=$elenco_utenti[$sign_eliminazione_mf]['operatore'];	
				$pdf->SetXY(140,49);
				$pdf->Write(0, $firma_estesa);
			}
		}
	}	

	$eliminato_na=$info_nc_mt_analisi[0]['eliminato_na'];
	if ($eliminato_na!=null) {
		if ($eliminato_na=="1") {
			$pdf->SetXY(19.5,55.7);
			$pdf->Write(0, "x");

			$data_eliminazione_na=$info_nc_mt_analisi[0]['data_eliminazione_na'];
			if ($data_eliminazione_na!=null) {
				$data_eliminazione_na=date("d-m-Y",strtotime($data_eliminazione_na));
				$pdf->SetXY(92,55.7);
				$pdf->Write(0, $data_eliminazione_na);
			}
			$sign_eliminazione_na=$info_nc_mt_analisi[0]['sign_eliminazione_na'];
			if ($sign_eliminazione_na!=0) {
				$firma_estesa=$elenco_utenti[$sign_eliminazione_na]['operatore'];	
				$pdf->SetXY(140,55.7);
				$pdf->Write(0, $firma_estesa);
			}
		}
	}


	$pdf->SetXY(37,68.2);
	$pdf->SetTextColor(0,0,255);
	$pdf->SetStyle('U',true);
	$perc="../analisi_mt/allegati_ris/$id_ref";
	$files = glob("$perc/*.{JPG,JPEG,PNG,GIF,PDF,DOC,DOCX,ODT,jpg,jpeg,png,gif,pdf,doc,docx,odt}", GLOB_BRACE);
	$cont=0;
	foreach($files as $file) {
		$cont++;
		$url=$dominio.$file;
		$url=str_replace("../","/",$url);
		
		$t1="Allegato $cont";
	
		$pdf->Cell(21,3,$t1,'LR',0,'L',false,$url);
	}
	$pdf->SetStyle('U',false);
	$pdf->SetTextColor(0);	

	$pdf->SetFont('Times','',11);
	$data_chiusura_nc=$info_nc_mt_analisi[0]['data_chiusura_nc'];
	if ($data_chiusura_nc!=null) {
		$data_chiusura_nc=date("d-m-Y",strtotime($data_chiusura_nc));
		$pdf->SetXY(31,76);
		$pdf->Write(0, $data_chiusura_nc);
	}
	$sign_chiusura_nc=$info_nc_mt_analisi[0]['sign_chiusura_nc'];
	if ($sign_chiusura_nc!=0) {
		$firma_estesa=$elenco_utenti[$sign_chiusura_nc]['operatore'];	
		$pdf->SetXY(100,76);
		$pdf->Write(0, $firma_estesa);
	}


	
	
	print json_encode($info_nc_mt_analisi);
	/*	
	$pdf->AddPage('P'); 
	$pdf->SetMargins(0,0,0);
	// set the sourcefile 
	// import page 2 
	$tplIdx = $pdf->importPage(2); 
	$pdf->useTemplate($tplIdx, 0, 0); 
	*/

	$pdf->Output("rapporti/".$id_ref.".pdf","F");		
	
	
	//print json_encode($info_nc_mt);
	//$get_code=$main_T->get_code($protocollo);
	//print json_encode($get_code);
}


if ($operazione=="pdf_lista_pr") {
	$data1=$_POST['data1'];$data2=$_POST['data2'];
	@unlink("rapporti/lista.pdf");
	
	$periodo_ref="$data1 $data2";
	$info_nc_pr=$main->lista_nc(1,$periodo_ref,"");
	
	
	
	require('../../fpdi/fpdf.php'); 
	require('../../fpdi/fpdi.php');
	class PDF extends FPDI{
		protected $B = 0;
		protected $I = 0;
		protected $U = 0;
		protected $HREF = '';		
		function SetStyle($tag, $enable){
			// Modify style and select corresponding font
			$this->$tag += ($enable ? 1 : -1);
			$style = '';
			foreach(array('B', 'I', 'U') as $s)
			{
				if($this->$s>0)
					$style .= $s;
			}
			$this->SetFont('',$style);
		}
								
		function PutLink($URL, $txt){
			// Put a hyperlink
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}

	}	
	$elenco_utenti=$main->array_utenti_bis();

	$pdf = new PDF('L', 'mm');
	$pdf->SetAutoPageBreak(false);
	$pdf->SetAuthor('Liofilchem srl');
	$pdf->SetTitle('MOD_52E');
	$pdf->AddPage('L'); 
	$pdf->SetMargins(0,0,0);
	$pdf->setSourceFile('mod52e_prodotto.pdf'); 
	
	// set the sourcefile 
	// import page 1 
	$tplIdx = $pdf->importPage(1); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0); 
	
	$y=52.5;
	
	$riga=0;
	$d1=date("d-m-Y",strtotime($data1));$d2=date("d-m-Y",strtotime($data2));
	
	$periodo_ref1="$d1 / $d2";
	$pdf->SetFont('Times','',9);
	$pdf->SetXY(49,33.2);
	$pdf->Write(0, $periodo_ref1 );
	

	for ($lun=0;$lun<=count($info_nc_pr)-1;$lun++) {		
		if (($lun+1)/14==intval(($lun+1)/14)) {
			$pdf->AddPage('L'); 
			$pdf->SetMargins(0,0,0);
			$pdf->setSourceFile('mod52e_prodotto.pdf'); 
			
			// set the sourcefile 
			// import page 1 
			$tplIdx = $pdf->importPage(1); 
			// use the imported page as the template 
			$pdf->useTemplate($tplIdx, 0, 0); 
			$riga=0;
			$pdf->SetXY(49,32.5);
			$pdf->Write(0, $periodo_ref1 );
			
		}
		$pdf->SetFont('Times','',9);
		//$pdf->SetTextColor(255,0,0); 
		$id_ref=$info_nc_pr[$lun]['id'];
		$protocollo_nc=$info_nc_pr[$lun]['protocollo_nc'];
		
		$pdf->SetXY(13,$y+$riga);
		$pdf->Write(0, $protocollo_nc );
		
		$data_nc=$info_nc_pr[$lun]['data_nc'];
		$data_nc=date("d-m-Y",strtotime($data_nc));
		$pdf->SetXY(37,$y+$riga);
		$pdf->Write(0, $data_nc );


		$pdf->SetXY(64,$y+$riga);
		$pdf->Write(0, $info_nc_pr[$lun]['codice']);


		$pdf->SetXY(85,($y-4)+$riga);
		$descr_art=stripslashes($info_nc_pr[$lun]['descrizione']);
		$descr_art = iconv('UTF-8', 'windows-1252', $descr_art);	
		$pdf->MultiCell(57,4,stripslashes($descr_art),0,'L');
		
		$lotto=$info_nc_pr[$lun]['lotto'];
		$lotto = iconv('UTF-8', 'windows-1252', $lotto);
		$pdf->SetXY(140,$y+$riga);
		$pdf->Write(0,$lotto);
		
		
		$info_nc_pr_analisi=$analisi_pr->info_nc_pr($id_ref);
		$classificazione_nc=$info_nc_pr_analisi[0]['classificazione_nc'];
		$arr_risp=$main->classificazioni($classificazione_nc);
		$descrizione="";
		if (isset($arr_risp[0]['descrizione'])) $descrizione=stripslashes($arr_risp[0]['descrizione']);
		$descrizione = iconv('UTF-8', 'windows-1252', $descrizione);
		$pdf->SetFont('Times','',9);
		$pdf->SetXY(167.2,($y-4.8)+$riga);
		$pdf->MultiCell(45,3.2,stripslashes($descrizione),0,'L');	


		$attivita=$info_nc_pr_analisi[0]['attivita'];
		$descrizione="";
		if ($attivita=="1") $descrizione="Accettare il prodotto";
		if ($attivita=="2") $descrizione="Rilavorare il prodotto";
		if ($attivita=="2") $descrizione="Selezionare ed eliminare i pezzi non conformi";
		if ($attivita=="4") $descrizione="Eliminare l'intero lotto";
		$pdf->SetXY(210,($y-4.8)+$riga);
		$pdf->MultiCell(34,3.2,stripslashes($descrizione),0,'L');	


		$pdf->SetFont('Times','',9);
		$data_chiusura_nc=$info_nc_pr[$lun]['data_chiusura_nc'];
		if ($data_chiusura_nc!=null) $data_chiusura_nc=date("d-m-Y",strtotime($data_chiusura_nc));
		else $data_chiusura_nc="";
		$pdf->SetXY(244,$y+$riga);
		$pdf->Write(0,$data_chiusura_nc);

		

		$riga=$riga+10;

	}
	
	$pdf->Output("rapporti/lista.pdf","F");
	print json_encode($info_nc_pr_analisi);
}



if ($operazione=="pdf_lista_mt") {
	$data1=$_POST['data1'];$data2=$_POST['data2'];
	@unlink("rapporti/lista.pdf");
	
	$periodo_ref="$data1 $data2";
	$info_nc_mt=$main->lista_nc(2,$periodo_ref,"");
	
	
	
	require('../../fpdi/fpdf.php'); 
	require('../../fpdi/fpdi.php');
	class PDF extends FPDI{
		protected $B = 0;
		protected $I = 0;
		protected $U = 0;
		protected $HREF = '';		
		function SetStyle($tag, $enable){
			// Modify style and select corresponding font
			$this->$tag += ($enable ? 1 : -1);
			$style = '';
			foreach(array('B', 'I', 'U') as $s)
			{
				if($this->$s>0)
					$style .= $s;
			}
			$this->SetFont('',$style);
		}
								
		function PutLink($URL, $txt){
			// Put a hyperlink
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}

	}	
	$elenco_utenti=$main->array_utenti_bis();

	$pdf = new PDF('L', 'mm');
	$pdf->SetAutoPageBreak(false);
	$pdf->SetAuthor('Liofilchem srl');
	$pdf->SetTitle('MOD_52F');
	$pdf->AddPage('L'); 
	$pdf->SetMargins(0,0,0);
	$pdf->setSourceFile('mod52f_materiale.pdf'); 
	
	// set the sourcefile 
	// import page 1 
	$tplIdx = $pdf->importPage(1); 
	// use the imported page as the template 
	$pdf->useTemplate($tplIdx, 0, 0); 
	
	$y=48.5;
	
	$riga=0;
	$d1=date("d-m-Y",strtotime($data1));$d2=date("d-m-Y",strtotime($data2));
	
	$periodo_ref1="$d1 / $d2";
	$pdf->SetFont('Times','',9);
	$pdf->SetXY(49,32.5);
	$pdf->Write(0, $periodo_ref1 );
	

	for ($lun=0;$lun<=count($info_nc_mt)-1;$lun++) {		
		if (($lun+1)/14==intval(($lun+1)/14)) {
			$pdf->AddPage('L'); 
			$pdf->SetMargins(0,0,0);
			$pdf->setSourceFile('mod52f_materiale.pdf'); 
			
			// set the sourcefile 
			// import page 1 
			$tplIdx = $pdf->importPage(1); 
			// use the imported page as the template 
			$pdf->useTemplate($tplIdx, 0, 0); 
			$riga=0;
			$pdf->SetXY(49,32.5);
			$pdf->Write(0, $periodo_ref1 );
			
		}
		$pdf->SetFont('Times','',9);
		//$pdf->SetTextColor(255,0,0); 
		$id_ref=$info_nc_mt[$lun]['id'];
		$protocollo_nc=$info_nc_mt[$lun]['protocollo_nc'];
		
		$pdf->SetXY(16,$y+$riga);
		$pdf->Write(0, $protocollo_nc );
		
		$data_nc=$info_nc_mt[$lun]['data_nc'];
		$data_nc=date("d-m-Y",strtotime($data_nc));
		$pdf->SetXY(39,$y+$riga);
		$pdf->Write(0, $data_nc );


		$pdf->SetXY(64,$y+$riga);
		$pdf->Write(0, $info_nc_mt[$lun]['cod_art']);


		$pdf->SetXY(80,($y-4)+$riga);
		$descr_art=stripslashes($info_nc_mt[$lun]['descr_art']);
		$descr_art = iconv('UTF-8', 'windows-1252', $descr_art);	
		$pdf->MultiCell(48,4,stripslashes($descr_art),0,'L');
		
		$lotto=$info_nc_mt[$lun]['lotto_liof'];
		$lotto = iconv('UTF-8', 'windows-1252', $lotto);
		$pdf->SetXY(126,$y+$riga);
		$pdf->Write(0,$lotto);

		$lotto_cf=$info_nc_mt[$lun]['lotto_cf'];
		$lotto_cf = iconv('UTF-8', 'windows-1252', $lotto_cf);
		$pdf->SetXY(149.8,$y+$riga);
		$pdf->Write(0,$lotto_cf);

		$pdf->SetFont('Times','',8);
		$fornitore=$info_nc_mt[$lun]['fornitore'];
		$fornitore = iconv('UTF-8', 'windows-1252', $fornitore);
		$pdf->SetXY(173.9,($y-4.8)+$riga);
		$pdf->MultiCell(28,3,strtolower(stripslashes($fornitore)),0,'L');
		
		$tipo_nc=$info_nc_mt[$lun]['tipo_nc'];
		$arr_risp=$main->tipo_nc(2,$tipo_nc);
		$descrizione=$arr_risp[0]['descrizione'];
		
		$descrizione = iconv('UTF-8', 'windows-1252', $descrizione);
		
		$pdf->SetFont('Times','',8);
		$pdf->SetXY(200,($y-4.8)+$riga);
		//$pdf->Write(0, $descrizione);	
		$pdf->MultiCell(39,3,stripslashes($descrizione),0,'L');		
		
		$info_nc_mt_analisi=$analisi_mt->info_nc_mt($id_ref);
		$pdf->SetFont('Times','',8);

		$attivita=$info_nc_mt_analisi[0]['attivita'];
		$descrizione="";
		if ($attivita=="1") $descrizione="Accettare il prodotto";
		if ($attivita=="2") $descrizione="Rilavorare il prodotto";
		if ($attivita=="2") $descrizione="Selezionare ed eliminare i pezzi non conformi";
		if ($attivita=="4") $descrizione="Eliminare l'intero lotto";
		$pdf->SetXY(234.8,($y-4.8)+$riga);
		$pdf->MultiCell(33,3.2,stripslashes($descrizione),0,'L');	


		$pdf->SetFont('Times','',9);
		$data_chiusura_nc=$info_nc_mt[$lun]['data_chiusura_nc'];
		if ($data_chiusura_nc!=null) $data_chiusura_nc=date("d-m-Y",strtotime($data_chiusura_nc));
		else $data_chiusura_nc="";
		$pdf->SetXY(264,$y+$riga);
		$pdf->Write(0,$data_chiusura_nc);

		

		$riga=$riga+10;

	}
	
	$pdf->Output("rapporti/lista.pdf","F");
	print json_encode($info_nc_mt);
}


function isLocalhost($whitelist = ['127.0.0.1', '::1']) {
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
}

?>
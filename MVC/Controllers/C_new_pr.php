<?php

	$main_all = new Main_all($db);
	$elenco_reparti=$main_all->reparti(0);
	$tipo_nc=$main_all->tipo_nc(1,0);
	
	$main_new_pr = new Main_new_pr($db);
	
	$id_ref=0;
	if (isset($_GET['id_ref'])) $id_ref=$_GET['id_ref'];
	
	$sendmail="OK";
	if (isset($_POST['btn_ins_nc_pr'])) {
		$resp=$main_new_pr->inser_nc_pr($id_ref);

		//invio della eventuale notifica
		if ($id_ref==0) {
			if ($resp['header']=="OK" && $sendmail=="OK") { 
				$ref=$resp['last_id'];			
				$fx="../../preferenze.ini";
				$invio=1;$dest="";
				if (file_exists($fx)) {
					$ini_array = parse_ini_file($fx, true);
					
					if (isset($ini_array['notifica_nuova_nc']['send'])) $invio=$ini_array['notifica_nuova_nc']['send'];
					if (isset($ini_array['notifica_nuova_nc']['destinatari'])) $dest=$ini_array['notifica_nuova_nc']['destinatari'];
					
				}	
				if ($invio=="2" && strlen($dest)!=0) {
					$protocollo_nc=$resp['info']['protocollo_nc'];
					$lotto=$resp['info']['lotto'];
					$cod_art=$resp['info']['codice'];
					$descr_art=$resp['info']['descrizione'];	
					include ("send_notifica.php");	
				}	
			}
		}
		
		$param="ins=1";
		
		if ($resp['header']=="OK" && $sendmail=="OK") { 
			$id_ref=$resp['last_id'];			
			if (strlen($id_ref)!=0 && $id_ref!=0) $param.="&id_ref=$id_ref";
			echo "<meta http-equiv='refresh' content='0;URL=../../pages/insert/new_nc_pr.php?$param'>";
	
		}	
	}	
	
	$info_nc_pr=array();
	$attrezzature="";$lista_attrezzature=array();
	$data_nc="";$protocollo="";$id_reparto_view="";$reparto_where_nc="";
	$tipo_prodotto="";$codice="";$descrizione="";$attr_sn="";
	$lotto="";$qta_ric="";$qta_prod="";$qta_nc="";$qta_dele="";
	$tiponc="";$descrizione_nc="";
	if (isset($_GET['id_ref']) && strlen($_GET['id_ref'])!=0 && $_GET['id_ref']!=0) {
		$info_nc_pr=$main_all->lista_nc(1,"",$_GET['id_ref']);
		$data_nc=$info_nc_pr[0]['data_nc'];
		$protocollo=$info_nc_pr[0]['protocollo'];
		$attrezzature=$info_nc_pr[0]['attrezzature'];
		$reparto_where_nc=$info_nc_pr[0]['reparto_where_nc'];
		$id_reparto_view=$info_nc_pr[0]['id_reparto_view'];
		$lista_attrezzature=$main_all->list_attrezzature(0,$reparto_where_nc);
		
		$tipo_prodotto=$info_nc_pr[0]['tipo_prodotto'];
		$codice=$info_nc_pr[0]['codice'];
		$descrizione=stripslashes($info_nc_pr[0]['descrizione']);
		$attr_sn=$info_nc_pr[0]['attr_sn'];
		$lotto=$info_nc_pr[0]['lotto'];
		$qta_ric=$info_nc_pr[0]['qta_ric'];
		$qta_prod=$info_nc_pr[0]['qta_prod'];
		$qta_nc=$info_nc_pr[0]['qta_nc'];
		$qta_dele=$info_nc_pr[0]['qta_dele'];
		$tiponc=$info_nc_pr[0]['tipo_nc'];
		$descrizione_nc=stripslashes($info_nc_pr[0]['descrizione_nc']);
		
	}


	
?>
<?php

	$main_all = new Main_all($db);
	$tipo_nc=$main_all->tipo_nc(2,0);
	
	$main_new_mt = new Main_new_mt($db);
	
	$id_ref=0;
	if (isset($_GET['id_ref'])) $id_ref=$_GET['id_ref'];
	
	$sendmail="OK";
	if (isset($_POST['btn_ins_nc_mt'])) {
		$resp=$main_new_mt->inser_nc_mt($id_ref);
		

		//invio della eventuale notifica
		if ($id_ref==0) {
			if ($resp['header']=="OK" && $sendmail=="OK") { 
				$ref=$resp['last_id'];			
				$fx="../../preferenze.ini";
				$invio=1;$dest="";
				if (file_exists($fx)) {
					$ini_array = parse_ini_file($fx, true);
					
					if (isset($ini_array['notifica_nuova_nc_mt']['send'])) $invio=$ini_array['notifica_nuova_nc_mt']['send'];
					if (isset($ini_array['notifica_nuova_nc_mt']['destinatari'])) $dest=$ini_array['notifica_nuova_nc_mt']['destinatari'];
					
				}	
				if ($invio=="2" && strlen($dest)!=0) {
					$protocollo_nc=$resp['info']['protocollo_nc'];
					$lotto="";
					$cod_art=$resp['info']['codice'];
					$descr_art=$resp['info']['descrizione'];	
					include ("send_notifica_mt.php");	
				}	
			}
		}
		
		$param="ins=1";
		
		if ($resp['header']=="OK" && $sendmail=="OK") { 
			$id_ref=$resp['last_id'];			
			if (strlen($id_ref)!=0 && $id_ref!=0) $param.="&id_ref=$id_ref";
			echo "<meta http-equiv='refresh' content='0;URL=../../pages/insert_mt/new_nc_mt.php?$param'>";
	
		}	
	}	
	
	$info_nc_mt=array();
	
	$data_nc="";
	$codice="";$descrizione="";
	$lotto_liofilchem="";
	$fornitore="";
	$cod_cf="";$lotto_cf="";
	
	$qta_fornita="";$qta_nc="";
	$tiponc="";$descrizione_nc="";
	if (isset($_GET['id_ref']) && strlen($_GET['id_ref'])!=0 && $_GET['id_ref']!=0) {
		$info_nc_mt=$main_all->lista_nc(2,"",$_GET['id_ref']);
		$data_nc=$info_nc_mt[0]['data_nc'];
		
		$codice=$info_nc_mt[0]['cod_art'];
		$descrizione=stripslashes($info_nc_mt[0]['descr_art']);

		$lotto_liofilchem=$info_nc_mt[0]['lotto_liof'];
		$fornitore=stripslashes($info_nc_mt[0]['fornitore']);
		$cod_cf=$info_nc_mt[0]['cod_cf'];
		$lotto_cf=$info_nc_mt[0]['lotto_cf'];
		
		$qta_fornita=$info_nc_mt[0]['qta_fornita'];
		$qta_nc=$info_nc_mt[0]['qta_nc'];

		$tiponc=$info_nc_mt[0]['tipo_nc'];
		$descrizione_nc=stripslashes($info_nc_mt[0]['descrizione_nc']);
		
	}

	
?>
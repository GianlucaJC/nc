<?php
	$main_all = new Main_all($db);
	//chiamate ajax-fetch
	if (isset($_POST['operazione'])) {
		$operazione=$_POST['operazione'];
		if ($operazione=="classificazioni_from_tipologia") {
			$periodo=$_POST['periodo'];
			$id_tipo=$_POST['id_tipo'];
			$elenco_classificazioni=$main_all->classificazioni_in_nc_extra($periodo,$id_tipo);
			print json_encode($elenco_classificazioni);

		}
		exit;
	}
	//fine chiamate ajax-fetch
	
	$tipo_prodotto_in_nc=array();
	$tipo_stat="";
	$periodo="";
	$today=date("Y-m-d");
	$da_data="";$a_data="";
	
	if (isset($_POST['tipo_stat']) || isset($_POST['da_data'])) {
		if (isset($_POST['tipo_stat'])) $tipo_stat=$_POST['tipo_stat'];
		if (isset($_POST['da_data'])) {
			$da_data=$_POST['da_data'];
			$a_data=$_POST['a_data'];
			$tipo_stat=6;
		}	
		if ($tipo_stat=="1") $periodo=$today;
		if ($tipo_stat=="2") {
			$today7=cal_date("7",2);
			$periodo="$today7 $today";
		}	
		if ($tipo_stat=="3") {
			$today31=cal_date("31",2);
			$periodo="$today31 $today";
		}	
		if ($tipo_stat=="4") {
			$today365=cal_date("365",2);
			$periodo="$today365 $today";
		}	
		if ($tipo_stat=="5") {
			$today365=cal_date("365",2);
			$periodo="2000-01-01 $today";
		}	
		if ($tipo_stat=="6") {
			$periodo="$da_data $a_data";
		}	
		$tipo_prodotto_in_nc=$main_all->tipo_prodotto_in_nc($periodo);
			
		
	}
	
	$tipo_analisi="";
	$analisi_anno=array();
	if (isset($_POST['tipo_analisi'])) {
		$tipo_analisi=$_POST['tipo_analisi'];
		$analisi_anno=$main_all->analisi_anno($tipo_analisi);
	}
	
?>	
<?php
	$main_all = new Main_all($db);

	$periodo_ref="";$m_get=0;
	if (isset($_GET['periodo'])) {
		$periodo_ref=$_GET['periodo'];
		$m_get=substr($periodo_ref,4,2);
	}	
	

	$next=0;
	if (isset($_GET['next'])) {$next=$_GET['next'];}
	$anno_ref=date("Y");
	if (isset($_GET['anno_ref'])) {$anno_ref=$_GET['anno_ref'];}

	
	$periodo_custom="";
	if (isset($_POST['periodo_custom'])) {
		$periodo_custom=$_POST['periodo_custom'];
		$periodo_ref=$periodo_custom;
	}	
	if (isset($_GET['anno_ref'])) $periodo_ref=$_GET['anno_ref'];
	
	if (strlen($periodo_ref)==0 && !isset($_GET['next'])) {
		$y=intval(date("Y"));
		$m=intval(date("m"));
		if (strlen($m)==1) $m="0$m";
		$periodo_ref="$y$m";
	}
	
	$nc=0;
	if (isset($_GET['nc_mt'])) $nc=$_GET['nc_mt'];
	$elenco_nc=$main_all->lista_nc(2,$periodo_ref,$nc);
	$array_utenti=$main_all->array_utenti();
	$array_utenti_bis=$main_all->array_utenti_bis();
	
	//filtri
	$tipo_filtro="";$str_cerca="";$filtro_reclamo_fornitore="";$filtro_stato="";
	$filtro_tipologia="";$filtro_attivita="";$filtro_fornitore="";
	if (isset($_POST['tipo_filtro'])) $tipo_filtro=$_POST['tipo_filtro'];
	if (isset($_POST['str_cerca'])) $str_cerca=$_POST['str_cerca'];	
	if (isset($_POST['filtro_stato'])) $filtro_stato=$_POST['filtro_stato'];	
	if (isset($_POST['filtro_tipologia'])) $filtro_tipologia=$_POST['filtro_tipologia'];
	if (isset($_POST['filtro_fornitore'])) $filtro_fornitore=$_POST['filtro_fornitore'];
	if (isset($_POST['filtro_reclamo_fornitore'])) $filtro_reclamo_fornitore=$_POST['filtro_reclamo_fornitore'];	
	if (isset($_POST['filtro_attivita'])) $filtro_attivita=$_POST['filtro_attivita'];
	//
	
	$tipologia_nc=$main_all->tipo_nc(2,0);
	$fornitori_in_nc=$main_all->fornitori_in_nc();
?>	
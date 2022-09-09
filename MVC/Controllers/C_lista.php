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
	if (isset($_GET['nc'])) $nc=$_GET['nc'];

	$tipo_filtro="";$str_cerca="";$filtro_segnalatore="";$filtro_stato="";
	$filtro_tipologia="";$filtro_attrezzatura="";$filtro_reparto="";$filtro_classificazioni="";
	$filtro_tipo_prodotti="";$filtro_attivita="";
	if (isset($_POST['tipo_filtro'])) $tipo_filtro=$_POST['tipo_filtro'];
	if (isset($_POST['str_cerca'])) $str_cerca=$_POST['str_cerca'];	
	if (isset($_POST['filtro_segnalatore'])) $filtro_segnalatore=$_POST['filtro_segnalatore'];	
	if (isset($_POST['filtro_stato'])) $filtro_stato=$_POST['filtro_stato'];	
	if (isset($_POST['filtro_tipologia'])) $filtro_tipologia=$_POST['filtro_tipologia'];
	if (isset($_POST['filtro_attrezzatura'])) $filtro_attrezzatura=$_POST['filtro_attrezzatura'];
	if (isset($_POST['filtro_reparto'])) $filtro_reparto=$_POST['filtro_reparto'];
	if (isset($_POST['filtro_classificazioni'])) $filtro_classificazioni=$_POST['filtro_classificazioni'];
	if (isset($_POST['filtro_tipo_prodotti'])) $filtro_tipo_prodotti=$_POST['filtro_tipo_prodotti'];
	if (isset($_POST['filtro_attivita'])) $filtro_attivita=$_POST['filtro_attivita'];
	
	
	$elenco_nc=$main_all->lista_nc(1,$periodo_ref,$nc);
	$array_utenti=$main_all->array_utenti();
	$array_utenti_bis=$main_all->array_utenti_bis();
	$segnalatori_nc_pr=$main_all->segnalatori_nc_pr();
	$tipologia_nc=$main_all->tipo_nc(1,0);
	$attrezzature=$main_all->attrezzature_movimentate();
	$reparti_where_nc=$main_all->reparti_where_nc();
	$classificazioni_in_nc=$main_all->classificazioni_in_nc();
	$tipo_prodotto_in_nc=$main_all->tipo_prodotto_in_nc($periodo="");
	
	
	
?>	
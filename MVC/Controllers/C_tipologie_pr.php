<?php
	$main_all = new Main_all($db);
	
	$main_tabelle = new Main_Tabelle($db);
	if (isset($_POST['to_remove']) && strlen($_POST['to_remove'])!=0) 
		$main_tabelle->remove_tiponc_pr($_POST['to_remove']);
	
	$ins_new="";
	$id_edit=0;
	if (isset($_GET['id_tipo'])) $id_edit=$_GET['id_tipo'];
	if (isset($_POST['btn_new'])) {
		$id_edit=0;	
		if (isset($_POST['id_edit'])) {
			$id_edit=$_POST['id_edit'];
			$ins_new=$main_tabelle->new_tipo_nc(1,$id_edit);
			$id_edit=0;
		}	
		else	
			$ins_new=$main_tabelle->new_tipo_nc(1,0);
		
	}	
	
	$edit_tipo="";
	if (isset($_GET['id_tipo'])) $edit_tipo=$main_all->tipo_nc(1,$_GET['id_tipo']);
	$edit=0;
	if (is_array($edit_tipo)) $edit=1;
	

	$elenco_tipologie=$main_all->tipo_nc(1);


?>	
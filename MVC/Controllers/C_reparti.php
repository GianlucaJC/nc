<?php
	$main_all = new Main_all($db);
	
	$main_tabelle = new Main_Tabelle($db);
	if (isset($_POST['to_remove']) && strlen($_POST['to_remove'])!=0) $main_tabelle->remove_rep($_POST['to_remove']);
	
	$ins_new="";
	$id_edit=0;
	if (isset($_GET['id_reparto'])) $id_edit=$_GET['id_reparto'];
	if (isset($_POST['btn_new'])) {
		$id_edit=0;	
		if (isset($_POST['id_edit'])) {
			$id_edit=$_POST['id_edit'];
			$ins_new=$main_tabelle->new_rep($id_edit);
			$id_edit=0;
		}	
		else	
			$ins_new=$main_tabelle->new_rep(0);
		
	}	
	
	$edit_reparto="";
	if (isset($_GET['id_reparto'])) $edit_reparto=$main_all->reparti($_GET['id_reparto']);
	$edit=0;
	if (is_array($edit_reparto)) $edit=1;
	
	$stabilimenti=$main_all->stabilimenti();
	$elenco_reparti=$main_all->reparti(0);


?>	
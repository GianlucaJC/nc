<?php
	$main_all = new Main_all($db);
	
	$main_tabelle = new Main_Tabelle($db);
	if (isset($_POST['to_remove']) && strlen($_POST['to_remove'])!=0) $main_tabelle->remove_attr($_POST['to_remove']);
	
	$ins_new="";
	$id_edit=0;
	if (isset($_GET['id_attr'])) $id_edit=$_GET['id_attr'];
	if (isset($_POST['btn_new'])) {
		$id_edit=0;	
		if (isset($_POST['id_edit'])) {
			$id_edit=$_POST['id_edit'];
			$ins_new=$main_tabelle->new_attr($id_edit);
			$id_edit=0;
		}	
		else	
			$ins_new=$main_tabelle->new_attr(0);
		
	}	
	
	$edit_attr="";
	if (isset($_GET['id_attr'])) $edit_attr=$main_all->list_attrezzature($_GET['id_attr'],0);
	$edit=0;
	if (is_array($edit_attr)) $edit=1;
	
	
	$elenco_reparti=$main_all->reparti(0);
	
	$list_attrezzature=$main_all->list_attrezzature(0,0);



?>	
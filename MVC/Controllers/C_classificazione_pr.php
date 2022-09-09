<?php
	$main_all = new Main_all($db);
	
	$main_tabelle = new Main_Tabelle($db);
	if (isset($_POST['to_remove']) && strlen($_POST['to_remove'])!=0) 
		$main_tabelle->remove_classificazione($_POST['to_remove']);
	
	$ins_new="";
	$id_edit=0;
	if (isset($_GET['id_class'])) $id_edit=$_GET['id_class'];
	if (isset($_POST['btn_new'])) {
		$id_edit=0;	
		if (isset($_POST['id_edit'])) {
			$id_edit=$_POST['id_edit'];
			$ins_new=$main_tabelle->new_class($id_edit);
			$id_edit=0;
		}	
		else	
			$ins_new=$main_tabelle->new_class(0);
		
	}	
	
	$edit_class="";
	if (isset($_GET['id_class'])) $edit_class=$main_all->classificazioni($_GET['id_class']);
	$edit=0;
	if (is_array($edit_class)) $edit=1;
	

	$elenco_classificazioni=$main_all->classificazioni(0);


?>	
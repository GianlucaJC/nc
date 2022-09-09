<?php
	$main_all = new Main_all($db);
	if (isset($_POST['operazione'])) {
		//operazioni Fetch
		$operazione=$_POST['operazione'];
		if ($operazione=="save_utenti") {
			$id_u=$_POST['id_u'];
			$service=$_POST['service'];
			$team=$_POST['team'];
			$txt_mail=$_POST['txt_mail'];
			$set_utenti=$main_all->set_utenti($id_u,$service,$team,$txt_mail);
			print json_encode($set_utenti);
		}
		exit;
	}
	
	$main_tabelle = new Main_Tabelle($db);
	if (isset($_POST['to_remove']) && strlen($_POST['to_remove'])!=0) $main_tabelle->remove_rep($_POST['to_remove']);
	
	$elenco_utenti=$main_all->elenco_utenti(0,0);


?>	
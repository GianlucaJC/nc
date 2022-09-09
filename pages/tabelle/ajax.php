<?php
session_start();
include_once '../../database.php';

$database = new Database();
$db = $database->getConnection();
include_once '../../MVC/Models/M_main.php';
include_once '../../MVC/Models/M_set_ini.php';

$main = new Main_all($db);
$set_ini = new M_set_ini($db);
	
$operazione=$_POST['operazione'];
if ($operazione=="set_notifica") {
	//proviene da tabelle/operazioni.php
	$from=$_POST['from'];
	$opt_notif=$_POST['opt_notif'];
	$destinatari_lista=$_POST['destinatari_lista'];

	$config_file="../../preferenze.ini";
	if ($from=="1")
		$section="notifica_nuova_nc";
	if ($from=="2")
		$section="notifica_nuova_nc_mt";
	
	$key="send";$value=$opt_notif;
	$set_ini->config_set($config_file, $section, $key, $value);	
	$key="destinatari";$value=$destinatari_lista;
	$set_ini->config_set($config_file, $section, $key, $value);	


	$resp=array();
	$resp['status']="OK";
	print json_encode($resp);
}

?>
<?php
session_start();
include_once '../../database.php';

$database = new Database();
$db = $database->getConnection();
$dbT = $database->getConnTarget();
include_once '../../MVC/Models/M_main.php';

$main = new Main_all($db);
$main_T = new Main_all($dbT);

	
$operazione=$_POST['operazione'];
if ($operazione=="get_code") {
	$protocollo=$_POST['protocollo'];
	
	$get_code=$main_T->get_code($protocollo);
	print json_encode($get_code);
}

if ($operazione=="elenco_attr") {
	$id_reparto=$_POST['id_reparto'];
	$elenco_attr=$main->attrezzature(0,$id_reparto);
	print json_encode($elenco_attr);
}
if ($operazione=="delete_foto") {
	$foto=$_POST['foto'];
	@unlink($foto);
	$resp=array("status"=>"OK");
	print json_encode($resp);
}

if ($operazione=="refresh_tipo") {
	$elenco_classificazioni=$main->classificazioni(0);
	print json_encode($elenco_classificazioni);
}

?>
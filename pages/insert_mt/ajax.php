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
	$lotto=$_POST['lotto'];
	//es di lotto prova: 044972D22
	$get_info_materiali=$main_T->get_info_materiali($lotto);
	print json_encode($get_info_materiali);
}

if ($operazione=="elenco_attr") {
	$id_reparto=$_POST['id_reparto'];
	$elenco_attr=$main->list_attrezzature(0,$id_reparto);
	print json_encode($elenco_attr);
}

if ($operazione=="refresh_tipo") {
	$elenco_tipo_nc=$main->tipo_nc(2,0);
	print json_encode($elenco_tipo_nc);
}

if ($operazione=="delete_foto") {
	$foto=$_POST['foto'];
	@unlink($foto);
	$resp=array("status"=>"OK");
	print json_encode($resp);
}

?>
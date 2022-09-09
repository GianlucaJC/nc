<?php
session_start();


include_once '../database.php';
$start=$_GET['start'];$end=$_GET['end'];
$d=substr($start,0,10);$d1=substr($end,0,10);
$database = new Database();
$db = $database->getConnection();

$array = array();

	/*
	$d=date("Y-m-d");
	$d1 = strtotime ( '+5 day' , strtotime ( $d ) ); 
	$d1 = date ( 'Y-m-d' , $d1 );

	$d="2021-12-01";$d1="2021-12-31";

	*/


	$sql="SELECT * from `eventi` e
		WHERE (e.visibile_da_data is null or e.visibile_da_data<=CURRENT_DATE()) and e.pubblicato=1 and CAST(e.data_evento as date)>=CURRENT_DATE() and e.denominazione is not null and e.data_evento>='$d' and e.data_evento<'$d1'";

	$resp=array();
	$result=$db->query($sql);
	$elem=0;
	$i=0;
	while($rows = $result->fetch_assoc()){
		$id_evento=$rows['id'];
        $short_descr=$rows['short_descr'];
		$start=$rows['data_evento'];
		$end=$rows['data_fine'];

        /*
			$year01 = substr($data_evento, 0,4);
			$month01 = substr($data_evento, 5,2);
			$day01 = substr($data_evento, 8,2);
			
			$timestart = "1600";
			$timeend = "1800";
		   

			$ora01 = substr($timestart, 0, 2);
			$min01 = substr($timestart, 2, 2);

			$ora02 = substr($timeend, 0, 2);
			$min02 = substr($timeend, 2, 2);


			$start="$year01-$month01-$day01 $ora01:$min01";
			$end="$year01-$month01-$day01 $ora02:$min02";
		*/
		$colo="#3c8dbc";
		if ($start!=$end) $colo="darkorange";
        $array[$i] = array(
                'id' => $i,
				'url' => "percorsi/dettaglio.php?event=".$id_evento,
                'title' => $short_descr,
                'start' => $start,
                'end' => $end,
                'allDay' => true,
				'backgroundColor' => $colo, //Primary (light-blue)
				);
				

				
/*
				'url' => 'https://www.google.com/',
			    'backgroundColor' => '#3c8dbc', //Primary (light-blue)
				'borderColor' => '#3c8dbc' //Primary (light-blue)
*/		
		//'allDay' => false -->con orario
				
        $i++;
    }

	echo json_encode($array);

//}
?>
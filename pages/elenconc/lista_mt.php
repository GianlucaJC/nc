<?php
session_start();
$nc_access=$_SESSION['nc_access'];

include_once '../../database.php';
$database = new Database();
$db = $database->getConnection();

$page_ref="lista_mt";

include_once '../../MVC/Models/M_main.php';
include_once '../../MVC/Controllers/C_lista_mt.php';
if (!isset($_SESSION['user_nc'])) {
	header("location: ../login/login.php");
	exit;
}		

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="NC">
  <title>ListaNC-MT</title>

  <!-- Google Font: Source Sans Pro -->
 
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10,b-1.1.0,b-html5-1.1.0,se-1.1.0/datatables.min.css">

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.firme_style
		{
			font-family:    Arial, Helvetica, sans-serif;
			font-size:      0.5em;
			
		}
	</style>
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
		<?php
			include("../../cerca.php");
		?>





     
	 <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

	<?php
	
	$path="../../";	
	include ("../../side_menu.php");
	?>	
<style>


</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		 
			<nav class="bg-dark navbar-dark">
			  
			  <div class="container">
				<center>
				<a href="javascript:void(0)" class="navbar-brand"><i class="fas fa-clipboard-list"></i> Lista NC Materiali</a>
				</center>
				
				
				
			  </div>
			 </nav>
			 
            <div class="card">

				  <div class="card-body">
				  <?php
				  if ($nc_access!="2") {?>
					  
					<div  style='float:right'>
					  <button type="button" class="mb-2 btn btn-primary" onclick="$('#div_filtri').toggle()">Filtri</button>
					  
					  <button type="button" class="ml-2 mb-2 btn btn-primary" onclick="$('.info_firme').toggle()">Nascondi/Visualizza Firme</button>
					  
					  <button type="button" class="mb-2 ml-2 btn btn-primary" onclick="$('#div_rapporto').toggle();">Elenco NC <i class='fas fa-file-pdf'></i> </button>

						<div class='container-fluid' style='display:none' id='div_rapporto'>
							<div class='row'>
								<div class="col-md-6">
									<div class="form-floating mb-3 mb-md-0">
										<input class="form-control" id="data1" name='data1' type="date" required />
										<label for="data1">Da data</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-floating mb-3 mb-md-0">
										<input class="form-control" id="data2" name='data2' type="date" required />
										<label for="data2">A data</label>
									</div>
								</div>
							</div>
						  <button type="button" class="mb-2 btn btn-primary" onclick="pdf_lista()">Crea <i class='fas fa-file-pdf'></i> </button>

						</div>
						

					 </div> 					  

				  
				  	<?php 
						include("filtri_mt.php");
					
					}  ?>
				  
					<table id="tb_nc" class="table table-bordered">
						<thead>
							<tr>
								<th style="width:40px">Protocollo</th>
								<th style="width:80px">Data</th>
								<th style="width:80px">Lotto</th>
								<th style="width:100px">Codice</th>
								<th>Descrizione</th>
								<th style="width:30px">Info</th>
								<?php 
									if ($nc_access!="2") echo "<th style='width:600px'>Analisi/Risoluzione</th>";
								?>
								<th style="width:40px">Segnalatore</th>
								<th style="width:40px">Rapporto</th>
								
							</tr>
						</thead>
						<tbody>
							<?php
								
								for ($sca=0;$sca<=count($elenco_nc)-1;$sca++) {
									$tipo=2;
									$id_oper=$elenco_nc[$sca]['id_oper'];
									$chi_segnala=$array_utenti_bis[$id_oper]['operatore'];
									$stato=$elenco_nc[$sca]['stato'];
									$id_ref=$elenco_nc[$sca]['id'];
									$data_nc=$elenco_nc[$sca]['data_nc'];
									$lotto_liof=$elenco_nc[$sca]['lotto_liof'];
									$protocollo_nc=stripslashes($elenco_nc[$sca]['protocollo_nc']);
									
									$codice=stripslashes($elenco_nc[$sca]['cod_art']);
									$descrizione=stripslashes($elenco_nc[$sca]['descr_art']);
									
									$status="";
									if ($stato==0) $status="table-danger";
									if ($stato==1) $status="table bg-orange";
									if ($stato==2) $status="table-warning";
									if ($stato==3) $status="table-success";
									echo "<tr class='$status'>";
									


										echo "<td style='text-align:center'>$protocollo_nc</td>";
										echo "<td>$data_nc</td>";
										echo "<td>$lotto_liof</td>";
										echo "<td>$codice</td>";
										echo "<td>$descrizione</td>";
										
										echo "<td style='text-align:center'>";
											echo "<a href='../insert_mt/new_nc_mt.php?tipo=$tipo&id_ref=$id_ref'>";
												echo "<i class='fas fa-info-circle'></i>";
											echo "</a>";	
										echo "</td>";
										if ($nc_access!="2") {					
											echo "<td style='text-align:center'>";

											
												echo "<a href='../analisi_mt/analisi_mt.php?tipo=$tipo&id_ref=$id_ref'>";
													echo "<button class='btn btn-primary' type='button'><i class='fas fa-file-alt'></i></button>";
												echo "</a>";	
												
												$stato_firme=stato_firme($elenco_nc,$sca);
												echo $stato_firme;
												
											echo "</td>";
											
										}	
										echo "<td>";
											echo $chi_segnala;
										echo "</td>";
										
										echo "<td style='text-align:center'>";
											echo "<a href='#' onclick='prepara_pdf($id_ref)'>";
												echo "<button class='btn btn-primary' type='button'><i class='fas fa-file-pdf'></i></button>";
											echo "</a>";
										echo "</td>";										
									echo "</tr>";
								}
							?>
						</tbody>
					  
						<tfoot>

						</tfoot>					  
					</table>  
				</div>	
			</div>	
					  

		




        <!-- /.row -->
		
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Consultazione in base al periodo</h3>
              </div>
				  <div class="card-body">
				  <form action="lista_mt.php?next=<?php echo $next; ?>" method="post" id='frm_periodo' name='frm_periodo'>
				    <?php
						$y=intval(date("Y"));
						$y1=$y-4;$y2=$y+1;
						$mese_vis="";
						echo "<center>";
							echo "<select class='form-control mb-2' aria-label='Default select example' onchange=\"$('#frm_periodo').submit()\" name='periodo_custom'>";
							  echo "<option selected>Scegli altro periodo</option>";
							  for ($sca=$y1;$sca<=$y2;$sca++) {
								echo "<optgroup label='$sca'>";
									for ($mm=1;$mm<=12;$mm++) {  
										if (strlen($mm)==1) $m2="0$mm";
										else $m2=$mm;
										$perx="$sca$m2";
										if ($mm==1) $mese_vis="GENNAIO";
										if ($mm==2) $mese_vis="FEBBRAIO";
										if ($mm==3) $mese_vis="MARZO";
										if ($mm==4) $mese_vis="APRILE";
										if ($mm==5) $mese_vis="MAGGIO";
										if ($mm==6) $mese_vis="GIUGNO";
										if ($mm==7) $mese_vis="LUGLIO";
										if ($mm==8) $mese_vis="AGOSTO";
										if ($mm==9) $mese_vis="SETTEMBRE";
										if ($mm==10) $mese_vis="OTTOBRE";
										if ($mm==11) $mese_vis="NOVEMBRE";
										if ($mm==12) $mese_vis="DICEMBRE";
										echo "<option value='$perx' ";
										
										echo ">$mese_vis</option>";
									}
								echo "</optgroup>";								
							  }
							echo "</select>";
						echo "</center>";
					?>
					<input type='hidden' name='next' id='next' value='<?php echo $next;?>'>
					</form>
					<div style='overflow-x:scroll'>
						
						<ul class="pagination pagination-month justify-content-l">


						  <li class="page-item"><a class="page-link" href="lista_mt.php?next=<?php echo ($next-1);?>">«</a></li>
							<?php
								$periodi=array();
								$y=intval(date("Y"));
								$m=intval(date("m"));
								

								

								if ($next!=0) {
									$num_m=$next*12;

									$data_ref="$y-01-01";
									
									$d1 = strtotime("$num_m months", strtotime($data_ref));
									$d2=date("Y-m-d", $d1);
									
									$y=substr($d2,0,4);$m=0;
									
								}

								
								$mese="Gen";$act="";
								if ($m_get==0) $m_get=$m;
								for ($sca=1;$sca<=12;$sca++) {
									if ($sca==$m_get && !isset($_GET['anno_ref'])) $act="active";
									else $act="";
									
									
									if (strlen($sca)==1) $mx="0$sca";
									else $mx=$sca;
									
									$periodo="$y$mx";
									
									

									if ($sca==1) $mese="Gen";
									if ($sca==2) $mese="Feb";
									if ($sca==3) $mese="Mar";
									if ($sca==4) $mese="Apr";
									if ($sca==5) $mese="Mag";
									if ($sca==6) $mese="Giu";
									if ($sca==7) $mese="Lug";
									if ($sca==8) $mese="Ago";
									if ($sca==9) $mese="Set";
									if ($sca==10) $mese="Ott";
									if ($sca==11) $mese="Nov";
									if ($sca==12) $mese="Dic";
									echo "<li class='page-item $act'>";
										$lnk="lista_mt.php?periodo=$periodo&next=$next";
										echo "<a class='page-link' href='$lnk'>";
											echo "<p class='page-month'>$mese</p>";
											echo "<p class='page-year'>$y</p>";
										echo "</a>";
									 echo "</li>";
								}
							?>


						  <li class="page-item"><a class="page-link" href="lista_mt.php?next=<?php echo ($next+1);?>">»</a></li>
						</ul>
						</div>
					</div>
					<?php 
						$out="outline-";
						if (isset($_GET['anno_ref'])) $out="";
					?>
					<ul class="pagination pagination-month justify-content-center">
						<?php
							
							$lnk="lista_mt.php?next=$next&anno_ref=$y";
						?>
						<a href='<?php echo $lnk;?>'>
							<button type="button" class="btn btn-<?php echo $out; ?>primary">Tutte le NC <?php echo $y;?></button>
						</a>
					<ul>
				  </div>
            </div>
          </div>
        </div>
		
      </div><!-- /.container-fluid -->
    </div>


    <!-- /.content -->
	
		
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
		<?php include("../tabelle/operazioni.php"); ?>

    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
	<?php 
		include("../../footer.php");
		
	?>
  </footer>  


</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="../../plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/pages/funzioni_comuni.js"></script>
<!-- Page specific script -->


<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<script>
$(function(){
	  buttons=[
		{
			extend: 'copyHtml5',
			/*
			exportOptions: {
				columns: [ 0, ':visible' ]
			}
			*/
		},
		{
			extend: 'csvHtml5'
		},
		{
			extend: 'excelHtml5',
			/*
			exportOptions: {
				columns: [ 0, 1, 2, 5 ]
			}
			*/
		},
		{
			extend: 'pdfHtml5'
		}

		]	

	$("#tb_nc").DataTable({
		//"responsive": true, 
        dom: 'Bfrtip',
		buttons:buttons,
		
		
		
		
		"lengthChange": false, "autoWidth": false,
		"pageLength": 10,
		//, "colvis"
		
		"language": {
			"lengthMenu": "Mostra _MENU_ NC per pagina &nbsp&nbsp",
			"zeroRecords": "Non ci sono NC",
			"info": "Pagina mostrata _PAGE_ di _PAGES_ di _TOTAL_ NC",
			"infoEmpty": "Non risultano NC",
			"infoFiltered": "(filtrati da _MAX_ record totali)",
			"search":         "Cerca:",
			"paginate": {
				"first":      "Prima",
				"last":       "Ultima",
				"next":       "Successiva",
				"previous":   "Precedente"
			}
		
		}


		
	}).buttons().container().appendTo('#tb_nc_wrapper .col-md-6:eq(0)');	
})	

function prepara_pdf(id_ref) {
	fetch('ajax.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=prepara_pdf_mt&id_ref='+id_ref
	})
	.then(response => {
		if (response.ok) {
		   return response.json();
		}
	})
	.then(resp=>{
		console.log(resp)
		var anchor = document.createElement('a');
		anchor.href = "rapporti/"+id_ref+".pdf";
		anchor.target="_blank";
		anchor.click();		
		
		/*
		if (resp[0].denominazione) {
		}
		*/
			
	})
	.catch(status, err => {
		return console.log(status, err);
	})		
}

function pdf_lista() {
	data1=$("#data1").val()
	data2=$("#data2").val()
	if (data1.length==0 || data2.length==0) {
		alert("Controllare il range di date impostato!");
		return false;
	}
	
	fetch('ajax.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=pdf_lista_mt&data1='+data1+'&data2='+data2
	})
	.then(response => {
		if (response.ok) {
		   return response.json();
		}
	})
	.then(resp=>{
		console.log(resp)
		var anchor = document.createElement('a');
		anchor.href = "rapporti/lista.pdf";
		anchor.target="_blank";
		anchor.click();		
		
		/*
		if (resp[0].denominazione) {
		}
		*/
			
	})
	.catch(status, err => {
		return console.log(status, err);
	})		
}

function set_cerca(value) {
	$(".filtri").hide(150);
	$("#str_cerca").val('');
	$("#str_cerca").prop("required",false);
	if (value=="1") {
		$("#str_cerca").attr("placeholder", "Codice");
		$("#str_cerca").prop("required",true);
		$("#div_str_cerca").show(150);
	}
	if (value=="2") {
		$("#str_cerca").attr("placeholder", "Lotto");
		$("#str_cerca").prop("required",true);
		$("#div_str_cerca").show(150);
	}	
	if (value=="3") {
		$("#div_filtro_reclamo_fornitore").show(150);
	}
	if (value=="4") {
		$("#div_filtro_tipologia").show(150);
	}

	if (value=="5") {
		$("#div_filtro_fornitore").show(150);
	}

	if (value=="6") {
		$("#div_stato_lavorazione").show(150);
	}
	if (value=="10") {
		$("#div_filtro_attivita").show(150);
	}
	

	
}

</script>

<?php
	function stato_firme($elenco_nc,$sca) {
		
		global $array_utenti;
		$firma_valutazione=$elenco_nc[$sca]['firma_valutazione'];
		$data_valutazione=$elenco_nc[$sca]['data_valutazione'];


		$sign_ris1=$elenco_nc[$sca]['sign_ris1'];
		$data_sezione_ris1=$elenco_nc[$sca]['data_sezione_ris1'];

		$sign_ris2=$elenco_nc[$sca]['sign_ris2'];
		$data_sezione_ris2=$elenco_nc[$sca]['data_sezione_ris2'];

		$sign_eliminazione_mv=$elenco_nc[$sca]['sign_eliminazione_mv'];
		$data_eliminazione_mv=$elenco_nc[$sca]['data_eliminazione_mv'];

		$sign_eliminazione_mf=$elenco_nc[$sca]['sign_eliminazione_mf'];
		$data_eliminazione_mf=$elenco_nc[$sca]['data_eliminazione_mf'];

		$sign_eliminazione_na=$elenco_nc[$sca]['sign_eliminazione_na'];
		$data_eliminazione_na=$elenco_nc[$sca]['data_eliminazione_na'];

		$sign_chiusura_nc=$elenco_nc[$sca]['sign_chiusura_nc'];
		$data_chiusura_nc=$elenco_nc[$sca]['data_chiusura_nc'];


		$view=null;
		$bg1="danger";
		if ($firma_valutazione!=0) $bg1="success";


		
		$bg2="danger";
		if ($sign_ris1!=0 && $sign_ris2!=0) $bg2="success";
		if ($sign_ris1==0 || $sign_ris2==0) $bg2="orange";
		if ($sign_ris1==0 && $sign_ris2==0) $bg2="danger";


		$bg3="danger";
		if (($sign_eliminazione_mf!=0 && $sign_eliminazione_mv!=0) || $sign_eliminazione_na!=0 ) $bg3="success";
		if (($sign_eliminazione_mf!=0 || $sign_eliminazione_mv!=0) && ($sign_eliminazione_mf==0 || $sign_eliminazione_mv==0)) $bg3="orange";
		if ( $sign_eliminazione_mf==0 && $sign_eliminazione_mv==0 && $sign_eliminazione_na==0 ) $bg3="danger";
		
		$bg4="danger";
		if ($sign_chiusura_nc!=0) $bg4="success";


		
		$view.="<div class='container info_firme firme_style' style='display:none'><hr>";
			$view.="<div class='row'>";
				$view.="<div class='col-sm-3'>";
					$view.="<div style='width:100%' class='badge bg-$bg1'>VALUTAZIONE</div>";
				$view.="</div>";
				$view.="<div class='col-sm-3'>";
					$view.="<div style='width:100%' class='badge bg-$bg2'>RISOLUZIONE</div>";
				$view.="</div>";
				$view.="<div class='col-sm-3'>";
					$view.="<div style='width:100%' class='badge bg-$bg3'>ELIMINAZIONE</div>";
				$view.="</div>";
				$view.="<div class='col-sm-3'>";
					$view.="<div style='width:100%' class='badge bg-$bg4'>CHIUSURA NC</div>";
				$view.="</div>";
			$view.="</div>";	


			$view.="<div class='row'>";
				//Valutazione
				$view.="<div class='col-sm-3'>";
						$view.="<div class='row'>";
						
							if ($firma_valutazione!=0) {
								$view.="<div class='col-sm-12  bg-success'><i>".$array_utenti[$firma_valutazione]."</i> <hr> $data_valutazione</div>";
							} else
								$view.="<div class='col-sm-12  bg-danger'>---<hr>---</div>";

						$view.="</div>";
						
				$view.="</div>";
			

				//Risoluzione
				$view.="<div class='col-sm-3'>";
					$view.="<div class='row'>";
						if ($sign_ris1!=0) {
							$view.="<div class='col-sm-6 bg-success'>F1-<i>".$array_utenti[$sign_ris1]."</i> <hr> $data_sezione_ris1</div>";
						} else
							$view.="<div class='col-sm-6 bg-danger'>F1<hr>---</div>";
						
						if ($sign_ris2!=0) {
							$view.="<div class='col-sm-6 bg-success'>F2-<i>".$array_utenti[$sign_ris2]."</i> <hr> $data_sezione_ris2</div>";
						} else
							$view.="<div class='col-sm-6 bg-danger'>F2<hr>---</div>";
					$view.="</div>";
				$view.="</div>";
				
				//Eliminazione
				$view.="<div class='col-sm-3'>";
					$view.="<div class='row'>";
						if ($sign_eliminazione_na!=0) {
							$view.="<div class='col-sm-12 bg-success'>N/A-<i>".$array_utenti[$sign_eliminazione_na]."</i> <hr> $data_eliminazione_na</div>";
						} else {
							if ($sign_eliminazione_mv!=0) {
								$view.="<div class='col-sm-6 bg-success'>MV-<i>".$array_utenti[$sign_eliminazione_mv]."</i> <hr> $data_eliminazione_mv</div>";
							} else
								$view.="<div class='col-sm-6 bg-danger'>MV<hr>---</div>";
							
							if ($sign_eliminazione_mf!=0) {
								$view.="<div class='col-sm-6 bg-success'>MF-<i>".$array_utenti[$sign_eliminazione_mf]."</i> <hr> $data_eliminazione_mf</div>";
							} else
								$view.="<div class='col-sm-6 bg-danger'>MF<hr>---</div>";
						}
					$view.="</div>";
				$view.="</div>";				
				
				//Chiusura NC
				$view.="<div class='col-sm-3'>";
					$view.="<div class='row'>";
						if ($sign_chiusura_nc!=0) {
							$view.="<div class='col-sm-12 bg-success'><i>".$array_utenti[$sign_chiusura_nc]."</i> <hr> $data_chiusura_nc</div>";
						} else
							$view.="<div class='col-sm-12 bg-danger'>---<hr>---</div>";
							
						
					$view.="</div>";
				$view.="</div>";			
			$view.="</div>";
		$view.="</div>";

		
		return $view;
	}
?>

</body>
</html>

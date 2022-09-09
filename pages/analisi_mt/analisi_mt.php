<?php
session_start();
$nc_access=$_SESSION['nc_access'];

include_once '../../database.php';
$database = new Database();
$db = $database->getConnection();
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
if ($nc_access=="2")  header("location:../../index.php");
if (!isset($_GET['id_ref'])) header("location:../../index.php");
$page_ref="";
include_once '../../MVC/Models/M_main.php';
include_once '../../MVC/Models/M_analisi_mt.php';
include_once '../../MVC/Controllers/C_analisi_mt.php';

if (!isset($_SESSION['user_nc'])) {
	header("location: ../login/login.php");
	exit;
}		
/*
	Per gli allegati:
	- ho creato una view standard html contenuta in class_allegati.php
	- siccome non può essere istanziata contemporaneamente sulla stessa pagina in più parti, tramite chiamata fetch popolo una finestra modal (dal contenuto di class_allegati)
	- richiamo tramite js le impostazioni iniziali per far funzionare il plug-in (function set_class_allegati in demo-config.js)
*/

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="NC">
 

  <title>AnalisiNC_MT</title>

  
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/styles.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  
  <!-- per upload -->
  <link href="../../dist/css/jquery.dm-uploader.min.css" rel="stylesheet">
  <!-- per upload -->  
  <link href="styles.css?ver=1.0" rel="stylesheet">

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  
  
</head>

<style>
.accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");
    transform: scale(0.75) !important;
	color: #ffdf7e;
}
.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M0 8a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");
	
}
.accordion-button:not(.collapsed) {
	color:silver;
}
.accordion-button {
	background-color: #ffdf7e;
	color:white;
}
</style>


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
				<a href="javascript:void(0)" class="navbar-brand"><i class="fas fa-calendar-check"></i>  Analisi/Valutazione - Risoluzione NC di Materiale</a>
				</center>
			  </div>
			 </nav>

<?php

			if (isset($_GET['ins']) && $_GET['ins']=="1") {
				echo "<div class='alert alert-success mt-2' role='alert'>";
					echo "Dati acquisiti con successo!";
				echo "</div>";
			}
			$stato=$info_nc_mt[0]['stato'];
			$action="analisi_mt.php?id_ref=$id_ref";
			if (($nc_access=="2" || $nc_access=="5") && $id_ref!=0) $action="no";
?>			


			<div class="accordion mt-3" id="myAccordion">
				<?php
					
					
					$coll="collapse";$coll1="collapsed";
					if (isset($_POST['accordion1']) && $_POST['accordion1']=="1") {$coll="";$coll1="";}
					

					$stile_agg="background-color:#ffdf7e;color:red";
					if ($info_nc_mt[0]['firma_valutazione']!=0) $stile_agg="background-color:green;color:white";
					if ($stato==0 || $stato==1) $stile_agg="background-color:red;color:white";
					if ($stato==1) $stile_agg="background-color:orange;color:white";
					
					
				?>				
				<input type='hidden' name='nc_access' id='nc_access' value='<?php echo $nc_access;?>'>
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading">
						<!-- onclick="set_sezione(1)" !-->
					
						<button  type="button" class="accordion-button <?php echo $coll1; ?>" data-bs-toggle="collapse" data-bs-target="#collapse" style='<?php echo $stile_agg;?>'>
						<?php
							echo "<h5>Sezione ANALISI/VALUTAZIONE NON CONFORMITA'</h5>";
						?>
						</button>									
					</h2>

					<!-- Form   V A L U T A Z I O N E !-->
					
						<form action="<?php echo $action;?>" method="post" id='frm_val' name='frm_val' autocomplete="off" class="needs-validation" novalidate >
							<input type='hidden' name='accordion1' id='accordion1'>
							<input type='hidden' name='id_ref' id='id_ref' value='<?php echo $id_ref;?>'>
							
							<input type='hidden' id='check_sign_valutazione' value="<?php echo $info_nc_mt[0]['firma_valutazione'];?>">

							
			
							<div id="collapse" class="accordion-collapse <?php echo $coll; ?>" data-bs-parent="#myAccordion" >
								
								<?php include("valutazione.php"); ?>
								
							</div>
						</form>
					<!-- Fine Form VALUTAZIONE !-->
				</div>

				
				
				<?php
					/*
					$coll="collapse";$coll1="collapsed";
					if (isset($_POST['accordion1']) && $_POST['accordion1']=="1") {$coll="";$coll1="";}
					*/
					$stile_agg="background-color:#ffdf7e;color:red";
					if ($info_nc_mt[0]['sign_ris1']!=0 && $info_nc_mt[0]['sign_ris2']!=0) $stile_agg="background-color:green;color:white";
					if ($stato==0 || $stato==1) $stile_agg="background-color:red;color:white";
					if ($stato==1) $stile_agg="background-color:orange;color:white";
					
					
				?>					
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading2">
						<!-- onclick="set_sezione(2)" !-->
						<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse2" style='<?php echo $stile_agg;?>' >
						<?php
							echo "<h5>Sezione RISOLUZIONE NON CONFORMITA'</h5>";
						?>
						</button>									
					</h2>
					<!-- Form   R I S O L U Z I O N E (inserito nello script) !-->
						<div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
							<?php include("risoluzione.php"); ?>
						</div>
					<!-- Fine Form RISOLUZIONE !-->
				</div>


				<?php
					/*
					$coll="collapse";$coll1="collapsed";
					if (isset($_POST['accordion1']) && $_POST['accordion1']=="1") {$coll="";$coll1="";}
					*/
					$stile_agg="background-color:#ffdf7e;color:red";
					if (($info_nc_mt[0]['sign_eliminazione_mf']!=0 && $info_nc_mt[0]['sign_eliminazione_mv']!=0) || $info_nc_mt[0]['sign_eliminazione_na']!=0 ) $stile_agg="background-color:green;color:white";
					if ($stato==0 || $stato==1) $stile_agg="background-color:red;color:white";
					if ($stato==1) $stile_agg="background-color:orange;color:white";

					
				?>	
				
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading3">
						<!-- onclick="set_sezione(2)" !-->
						<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse3" style='<?php echo $stile_agg;?>'>
						<?php
							echo "<h5>Sezione ELIMINAZIONE DEL MATERIALE NON CONFORME </h5>";
						?>
						</button>									
					</h2>
					<!-- Form   E L I M I N A Z I O N E (inserito nello script) !-->
						<div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
							<?php include("eliminazione.php"); ?>
						</div>
					<!-- Fine Form RISOLUZIONE !-->
				</div>

				<?php
					/*
					$coll="collapse";$coll1="collapsed";
					if (isset($_POST['accordion1']) && $_POST['accordion1']=="1") {$coll="";$coll1="";}
					*/
					$stile_agg="background-color:#ffdf7e;color:red";
					if ($info_nc_mt[0]['sign_chiusura_nc']!=0) $stile_agg="background-color:green;color:white";
					if ($stato==0) $stile_agg="background-color:red;color:white";
					if ($stato==1) $stile_agg="background-color:orange;color:white";

				?>
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading4">
						<!-- onclick="set_sezione(2)" !-->
						<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse4" style='<?php echo $stile_agg;?>' >
						<?php
							echo "<h5>Sezione CHIUSURA NON CONFORMITA'</h5>";
						?>
						</button>									
					</h2>
					<!-- Form   E L I M I N A Z I O N E (inserito nello script) !-->
						<div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
							<?php include("finale.php"); ?>
						</div>
					<!-- Fine Form RISOLUZIONE !-->
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
  

<div class="modal fade bd-example-modal-lg" id="win_dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Finestra di servizio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id='body_dialog'>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>   
  
 
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
	<?php 
		include("../../footer.php");
	?>
  </footer>  


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
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

<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../dist/js/pages/funzioni_comuni.js"></script>

<!-- per upload -->
<script src="../../dist/js/jquery.dm-uploader.min.js"></script>
<script src="demo-ui.js?ver=1.0"></script>
<script src="demo-config.js?ver=1.4"></script>
<script src="analisi_mt.js?ver=1.2"></script>

<!-- fine upload -->



</body>
</html>

<?php
	session_start();

	include_once '../../database.php';
	$database = new Database();
	$db = $database->getConnection();
	
	include_once '../../MVC/Models/M_eventi.php';
	include_once '../../MVC/Controllers/C_search.php';
	

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

  <title>Cerca codici</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10,b-1.1.0,b-html5-1.1.0,se-1.1.0/datatables.min.css">
	
  <!-- per upload -->
  <link href="../../dist/css/jquery.dm-uploader.min.css" rel="stylesheet">
  <!-- per upload -->  
  <link href="styles.css?ver=1.0" rel="stylesheet">
	
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
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>



     
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">NonConformità</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Pages</li>
			  <li class="breadcrumb-item active">Cerca codici</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
	  
		<section class="content">
			<div class="container-fluid">
				<h2 class="text-center display-4">Cerca Codici</h2>
				<div class="row">
					<div class="col-md-8 offset-md-2">
						<form action="search.php" method="post" name="frm_search" id="frm_search" autocomplete="off">
							<div class="input-group">
								<input class="form-control form-control-lg" type="search" placeholder="Codice/Lotto/Protocollo" aria-label="Codice/Lotto/Protocollo" name='cerca_evento'>
								<div class="input-group-append">
									<button type="submit" class="btn btn-lg btn-default">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div id='div_ris_cerca' class='mt-3 mb-3'>
					<?php 
					//print_r($cerca_evento);
						if (count($cerca_evento)>0) {
							echo "<div class='list-group'>";
								for ($sca=0;$sca<=count($cerca_evento)-1;$sca++) {
								  echo "<a href='../percorsi/dettaglio.php?event=".$cerca_evento[$sca]['id_evento']."' class='list-group-item list-group-item-action flex-column align-items-start '>";
									echo "<div class='d-flex w-100 justify-content-between'>";
									  echo "<h5 class='mb-1 text-primary'>".$cerca_evento[$sca]['short_descr_e']."</h5>";
									  echo "<small>".$cerca_evento[$sca]['distanza']."</small>";
									echo "</div>";
									echo "<p class='mb-1'>".$cerca_evento[$sca]['short_descr']."</p>";
									echo "<p class='mb-1'><small>Data evento: <b>".date("d-m-Y",strtotime($cerca_evento[$sca]['data_evento']))."</b></small></p>";
									echo "<p><small>Luogo: <b>".$cerca_evento[$sca]['luogo']."</b></small></p>";

								  echo "</a>";
								}
							echo "</div>";	
						} else {
							if (isset($_POST['cerca_evento'])) { 
								echo "<div class='alert alert-warning' role='alert'>";
								  echo "Nessun evento trovato!";
								echo "</div>";
							}
						}
						?>	
				</div>				
			</div>
		</section>	  

        <!-- /.row -->
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
    <strong>NC</strong>
    <div class="float-right d-none d-sm-inline-block">
			Copyright © Jolly Computer snc
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<script src="demo-config.js?ver=1.3"></script>
<!-- fine upload -->

<?php if (1==2) {?>
	<!-- AdminLTE App -->
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
<?php } ?>

<script>
  $(function () {
			$("#example1").DataTable({
				//"responsive": true, 
				"lengthChange": false, "autoWidth": false,
				"pageLength": 50,
				//, "colvis"
				"buttons": ["copy", "excel", "pdf"],
				"language": {
					"lengthMenu": "Mostra _MENU_ Moduli per pagina &nbsp&nbsp",
					"zeroRecords": "Non ci sono moduli",
					"info": "Pagina mostrata _PAGE_ di _PAGES_ di _TOTAL_ Moduli",
					"infoEmpty": "Non risultano Moduli",
					"infoFiltered": "(filtrati da _MAX_ record totali)",
					"search":         "Cerca:",
					"paginate": {
						"first":      "Prima",
						"last":       "Ultima",
						"next":       "Successiva",
						"previous":   "Precedente"
					}
				
				}	  
			}).buttons().container().appendTo('#tb_resp_wrapper .col-md-6:eq(0)');		
  });

 ini_upload() 

</script>

</body>
</html>

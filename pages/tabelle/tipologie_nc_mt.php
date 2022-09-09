<?php
session_start();
/*
if (!(isset($_SESSION['tipo_user']) &&  $_SESSION['tipo_user']=="0")) 
	header("location: ../../index.php");
*/

include_once '../../database.php';
$database = new Database();
$db = $database->getConnection();

include_once '../../MVC/Models/M_main.php';
include_once '../../MVC/Models/M_tabelle.php';
include_once '../../MVC/Controllers/C_tipologie_mt.php';

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

  <title>Tiplogie NC</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10,b-1.1.0,b-html5-1.1.0,se-1.1.0/datatables.min.css">
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
          <form action='../cerca/search.php' method='post' class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Luogo o nome evento/percorso" aria-label="Luogo o nome evento/percorso" name='cerca_evento'>
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
            <h1 class="m-0">Tipologie NC di Materiale</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Pages</li>
			  <li class="breadcrumb-item active">Tipologie NC MT</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

		<div class="row">  
          <!-- /.col-md-6 -->

		  
		  
          <div class="col-lg-12">
			<form action="tipologie_nc_mt.php" method="post" id='frm_view' name='frm_view' autocomplete="off" >  
				<input type='hidden' name='id_edit' id='id_edit' value="<?php echo $id_edit;?>">
				<div class="card" style='overflow-x:scroll'>
				  <div class="card-header">
					<h5 class="m-0">Elenco Tipologie presenti</h5>
				  </div>
				  <div class="card-body">
					<?php
							if ($edit==1) {
								$view_new="display:block";
							}
							else {
								$view_new="display:none";
								echo "<a href='#' onclick=\"$('#div_new').toggle();$('#from_clone').val('')\">";
										echo "<button type='button' class='btn btn-primary'>Definizione Nuova Tipologia</button>";
								echo "</a>";
							}
							
					?>
					
					<div id='div_new' class='mt-4' style='<?php echo $view_new;?>'>
						<div class="row">

							<?php
								$value="";
								if ($edit==1) {
									$value="value=\"".stripslashes($edit_tipo[0]['descrizione'])."\"";
								}
							?>
							<div class="col-md-8">
							  <label for="descr_tipo" class="form-label">Descrizione Tipologia</label>
							  <input type="text" class="form-control" id="descr_tipo" name="descr_tipo" placeholder="Descrizione" maxlength=200 <?php echo $value;?> required>
							</div>							


						</div>
						<div class='mt-4'>
							
							<button type='submit' id='btn_new' name='btn_new' class='btn btn-success'>
							<?php
								if ($edit==0) echo "Crea Tipologia di materiale";
								else echo "Modifica Tipologia di materiale";
							?>
							</button>
							<button onclick="location.href='tipologie_nc_mt.php'" type='button' id='btn_close' class='btn btn-secondary'>Chiudi</button>
						</div>
												
					</div>					
					
					<?php					
						if ($ins_new && is_array($ins_new)) {
							if ($ins_new['header']=="KO") {
								echo "<div class='alert alert-warning mt-3' role='alert'>";
								  echo "Problemi occorsi durante la creazione:<hr>";
								  echo "Dettagli: <i>".$ins_new['error']."</i>";
								echo "</div>";
							}
						}
					?>
					
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Modifica</th>
								<!--
									<th>Clona</th>
								!-->
								<th>Elimina</th>
								<th>Descrizione Tipologia di materiale</th>
							</tr>
						</thead>
					  <tbody>
						<?php
						
							for ($sca=0;$sca<=count($elenco_tipologie)-1;$sca++) {
									$id_t=$elenco_tipologie[$sca]['id'];
									echo "<tr>";
										echo "<td style='text-align:center;'>";
											echo "<a href='tipologie_nc_mt.php?id_tipo=$id_t'>";
												echo "<i class='fas fa-edit'></i>";
											echo "</a>";
										echo "</td>";
										if (1==2) {
											echo "<td style='text-align:center;'>";
												echo "<a href='#' onclick=\"$('#div_new').show();$('#from_clone').val($id_t)\">";
													echo "<i class='fas fa-clone'></i>";
												echo "</a>";
											echo "</td>";
										}
										
										
										echo "<td style='text-align:center;'>";
											echo "<a href='javascript:void(0)' class='btn btn-primary btn_remove' data-remove=$id_t>";
												echo "<i class='fas fa-trash-alt'></i>";
											echo "</a>";
										echo "</td>";
										echo "<td>";
											echo "<b>".stripslashes($elenco_tipologie[$sca]['descrizione'])."</b>";
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
				<input type='hidden' id='to_remove' name='to_remove'>
				<input type='hidden' id='from_clone' name='from_clone'>

			</form>
			
			<form action="elenco.php" method="post" id='frm_delete' name='frm_delete'>  
				<input type='hidden' name='id_delete' id='id_delete' >
			</form>
			
			<form target='_blank' action="impegno.php" method="post" id='frm_impegno' name='frm_impegno'>  
				<input type='hidden' name='impegno' id='impegno' >
			</form>
          </div>
          <!-- /.col-md-6 -->
        </div>
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
				"pageLength": 20,
				//, "colvis"
				"buttons": ["copy", "excel", "pdf"],
				"language": {
					"lengthMenu": "Mostra _MENU_ Tipologie di materiale per pagina &nbsp&nbsp",
					"zeroRecords": "Non ci sono Tipologie di materiale",
					"info": "Pagina mostrata _PAGE_ di _PAGES_ di _TOTAL_ Tipologie di materiale",
					"infoEmpty": "Non risultano Tipologie di materiale",
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
  
	$(".btn_remove").bind('click', function(event) {
		if (!confirm("Sicuri di rimuovere la tipologia di materiale?")) return false;
		to_remove=$(this).attr("data-remove");
		$("#to_remove").val(to_remove)
		$("#frm_view").submit();
	}); 	


</script>

</body>
</html>

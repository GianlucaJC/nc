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
include_once '../../MVC/Controllers/C_utenti.php';
if (!isset($_SESSION['user_nc'])) {
	header("location: ../login/login.php");
	exit;
}			
$nc_access=$_SESSION['nc_access'];
if ($nc_access!="1") header("location: ../../index.php");

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

  <title>Utenti/Team</title>

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
            <h1 class="m-0">Utenti/Team</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Pages</li>
			  <li class="breadcrumb-item active">Utenti/Team</li>
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
			<form action="utenti.php" method="post" id='frm_view' name='frm_view' autocomplete="off" >  
				<input type='hidden' name='id_edit' id='id_edit' value="<?php echo $id_edit;?>">
				<div class="card" style='overflow-x:scroll'>
				  <div class="card-header">
					<h5 class="m-0">Elenco Utenti presenti</h5>
				  </div>
				  <div class="card-body">

					
				
					
					
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Operatore</th>
								<th style='text-align:center'>Tipo Accesso</th>
								<th style='text-align:center'>Team SI/NO</th>
								<th>E-mail</th>
								<th style='text-align:center'>Salva</th>
								<!--
								<th>Attrezzature associate</th>
								!-->
							</tr>
						</thead>
					  <tbody>
						<?php
						
							for ($sca=0;$sca<=count($elenco_utenti)-1;$sca++) {
									$id_u=$elenco_utenti[$sca]['id'];
									$nc_access=$elenco_utenti[$sca]['nc_access'];
									$abilitato_team=$elenco_utenti[$sca]['abilitato'];
									$operatore=stripslashes($elenco_utenti[$sca]['operatore']);
									$email=stripslashes($elenco_utenti[$sca]['email']);
									echo "<tr>";
										echo "<td>";
											echo "<b>$operatore</b>";
										echo "</td>";

										echo "<td style='text-align:center;'>";
											echo "<select class='form-control' id='service$id_u' data-placeholder='Accesso al servizio' >";
/*
Segnalatore base: può segnalare la NC e visualizzare il resto (preclusione analisi NC)
Segnalatore Caporeparto: come base ma vede analisi NC
Valutatore: può segnalare, valutare e chiudere la NC
Eliminatore : può segnalare una NC e può compilare la parte dell'eliminazione
ADMIN: può fare tutte le modifiche delle tabelle, eliminare le nc 
*/
												echo "<option value='0' ";
												if ($nc_access==0) echo " selected ";
												echo ">Disabilitato</option>";
												/*
												echo "<option value='1' ";
												if ($nc_access==1) echo " selected ";
												echo ">Admin</option>";
												*/

												echo "<option value='2' ";
												if ($nc_access==2) echo " selected ";
												echo ">Segnalatore Base</option>";

												echo "<option value='5' ";
												if ($nc_access==5) echo " selected ";
												echo ">Segnalatore Caporeparto</option>";
												
												echo "<option value='3' ";
												if ($nc_access==3) echo " selected ";
												echo ">Valutatore</option>";

												echo "<option value='4' ";
												if ($nc_access==4) echo " selected ";
												echo ">Eliminatore</option>";


											echo "</select>";
										echo "</td>";

										echo "<td style='text-align:center;'>";
											echo "<select class='form-control' id='team$id_u' data-placeholder='Accesso al servizio' >";
											
												echo "<option value='0' ";
												if ($abilitato_team==0) echo " selected ";
												echo ">NO</option>";

												echo "<option value='1' ";
												if ($abilitato_team==1) echo " selected ";
												echo ">SI</option>";
											echo "</select>";

										echo "</td>";

										echo "<td>";
												echo "<input class='form-control' id='txt_mail$id_u'  type='text' placeholder='E-mail' value='$email' maxlength=120  />";
										echo "</td>";
										
										echo "<td style='text-align:center'>";
											echo "<button id='btn_set$id_u' type='button' class='attesa_set btn btn-primary set_service' data-service=$id_u onclick='imposta_servizio($id_u)'>"; 
												echo "<i class='fas fa-save'></i>";
											echo "</button>";
											
											echo "<button style='display:none' class='attesa ml-2 btn btn-primary' type='button' id='btn_wait$id_u' disabled>";
											  echo "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>";
											  echo " Attendere...";
											echo "</button>";

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
				"lengthMenu": "Mostra _MENU_ Utenti per pagina &nbsp&nbsp",
				"zeroRecords": "Non ci sono Utenti",
				"info": "Pagina mostrata _PAGE_ di _PAGES_ di _TOTAL_ Utenti",
				"infoEmpty": "Non risultano Utenti",
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

		var table = $('#example1').DataTable();
		
  });
 	

function imposta_servizio(id_u)  {
	
	$(".attesa").hide();
	$(".attesa_set").attr("disabled",true);
	
	
	
	//id_u=$(contesto).attr("data-service");
	$("#btn_wait"+id_u).show();
	
	service=$("#service"+id_u).val();
	team=$("#team"+id_u).val();
	txt_mail=$("#txt_mail"+id_u).val();	
	setTimeout(function(){
	
		fetch('utenti.php', {
			method: 'post',
			//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
			headers: {
			  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
			},
			body: 'operazione=save_utenti&id_u='+id_u+'&service='+service+'&team='+team+'&txt_mail='+txt_mail
		})
		.then(response => {
			$(".attesa_set").attr("disabled",false);
			$("#btn_wait"+id_u).hide();
			
			if (response.ok) {
			   return response.json();
			}
		})
		.then(resp=>{
			$(".attesa_set").attr("disabled",false);
			$("#btn_wait"+id_u).hide();
			if (resp.status=="KO") {
				alert("Problemi occorsi durante il salvataggio.\n\nDettagli:\n"+resp.error);
				return false;
			}

		})
		.catch(status, err => {
			$(".attesa_set").attr("disabled",false);
			$("#btn_wait"+id_u).hide();
			return console.log(status, err);
		})	
	
	
	},1000);	
}

</script>

</body>
</html>

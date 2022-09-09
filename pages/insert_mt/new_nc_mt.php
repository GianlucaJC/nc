<?php
session_start();
$nc_access=$_SESSION['nc_access'];

include_once '../../database.php';
$database = new Database();
$db = $database->getConnection();


$page_ref="new_nc_mt";

include_once '../../MVC/Models/M_main.php';
include_once '../../MVC/Models/M_inser_mt.php';
include_once '../../MVC/Controllers/C_new_mt.php';
	

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
<!-- Global site tag (gtag.js) - Google Analytics -->


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="NC">
 

  <title>InserimentoNC</title>

  
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/styles.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
      <div class="container-fluid segnalazione">
		<form action="new_nc_mt.php?id_ref=<?php echo $id_ref;?>" method="post" id='frm_ins' name='frm_ins' autocomplete="off" class="needs-validation" novalidate >  
			<nav class="bg-dark navbar-dark">
			  
			  <div class="container">
				<center>
				<a href="javascript:void(0)" class="navbar-brand"><i class="fas fa-plus-square"></i>  Inserimento/Modifica NC di Materiale</a>
				</center>
			  </div>
			 </nav>

		<input type='hidden' name='nc_access' id='nc_access' value='<?php echo $nc_access;?>'>
		<input type='hidden' name='id_ref' id='id_ref' value='<?php echo $id_ref; ?>'>
		<?php
			$id_ref_temp=uniqid();
		?>
		<input type='hidden' name='id_ref_temp' id='id_ref_temp' value='<?php echo $id_ref_temp; ?>'>


<?php

			if (isset($_GET['ins']) && $_GET['ins']=="1") {
				echo "<div class='alert alert-success mt-2' role='alert'>";
					echo "Dati acquisiti con successo!";
				echo "</div>";
			}
			//in caso di problema su invio notifica
			if ($sendmail!="OK") {
				echo "<div class='alert alert-warning mt-2' role='alert'>";
					echo "Problema occorso durante l'invio della notifica<hr>$sendmail";
				echo "</div>";
			}
?>			

		
			<div class="row mt-3">
				<div class="col-md-2">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="data_nc" name='data_nc' type="date" value="<?php echo $data_nc;?>" required />
						<label for="data_nc">Data</label>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="lotto_liofilchem" name='lotto_liofilchem' type="text" placeholder="Lotto Liofilchem" maxlength=50 required  value="<?php echo $lotto_liofilchem;?>" onfocusout="set_cod(this.value)"  />
						<label for="lotto_liofilchem">Lotto Liofilchem</label>
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="cod_art" name='cod_art' type="text" placeholder="Codice"  value="<?php echo $codice; ?>" readonly required maxlength=30 />
						<label for="cod_art">Codice</label>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="descr_art" name='descr_art' type="text" placeholder="Descrizione"  required value="<?php echo $descrizione; ?>" readonly maxlength=255 />
						<label for="descr_art">Descrizione</label>
					</div>

				</div>			
			</div>

			

			<div class="row mt-3">
				<div class="col-md-6">
					<div class="form-floating mb-3 mb-md-0">
						<input type='hidden' name='cod_cf' id='cod_cf' value='<?php echo $cod_cf; ?>' maxlength=20>
						<input class="form-control" id="fornitore" name='fornitore' type="text" placeholder="Fornitore" value="<?php echo $fornitore; ?>" readonly maxlength=255 />
						<label for="fornitore">Fornitore</label>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="lotto_cf" name='lotto_cf' type="text" placeholder="Lotto fornitore"  value="<?php echo $lotto_cf; ?>" readonly maxlength=50 />
						<label for="lotto_cf">Lotto Fornitore</label>
					</div>

				</div>
			</div>					

			


			<div class="row mt-3">
				<div class="col-md-4">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="qta_fornita" name='qta_fornita' type="number" placeholder="Q.ta Fornita" value="<?php echo $qta_fornita; ?>" readonly  />
						<label for="qta_fornita">Quantità fornita</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="qta_nc" name='qta_nc' type="number" placeholder="Q.ta NC"  value="<?php echo $qta_nc; ?>" required step='any' />
						<label for="qta_nc">Quantità non conforme</label>
					</div>

				</div>

				<div class="col-md-4">
					  <div class="form-floating mb-3 mb-md-0">
						
						<select class="form-select" id="tipo_nc" aria-label="Tipologia NC" name='tipo_nc' onchange='' placeholder="Tipologia NC" required>
							<option value=''>Select...</option>
							
							<?php
								
								for ($sca=0;$sca<=count($tipo_nc)-1;$sca++) {
									$descr_tipo=$tipo_nc[$sca]['descrizione'];
									$descr_tipo=stripslashes($descr_tipo);
									echo "<option value=".$tipo_nc[$sca]['id'];
									if ($tiponc==$tipo_nc[$sca]['id']) echo " selected ";
									echo ">".$descr_tipo."</option>";
								}
							?>
						</select>
						<label for="tipo_nc">Tipologia NC</label>
						</div>
						<a onclick="$('#up_tipo').show();" href='../tabelle/tipologie_nc_mt.php' target='_blank' id='a_tipo'>
							<i class="fas fa-cogs"></i>
						</a>						
						<span id='up_tipo' style='display:none;'>
							<a href='javascript:void(0)' onclick="refresh_tipo()">
								<font color='red'><i class="ml-3 fas fa-sync-alt"></i></font>
							</a>
						</span>	
				</div>				
			</div>
			
			<div class="row mt-3">

				<div class="col-md-12">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="descrizione_nc" name='descrizione_nc' type="text" placeholder="Descrizione" required maxlength=255 value="<?php echo $descrizione_nc; ?>" />
						<label for="descrizione_nc">Descrizione della Non Conformità</label>
					</div>
				</div>				
			</div>	
				
			
			<div class="row mt-3">

				<div class="col-md-4">
					<button type="button" name='btn_allegati' id='btn_allegati' class="btn btn-info" data-target="#win_dialog" data-toggle="modal" onclick='set_sezione(1)' ><i class="fas fa-paperclip"></i> Definisci allegati</button>			
				</div>	

			</div>

			<div class="row mt-3 container-fluid" id='div_allegati'>
				<?php 
					include("view_allegati.php");
					echo "<hr>";
				?>
			</div>


			
			
			<button type="submit" name='btn_ins_nc_mt' id='btn_ins_nc_mt' class="btn btn-primary"><i class="fas fa-save"></i> Salva NC</button>

		</form>
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
        <h5 class="modal-title" id="exampleModalLabel">Info</h5>
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

<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
		  event.preventDefault();
		  event.stopPropagation();

		  var html;
	   	  html="<p><b>Attenzione</b><br>Per poter avanzare è necessario controllare tutti i campi evidenziati in rosso</p>";
		  $("#body_dialog").html(html)
		  $('#win_dialog').modal('show')
		  
        } else {
			cod_art=$("#cod_art").val()
			descr_art=$("#descr_art").val()
			
			if (cod_art.length==0 || descr_art.length==0) {
				  event.preventDefault();
				  event.stopPropagation();
				  var html;
				  html="<p><b>Attenzione</b><br>Non risulta valorizzato il Codice. Controllare il lotto al quale fa riferimento</p>";
				  $("#body_dialog").html(html)
				  $('#win_dialog').modal('show')
				  return false;
		  
			}
			return true;
		}
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


$(function(){
	id_ref=$("#id_ref").val()
	nc_access=$("#nc_access").val()
	if (id_ref!="0") {
		$(".segnalazione").find('select,input,textarea,button').attr("disabled","disabled");
		$("#btn_ins_nc_mt").hide();
		$("#a_tipo").hide();
	}	
})	

function set_cod(value) {
	$("#cod_art").val("")
	$("#descr_art").val("")
	$("#cod_cf").val("")
	$("#fornitore").val("")
	$("#lotto_cf").val("")
	$("#qta_fornita	").val("")
	fetch('ajax.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=get_code&lotto='+value
	})
	.then(response => {
		if (response.ok) {
		   return response.json();
		}
	})
	.then(resp=>{
		
		if (resp.header=="OK") {
			$("#cod_art").val(resp.cod_art)
			$("#descr_art").val(resp.des_art)
			$("#cod_cf").val(resp.cod_cf)
			$("#fornitore").val(resp.rag_soc_cf)
			$("#lotto_cf").val(resp.lotto_cf)
			$("#qta_fornita	").val(resp.qta_fornita)
			
		}	
	})
	.catch(status, err => {
		return console.log(status, err);
	})	
	
}


function refresh_tipo() {
	$("#tipo_nc").empty();
	fetch('ajax.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=refresh_tipo'
	})
	.then(response => {
		if (response.ok) {
		   return response.json();
		}
	})
	.then(resp=>{
		
		html="";
		html+="<option value='' selected='selected'>Select...</option>";
		for (sca=0;sca<=resp.length-1;sca++) {
			id=resp[sca].id
			descrizione=resp[sca].descrizione
			html+="<option value='"+id+"'>"+resp[sca].descrizione+"</option>";
		}
		$('#tipo_nc').append(html);
		$('#up_tipo').hide();
		
	})
	.catch(status, err => {
		$('#up_tipo').hide();
		return console.log(status, err);
	})	
}



function set_sezione(sezione) {
	$(".allegati").empty();
	fetch('class_allegati.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=refresh_tipo'
	})
	.then(response => {
		if (response.ok) {
		   return response.text();
		}
		
	})
	.then(resp=>{
		//$("#div_sezione"+sezione).html(resp);
		
		$("#body_dialog").html(resp);
		set_class_allegati(sezione); //in demo-config.js
	})
	.catch(status, err => {
		
		return console.log(status, err);
	})
}

</script>

</body>
</html>

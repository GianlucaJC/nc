<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
session_start();
include_once 'database.php';
$database = new Database();
$db = $database->getConnection();
include_once 'MVC/Models/M_main.php';
include_once 'MVC/Controllers/C_dash.php';


$nc_access=$_SESSION['nc_access'];


if (isset($_GET['logout'])){
	session_unset();
	session_destroy();
}

$page_ref="index";



$nc="0";$altro="";
if (isset($_GET['nc'])) $altro="?nc=".$_GET['nc'];
if (isset($_GET['nc_mt'])) $altro="?nc_mt=".$_GET['nc_mt'];

if (!isset($_SESSION['user_nc'])) {
	header("location: pages/login/login.php".$altro);
	exit;
} else {
	if (strlen($altro)!=0) {
		if (isset($_GET['nc']))
			header("location: pages/elenconc/lista.php".$altro);
		if (isset($_GET['nc_mt']))
			header("location: pages/elenconc/lista_mt.php".$altro);
		exit;
	}
}

if ($nc_access=="2" || $nc_access=="5") header("location: pages/insert/new_nc_pr.php");
if ($nc_access=="4") header("location: pages/elenconc/lista.php");



/*
include_once 'MVC/Models/M_profilo.php';
include_once 'MVC/Models/M_eventi.php';

*/

	


?>

<!DOCTYPE html>
<html lang="it">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="NC">
  <title>NON Conformità | Dashboard</title>


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo1.jpeg" alt="LogoNC" height="60" >
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
		<?php
			include("cerca.php");
		?>


      <!-- Messages Dropdown Menu -->
	  

	  
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

	  
    </ul>
  </nav>
  <!-- /.navbar -->

	<?php 
		$path="";
		include("side_menu.php");
	?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content mt-3">
      <div class="container-fluid">
	  
	  

		<!-- in assenza di questo div il successivo sarebbe incluso all'interno del corpo del div contenitore !-->
		<div class='row'></div>
		
        <div class="row" style='display:none'>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>Totale Non conformità</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Dettagli <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>3</h3>

                <p>NC Nuove</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Dettagli <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>NC In corso</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">Dettagli <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>103</h3>

                <p>NC Chiuse</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">Dettagli <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
		
		
		<?php
			//print_r($tipo_prodotto_in_nc);
			$today=date("d-m-Y");
			
			$today7=cal_date("7",1);
			$today31=cal_date("31",1);
			$today365=cal_date("365",1);
			
			$week="$today - $today7";
			$month="$today31 - $today";
			$year="$today365 - $today";
		?>
		

			<?php
				/*
				$out1="outline-";
				if ($tipo_stat=="1") $out1="";
				echo "<input class='btn btn-".$out1."primary' onclick=\"$('#tipo_stat').val(1)\" type='submit' value='Oggi ($today)'>";
				*/

				$act1="";$act2="";$act3="";$act4="";$act5="";$act6="";
				$disp_range="display:none";
				if ($tipo_stat=="1") $act1="active";
				if ($tipo_stat=="2") $act2="active";
				if ($tipo_stat=="3") $act3="active";
				if ($tipo_stat=="4") $act4="active";
				if ($tipo_stat=="5") $act5="active";
				if ($tipo_stat=="6") {$act6="active";$disp_range="";}
			?>
			<h5 class='mt-2'>
				<a href='javascript:void(0)' onclick="$('#div_stat1').toggle(150)";>
					Statistica per periodo dell'analisi
				</a>	
			</h5>
			<?php
				$disp1="display:none";
				$disp2="display:none";
				if (strlen($tipo_stat)!=0) $disp1="";
				if (strlen($tipo_analisi)!=0) $disp2="";
			?>
			
			<div class="list-group mt-3" style='<?php echo $disp1;?>' id='div_stat1'>
				<?php
					echo "<form action='index.php' method='post' id='frm_periodo' name='frm_periodo'>";
						echo "<input type='hidden' class='tipo_stat' name='tipo_stat' id='tipo_stat'>";

						echo "<input class='list-group-item list-group-item-action $act1' onclick=\"$('.tipo_stat').val(1)\" type='submit' value='Oggi ($today)'>";

						echo "<input class='list-group-item list-group-item-action $act2' onclick=\"$('.tipo_stat').val(2)\" type='submit' value='Nella settimana ($week)'>";

						echo "<input class='list-group-item list-group-item-action $act3' onclick=\"$('.tipo_stat').val(3)\" type='submit' value='Nel mese ($month)'>";

						echo "<input class='list-group-item list-group-item-action $act4' onclick=\"$('.tipo_stat').val(4)\" type='submit' value=\"Nell'anno ($year)\">";

						echo "<input class='list-group-item list-group-item-action $act5'
						onclick=\"$('.tipo_stat').val(5)\" type='submit' value=\"Da sempre\">";
					echo "</form>";

					
					echo "<input class='list-group-item list-group-item-action $act6'
					onclick=\"set_range();\" type='button' value=\"Come da range\">";
					

				?>			  

			</div>
			
			<?php 
			
			echo "<form action='index.php' method='post' id='frm_periodo' name='frm_periodo'>";
				echo "<input type='hidden' class='tipo_stat' name='tipo_stat' id='tipo_stat'>";
				echo "<div class='row mt-2' id='div_range' style='$disp_range'>";
						echo "<div class='col-lg-3'>";
							echo "<label for='da_data'>Da data</label>";
							echo "<input required class='form-control' type='date' name='da_data' id='da_data' value='$da_data'> ";
						echo "</div>";
						echo "<div class='col-lg-3'>";
							echo "<label for='a_data'>A data</label>";
							echo "<input required class='form-control' type='date' name='a_data' id='a_data' value='$a_data'> ";
						echo "</div>";
						echo "<div class='col-lg-3'>";
							echo "<label for='sub_range'> </label>";
							echo "<button type='submit' id='sub_range' name='sub_range' class='form-control btn btn-primary'>Imposta</button> ";
						echo "</div>";
						
				echo "</div>";
			echo "</form>";
			
			?>
			
			<h5 class='mt-4'>
				<a href='javascript:void(0)' onclick="$('#div_stat2').toggle(150)";>
					Analisi Generale
				</a>
			</h5>
			
			<div class="list-group mt-3" style='<?php echo $disp2; ?>' id='div_stat2'>
				<?php
				
					$act1="";$act2="";$act3="";
					if ($tipo_analisi=="1") $act1="active";
					if ($tipo_analisi=="2") $act2="active";
					if ($tipo_analisi=="3") $act3="active";
					
					$anno1=date("Y");$anno2=date("Y")-1;$anno3=date("Y")-2;
					
					echo "<form action='index.php' method='post' id='frm_analisi' name='frm_analisi'>";
						echo "<input type='hidden' name='tipo_analisi' id='tipo_analisi'>";

						echo "<input class='list-group-item list-group-item-action $act1' onclick=\"$('#tipo_analisi').val(1)\" type='submit' value='$anno1'>";

						echo "<input class='list-group-item list-group-item-action $act2' onclick=\"$('#tipo_analisi').val(2)\" type='submit' value='$anno2'>";

						echo "<input class='list-group-item list-group-item-action $act3' onclick=\"$('#tipo_analisi').val(3)\" type='submit' value='$anno3'>";


					echo "</form>";
				?>			  

			</div>			
		
		<hr>
		
		<?php

			
			if (strlen($tipo_stat)!=0) {
				 include("stat_periodo.php");
				
			} 

			
			if (strlen($tipo_analisi)!=0) {
				 include("stat_analisi.php");
				
			} 
	
		?>

		
		
		
		
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  





  <!-- /.content-wrapper -->
  <footer class="main-footer">
	<?php 
		include("footer.php");
	?>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard3.js"></script>
<script src="main.js?ver=2.0"></script>
<script>

</script>


</body>
</html>

<?php
function cal_date($dato,$tipo) {
	$oggi=date("Y-m-d", time());	
	$data = strftime('%Y-%m-%d', strtotime("-$dato day", strtotime($oggi)));
	$date = date_create($data);
	$format="Y-m-d";
	if ($tipo=="1") $format="d-m-Y";
	
	
	$d=date_format($date, $format);
	return $d;
}
?>
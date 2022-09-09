<div class="row">
  <div class="col-lg-12">
	<!-- /.card -->
	<div class="card">
	  <div class="card-header border-0">
		<h3 class="card-title">Elenco NC per Tipologia Prodotto</h3>
		<div class="card-tools">
		  <!--
		  <a href="#" class="btn btn-tool btn-sm">
			<i class="fas fa-download"></i>
		  </a>
		  !-->
		  <a href="#" class="btn btn-tool btn-sm">
			<i class="fas fa-bars"></i>
		  </a>
		</div>
	  </div>
	  <div class="card-body table-responsive p-0">
		<table class="table table-striped table-valign-middle" id='tb_stat'>
		  <thead>
		  <tr>
			<th>Tipologia Prodotto</th>
			<th>NC</th>
			<th colspan=4 style='text-align:center'>Risoluzione</th>
			<th>Dettagli</th>
		  </tr>
		  <tr>
			<th></th><th></th>
			<th>Accettare il prodotto</th>
			<th>Rilavorare il prodotto</th>
			<th>Selezionare ed eliminare i pezzi non conformi</th>
			<th>Eliminare l'intero lotto</th>
			<th></th>
		  </tr>
		  </thead>
		  <tbody>
			<?php 
				
				
				
				for ($sca=0;$sca<=count($tipo_prodotto_in_nc)-1;$sca++) {
				  $id_tipo=$tipo_prodotto_in_nc[$sca]['id'];
				  
				  $info_stat_tipo=$main_all->info_stat_tipo($id_tipo,$periodo);
				  echo "<tr id='riga$sca'>";
					echo "<td>";
					   echo "<div id='spin$sca' style='display:none' class='mr-1  spinner-border spinner-border-sm' role='status'>";
						 echo "<span class='sr-only'></span>";
					  echo "</div>";
					
						echo "<a href='javascript:void(0)' onclick=\"get_class($sca,$id_tipo,'$periodo')\">";
							echo $tipo_prodotto_in_nc[$sca]['descrizione'];
						echo "</a>";	
					echo "</td>";
					echo "<td>";
						echo $info_stat_tipo['num_nc'];
					echo "</td>";
					
					echo "<td style='text-align:center'>";
						echo $info_stat_tipo['att1'];
					echo "</td>";
					echo "<td style='text-align:center'>";
						echo $info_stat_tipo['att2'];
					echo "</td>";
					echo "<td style='text-align:center'>";
						echo $info_stat_tipo['att3'];
					echo "</td>";
					echo "<td style='text-align:center'>";
						echo $info_stat_tipo['att4'];
					echo "</td>";

					echo "<td id='dettaglio$sca'>";
					
					  echo "<div>";
						  echo "<a href='javascript:void(0)' onclick=\"get_class($sca,$id_tipo,'$periodo')\" class='text-muted'>";
							echo "<i class='fas fa-search'></i>";
						  echo "</a>";
					  echo "</div>";
					echo "</td>";
				  echo "</tr>";

			}
				
			?>
			
			  
		  </tbody>
		</table>
	  </div>
	</div>
	<!-- /.card -->
  </div>
  <!-- /.col-md-6 -->
</div>		  
  
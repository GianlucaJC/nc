<?php
	$anno=intval(date("Y"));
	if ($tipo_analisi=="2") $anno=$anno-1;
	if ($tipo_analisi=="3") $anno=$anno-2;
?>
<div class="row">
	  <!-- /.col-md-6 -->
	  <div class="col-lg-12" >
		<div class="card">
		  <div class="card-header border-0">
			
			<div class="d-flex justify-content-between">
			  <h3 class="card-title"><b>ANALISI ANNUALE NC</b></h3>
			  <!-- 		
			  <a href="javascript:void(0);">View Report</a>
			  !-->
			</div>
			
		  </div>
		  <div class="card-body">
			<div class="d-flex">
			  <p class="d-flex flex-column">
				<span class="text-bold text-lg">
					<?php
						if (isset($analisi_anno['num_nc_anno'])) echo $analisi_anno['num_nc_anno'];
					?>
				</span>
				<span>NC Totali nel <?php echo "<b>$anno</b>"; ?></span>
			  </p>
			  <!--
			  <p class="ml-auto d-flex flex-column text-right">
				<span class="text-success">
				  <i class="fas fa-arrow-up"></i> 33.1%
				</span>				
				<span class="text-muted">Tendenza ultimo mese</span>
			  </p>
			  !-->
			</div>
			
			
			<div>
	  <div class="card-body table-responsive p-0">
			<table class="table table-striped table-valign-middle" id='tb_stat'>
			  <thead>
				  <tr>
					<th>Mese</th>
					<th>NC Totali</th>
					<th>% su NC Totali Annuali</th>
				  </tr>
			  </thead>
			  <tbody>
				<?php
					$num_anno=$analisi_anno['num_nc_anno'];
					
					$mese="";$media_t=0;$trim=0;
					$trimestre_tipo=array();
					$lotti_trim=0;$totale_anno=0;
					$somma_q1=0;$somma_q2=0;$somma_q3=0;$somma_q4=0;
					for ($sca=1;$sca<=12;$sca++) {

						if ($sca==1) $mese="Gennaio";
						if ($sca==2) $mese="Febbraio";
						if ($sca==3) $mese="Marzo";
						if ($sca==4) $mese="Aprile";
						if ($sca==5) $mese="Maggio";
						if ($sca==6) $mese="Giugno";
						if ($sca==7) $mese="Luglio";
						if ($sca==8) $mese="Agosto";
						if ($sca==9) $mese="Settembre";
						if ($sca==10) $mese="Ottobre";
						if ($sca==11) $mese="Novembre";
						if ($sca==12) $mese="Dicembre";
						$pref="";
						if ($sca<=9) $pref="0";
						$indice="nc_".$pref.$sca;
						$num_nc_mese=0;
						if (isset($analisi_anno[$indice])) {
							$num_nc_mese=$analisi_anno[$indice];
						}							
						
						echo "<tr>";
							echo "<td>";
								echo "<a href='javascript:void(0)' onclick=\"$('#div_prod$sca').toggle(150);\">";
									echo $mese;
								echo "</a>";	
								$view_tipo_prodotti=view_tipo_prodotti($analisi_anno,$sca,$num_nc_mese);
								echo $view_tipo_prodotti['view'];
							echo "</td>";
							
							$nc_id=$analisi_anno[$indice."_id"];
							echo "<td>";
									//+resp.info_class[sca].id_ref_nc
								echo "<a href='pages/elenconc/lista.php?nc=$nc_id'  target='_blank'>";					
									echo $num_nc_mese;
								echo "</a>";	
								
							echo "</td>";
							echo "<td>";
								$perc_mens="";
								if ($num_anno!=0 && $num_nc_mese!=0) {
									$perc_mens=(100/$num_anno)*$num_nc_mese;
									$perc_mens=number_format($perc_mens,2);
									$perc_mens.="%";
								}	
								echo $perc_mens;
							echo "</td>";
						echo "</tr>";
						$media_t+=$num_nc_mese;
						
						$riep_tipo=$view_tipo_prodotti['riep_tipo'];
						$lotti_trim+=$view_tipo_prodotti['lotti'];
						foreach ($riep_tipo as $k=>$v) {
							if (isset($trimestre_tipo[$k])) 
								$trimestre_tipo[$k]['q']+=$riep_tipo[$k]['q'];
							 else {
								 $trimestre_tipo[$k]['tipologia']=$riep_tipo[$k]['tipologia'];
								 $trimestre_tipo[$k]['q']=$riep_tipo[$k]['q'];
							 }
						}
						
						
						if (($sca/3)==intval($sca/3)) {
							
							$trim++;
							echo "<tr>";
								echo "<td style='background-color:#f0f8ff'>";
									echo "<a href='javascript:void(0)' onclick=\"$('#divq_$trim').toggle(150)\">";
										echo "<b>Q$trim</b>";
									echo "</a>";
									
									//Riepilogo DATI Quarter per le tipologie
									$riep_trim_tipo=riep_trim_tipo($trimestre_tipo,$trim,$media_t,$lotti_trim,$anno);
									echo $riep_trim_tipo;
									//
									
								echo "</td>";
								echo "<td style='background-color:#f0f8ff'>";
									if ($media_t==0) $media_t="";
									echo "<b>$media_t</b>";
								echo "</td>";
								echo "<td style='background-color:#f0f8ff'>";
									$perc_t="";
									if ($num_anno!=0 && $media_t!=0) {
										$perc_t=(100/$num_anno)*$media_t;
										$perc_t=number_format($perc_t,2);
										$perc_t.="%";
									}	
									echo "<b>$perc_t</b>";
								echo "</td>";
							echo "</tr>";
							if (($sca/3)==1) $somma_q1=$media_t;
							if (($sca/3)==2) $somma_q2=$media_t;
							if (($sca/3)==3) $somma_q3=$media_t;
							if (($sca/3)==4) $somma_q4=$media_t;
							$media_t=0;
							$lotti_trim=0;
							$trimestre_tipo=array();
						}						
					}
					
					
				?>
			  </tbody>
			  <tfoot>
			  
			  </tfoot>
			</table>
			
			<hr>
			<div class="d-flex justify-content-between">
			  <h3 class="card-title"><b>ANALISI MEDIA MENSILE NC</b></h3>
			  <!-- 		
			  <a href="javascript:void(0);">View Report</a>
			  !-->
			</div>			
			<table class="table table-striped table-valign-middle" id='tb_stat_media'>
			  <thead>
				  <tr>
					<th>MEDIA</th>
					<th>NC Totali</th>
					<th>% su NC Totali Annuali</th>
				  </tr>
			  <thead>

			  <tbody>
				<tr>
					<td>
					</td>
					<td>
						<?php 
							$data_ultimo_ins=$analisi_anno['data_ultimo_ins'];
							$divis=0;
							if ($data_ultimo_ins!=null && strlen($data_ultimo_ins)>5)
								$divis=intval(substr($data_ultimo_ins,5,2));
							$media="";
							if ($divis!=0) {
								$media=($num_anno/$divis);
								$media=number_format($media,2);
							}	
							echo $media;
						?>
					</td>
					<td>
						<?php
							$media_su_anno="";
							
							if ($num_anno!=0) {
								$media_su_anno=(100/$num_anno)*$media;
								$media_su_anno=number_format($media_su_anno,2)."%";
							}	
							echo $media_su_anno;
						?>
					</td>
				</tr>
			  </tbody>
			  <tfoot>
			  
			  </tfoot>
			</table>
			

			<hr>
			<div class="d-flex justify-content-between">
			  <h3 class="card-title"><b>ANALISI MEDIA QUARTER NC</b></h3>
			  <!-- 		
			  <a href="javascript:void(0);">View Report</a>
			  !-->
			</div>			
			<table class="table table-striped table-valign-middle" id='tb_stat_media'>
			  <thead>
				  <tr>
					<th>MEDIA</th>
					<th>NC Totali</th>
					<th>% su NC Totali Annuali</th>
				  </tr>
			  <thead>

			  <tbody>
				<?php 
					$s1=0;$s2=0;$s3=0;$s4=0;
					for ($sca=1;$sca<=4;$sca++) {?>
						<tr>
							
							<td>
								<?php echo "<h6>Q".$sca."</h6>"; ?>
							</td>
							<td>
								<?php 
									if ($sca==1) {
										if ($divis!=0) {
											if ($divis>=3)
												$s1=number_format($somma_q1/3,2);
											else 
												$s1=number_format($somma_q1/$divis,2);
										}
										if ($s1!=0) echo $s1;
									}	
									if ($sca==2) {
										if ($divis!=0) {
											if ($divis>=6)
												$s2=number_format($somma_q2/3,2);
											else 
												$s2=number_format($somma_q2/($divis-3),2);
										}
										if ($s2!=0) echo $s2;
									}	
									if ($sca==3) {
										if ($divis!=0) {
											if ($divis>=9)
												$s3=number_format($somma_q3/3,2);
											else 
												$s3=number_format($somma_q3/($divis-6),2);
										}		
										if ($s3!=0) echo $s3;
									}	
									if ($sca==4) {
										if ($divis!=0) {
											if ($divis>=12)
												$s4=number_format($somma_q4/3,2);
											else 
												$s4=number_format($somma_q4/($divis-9),2);
										}									
										if ($s4!=0) echo $s4;
									}
								?>
							</td>
							<td>

								<?php
									$media_su_anno="";$somma=0;
									if ($sca==1) $somma=$s1;
									if ($sca==2) $somma=$s2;
									if ($sca==3) $somma=$s3;
									if ($sca==4) $somma=$s4;

									if ($num_anno!=0) {
										$media_su_anno=(100/$num_anno)*$somma;
										if ($media_su_anno!=0)
											$media_su_anno=number_format($media_su_anno,2)."%";
										else $media_su_anno="";
									}	
									echo $media_su_anno;
								?>						

							</td>
						</tr>
				<?php } ?>
			  </tbody>
			  <tfoot>
			  
			  </tfoot>
			</table>			
			



		  
			</div>
			<!-- /.d-flex -->


		  </div>
		</div>
		<!-- /.card -->



	  </div>
</div>

<?php
	function view_tipo_prodotti($analisi_anno,$mese,$num_nc_mese) {
		
		//statistica per tipo prodotti nel mese
		$view=null;
		$ent=0;
		global $anno;
		$m=$mese;
		if (intval($m)<=9) $m="0$m";
		
		$per1="$anno-$m-01";
		$temp = new DateTime( $per1 ); 
		$per2=$temp->format( 'Y-m-t' );
		$periodo="$per1 $per2";

		if (isset($analisi_anno['analisi_prodotto'][$mese])) {
			$lotti=0;
			if (isset($analisi_anno['elenco_lotti'][$mese])) 
				$lotti=$analisi_anno['elenco_lotti'][$mese];			
			
			
			$view.="<div class='card-body table-responsive p-0' id='div_prod$mese' style='display:none'>";
				$view.="<hr>";
				$view.="<table class='table table-striped table-valign-middle'>";
					$view.="<thead>";
					$view.="<tr>";
						$view.="<th>Tipo prodotto</th>";
						$view.="<th>Num</th>";
						$view.="<th>Incidenza % su NC Totali</th>";
						$view.="<th>Incidenza su lotti prodotti ($lotti)</th>";
					$view.="</tr>";

					$view.="<tbody>";
						$riep_tipo=array();
						
						for ($sca=0;$sca<=count($analisi_anno['analisi_prodotto'][$mese])-1;$sca++) {
							$ent++;
							$id_tipo=$analisi_anno['analisi_prodotto'][$mese][$sca]['tipo_prodotto'];
							
							$tipologia=$analisi_anno['analisi_prodotto'][$mese][$sca]['descrizione'];
							$id_ref_rig="$anno$mese$sca";
							$q=$analisi_anno['analisi_prodotto'][$mese][$sca]['q'];
							$riep_tipo[$id_tipo]['tipologia']=$tipologia;
							$riep_tipo[$id_tipo]['q']=$q;
							
							$view.="<tr id='riga$id_ref_rig'>";
								$view.="<td>";
									$view.="<div id='spin$id_ref_rig' style='display:none' class='mr-1  spinner-border spinner-border-sm' role='status'>";
									$view.="<span class='sr-only'></span>";
									$view.="</div>";
									
									$js="get_class.num_nc_mese=$num_nc_mese;";
									$js="get_class.num_lotti=$lotti;";
									$js.="get_class($id_ref_rig,$id_tipo,'$periodo')";
									
									$view.="<a href='javascript:void(0)' onclick=\"$js\">";
									  $view.="<i>".$tipologia."</i>";
								    $view.="</a>";
								$view.="</td>";
								
								$inc_mese="";$inc_lotti_mese="";
								if ($num_nc_mese!=0) {
									$inc_mese=(100/$num_nc_mese)*$q;
									$inc_mese=number_format($inc_mese,2)."%";
								}	

								if ($lotti!=0) {
									$inc_lotti_mese=(100/$lotti)*$q;
									$inc_lotti_mese=number_format($inc_lotti_mese,2)."%";
								}	
								$view.="<td>".$q."</td>";
								$view.="<td>".$inc_mese."</td>";
								$view.="<td>".$inc_lotti_mese."</td>";
							$view.="</tr>";
						}
					$view.="</tbody>";	
				$view.="</table>";
		}
		
		$dati['view']=$view;
		$dati['lotti']=$lotti;
		$dati['riep_tipo']=$riep_tipo;
		return $dati;
	

	}
	
	function riep_trim_tipo($trimestre_tipo,$trim,$media_t,$lotti_trim,$anno) {
		
		$view=null;
		$periodo="";$mese_in="";$mese_fi="";
		if ($trim==1) {$mese_in="01";$mese_fi="03";}
		if ($trim==2) {$mese_in="04";$mese_fi="06";}
		if ($trim==3) {$mese_in="07";$mese_fi="09";}
		if ($trim==4) {$mese_in="10";$mese_fi="12";}
		$p1="$anno-$mese_in-01";
		$px="$anno-$mese_fi-01";
		$temp = new DateTime( $px ); 
		$p2=$temp->format( 'Y-m-t' );
		
		$periodo="$p1 $p2";
		
		
		
		$view.="<div id='divq_$trim' style='display:none'>";
			$view.="<hr>";
			$view.="<table class='table table-striped table-valign-middle'>";
				$view.="<thead>";
					$view.="<tr>";
						$view.="<th>Tipo Prodotto</th>";
						$view.="<th>Num</th>";
						$view.="<th>Incidenza % su NC Totali ($media_t)</th>";
						$view.="<th> Incidenza su lotti prodotti ($lotti_trim)</th>";
					$view.="</tr>";	
				$view.="</thead>";
				$view.="<tbody>";
					
					$incr=0;
					foreach ($trimestre_tipo as $k=>$v) {
						$num_nc_mese=$trimestre_tipo[$k]['q'];
						$incr++;
						$id_ref_rig="riga_trim_".$trim."_$incr";	
						$js="get_class.num_nc_mese=$num_nc_mese;";
						$js="get_class.num_lotti=$lotti_trim;";
						$js.="get_class('$id_ref_rig',$k,'$periodo')";
						$view.="<tr id='riga$id_ref_rig'>";
						 
							$view.="<td>";

								$view.="<div id='spin$id_ref_rig' style='display:none' class='mr-1  spinner-border spinner-border-sm' role='status'>";
								$view.="<span class='sr-only'></span>";
								$view.="</div>";
								
								$view.="<i>";
									$view.="<a href='javascript:void(0)' onclick=\"$js\">";
										$view.= $trimestre_tipo[$k]['tipologia'];
									$view.="</a>";	
								$view.="</i>";
							$view.="</td>";
							
							$view.="<td>";
								$view.="<i>";
									$view.= $trimestre_tipo[$k]['q'];
								$view.="</i>";
							$view.="</td>";
							
							$view.="<td>";
								$inc_tipo_t="";
								if ($media_t>0) {
									$inc_tipo_t=(100/$media_t)*$trimestre_tipo[$k]['q'];
									$inc_tipo_t=number_format($inc_tipo_t,2)."%";
								}
								$view.=$inc_tipo_t;
							$view.="</td>";
							
							$view.="<td>";
							$inc_tipo_trim_lotti=0;
								if ($lotti_trim>0) {
									$inc_tipo_trim_lotti=(100/$lotti_trim)*$trimestre_tipo[$k]['q'];
									$inc_tipo_trim_lotti=number_format($inc_tipo_trim_lotti,2)."%";
								}
								$view.=$inc_tipo_trim_lotti;
							$view.="</td>";
							
						$view.="</tr>";
					}
				$view.="</tbody>";
			$view.="</table>";
		$view.="</div>";
		
		return $view;
	}
	
?>
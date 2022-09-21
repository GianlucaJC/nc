<!-- contenitore principale della valutazione che sarà inibito dopo la firma mediante JS !-->
<div class="card-body">
	<div class="valutazione">
		<div class="row mt-3">
			<div class="col-md-3">
				<div class="form-floating mb-3 mb-md-0">
					
					<select class="form-select" id="tipo_prodotto" aria-label="Tipo Prodotto" name='tipo_prodotto' required>
						<option value=''>Select...</option>
						<?php
						for ($sca=0;$sca<=count($lista_tipo_prodotti)-1;$sca++) {
							$id_tipo_pr=$lista_tipo_prodotti[$sca]['id'];
							$descrizione=$lista_tipo_prodotti[$sca]['descrizione'];
							echo "<option value='$id_tipo_pr' ";
							if ($info_nc_pr[0]['tipo_prodotto']==$id_tipo_pr) echo " selected ";
							echo ">".$descrizione."</option>";
						}	
						?>							
					</select>						
					<label for="tipo_prodotto">Tipologia Prodotto</label>
				</div>
			</div>

			<div class="col-md-3">
				  <div class="form-floating mb-3 mb-md-0">
					<select class="form-select" id="nc_rilevata" aria-label="NC Rilevata" name='nc_rilevata'>
						<option value=''>Select...</option>
						<option value='1'
						<?php if ($info_nc_pr[0]['nc_rilevata']==1) echo " selected "; ?>
						>Prima della consegna del prodotto al cliente</option>
						<option value='2'
						<?php if ($info_nc_pr[0]['nc_rilevata']==2) echo " selected "; ?>
						>Dopo la consegna del prodotto al cliente</option>
					</select>
					<!-- da collegare al codice !-->
					<label for="nc_rilevata">Non conformità rilevata</label>
					</div>
			</div>

			<div class="col-md-6">
				  <div class="form-floating mb-3 mb-md-0">
					<select class="form-select" id="classificazione_nc" aria-label="Classificazione NC" name='classificazione_nc' >
						<option value=''>Select...</option>
						<?php
							for ($sca=0;$sca<=count($classificazioni)-1;$sca++) {
								$descr_cl=stripslashes($classificazioni[$sca]['descrizione']);
								$id_cl=$classificazioni[$sca]['id'];
								echo "<option value='$id_cl' ";
								if ($info_nc_pr[0]['classificazione_nc']==$id_cl) echo " selected ";
								echo ">$descr_cl</option>";
								
							}
						?>
					</select>
					<!-- da collegare al codice !-->
					<label for="classificazione_nc">Classificazione NC</label>
					</div>
					<a id='a_class' onclick="$('#up_tipo').show();" href='../tabelle/classificazione_nc_pr.php' target='_blank'>
						<i class="fas fa-cogs"></i>
					</a>						
					<span id='up_tipo' style='display:none;'>
						<a href='javascript:void(0)' onclick="refresh_tipo()">
							<font color='red'><i class="ml-3 fas fa-sync-alt"></i></font>
						</a>
					</span>	
					
			</div>	
			

			<div class="mt-3">
					<table id="tb_analisi" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>AREA</th>
								<th>ANALISI EFFETTUATA</th>
								<th>CAUSA DELLA NON CONFORMITA'</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class='text-primary'><b>Man</b></span></td>
								<td>

									<textarea class="form-control" id='txt_man' placeholder="Descrizione" name='txt_man' rows="2" cols="50" maxlength=300><?php echo trim($info_nc_pr[0]['txt_man']);?></textarea>

									
								</td>
								<td>
									<select class='form-control' name='man_sn' id='man_sn'>
										<option value=''>Select...</option>
										<option value='1'
										<?php if ($info_nc_pr[0]['man_sn']==1)echo " selected ";?>
										>SI</option>
										<option value='0'
										<?php if ($info_nc_pr[0]['man_sn']!=null && $info_nc_pr[0]['man_sn']==0)echo " selected ";?>
										>NO</option>
									</select>
									
								</td>
							</tr>

							<tr>
								<td><span class='text-primary'><b>Method</b></span></td>
								<td>
									<textarea class="form-control" id='txt_method' placeholder="Descrizione" name='txt_method' rows="2" cols="50" maxlength=300><?php echo trim($info_nc_pr[0]['txt_method']);?></textarea>
								</td>
								<td>
									<select class='form-control' name='method_sn' id='method_sn'>
										<option value=''>Select...</option>
										<option value='1'
										<?php if ($info_nc_pr[0]['method_sn']==1)echo " selected ";?>
										>SI</option>
										<option value='0'
										<?php if ($info_nc_pr[0]['method_sn']!=null &&  $info_nc_pr[0]['method_sn']==0)echo " selected ";?>
										>NO</option>
									</select>
									
								</td>
							</tr>
							
							<tr>
								<td><span class='text-primary'><b>Material</b></span></td>
								<td>
									<textarea class="form-control" id='txt_material' placeholder="Descrizione" name='txt_material' rows="2" cols="50" maxlength=300><?php echo trim($info_nc_pr[0]['txt_material']);?></textarea>
									
								</td>
								<td>
									<select class='form-control' name='material_sn' id='material_sn'>
										<option value=''>Select...</option>
										<option value='1'
										<?php if ($info_nc_pr[0]['material_sn']==1)echo " selected ";?>
										>SI</option>
										<option value='0'
										<?php if ($info_nc_pr[0]['material_sn']!=null && $info_nc_pr[0]['material_sn']==0)echo " selected ";?>
										>NO</option>
									</select>
									
								</td>
							</tr>

							<tr>
								<td><span class='text-primary'><b>Machine</b></span></td>
								<td>

									<textarea class="form-control" id='txt_machine' placeholder="Descrizione" name='txt_machine' rows="2" cols="50" maxlength=300><?php echo trim($info_nc_pr[0]['txt_machine']);?></textarea>									
									
								</td>
								<td>
									<select class='form-control' name='machine_sn' id='machine_sn'>
										<option value=''>Select...</option>
										<option value='1'
										<?php if ($info_nc_pr[0]['machine_sn']==1)echo " selected ";?>
										>SI</option>
										<option value='0'
										<?php if ($info_nc_pr[0]['machine_sn']!=null &&  $info_nc_pr[0]['machine_sn']==0)echo " selected ";?>
										>NO</option>
									</select>
									
								</td>
							</tr>	

							<tr>
								<td><span class='text-primary'><b>Enviroment</b></span></td>
								<td>

									<textarea class="form-control" id='txt_enviroment' placeholder="Descrizione" name='txt_enviroment' rows="2" cols="50" maxlength=300><?php echo trim($info_nc_pr[0]['txt_enviroment']);?></textarea>										
								</td>
								<td>
									<select class='form-control' name='enviroment_sn' id='enviroment_sn'>
										<option value=''>Select...</option>
										<option value='1'
										<?php if ($info_nc_pr[0]['enviroment_sn']==1)echo " selected ";?>
										>SI</option>
										<option value='0'
										<?php if ($info_nc_pr[0]['enviroment_sn']!=null && $info_nc_pr[0]['enviroment_sn']==0)echo " selected ";?>
										>NO</option>
									</select>
									
								</td>
							</tr>								

						</tbody>
					</table>
			</div>


		</div>
		
		<?php 
			include("view_allegati.php");
			echo "<hr>";
		?>

				

				<button type="button" name='btn_allegati' id='btn_allegati' class="btn btn-info" data-target="#win_dialog" data-toggle="modal" onclick='set_sezione(1)' ><i class="fas fa-paperclip"></i> Definisci allegati</button>
				
				<button onclick="$('#accordion1').val('1')" type="submit" name='btn_ins_nc_pr' id='btn_ins_nc_pr' class="btn btn-primary ml-3"><i class="fas fa-save"></i> Salva Analisi Valutazione</button>

				<a href='javascript:void(0)' onclick='location.reload()'>
					<button type="button" style='display:none' id='btn_refr' class="btn btn-warning ml-4"><i class="fas fa-sync"></i> Refresh </button>
				</a>	
		

		
		<hr>
		<?php
			$dis="";$out="primary";
			
			if ($check_sign==false) {
				$dis="disabled";$out="outline-secondary";
			}
			if ($info_nc_pr[0]['firma_valutazione1']!=0) {
				$dis="disabled";$out="success";
			}
		?>
	</div>
	
	
	<div class="row mt-4 mb-4">
		<div class="col-md-2">
			<div class="form-floating mb-3 mb-md-0">
				<input class="form-control" id="data_valutazione1_nc" name='data_valutazione1_nc' type="date" <?php echo $dis; ?> value="<?php echo $info_nc_pr[0]['data_valutazione1_nc'];?>" />
				<label for="data_nc">Data</label>
			</div>
		</div>
		
		
		<div class="col-md-4">
			<button onclick='sign_valutazione(<?php echo $id_ref;?>,1)' <?php echo $dis; ?> type="button" name='btn_sign_valutazione1' id='btn_sign_valutazione1' class="btn btn-<?php echo $out;?> btn-lg m-1">
				<i class="fas fa-signature"></i> 1ª Firma per analisi/valutazione completata
			</button>
		</div>
	
	<?php

		$dis="";$out="primary";
		if ($check_sign==false) {
			$dis="disabled";$out="outline-secondary";
		}
		if ($info_nc_pr[0]['firma_valutazione2']!=0) {
			$dis="disabled";$out="success";
		}								

	?>

		<div class="col-md-2">
			<div class="form-floating mb-3 mb-md-0">
				<input class="form-control" id="data_valutazione2_nc" name='data_valutazione2_nc' type="date" <?php echo $dis; ?> value="<?php echo $info_nc_pr[0]['data_valutazione2_nc'];?>" />
				<label for="data_nc">Data</label>
			</div>
		</div>
		<div class="col-md-4">
			<button onclick='sign_valutazione(<?php echo $id_ref;?>,2)' <?php echo $dis; ?> type="button" name='btn_sign_valutazione2' id='btn_sign_valutazione2' class="btn btn-<?php echo $out;?> btn-lg m-1">
				<i class="fas fa-signature"></i> 2ª Firma per analisi/valutazione completata
			</button>
		</div>
	</div>
	
</div>
<!-- contenitore principale della valutazione che sarà inibito dopo la firma mediante JS !-->
<?php

?>
<div class="card-body">
	<div class="valutazione">
		<div class="row mt-3">
			<div class="col-md-4">
				  <div class="form-floating mb-3 mb-md-0">
					
					<select class="form-select" id="nc_rilevata" aria-label="NC Rilevata" name='nc_rilevata' required>
						<option value=''>Select...</option>
						<option value='1'
						<?php if ($info_nc_mt[0]['nc_rilevata']==1) echo " selected "; ?>
						>Prima della consegna del prodotto al cliente</option>
						<option value='2'
						<?php if ($info_nc_mt[0]['nc_rilevata']==2) echo " selected "; ?>
						>Dopo la consegna del prodotto al cliente</option>
					</select>
					<!-- da collegare al codice !-->
					<label for="nc_rilevata">Non conformità rilevata</label>
					</div>
			</div>

			<div class="col-md-4">
				  <div class="form-floating mb-3 mb-md-0">
					<select class="form-select" id="invio_reclamo_fornitore" aria-label="Invio reclamo" name='invio_reclamo_fornitore' onchange="set_reclamo(this.value)" required>
						<option value=''>Select...</option>
						
						<?php
							echo "<option value='1' ";
							if ($info_nc_mt[0]['invio_reclamo_fornitore']==1) echo " selected ";
							echo ">SI</option>";
							echo "<option value='2' ";
							if ($info_nc_mt[0]['invio_reclamo_fornitore']==2) echo " selected ";
							echo ">NO</option>";
						?>
					</select>
					<!-- da collegare al codice !-->
					<label for="invio_reclamo_fornitore">Invio reclamo al fornitore</label>
					</div>
			</div>	
			
			<?php
				$vis_ref="display:none";
				if (strlen(($info_nc_mt[0]['ref_prot_reclamo']))!=0) $vis_ref="";
			?>
			
			<div class="col-md-4" id='div_ref_prot' style="<?php echo $vis_ref; ?>">
				  <div class="form-floating mb-3 mb-md-0">
					<input class="form-control" id='ref_prot_reclamo' name='ref_prot_reclamo' type="text" value="<?php echo stripslashes($info_nc_mt[0]['ref_prot_reclamo']);?>" placeholder="Ref." maxlength=50 />
					<!-- da collegare al codice !-->
					<label for="ref_prot_reclamo">Riferimento Protocollo Reclamo</label>
				 </div>
			</div>	
			



		</div>
		
		<hr>
		<?php
			$dis="";$out="primary";
			if ($check_sign_valutazione==false) {
				$dis="disabled";$out="outline-secondary";
			}
			if ($info_nc_mt[0]['firma_valutazione']!=0) {
				$dis="disabled";$out="success";
			}
		?>

	
	<div class="row mt-4 mb-4">
		<div class="col-md-2">
			<div class="form-floating mb-3 mb-md-0">
				<input class="form-control" id="data_valutazione" name='data_valutazione' type="date" <?php echo $dis; ?> value="<?php echo $info_nc_mt[0]['data_valutazione'];?>" required />
				<label for="data_valutazione">Data</label>
			</div>
		</div>
		
		
		<div class="col-md-4">
			<button  <?php echo $dis; ?> type="submit" name='submit_sign_valutazione' id='submit_sign_valutazione' class="btn btn-<?php echo $out;?> btn-lg m-1">
				<i class="fas fa-signature"></i> Firma per analisi/valutazione completata
			</button>
		</div>


	</div>
	</div>
	

	
</div>
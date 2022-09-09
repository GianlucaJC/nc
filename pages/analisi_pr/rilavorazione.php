
<?php 
	$view_ril="display:none";
	if ($info_nc_pr[0]['attivita']==2) $view_ril="";
?>
<div id="div_rilavorazione" style='<?php echo $view_ril;?>'>
	<hr>
	<div style='background-color:gray;padding:2px'>
		<font color='white'>Identificazione del prodotto non conforme</font>
	</div>	
	<div class='row mt-3'>
		<div class="col-md-1">
		  Codice
		</div>								
		<div class="col-md-3">
			<input class="form-control" id='codice' name='codice' type="text" value="<?php echo $info_nc_pr[0]['codice'];?>" readonly  />
		</div>								

		<div class="col-md-1">
		  Descrizione
		</div>								
		<div class="col-md-3">
			<input class="form-control" id='descrizione' name='descrizione' type="text" value="<?php echo $info_nc_pr[0]['descrizione'];?>" readonly  />
		</div>								

		<div class="col-md-1">
		  Lotto
		</div>								
		<div class="col-md-3">
			<input class="form-control" id='lotto' name='lotto' type="text" value="<?php echo  $info_nc_pr[0]['lotto'];?>" readonly  />
		</div>								
	</div>
	<div class='row mt-3'>
		<div class="col-md-1">
		  Nuovo Lotto
		</div>								
		<div class="col-md-3">
			<input class="form-control" id='new_lotto' name='new_lotto' type="text" placeholder="Nuovo Lotto" value="<?php echo $info_nc_pr[0]['new_lotto'];?>"  <?php echo $dis; ?> />
		</div>								

		<div class="col-md-1">
		  Scadenza
		</div>								
		<div class="col-md-3">
			<input class="form-control" id='scadenza' name='scadenza' type="date" value="<?php echo  $info_nc_pr[0]['scadenza'];?>"  placeholder="scadenza" <?php echo $dis; ?>/>
		</div>								
	</div>
	
	<div style='background-color:gray;padding:2px' class='mt-3'>
		<font color='white'>Attività da svolgere sul prodotto</font>
	</div>		

	<div class='row mt-3'>
		<div class="col-md-12">
			Descrizione
			<textarea class="form-control obbl" id="attivita_sul_prodotto" name="attivita_sul_prodotto" rows="2" placeholder='Descrizione' <?php echo $dis; ?>><?php echo stripslashes(htmlspecialchars_decode($info_nc_pr[0]['attivita_sul_prodotto']));?></textarea>
		</div>
	</div>	
	
	
	<div style='background-color:gray;padding:2px' class='mt-3'>
		<font color='white'>Valutazione dell'impatto della rilavorazione sul prodotto</font>
	</div>		

	<div class='row mt-3'>
		<div class="col-md-12">
			Effetti avversi della rilavorazione sul prodotto
			<textarea class="form-control obbl" id="effetti_avversi" name="effetti_avversi" rows="2" placeholder='Descrizione' <?php echo $dis; ?>><?php echo stripslashes(htmlspecialchars_decode($info_nc_pr[0]['effetti_avversi']));?></textarea>
		</div>

		<div class="col-md-12">
			Attività di controllo da eseguire sul prodotto rilavorato
			<textarea class="form-control obbl" id="attivita_controllo" name="attivita_controllo" rows="2" placeholder='Descrizione' <?php echo $dis; ?>><?php echo stripslashes(htmlspecialchars_decode($info_nc_pr[0]['attivita_controllo']));?></textarea>
		</div>
	</div>	



	<div style='background-color:gray;padding:2px' class='mt-3'>
		<font color='white'>Istruzioni operative e registrazione attività</font>
	</div>		

	<div class='row mt-3'>
		<div class="col-md-12">
			Descrizione
			<textarea class="form-control obbl" id="istruzioni_operative" name="istruzioni_operative" rows="3" placeholder='Descrizione' <?php echo $dis; ?>><?php echo stripslashes(htmlspecialchars_decode($info_nc_pr[0]['istruzioni_operative']));?></textarea>
		</div>

	</div>	





	<hr>
</div>
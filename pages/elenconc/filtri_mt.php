<!--					 
ricerche per codice, lotto, segnalatore
tipologia, attrezzatura
stato di lavorazione
della NC	
!-->
<?php
	$vis="display:none";
	$vis1="display:none";
	$vis2="display:none";
	$vis3="display:none";
	$vis4="display:none";
	$vis5="display:none";
	$vis6="display:none";
	$vis7="display:none";
	$vis8="display:none";
	$vis9="display:none";
	$vis10="display:none";
	
	
	if (isset($_POST['btn_cerca'])) $vis="display:block";
	if (isset($_POST['str_cerca']) && ($tipo_filtro=="1" || $tipo_filtro=="2")) $vis1="display:block";
	if (isset($_POST['filtro_reclamo_fornitore']) && $tipo_filtro=="3") $vis3="display:block";
	if (isset($_POST['filtro_tipologia']) && $tipo_filtro=="4") $vis4="display:block";
	if (isset($_POST['filtro_fornitore']) && $tipo_filtro=="5") $vis5="display:block";
	if (isset($_POST['filtro_stato']) && $tipo_filtro=="6") $vis6="display:block";
	if (isset($_POST['filtro_attivita']) && $tipo_filtro=="10") $vis10="display:block";
	
	
?>	
	<form action="lista_mt.php" method="post" id='frm_view' name='frm_view'>  
	 <div id='div_filtri' style='<?php echo $vis;?>;clear:right' class='mt-2 mb-2'>
		<div class='row'>
			<div class='col-sm-6'>
				<label for="tipo_filtro">Tipo filtro</label>
				<select class='form-control mb-2' aria-label='Select tipo filtro' onchange="set_cerca(this.value)" name='tipo_filtro' id='tipo_filtro' required>
					<option value=''>Select...</option>
					<option value=1
					<?php if ($tipo_filtro=="1") echo " selected ";?>
					>Codice</option>
					<option value=2
					<?php if ($tipo_filtro=="2") echo " selected ";?>
					>Lotto</option>
					<option value=3
					<?php if ($tipo_filtro=="3") echo " selected ";?>
					>Invio reclamo a fornitore</option>
					<option value=4
					<?php if ($tipo_filtro=="4") echo " selected ";?>
					>Tipologia NC</option>
					<option value=5
					<?php if ($tipo_filtro=="5") echo " selected ";?>
					>Fornitore</option>
					<option value=6
					<?php if ($tipo_filtro=="6") echo " selected ";?>
					>Stato lavorazione NC</option>
					<option value=10
					<?php if ($tipo_filtro=="10") echo " selected ";?>
					>Attività</option>
				</select>
			</div>
			
			<div class='col-sm-6 filtri' id='div_str_cerca' style='<?php echo $vis1;?>'>
				<label for="str_cerca">Dato da cercare</label>
				<input class="form-control" id="str_cerca" name='str_cerca' type="text" maxlength=60 onkeyup="this.value = this.value.toUpperCase();" value="<?php echo $str_cerca; ?>" />							
			</div>
			
			<div class='col-sm-6 filtri' id='div_filtro_reclamo_fornitore' style='<?php echo $vis3;?>'>
				<!-- contenuto della sezione !-->
				
			  <div class="form-floating mb-3 mb-md-0">
				<label for="filtro_reclamo_fornitore">Invio Reclamo Fornitore</label>
				<select class="form-control mb-2" id="filtro_reclamo_fornitore" aria-label="Filtro Reclamo fornitore" name='filtro_reclamo_fornitore'>
					<option value=''>Select...</option>
					<option value='1'
					<?php if ($filtro_reclamo_fornitore==1) echo " selected "; ?>
					>SI</option>
					<option value='2'
					<?php if ($filtro_reclamo_fornitore==2) echo " selected "; ?>
					>NO</option>
				</select>
				<!-- da collegare al codice !-->
				
				</div>
			
			</div>				


			
			<div class='col-sm-6 filtri' id='div_stato_lavorazione' style='<?php echo $vis6;?>'>
				<label for="filtro_stato">Stato lavorazione</label>
				<select class='form-control mb-2' aria-label='Select stato' onchange="" name='filtro_stato' id='filtro_stato'>
					<option value=''>Select...</option>
					<option value='0'
					<?php if ($filtro_stato=="0") echo " selected ";?>
					>Nuova</option>
					<option value='1'
					<?php if ($filtro_stato=="1") echo " selected ";?>
					>Visionata</option>
					<option value='2'
					<?php if ($filtro_stato=="2") echo " selected ";?>
					>In lavorazione</option>
					<option value='3'
					<?php if ($filtro_stato=="3") echo " selected ";?>
					>Conclusa</option>
				</select>
				
			</div>			
			
			<div class='col-sm-6 filtri' id='div_filtro_tipologia' style='<?php echo $vis4;?>'>
				<label for="filtro_tipologia">Tipologia NC</label>
				<select class='form-control mb-2' aria-label='Select Tipologia NC' onchange="" name='filtro_tipologia' id='filtro_tipologia'>
					<option value=''>Select...</option>
				<?php
					
					for ($sca=0;$sca<=count($tipologia_nc)-1;$sca++) {
						$id_tipo=$tipologia_nc[$sca]['id'];
						$descr_tipo=$tipologia_nc[$sca]['descrizione'];
						echo "<option value='$id_tipo'";
						if ($id_tipo==$filtro_tipologia) echo " selected ";
						echo ">$descr_tipo</option>";
					}	
				
				?>
				</select>
		
			</div>	

			<div class='col-sm-6 filtri' id='div_filtro_fornitore' style='<?php echo $vis5;?>'>
				<label for="filtro_fornitore">Fornitore</label>
				<select class='form-control mb-2' aria-label='Select Fornitore' onchange="" name='filtro_fornitore' id='filtro_fornitore'>
					<option value=''>Select...</option>
				<?php
					
					for ($sca=0;$sca<=count($fornitori_in_nc)-1;$sca++) {
						$cod_cf=$fornitori_in_nc[$sca]['cod_cf'];
						$fornitore=$fornitori_in_nc[$sca]['fornitore'];
						echo "<option value='$cod_cf'";
						if ($cod_cf==$filtro_fornitore) echo " selected ";
						echo ">$fornitore</option>";
					}	
				
				?>
				</select>
		
			</div>				



			<div class='col-sm-6 filtri' id='div_filtro_attivita' style='<?php echo $vis10;?>'>
				<!-- contenuto della sezione !-->
				
			  <div class="form-floating mb-3 mb-md-0">
				<label for="attivita">Attività</label>
				<select class="form-control mb-2" id="filtro_attivita" aria-label="Filtro Attività" name='filtro_attivita'>
					<option value=''>Select...</option>
					<option value='1'
					<?php if ($filtro_attivita==1) echo " selected "; ?>
					>Accettare il prodotto</option>
					<option value='2'
					<?php if ($filtro_attivita==2) echo " selected "; ?>
					>Selezionare ed eliminare i pezzi non conformi</option>
					<option value='3'
					<?php if ($filtro_attivita==3) echo " selected "; ?>
					>Eliminare l'intero lotto</option>
					<option value='4'
					<?php if ($filtro_attivita==4) echo " selected "; ?>
					>Reso al fornitore</option>


				</select>
				<!-- da collegare al codice !-->
				
				</div>
			
			</div>			
						
			

			
		</div>
		<input class="btn btn-primary mt-2" type="submit" name='btn_cerca' id='btn_cerca' value="Cerca">
		<a href='lista_mt.php'>
			<input class="ml2 btn btn-secondary mt-2" type="button" name='close_filter' id='close_filter' value="Chiudi filtro">
		</a>	
		<hr>
	 </div>
</form> 
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
	
	$vis4="display:none";
	$vis5="display:none";
	$vis6="display:none";
	$vis7="display:none";
	$vis8="display:none";
	$vis9="display:none";
	$vis10="display:none";
	
	
	if (isset($_POST['btn_cerca'])) $vis="display:block";
	if (isset($_POST['str_cerca']) && ($tipo_filtro=="1" || $tipo_filtro=="2")) $vis1="display:block";
	if (isset($_POST['filtro_segnalatore']) && $tipo_filtro=="3") $vis2="display:block";
	
	if (isset($_POST['filtro_tipologia']) && $tipo_filtro=="4") $vis4="display:block";
	if (isset($_POST['filtro_attrezzatura']) && $tipo_filtro=="5") $vis5="display:block";
	
	if (isset($_POST['filtro_stato']) && $tipo_filtro=="6") $vis6="display:block";
	if (isset($_POST['filtro_reparto']) && $tipo_filtro=="7") $vis7="display:block";
	if (isset($_POST['filtro_classificazioni']) && $tipo_filtro=="8") $vis8="display:block";
	if (isset($_POST['filtro_tipo_prodotti']) && $tipo_filtro=="9") $vis9="display:block";
	if (isset($_POST['filtro_attivita']) && $tipo_filtro=="10") $vis10="display:block";
	
	
?>	
	<form action="lista.php" method="post" id='frm_view' name='frm_view'>  
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
					>Segnalatore</option>
					<option value=4
					<?php if ($tipo_filtro=="4") echo " selected ";?>
					>Tipologia NC</option>
					<option value=5
					<?php if ($tipo_filtro=="5") echo " selected ";?>
					>Attrezzatura</option>
					<option value=6
					<?php if ($tipo_filtro=="6") echo " selected ";?>
					>Stato lavorazione NC</option>
					<option value=7
					<?php if ($tipo_filtro=="7") echo " selected ";?>
					>Reparto in cui è avvenuta la NC</option>
					<option value=8
					<?php if ($tipo_filtro=="8") echo " selected ";?>
					>Classificazione NC</option>
					<option value=9
					<?php if ($tipo_filtro=="9") echo " selected ";?>
					>Tipologia Prodotto</option>
					<option value=10
					<?php if ($tipo_filtro=="10") echo " selected ";?>
					>Attività</option>
				</select>
			</div>
			
			<div class='col-sm-6 filtri' id='div_str_cerca' style='<?php echo $vis1;?>'>
				<label for="str_cerca">Dato da cercare</label>
				<input class="form-control" id="str_cerca" name='str_cerca' type="text" maxlength=60 onkeyup="this.value = this.value.toUpperCase();" value="<?php echo $str_cerca; ?>" />							
			</div>

			<div class='col-sm-6 filtri' id='div_filtro_segnalatore' style='<?php echo $vis2;?>'>
				<label for="filtro_segnalatore">Segnalatore</label>
				<select class='form-control mb-2' aria-label='Select segnalatore' onchange="" name='filtro_segnalatore' id='filtro_segnalatore'>
					<option value=''>Select...</option>
				<?php
					
					foreach($segnalatori_nc_pr as $id_o=>$v) {
						$op=$segnalatori_nc_pr[$id_o]['operatore'];
						$op=stripslashes($op);
						echo "<option value='$id_o'";
						if ($id_o==$filtro_segnalatore) echo " selected ";
						echo ">$op</option>";
					}	
				
				?>
				</select>
		
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
			
			<div class='col-sm-6 filtri' id='div_filtro_attrezzatura' style='<?php echo $vis5;?>'>
				<label for="filtro_attrezzatura">Attrezzatura</label>
				<select class='form-control mb-2' aria-label='Select Attrezzatura' onchange="" name='filtro_attrezzatura' id='filtro_attrezzatura'>
					<option value=''>Select...</option>
				<?php
					
					for ($sca=0;$sca<=count($attrezzature)-1;$sca++) {
						$id_a=$attrezzature[$sca]['id'];
						$attrezzatura=$attrezzature[$sca]['attrezzatura'];
						echo "<option value='$id_a'";
						if ($id_a==$filtro_attrezzatura) echo " selected ";
						echo ">$attrezzatura</option>";
					}	
				
				?>
				</select>
		
			</div>

			<div class='col-sm-6 filtri' id='div_filtro_reparto' style='<?php echo $vis7;?>'>
				<label for="filtro_reparto">Reparto</label>
				<select class='form-control mb-2' aria-label='Select Reparto' onchange="" name='filtro_reparto' id='filtro_reparto'>
					<option value=''>Select...</option>
				<?php
					
					for ($sca=0;$sca<=count($reparti_where_nc)-1;$sca++) {
						$id_r=$reparti_where_nc[$sca]['id'];
						$reparto=$reparti_where_nc[$sca]['reparto'];
						echo "<option value='$id_r'";
						if ($id_r==$filtro_reparto) echo " selected ";
						echo ">$reparto</option>";
					}	
				
				?>
				</select>
		
			</div>
			
			<div class='col-sm-6 filtri' id='div_filtro_classificazioni' style='<?php echo $vis8;?>'>
				<label for="filtro_classificazioni">Classificazioni NC</label>
				<select class='form-control mb-2' aria-label='Select Classificazione' onchange="" name='filtro_classificazioni' id='filtro_classificazioni'>
					<option value=''>Select...</option>
				<?php
					
					for ($sca=0;$sca<=count($classificazioni_in_nc)-1;$sca++) {
						$id_c=$classificazioni_in_nc[$sca]['id'];
						$descrizione=$classificazioni_in_nc[$sca]['descrizione'];
						echo "<option value='$id_c'";
						if ($id_c==$filtro_classificazioni) echo " selected ";
						echo ">$descrizione</option>";
					}	
				
				?>
				</select>
		
			</div>			

			<div class='col-sm-6 filtri' id='div_filtro_tipo_prodotto' style='<?php echo $vis9;?>'>
				<label for="filtro_tipo_prodotti">Tipo Prodotti</label>
				<select class='form-control mb-2' aria-label='Select Classificazione' onchange="" name='filtro_tipo_prodotti' id='filtro_tipo_prodotti'>
					<option value=''>Select...</option>
				<?php
					
					for ($sca=0;$sca<=count($tipo_prodotto_in_nc)-1;$sca++) {
						$id_t=$tipo_prodotto_in_nc[$sca]['id'];
						$descrizione=$tipo_prodotto_in_nc[$sca]['descrizione'];
						echo "<option value='$id_t'";
						if ($id_t==$filtro_tipo_prodotti) echo " selected ";
						echo ">$descrizione</option>";
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
					>Rilavorare il prodotto</option>
					<option value='3'
					<?php if ($filtro_attivita==3) echo " selected "; ?>
					>Selezionare ed eliminare i pezzi non conformi</option>
					<option value='4'
					<?php if ($filtro_attivita==4) echo " selected "; ?>
					>Eliminare l'intero lotto</option>


				</select>
				<!-- da collegare al codice !-->
				
				</div>
			
			</div>			
						
			

			
		</div>
		<input class="btn btn-primary mt-2" type="submit" name='btn_cerca' id='btn_cerca' value="Cerca">
		<a href='lista.php'>
			<input class="ml2 btn btn-secondary mt-2" type="button" name='close_filter' id='close_filter' value="Chiudi filtro">
		</a>	
		<hr>
	 </div>
</form> 
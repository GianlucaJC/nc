<div class="card-body">
<?php
$dis="";
if ($check_sign_ris1==false) $dis="disabled";




if ($check_sign_ris2==false) $dis="disabled";

$action="analisi_mt.php?id_ref=$id_ref";
if (($nc_access=="2" || $nc_access=="5") && $id_ref!=0) $action="no";
?>
<div class="risoluzione">

	<form action="<?php echo $action; ?>" method="post" id='frm_ris' name='frm_ris' autocomplete="off" class="needs-validation2" novalidate >
		<div class="row mt-3">
			<div class="col-md-6">
				<!-- contenuto della sezione !-->
				
			  <div class="form-floating mb-3 mb-md-0">
				
				<select class="form-select" id="attivita" aria-label="Attività" name='attivita' required <?php echo $dis; ?>>
					<option value=''>Select...</option>
					<option value='1'
					<?php if ($info_nc_mt[0]['attivita']==1) echo " selected "; ?>
					>Accettare il prodotto</option>
					<option value='2'
					<?php if ($info_nc_mt[0]['attivita']==2) echo " selected "; ?>
					>Selezionare ed eliminare i pezzi non conformi</option>
					<option value='3'
					<?php if ($info_nc_mt[0]['attivita']==3) echo " selected "; ?>
					>Eliminare l'intero lotto</option>
					<option value='4'
					<?php if ($info_nc_mt[0]['attivita']==4) echo " selected "; ?>
					>Reso al fornitore</option>


				</select>
				<!-- da collegare al codice !-->
				<label for="attivita">Attività</label>
				</div>
			
			</div>
		</div>
		
		
		<div class='row mt-3'>
			<div class="col-md-12">
			  <label for="note">Note</label>
				<?php
					$note=stripslashes($info_nc_mt[0]['note']);
					$note=htmlspecialchars_decode($note);
				?>	
				<textarea class="form-control" id="note" name="note" rows="2" required <?php echo $dis; ?>><?php echo $note; ?></textarea>
			</div>								
		</div>
		
		<?php
			$team=$info_nc_mt[0]['team'];
			$arr_team=explode(";",$team);
		?>
		<div class="row mt-3">
			<div class="col-md-12">
			  <div class="mb-3 mb-md-0">
					<label for="team">Team coinvolto nella risoluzione della NC</label>

					<select class="select2" name='team[]' id='team' data-placeholder="Selezionare uno o più persone" style="width: 100%;" required multiple <?php echo $dis; ?> >
				
					<option value=''>Select...</option>
					<?php
						for ($sca=0;$sca<=count($elenco_team)-1;$sca++) {
							$id_u=$elenco_team[$sca]['id'];
							echo "<option value=$id_u ";
							if (in_array($id_u,$arr_team)) echo " selected ";
							echo ">".stripslashes($elenco_team[$sca]['operatore'])."</option>";
						}
					?>
				</select>
				
				</div>
			
			</div>
		</div>	

		<?php
			$informazione_organizzazioni=stripslashes($info_nc_mt[0]['informazione_organizzazioni']);
			$informazione_organizzazioni=htmlspecialchars_decode($informazione_organizzazioni);
		?>	

		<div class='row mt-3'>
			<div class="col-md-12">
			  <label for="informazione_organizzazioni">Necessità di informazione o meno di tutte le organizzazioni (distributori, utilizzatori finali) coinvolte</label>								
			  <div class="mb-3 mb-md-0">

				<textarea class="form-control" id="informazione_organizzazioni" name="informazione_organizzazioni" rows="2" required <?php echo $dis; ?>><?php echo $informazione_organizzazioni; ?></textarea>				
			  </div>
			</div>								
		</div>
	<br>
	<?php
		$dis1="";$out1="primary";
		if ($check_sign_ris1==false) {$dis1="disabled";$out1="success";}

	?>
		
			<div class='row mt-3'>
				<div class="col-md-2">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="data_sezione_ris1" name='data_sezione_ris1' type="date" required value="<?php echo $info_nc_mt[0]['data_sezione_ris1'];?>" <?php echo $dis1; ?> />
						<label for="data_sezione_ris1">Data</label>
					</div>
				</div>
				<div class="col-md-6">

					<!-- vedi azione del submit in analisi_mt.js needs-validation2 !-->
					<button onclick='set_require(1)' type="submit" name='btn_sign_sezione_ris1' id='btn_sign_sezione_ris1' class="btn btn-<?php echo $out1;?> btn-lg m-1" <?php echo $dis1; ?>>
						<i class="fas fa-signature"></i> Firma
					</button>

				</div>
				
			</div>	
		
		
		
			<?php
				$dis2="";$out2="primary";
				if ($check_sign_ris2==false) {$dis2="disabled";$out2="success";}
				/*
				$vis="display:none";
				if ($info_nc_mt[0]['motivazione_azione']!=null && strlen($info_nc_mt[0]['motivazione_azione'])!=0) $vis="";
				*/
				$vis="";
			?>	
		
			<br>
			<label>Necessità di avviare un'azione correttiva</label>
			<div class='row mt-1'>
				<div class="col-md-2">	
				  <div class="mb-3 mb-md-0">
						<div class="form-floating mb-3 mb-md-0">
							<select class="form-select" name='azione_correttiva' id='azione_correttiva' data-placeholder="Azione correttiva" style="width: 100%;" required onchange='set_motivazione(this.value)' <?php echo $dis2; ?> >
							
								<option value='' 
								<?php if ($info_nc_mt[0]['azione_correttiva']==null) echo " selected "; ?>
								
								>Select...</option>
								<option value=1
								<?php if ($info_nc_mt[0]['azione_correttiva']=="1") echo " selected "; ?>
								>SI</option>
								<option value=0
								<?php if ($info_nc_mt[0]['azione_correttiva']=="0") echo " selected "; ?>
								>NO</option>
							</select>
							<label for="azione_correttiva">Azione correttiva</label>
						</div>
					
					</div>								
				</div>	
			
				<div class="col-md-2">
					<div class="form-floating mb-3 mb-md-0">
						<input class="form-control" id="data_sezione_ris2" name='data_sezione_ris2' type="date" value="<?php echo $info_nc_mt[0]['data_sezione_ris2'];?>"  <?php echo $dis2; ?> />
						<label for="data_sezione_ris2">Data</label>
					</div>
				</div>
				<div class="col-md-2">

					<button onclick='set_require(2)' type="submit" name='btn_sign_sezione_ris2' id='btn_sign_sezione_ris2' class="form-control btn btn-<?php echo $out2;?> btn-lg m-1" <?php echo $dis2; ?>>
						<i class="fas fa-signature"></i> Firma
					</button>
				</div>
			</div>	
			
			<div class='row mt-3' style='<?php echo $vis; ?>' id='div_motivazione_azione'>
				<div class="col-md-12">
				  <label for="motivazione_azione" style='font-weight:normal;'>Indicare il riferimento all'azione correttiva o la motivazione se non intrapresa</label>								
				  <div class="mb-3 mb-md-0">
					<textarea class="form-control" id="motivazione_azione" name="motivazione_azione" rows="2" <?php echo $dis2; ?>><?php echo stripslashes($info_nc_mt[0]['motivazione_azione'])?></textarea>
					
				  </div>
				</div>								
			</div>
			
		
	</form>

</div>



</div>
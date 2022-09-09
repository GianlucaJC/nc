<!-- contenitore principale della valutazione che sarà inibito dopo la firma mediante JS !-->
<div class="card-body">
	<div class="eliminazione">
		<?php
			//se $check_sign_ris1==false e $check_sign_ris2 vuol dire che sono state apposte le prime 2 firme
			//quindi la sezione "eliminazione del materiale non conforme" può essere mostrata per le firme
			$disp="display:none";$no_sign=0;
			if ($check_sign_ris1==false && $check_sign_ris2==false) {$no_sign=1;$disp="";}
			

			$sign_fl=0;
			$dis3="";$out3="primary";
			if ($check_sign_eliminazione_mv==false) {
				$dis3="disabled";$out3="success";
				$sign_fl=1;
			}	

			$dis4="";$out4="primary";
			if ($check_sign_eliminazione_mf==false) {
				$dis4="disabled";$out4="success";
				$sign_fl=1;
			}
			
			$dis5="";$out5="primary";
			if ($check_sign_eliminazione_na==false) {
				$dis5="disabled";$out5="success";
				$dis3="disabled";$out3="secondary";
				$dis4="disabled";$out4="secondary";
			}
			if ($sign_fl==1) {
				$dis5="disabled";$out5="secondary";
			}
			
			if ($no_sign==0) {
				echo "<div class='alert alert-warning' role='alert'>";
				  echo "Sezione non ancora disponibile!";
				echo "</div>";
			}
			
		?> 
			<div id='div_seconda_sezione' class='mt-3 container'  style='<?php echo $disp; ?>'>
				
		<?php 
			include("view_allegati_elimina.php");
		?>

				<?php
				if ($sign_fl==0) {?>
					<hr>
					<button type="button" name='btn_allegati_elimina' id='btn_allegati_elimina' class="btn btn-info" data-target="#win_dialog" data-toggle="modal" onclick='set_sezione(3)' ><i class="fas fa-paperclip"></i> Definisci allegati</button>
					<hr>
				<?php } ?>
				
				<a href='javascript:void(0)' onclick='location.reload()'>
					<button type="button" style='display:none' id='btn_refr_elimina' class="btn btn-warning ml-4"><i class="fas fa-sync"></i> Refresh </button>
				</a>					
				
				<form action="<?php echo $action; ?>" method="post" id='frm_ris' name='frm_ris' autocomplete="off" class="needs-validation2" novalidate >
				

					<?php
						$check="";
						if ($info_nc_mt[0]['eliminato_magazzino_virtuale']==1) $check="checked";
					?>
					<div class='row mt-2'>
						<div class="col-md-4">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="" id="eliminato_magazzino_virtuale" name="eliminato_magazzino_virtuale" <?php echo $check; ?> <?php echo $dis3; ?>>
							  <label for="eliminato_magazzino_virtuale">Eliminato da magazzino virtuale</label>								
							 </div>
						</div>
						
						<div class="col-md-2">
							<div class="form-floating mb-3 mb-md-0">
								<input class="form-control" id="data_eliminazione_mv" name='data_eliminazione_mv' type="date" value="<?php echo $info_nc_mt[0]['data_eliminazione_mv'];?>"  required  <?php echo $dis3; ?> />
								<label for="data_eliminazione_mv">Data</label>
							</div>
						</div>
						<div class="col-md-4">
							<?php
								$out2="";
							?>
							<button  type="submit" name='btn_sign_eliminazione_mv' id='btn_sign_eliminazione_mv' class="form-control btn btn-<?php echo $out3;?> btn-lg m-1"  <?php echo $dis3; ?>>
								<i class="fas fa-signature"></i> Firma
							</button>
						</div>
					</form>	
					
					
				</div>	
				
				<form action="<?php echo $action; ?>" method="post" id='frm_ris' name='frm_ris' autocomplete="off" class="needs-validation2" novalidate >
					<div class='row mt-2'>
						<?php
							$check="";
							if ($info_nc_mt[0]['eliminato_magazzino_fisico']==1) $check="checked";
						?>			
						<div class="col-md-4">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="" id="eliminato_magazzino_fisico" name="eliminato_magazzino_fisico" <?php echo $dis4; ?> <?php echo $check; ?>>
							  <label for="eliminato_magazzino_fisico">Eliminato da magazzino fisico</label>								
							 </div>
						</div>
						
						<div class="col-md-2">
							<div class="form-floating mb-3 mb-md-0">
								<input class="form-control" id="data_eliminazione_mf" name='data_eliminazione_mf' type="date" value="<?php echo $info_nc_mt[0]['data_eliminazione_mf'];?>" required  <?php echo $dis4; ?> />
								<label for="data_eliminazione_mf">Data</label>
							</div>
						</div>
						<div class="col-md-4">

							<button  type="submit" name='btn_sign_eliminazione_mf' id='btn_sign_eliminazione_mf' class="form-control btn btn-<?php echo $out4;?> btn-lg m-1" <?php echo $dis4; ?>>
								<i class="fas fa-signature"></i> Firma
							</button>
						</div>
					
					</div>		
				</form>	

				<form action="<?php echo $action; ?>" method="post" id='frm_ris' name='frm_ris' autocomplete="off" class="needs-validation2" novalidate >
					<div class='row mt-2'>
						<?php
							$check="";
							if ($info_nc_mt[0]['eliminato_na']==1) $check="checked";
						?>			
						<div class="col-md-4">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="" id="eliminato_na" name="eliminato_na" <?php echo $dis5; ?> <?php echo $check; ?> required>
							  <label for="eliminato_na">N/A</label>								
							 </div>
						</div>
						
						<div class="col-md-2">
							<div class="form-floating mb-3 mb-md-0">
								<input class="form-control" id="data_eliminazione_na" name='data_eliminazione_na' type="date" value="<?php echo $info_nc_mt[0]['data_eliminazione_na'];?>" required  <?php echo $dis5; ?> />
								<label for="data_eliminazione_na">Data</label>
							</div>
						</div>
						<div class="col-md-4">

							<button  type="submit" name='btn_sign_eliminazione_na' id='btn_sign_eliminazione_na' class="form-control btn btn-<?php echo $out5;?> btn-lg m-1" <?php echo $dis5; ?>>
								<i class="fas fa-signature"></i> Firma
							</button>
						</div>
					
					</div>		
				</form>					

				
				
			</div>
	</div>
</div>	
	
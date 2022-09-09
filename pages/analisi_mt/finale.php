<div class="card-body">
	<div class="finale">
			<?php
			 $disp_finale="display:none";$no_finale=0;
				if ($check_sign_ris1==false && $check_sign_ris2==false && ( ($check_sign_eliminazione_mv==false && $check_sign_eliminazione_mf==false) ||$check_sign_eliminazione_na==false )){
					$disp_finale="";$no_finale=1;
				}	
				
			 
				if ($no_finale==0) {
					echo "<div class='alert alert-warning' role='alert'>";
					  echo "Sezione non ancora disponibile!";
					echo "</div>";
				}

			?>

			<div id='div_sezione_finale' class='mt-3 container' style='<?php echo $disp_finale; ?>'>

				
				<?php include("view_allegati_ris.php"); ?>

				<?php
					$dis5="";$out5="primary";
					if ($check_sign_chiusura_nc==false) {$dis5="disabled";$out5="success";}
				?>
				
				<form action="<?php echo $action; ?>" method="post" id='frm_ris' name='frm_ris' autocomplete="off" class="needs-validation2" novalidate >
					<div class='row mt-2'>

						<div class="col-md-4">
							<button type="button" name='btn_allegati_ris' id='btn_allegati_ris' class="btn btn-info" data-target="#win_dialog" data-toggle="modal" onclick='set_sezione(2)' <?php echo $dis5; ?>><i class="fas fa-paperclip"></i> Definisci allegati</button>
							
							<a href='javascript:void(0)' onclick='location.reload()'>
								<button type="button" style='display:none' id='btn_refr_ris' class="btn btn-warning ml-4"><i class="fas fa-sync"></i> Refresh </button>
							</a>

						</div>

						<div class="col-md-2">
							<div class="form-floating mb-3 mb-md-0">
								<input class="form-control" id="data_chiusura_nc" name='data_chiusura_nc' type="date" value="<?php echo $info_nc_mt[0]['data_chiusura_nc'];?>" required <?php echo $dis5; ?> />
								<label for="data_chiusura_nc">Data</label>
							</div>
						</div>
						<div class="col-md-4">

							<button  type="submit" name='btn_sign_chiusura_nc' id='btn_sign_chiusura_nc' class="form-control btn btn-<?php echo $out5;?> btn-lg m-1" <?php echo $dis5; ?> >
								<i class="fas fa-signature"></i> Firma
							</button>
						</div>
						
						
					</div>
				</form>
				
			</div>
	</div>
</div>		
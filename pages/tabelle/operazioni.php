<?php
$nc_access=$_SESSION['nc_access'];
echo "<h5>Opzioni</h5>";
echo "<p>Operazioni aggiuntive</p>";
if ($nc_access=="1") {

$fx="../../preferenze.ini";
$send=1;$destinatari_lista="";
$send_mt=1;$destinatari_lista_mt="";
if (file_exists($fx)) {
	$ini_array = parse_ini_file($fx, true);
	
	if (isset($ini_array['notifica_nuova_nc']['send'])) $send=$ini_array['notifica_nuova_nc']['send'];
	if (isset($ini_array['notifica_nuova_nc']['destinatari'])) $destinatari_lista=$ini_array['notifica_nuova_nc']['destinatari'];


	if (isset($ini_array['notifica_nuova_nc_mt']['send'])) $send_mt=$ini_array['notifica_nuova_nc_mt']['send'];
	if (isset($ini_array['notifica_nuova_nc_mt']['destinatari'])) $destinatari_lista_mt=$ini_array['notifica_nuova_nc_mt']['destinatari'];
	
}		
	
	?>



	
<form action="operazioni.php" method="post" id='frm_set' name='frm_set'>
 <h5>Notifica prodotti</h5>


  <fieldset class="form-group">
    <div class="row">
      
      <div class="col-sm-12">
        <div class="form-check">
          <input class="form-check-input radio_notifica" type="radio" name="opt_notif" id="opt_notif1" value="1" <?php if ($send=="1") echo " checked "; ?>>
          <label class="form-check-label" for="opt_notif1">
            Nessuna mail di notifica
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input radio_notifica" type="radio" name="opt_notif" id="opt_notif2" value="2"  <?php if ($send=="2") echo " checked "; ?>>
          <label class="form-check-label" for="opt_notif2">
           Invia notifica alla lista
          </label>
        </div>

      </div>
    </div>
  </fieldset>
  <div class="form-group row">
    <label for="destinatari_lista" class="col-sm-12 col-form-label">Lista destinatari</label>
    <div class="col-sm-12">
		<?php 
			$dis_lista="";
			if ($send=="1") $dis_lista=" readonly ";
		?>
		<textarea class="form-control" id="destinatari_lista" name="destinatari_lista" rows="3" <?php echo $dis_lista; ?> placeholder="Separare gli indirizzi con la virgola"><?php echo $destinatari_lista; ?></textarea>      
    </div>
  </div>  

  <div class="form-group row">
    <div class="col-sm-10">
	<!-- set_notifica_nuova_nc() presenti in dist/js/pages/funzioni_comuni.js !-->
      <button type="button" onclick='set_notifica_nuova(1)' class="btn btn-primary">Salva impostazioni</button>
    </div>
  </div>
  
  
  <hr>
  
 <h5>Notifica materiali</h5>


  <fieldset class="form-group">
    <div class="row">
      
      <div class="col-sm-12">
        <div class="form-check">
          <input class="form-check-input radio_notifica_mt" type="radio" name="opt_notif_mt" id="opt_notif1_mt" value="1" <?php if ($send_mt=="1") echo " checked "; ?>>
          <label class="form-check-label" for="opt_notif1_mt">
            Nessuna mail di notifica
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input radio_notifica_mt" type="radio" name="opt_notif_mt" id="opt_notif2_mt" value="2"  <?php if ($send_mt=="2") echo " checked "; ?>>
          <label class="form-check-label" for="opt_notif2_mt">
           Invia notifica alla lista
          </label>
        </div>

      </div>
    </div>
  </fieldset>
  <div class="form-group row">
    <label for="destinatari_lista_mt" class="col-sm-12 col-form-label">Lista destinatari</label>
    <div class="col-sm-12">
		<?php 
			$dis_lista="";
			if ($send_mt=="1") $dis_lista=" readonly ";
		?>
		<textarea class="form-control" id="destinatari_lista_mt" name="destinatari_lista_mt" rows="3" <?php echo $dis_lista; ?> placeholder="Separare gli indirizzi con la virgola"><?php echo $destinatari_lista_mt; ?></textarea>      
    </div>
  </div>  

  <div class="form-group row">
    <div class="col-sm-10">
	<!-- set_notifica_nuova_nc_mt() presenti in dist/js/pages/funzioni_comuni.js !-->
      <button type="button" onclick='set_notifica_nuova(2)' class="btn btn-primary">Salva impostazioni</button>
    </div>
  </div>  
  
  
	<div id='div_spin_notif' style='display:none' class="spinner-border" role="status">
	  <span class="sr-only">Loading...</span>
	</div>  
</form>	
	
<?php } ?>
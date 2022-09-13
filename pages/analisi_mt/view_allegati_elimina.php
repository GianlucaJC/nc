	

<div id='div_allegati_presenti'>
	<?php
		$perc="allegati_elimina/$id_ref";
		$files = glob("$perc/*.{JPG,JPEG,PNG,GIF,PDF,DOC,DOCX,ODT,jpg,jpeg,png,gif,pdf,doc,docx,odt}", GLOB_BRACE);
		
			$fotoref=0;
			foreach($files as $file) {
				if ($fotoref==0 || $fotoref/6==intval($fotoref/6)) {
					if ($fotoref!=0) echo "</div>";
					echo "<div class='row mb-3'>";
				}	
				echo "<div class='col-md-2' id='foto_$fotoref'>";
					
					if ($info_nc_mt[0]['sign_eliminazione_mv']==0 || $info_nc_mt[0]['sign_eliminazione_mf']==0) {
						
						echo "<a href='javascript:void(0)' onclick=\"delete_foto('$file',$fotoref)\">";
							echo "<font color='red'><i class='fas fa-trash-alt'></i></font>";
						echo "</a>";
					}
					echo "<a href='$file' target='_blank'>";
						echo "<button type='button' class='btn btn-info ml-2'>";
							echo "Allegato ".($fotoref+1);
						echo "</button>";	
					echo "</a>";
				echo "</div>";
				$fotoref++;
			}
			if ($fotoref>0) echo "</div>"; //ultimo div impaginazione
		
		
	?>
</div>
<div id='div_sezione3' class='allegati'>
	<?php 
		//include ("class_allegati.php"); 
	?>
</div>


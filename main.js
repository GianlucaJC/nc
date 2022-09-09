function set_range() {
	$('.tipo_stat').val(6)
	$("#div_range").toggle(150);
}

function get_class(riga,id_tipo,periodo) {
	if (typeof get_class.num_nc_mese === 'undefined') num_nc_mese=0
	else num_nc_mese=get_class.num_nc_mese
	if (typeof get_class.num_lotti === 'undefined') num_lotti=0
	else num_lotti=get_class.num_lotti


	
	if($("#newr"+riga).is(":visible")){
		$("#newr"+riga).remove();
		return false;
	}
	$("#newr"+riga).remove();
	$("#spin"+riga).show(100)
	
	setTimeout(function(){
		
		fetch('index.php', {
			method: 'post',
			//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
			headers: {
			  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
			},
			body: 'operazione=classificazioni_from_tipologia&id_tipo='+id_tipo+'&periodo='+periodo
		})
		.then(response => {
			if (response.ok) {
			   return response.json();
			}
		})
		.then(resp=>{
			
			$("#spin"+riga).hide(100)
			console.log(resp);
			html="";
			
			if (resp.info_class.length>0) {
				html+="<tr id='newr"+riga+"'>";
					html+="<th colspan=4>";
						html+="<table class='table table-striped table-valign-middle'>";
							html+="<tr>";
								html+="<th>Classificazione</th>";
								html+="<th>Accettare il prodotto</th>";
								html+="<th>Rilavorare il prodotto</th>";
								html+="<th>Selezionare ed eliminare i pezzi non conformi</th>";
								html+="<th>Eliminare l'intero lotto</th>";
								html+="<th>Num NC</th>";
								html+="<th>Incidenza % su NC Totali</th>";
								html+="<th>Incidenza su lotti prodotti</th>";
							html+="</tr>";
						for (sca=0;sca<=resp.info_class.length-1;sca++) {
							html+="<tr>";
								html+="<td>";
									html+=resp.info_class[sca].descrizione
								html+="</td>";
								
								html+="<td>";								
									html+=resp.info_class[sca].att1
								html+="</td>";

								html+="<td>";								
									html+=resp.info_class[sca].att2
								html+="</td>";

								html+="<td>";								
									html+=resp.info_class[sca].att3
								html+="</td>";

								html+="<td>";						
									html+=resp.info_class[sca].att4
								html+="</td>";
								
								q=resp.info_class[sca].q
								html+="<td>";
									html+="<a href='pages/elenconc/lista.php?nc="+resp.info_class[sca].id_ref_nc+"'  target='_blank'>";
										html+=q;
									html+="</a>";
								html+="</td>";
								html+="<td>";
									inc_tipo_mese="";
									if (parseFloat(num_nc_mese)!=0) {
										inc_tipo_mese=(100/num_nc_mese)*q
										inc_tipo_mese=inc_tipo_mese.toFixed(2);
										inc_tipo_mese=inc_tipo_mese+"%";
									}
									html+=inc_tipo_mese
								html+="</td>";
								html+="<td>";
									inc_lotti="";
									if (parseFloat(num_lotti)!=0) {
										inc_lotti=(100/num_lotti)*q
										inc_lotti=inc_lotti.toFixed(2);
										inc_lotti=inc_lotti+"%";
									}
									html+=inc_lotti
								html+="</td>";

								
							html+="</tr>";
						}
						html+="</table>";
						html+="</th>";
				html+="</tr>";
			}
			
			//$('#tb_stat tbody>tr:last').after(html);
			$("#riga"+riga).after(html);
			
	
		})
		.catch(status, err => {
			return console.log(status, err);
		})	
	
	
	},1000);		

	
}

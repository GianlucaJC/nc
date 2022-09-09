$(function(){
	  buttons=[
		{
			extend: 'copyHtml5',
			/*
			exportOptions: {
				columns: [ 0, ':visible' ]
			}
			*/
		},
		{
			extend: 'csvHtml5'
		},
		{
			extend: 'excelHtml5',
			/*
			exportOptions: {
				columns: [ 0, 1, 2, 5 ]
			}
			*/
		},
		{
			extend: 'pdfHtml5'
		}

		]	

	$("#tb_nc").DataTable({
		//"responsive": true, 
        dom: 'Bfrtip',
		buttons:buttons,
		
		
		
		
		"lengthChange": false, "autoWidth": false,
		"pageLength": 10,
		//, "colvis"
		
		"language": {
			"lengthMenu": "Mostra _MENU_ NC per pagina &nbsp&nbsp",
			"zeroRecords": "Non ci sono NC",
			"info": "Pagina mostrata _PAGE_ di _PAGES_ di _TOTAL_ NC",
			"infoEmpty": "Non risultano NC",
			"infoFiltered": "(filtrati da _MAX_ record totali)",
			"search":         "Cerca:",
			"paginate": {
				"first":      "Prima",
				"last":       "Ultima",
				"next":       "Successiva",
				"previous":   "Precedente"
			}
		
		}


		
	}).buttons().container().appendTo('#tb_nc_wrapper .col-md-6:eq(0)');	
})	


function prepara_pdf(id_ref) {
	fetch('ajax.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=prepara_pdf&id_ref='+id_ref
	})
	.then(response => {
		if (response.ok) {
		   return response.json();
		}
	})
	.then(resp=>{
		console.log(resp)
		var anchor = document.createElement('a');
		anchor.href = "rapporti/"+id_ref+".pdf";
		anchor.target="_blank";
		anchor.click();		
		
		/*
		if (resp[0].denominazione) {
		}
		*/
			
	})
	.catch(status, err => {
		return console.log(status, err);
	})		
}

function pdf_lista() {
	data1=$("#data1").val()
	data2=$("#data2").val()
	if (data1.length==0 || data2.length==0) {
		alert("Controllare il range di date impostato!");
		return false;
	}
	
	fetch('ajax.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=pdf_lista_pr&data1='+data1+'&data2='+data2
	})
	.then(response => {
		if (response.ok) {
		   return response.json();
		}
	})
	.then(resp=>{
		console.log(resp)
		var anchor = document.createElement('a');
		anchor.href = "rapporti/lista.pdf";
		anchor.target="_blank";
		anchor.click();		
		
		/*
		if (resp[0].denominazione) {
		}
		*/
			
	})
	.catch(status, err => {
		return console.log(status, err);
	})		
}

function set_cerca(value) {
	$(".filtri").hide(150);
	$("#str_cerca").val('');
	$("#str_cerca").prop("required",false);
	if (value=="1") {
		$("#str_cerca").attr("placeholder", "Codice");
		$("#str_cerca").prop("required",true);
		$("#div_str_cerca").show(150);
	}
	if (value=="2") {
		$("#str_cerca").attr("placeholder", "Lotto");
		$("#str_cerca").prop("required",true);
		$("#div_str_cerca").show(150);
	}	
	if (value=="3") {
		$("#div_filtro_segnalatore").show(150);
	}
	if (value=="4") {
		$("#div_filtro_tipologia").show(150);
	}
	if (value=="5") {
		$("#div_filtro_attrezzatura").show(150);
	}	
	if (value=="6") {
		$("#div_stato_lavorazione").show(150);
	}
	if (value=="7") {
		$("#div_filtro_reparto").show(150);
	}
	if (value=="8") {
		$("#div_filtro_classificazioni").show(150);
	}
	if (value=="9") {
		$("#div_filtro_tipo_prodotto").show(150);
	}
	if (value=="10") {
		$("#div_filtro_attivita").show(150);
	}
	

	
}

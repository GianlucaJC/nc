(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
		  event.preventDefault();
		  event.stopPropagation();

		  var html;
	   	  html="<p><b>Attenzione</b><br>Per poter avanzare è necessario controllare tutti i campi evidenziati in rosso</p>";
		  $("#body_dialog").html(html)
		  $('#win_dialog').modal('show')
		  
        } else {
			return true;
		}
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
  
  
  window.addEventListener('load', function() {

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation2');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
		  event.preventDefault();
		  event.stopPropagation();
		  
		  
        } else {
			return true;
		}
        form.classList.add('was-validated');
      }, false);
    });
  }, false);


})();


$(function(){
		
	//Initialize Select2 Elements
	$('.select2bs4').select2({
	  theme: 'bootstrap4'
	})  
	sel=$("#team").select2({
	  tags: true
	});
	check_sign_valutazione=$("#check_sign_valutazione").val();
	
	
	if ((check_sign_valutazione && check_sign_valutazione!="0") )
		$(".valutazione").find('select,input,textarea,button').attr("disabled","disabled");	
	

	id_ref=$("#id_ref").val()
	nc_access=$("#nc_access").val()

	if ((nc_access=="2" || nc_access=="5") && id_ref!="0") {
		$(".valutazione").find('select,input,textarea,button').attr("disabled","disabled");
		$(".risoluzione").find('select,input,textarea,button').attr("disabled","disabled");
		$(".eliminazione").find('select,input,textarea,button').attr("disabled","disabled");
		$(".finale").find('select,input,textarea,button').attr("disabled","disabled");
		$("#a_class").hide();
		
	}	

	if (nc_access=="4" && id_ref!="0") {
		$(".valutazione").find('select,input,textarea,button').attr("disabled","disabled");
		$(".risoluzione").find('select,input,textarea,button').attr("disabled","disabled");
		$("#a_class").hide();
		$(".finale").find('select,input,textarea,button').attr("disabled","disabled");
	}


	/*
	if (check_sign_valutazione1 && check_sign_valutazione1=="0") {
		$("#data_valutazione1_nc").attr("disabled",false);
		$("#btn_sign_valutazione1").attr("disabled",false);
	}
	if (check_sign_valutazione2 && check_sign_valutazione2=="0") {
		$("#data_valutazione2_nc").attr("disabled",false);
		$("#btn_sign_valutazione2").attr("disabled",false);
	}
	*/
		
	
	
})	


function set_reclamo(value) {
	$("#div_ref_prot").hide();
	if (value=="1") {
		$("#ref_prot_reclamo").prop("required",true);
		$("#div_ref_prot").show();	
	}
	if (value=="2") {
		$("#ref_prot_reclamo").removeAttr("required");
		$("#div_ref_prot").hide();
	}
}


function set_require(value) {
	if (value=="1") {
		$("#azione_correttiva").removeAttr("required");
		$('#motivazione_azione').removeAttr('required');
		$("#data_sezione_ris1").prop("required",true);
		$('#data_sezione_ris2').removeAttr('required');
	}
	if (value=="2") {
		$("#azione_correttiva").prop("required",true);
		$('#data_sezione_ris1').removeAttr('required');
		$("#data_sezione_ris2").prop("required",true);
		
		//$('#motivazione_azione').attr('required');
	}
}


function open_allegati() {
	$('#sez_allegati').toggle()
	$('html, body').animate({
		scrollTop: $("#sez_allegati").offset().top-150
	}, 1500);	
}

function delete_foto(foto,fotoref) {
	if (!confirm("Sicuri di cancellare l'allegato?")) return false;
	html="<span role='status' aria-hidden='true' class='spinner-border spinner-border-sm'></span> Attendere...";
	$("#foto_"+fotoref).html(html);
	setTimeout(function(){
	
		fetch('ajax.php', {
			method: 'post',
			//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
			headers: {
			  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
			},
			body: 'operazione=delete_foto&foto='+foto
		})
		.then(response => {
			if (response.ok) {
			   return response.json();
			}
		})
		.then(resp=>{
			if (resp.status=="KO") {
				alert("Problemi occorsi durante il salvataggio.\n\nDettagli:\n"+resp.error);
				return false;
			}
			$("#foto_"+fotoref).remove();
		})
		.catch(status, err => {
			return console.log(status, err);
		})	
	
	
	},1000);	
}

function refresh_tipo() {
	$("#classificazione_nc").empty();
	fetch('ajax.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=refresh_tipo'
	})
	.then(response => {
		if (response.ok) {
		   return response.json();
		}
	})
	.then(resp=>{
		
		html="";
		html+="<option value='' selected='selected'>Select...</option>";
		for (sca=0;sca<=resp.length-1;sca++) {
			id=resp[sca].id
			descrizione=resp[sca].descrizione
			html+="<option value='"+id+"'>"+resp[sca].descrizione+"</option>";
		}
		$('#classificazione_nc').append(html);
		$('#up_tipo').hide();
		
	})
	.catch(status, err => {
		$('#up_tipo').hide();
		return console.log(status, err);
	})	
}

function set_motivazione(value) {

	$('#motivazione_azione').removeAttr('required');

	//$("#div_motivazione_azione").hide();	
	if (value=="0") {
		//$("#div_motivazione_azione").show(200);
		$('#motivazione_azione').attr('required', true);
	}	
}

function set_sezione(sezione) {
	$(".allegati").empty();
	fetch('class_allegati.php', {
		method: 'post',
		//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
		headers: {
		  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
		},
		body: 'operazione=refresh_tipo'
	})
	.then(response => {
		if (response.ok) {
		   return response.text();
		}
		
	})
	.then(resp=>{
		//$("#div_sezione"+sezione).html(resp);
		
		$("#body_dialog").html(resp);
		set_class_allegati(sezione); //in demo-config.js
	})
	.catch(status, err => {
		
		return console.log(status, err);
	})
}




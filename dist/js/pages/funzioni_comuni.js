$(function () {

	$(".radio_notifica").on('change', function() {
		value=$("input[name='opt_notif']:checked").val();
		$("#destinatari_lista").prop("readonly", false);
		if (value=="1") $("#destinatari_lista").prop("readonly", true);
		
	})
})

function set_notifica_nuova(from) {
	$("#div_spin_notif").show();
	setTimeout(function(){
		if (from==1) {
			opt_notif=$("input[name='opt_notif']:checked").val();
			destinatari_lista=$("#destinatari_lista").val();
		}
		if (from==2) {
			opt_notif=$("input[name='opt_notif_mt']:checked").val();
			destinatari_lista=$("#destinatari_lista_mt").val();
		}
		
		
		fetch('../tabelle/ajax.php', {
			method: 'post',
			//cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached		
			headers: {
			  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
			},
			body: 'operazione=set_notifica&from='+from+'&opt_notif='+opt_notif+'&destinatari_lista='+destinatari_lista
		})
		.then(response => {
			if (response.ok) {
			   return response.json();
			}
		})
		.then(resp=>{
			$("#div_spin_notif").hide();
			if (resp.status=="KO") {
				alert("Problemi occorsi durante il salvataggio.\n\nDettagli:\n"+resp.error);
				return false;
			}

			$('.control-sidebar').ControlSidebar('toggle');
		})
		.catch(status, err => {
			return console.log(status, err);
		})	


	},1000);
}

	
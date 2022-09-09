$(function(){
 //set_class_allegati(0)
 num_upload=0;
});


function set_class_allegati(sezione) {
  /*
   * For the sake keeping the code clean and the examples simple this file
   * contains only the plugin configuration & callbacks.
   * 
   * UI functions ui_* can be located in: demo-ui.js
   */
  	
  id_ref=$("#id_ref_temp").val(); 
  
  
  $('#drag-and-drop-zone').dmUploader({ //
    url: 'upload.php',
	extraData: {
      "id_ref": id_ref,
	  "sezione":sezione
	},
	
	extFilter: ["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx"],
	
    maxFileSize: 8000000, // 8 Megs 
    onDragEnter: function(){
      // Happens when dragging something over the DnD area
      this.addClass('active');
    },
    onDragLeave: function(){
      // Happens when dragging something OUT of the DnD area
      this.removeClass('active');
    },
    onInit: function(){
      // Plugin is ready to use
      ui_add_log('Plugin Avviato :)', 'info');
    },
    onComplete: function(){
      // All files in the queue are processed (success or error)
      ui_add_log('Tutti i trasferimenti in sospeso sono terminati');
    },
    onNewFile: function(id, file){
      // When a new file is added using the file selector or the DnD area
      ui_add_log('Nuovo file aggiunto #' + id);
      ui_multi_add_file(id, file);
    },
    onBeforeUpload: function(id){
	  $("#div_img").empty();
      // about tho start uploading a file
      ui_add_log('Inizio upload di #' + id);
      ui_multi_update_file_status(id, 'uploading', 'Uploading...');
      ui_multi_update_file_progress(id, 0, '', true);
    },
    onUploadCanceled: function(id) {
      // Happens when a file is directly canceled by the user.
      ui_multi_update_file_status(id, 'warning', 'Cancellato da utente');
      ui_multi_update_file_progress(id, 0, 'warning', false);
    },
    onUploadProgress: function(id, percent){
      // Updating file progress
      ui_multi_update_file_progress(id, percent);
    },
    onUploadSuccess: function(id, data){
      // A file was successfully uploaded
	  
	  fx=data.path
	  
	  dx=JSON.stringify(data)
	  console.log(dx)
	  
      ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
      ui_add_log('Upload del file #' + id + ' COMPLETATO', 'success');
      ui_multi_update_file_status(id, 'success', 'Upload Completato');
      ui_multi_update_file_progress(id, 100, 'success', false);
	  html="";
	  num_upload++;
      html+="<div class='col-md-2' id='foto_"+num_upload+"'>";

			html+= "<a href='javascript:void(0)' onclick=\"delete_foto('"+fx+"',"+num_upload+")\">";
				html+= "<font color='red'><i class='fas fa-trash-alt'></i></font>";
			html+= "</a>";

			html+= "<a href='"+fx+"' target='_blank'>";
				html+= "<button type='button' class='btn btn-info ml-2'>";
					html+= "Allegato "+num_upload;
				html+= "</button>";	
			html+= "</a>";	  


	  html+="</div>";
		
	  //html+="</div>";
	  $("#div_allegati").append(html)
	  
    },
    onUploadError: function(id, xhr, status, message){
      ui_multi_update_file_status(id, 'danger', message);
      ui_multi_update_file_progress(id, 0, 'danger', false);  
    },
    onFallbackMode: function(){
      // When the browser doesn't support this plugin :(
      ui_add_log('Il plug-in non può essere utilizzato qui', 'danger');
    },
    onFileSizeError: function(file){
      ui_add_log('Il File \'' + file.name + '\' Non può essere aggiunto: Limite dimensione superato', 'danger');
    }
  });	
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
			$("#foto_"+fotoref).remove()
		})
		.catch(status, err => {
			return console.log(status, err);
		})	
	
	
	},1000);	
}
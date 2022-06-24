$(document).ready(function() {
   // On page load > documents
	var xin_table_document = $('#xin_table_document').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"documents/official_documents_list",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	/* Add data */ /*Form Submit*/
	$("#add_official_document").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'add_record');
		fd.append("form", action);
		var dep_id = $('#depval').val();
		e.preventDefault();		
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					xin_table_document.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('#add_official_document')[0].reset(); // To reset form fields
					$('.add-form').removeClass('show');
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
			} 	        
	   });
	});
	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&type=delete_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					$('.delete-modal').modal('toggle');
					xin_table_document.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);		
					$('input[name="csrf_token"]').val(JSON.csrf_hash);	
					Ladda.stopAll();				
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var modal = $(this);
	$.ajax({
		url : main_url+"documents/read_official_document",
		type: "GET",
		data: 'jd=1&data=official_document&field_id='+field_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});	
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',main_url+'documents/delete_official_document');
});
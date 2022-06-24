$(document).ready(function() {
	$('.mail-stars').on("click", function() {
		var field_id = $(this).data('field-id');
		var star_val = $(this).data('star-val');
		$.ajax({
			url : main_url+"mailbox/update_starmail_record",
			type: "GET",
			data: 'jd=1&data=mailbox&field_id='+field_id+'&star_val='+star_val,
			success: function (response) {
				if(response) {
					toastr.success('Mail updated.');
					window.location ='';
				}
			}
		});
	});
	$('.mail-delete').on("click", function() {
		var field_id = $(this).data('field-id');
		var delete_val = $(this).data('delete-val');
		$.ajax({
			url : main_url+"mailbox/update_deletemail_record",
			type: "GET",
			data: 'jd=1&data=mailbox&field_id='+field_id+'&delete_val='+delete_val,
			success: function (response) {
				if(response) {
					toastr.success('Mail updated.');
					window.location ='';
				}
			}
		});
	});
	$('.mail-important').on("click", function() {
		var field_id = $(this).data('field-id');
		var imp_val = $(this).data('imp-val');
		$.ajax({
			url : main_url+"mailbox/update_important_mail_record",
			type: "GET",
			data: 'jd=1&data=mailbox&field_id='+field_id+'&imp_val='+imp_val,
			success: function (response) {
				if(response) {
					toastr.success('Mail updated.');
					window.location ='';
				}
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
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);		
					$('input[name="csrf_token"]').val(JSON.csrf_hash);	
					Ladda.stopAll();				
				}
			}
		});
	});
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'add_record');
		fd.append("form", action);
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
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					window.location = main_url+'/my-mailbox';
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
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',main_url+'department/delete_department');
});
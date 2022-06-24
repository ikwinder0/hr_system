$(document).ready(function(){			
	/* update ticket data */
	$("#update_status").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&type=edit_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();			
				}
			}
		});
	});
	/* reply ticket */
	$("#ticket_reply").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&type=add_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					setTimeout(function(){
						window.location = '';
					}, 3000);		
				}
			}
		});
	});
	/* Add data */ /*Form Submit*/
	$("#add_attachment").submit(function(e){
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
					setTimeout(function(){
						window.location = '';
					}, 3000);	
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
	/* add ticket note */
	$("#add_note").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&type=add_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					setTimeout(function(){
						window.location = '';
					}, 3000);	
				}
			}
		});
	});
	$(".delete_note").on("click", function() {
		var field_id = $(this).data('field');
		$('#note_option_id_'+field_id).fadeOut();
		$('.note_option_id_'+field_id).fadeOut();
		$.ajax({
			url : main_url+"tickets/delete_ticket_note",
			type: "GET",
			data: 'jd=1&data=ticket_note&field_id='+field_id,
			success: function (response) {
				if(response) {
					toastr.success(response.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					setTimeout(function(){
						window.location = '';
					}, 3000);
				}
			}
		});
    });
	$(".delete_reply").on("click", function() {
		var field_id = $(this).data('field');
		$('#reply_option_id_'+field_id).fadeOut();
		$.ajax({
			url : main_url+"tickets/delete_ticket_reply",
			type: "GET",
			data: 'jd=1&data=ticket_reply&field_id='+field_id,
			success: function (response) {
				if(response) {
					toastr.success(response.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					setTimeout(function(){
						window.location = '';
					}, 3000);
				}
			}
		});
    });
	$(".delete_file").on("click", function() {
		var field_id = $(this).data('field');		
		$.ajax({
			url : main_url+"tickets/delete_ticket_file",
			type: "GET",
			data: 'jd=1&data=ticket_file&field_id='+field_id,
			success: function (response) {
				if(response) {
					$('#file_option_id_'+field_id).fadeOut();
					$('.file_option_id_'+field_id).remove();
					toastr.success(response.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					setTimeout(function(){
						window.location = '';
					}, 3000);
				}
			}
		});
    });
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
});
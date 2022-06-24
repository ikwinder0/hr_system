$(document).ready(function(){
	var xin_table = $('#xin_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : main_url+"projects/project_tasks_list?project_val="+$('#project_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	var xin_timelogs_table = $('#xin_timelogs_table').dataTable({
		"bDestroy": true,
		"ajax": {
			url : main_url+"projects/timelogs_list?project_val="+$('#project_id').val(),
			type : 'GET'
		},
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
	});
	/* add project note */
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
	/* add project discussion */
	$("#add_discussion").submit(function(e){
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
	/* add project bug */
	$("#add_bug").submit(function(e){
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
	/* update project */
	$("#update_project").submit(function(e){
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
					setTimeout(function(){
						window.location = '';
					}, 3000);			
				}
			}
		});
	});
	/* add timelogs */
	$("#add_timelogs").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=3&type=add_timelogs&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					xin_timelogs_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('#add_timelogs')[0].reset(); // To reset form fields
					Ladda.stopAll();		
				}
			}
		});
	});
	// view
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var modal = $(this);
	$.ajax({
		url : main_url+"projects/read_timelog",
		type: "GET",
		data: 'jd=1&data=timelog&field_id='+field_id,
		success: function (response) {
			if(response) {
				$("#ajax_view_modal").html(response);
			}
		}
		});
	});
	/* update project progress */
	$("#update_project_progress").submit(function(e){
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
					setTimeout(function(){
						window.location = '';
					}, 3000);		
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
	$("#add_task").submit(function(e){
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
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('#add_task')[0].reset(); // To reset form fields
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
	$(".delete_note").on("click", function() {
		var field_id = $(this).data('field');
		$('#note_option_id_'+field_id).fadeOut();
		$('.note_option_id_'+field_id).fadeOut();
		$.ajax({
			url : main_url+"projects/delete_project_note",
			type: "GET",
			data: 'jd=1&data=project_note&field_id='+field_id,
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
	$(".delete_discussion").on("click", function() {
		var field_id = $(this).data('field');
		$('#discussion_option_id_'+field_id).fadeOut();
		$('.discussion_option_id_'+field_id).fadeOut();
		$.ajax({
			url : main_url+"projects/delete_project_discussion",
			type: "GET",
			data: 'jd=1&data=project_discussion&field_id='+field_id,
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
	$(".delete_bug").on("click", function() {
		var field_id = $(this).data('field');		
		$.ajax({
			url : main_url+"projects/delete_project_bug",
			type: "GET",
			data: 'jd=1&data=project_bug&field_id='+field_id,
			success: function (response) {
				if(response) {
					$('#bug_option_id_'+field_id).fadeOut();
					$('.bug_option_id_'+field_id).remove();
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
			url : main_url+"projects/delete_project_file",
			type: "GET",
			data: 'jd=1&data=project_file&field_id='+field_id,
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
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',main_url+'tasks/delete_task');
});
$( document ).on( "click", ".delete_timelog", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',main_url+'projects/delete_timelog');
});
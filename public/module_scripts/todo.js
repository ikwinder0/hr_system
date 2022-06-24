$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"todo/todo_list",
            type : 'GET'
        },
		"language": {
            "lengthMenu": dt_lengthMenu,
            "zeroRecords": dt_zeroRecords,
            "info": dt_info,
            "infoEmpty": dt_infoEmpty,
            "infoFiltered": dt_infoFiltered,
			"search": dt_search,
			"paginate": {
				"first": dt_first,
				"previous": dt_previous,
				"next": dt_next,
				"last": dt_last
			},
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
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
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var modal = $(this);
		$.ajax({
		url : main_url+"todo/read_todo",
		type: "GET",
		data: 'jd=1&data=todo&field_id='+field_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	function delete_todo(e) {
		$('#' + e).fadeOut();
	}
	$(".delete_todolist").on("click", function() {
        $(this).parent().parent().fadeOut();
		var field_id = $(this).data('fieldid');
		$.ajax({
		url : main_url+"todo/delete_todo",
		type: "GET",
		data: 'jd=1&data=todo&field_id='+field_id,
		success: function (response) {
			if(response) {
				toastr.success('Item deleted.');
			}
		}
		});
    });
	$('.to-do-list input[type=checkbox]').on("click", function() {
		if ($(this).prop('checked')) {
			$(this).parent().addClass('done-task');
			var field_id = $(this).data('field-id');
			$.ajax({
			url : main_url+"todo/update_item",
			type: "GET",
			data: 'jd=1&data=todo&field_id='+field_id+'&task_done=1',
			success: function (response) {
				if(response) {
					toastr.success('Item updated.');
				}
			}
			});
		} else {
			$(this).parent().removeClass('done-task');
			var field_id = $(this).data('field-id');
			$.ajax({
			url : main_url+"todo/update_item",
			type: "GET",
			data: 'jd=1&data=todo&field_id='+field_id+'&task_done=0',
			success: function (response) {
				if(response) {
					toastr.success('Item updated.');
				}
			}
			});
		}
	});
	var i = 7;
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
					var task = $('.add_task_todo').val();
					toastr.success(JSON.result);
					var add_todo = $('<div class="to-do-list mb-3" id="' + i + '"><div class="d-inline-block"><label class="check-task custom-control custom-checkbox d-flex justify-content-center"><input type="checkbox" class="custom-control-input" onclick="check_task(' + i + ')" id="checkbox' + i + '"><span class="custom-control-label" for="checkbox' + i + '">' + task + '</span></label></div><div class="float-right"><a onclick="delete_todo(' + i + ');" href="#!" class="delete_todolist"><i class="far fa-trash-alt"></i></a></div></div>');
					i++;
					$(add_todo).appendTo(".new-task").hide().fadeIn(300);
					$('.add_task_todo').val('');
			
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					window.location = '';
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
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',main_url+'todo/delete_todo/'+$(this).data('record-id'));
});
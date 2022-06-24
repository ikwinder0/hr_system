$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : main_url+"timesheet/overtime_request_list",
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
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
/* Delete data */
$("#delete_record").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=true&type=delete_record&form="+action,
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

$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var modal = $(this);
	$.ajax({
		url: main_url+'timesheet/read_overtime_request',
		type: "GET",
		data: 'jd=1&is_ajax=9&mode=modal&data=add_attendance&type=add_attendance&field_id=1',
		success: function (response) {
			if(response) {
				$("#ajax_view_modal").html(response);
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
	url : main_url+"timesheet/read_overtime_request",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=edit_attendance&type=edit_attendance&field_id='+field_id,
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
$('#delete_record').attr('action',main_url+'timesheet/delete_overtime');
});

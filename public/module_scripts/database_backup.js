$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : main_url+"settings/database_backup_list",
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
		data: obj.serialize()+"&is_ajax=2&form="+action,
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

/* delete */
$("#db_backup").submit(function(e){
	
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&type=backup&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				xin_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			}
		}
	});
});

/* delete */
$("#del_backup").submit(function(e){
	
/*Form Submit*/
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&type=delete_old_backup&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				xin_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			}
		}
	});
});
});
$( document ).on( "click", ".deletedb", function() {
$('input[name=_token]').val($(this).data('record-id'));
$('#delete_record').attr('action',main_url+'settings/delete_dbsingle_backup/'+$(this).data('record-id'));
});
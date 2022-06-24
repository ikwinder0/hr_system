$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"settings/sms_template_list",
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
		"iDisplayLength": 50,
		"aLengthMenu": [[50, 60, 80, 100, -1], [50, 60, 80, 100, "All"]],
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
		
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var modal = $(this);
	$.ajax({
		url : main_url+"settings/read_sms_tempalte",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=sms_tempalte&field_id='+field_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
});

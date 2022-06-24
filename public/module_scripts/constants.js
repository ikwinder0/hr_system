$(document).ready(function() {		
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// listing
	var xin_table_payment_method = $('#xin_table_payment_method').dataTable({
		"bDestroy": true,
		//"bFilter": false,
		//"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
            url : main_url+"settings/payment_method_list",
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
	// listing
	var xin_table_currencies = $('#xin_table_currencies').dataTable({
		"bDestroy": true,
		//"bFilter": false,
		//"bLengthChange": false,
		"iDisplayLength": 25,
		"aLengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
		"ajax": {
            url : main_url+"settings/currency_list",
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
	var xin_table_religion = $('#xin_table_religion').dataTable({
		"bDestroy": true,
		//"bFilter": false,
		//"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
            url : main_url+"settings/religion_list",
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
	
	var xin_table_company_type = $('#xin_table_company_type').dataTable({
		"bDestroy": true,
		//"bFilter": false,
		//"bLengthChange": false,
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "All"]],
		"ajax": {
            url : main_url+"settings/company_type_list",
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
		
	jQuery("#payment_method_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=17&data=payment_method_info&type=payment_method_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					jQuery('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
					Ladda.stopAll();
				} else {
					xin_table_payment_method.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					jQuery('#payment_method_info')[0].reset(); // To reset form fields
					jQuery('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			}
		});
	});
	
	jQuery("#currency_type_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		$('.icon-spinner3').show();
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=currency_type_info&type=currency_type_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					xin_table_currencies.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					jQuery('#currency_type_info')[0].reset(); // To reset form fields
					Ladda.stopAll();
				}
			}
		});
	});
	
	jQuery("#company_type_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=company_type_info&type=company_type_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error,'Error');
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					xin_table_company_type.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					jQuery('#company_type_info')[0].reset(); // To reset form fields
					Ladda.stopAll();
				}
			}
		});
	});	
	jQuery("#religion_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=28&data=religion_info&type=religion_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error,'Error');
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					xin_table_religion.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					jQuery('#religion_info')[0].reset(); // To reset form fields
					Ladda.stopAll();
				}
			}
		});
	});
	/* Delete data */
	$("#delete_record").submit(function(e){
	var tk_type = $('#token_type').val();
	$('.icon-spinner3').show();
	if(tk_type == 'payment_method'){
		var field_add = '&type=delete_record&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'currency_type'){
		var field_add = '&type=delete_record&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'company_type'){
		var field_add = '&type=delete_record&';
		var tb_name = 'xin_table_'+tk_type;
	} else if(tk_type == 'religion'){
		var field_add = '&type=delete_record&';
		var tb_name = 'xin_table_'+tk_type;
	}
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			url: e.target.action,
			type: "post",
			data: obj.serialize()+field_add+"form="+action,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					Ladda.stopAll();
				} else {
					$('.delete-modal').modal('toggle');
					$('#'+tb_name).dataTable().api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				}
			}
		});
	});   
	
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_type = button.data('field_type');
		if(field_type == 'payment_method'){
			var field_add = '&data=ed_payment_method&type=ed_payment_method&';
		} else if(field_type == 'currency_type'){
			var field_add = '&data=currency_type&type=currency_type&';
		} else if(field_type == 'company_type'){
			var field_add = '&data=ed_company_type&type=ed_company_type&';
		} else if(field_type == 'religion'){
			var field_add = '&data=ed_religion&type=ed_religion&';
		}		
		var modal = $(this);
		$.ajax({
			url: main_url+'settings/constants_read',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id,
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
	$('input[name=token_type]').val($(this).data('token_type'));
	$('#delete_record').attr('action',main_url+'settings/delete_'+$(this).data('token_type'));
});
$(document).ready(function() {
	jQuery("#department_id").change(function(){
		jQuery.get(main_url+"employees/is_designation/"+jQuery(this).val(), function(data, status){
			jQuery('#designation_ajax').html(data);
		});
	});	
	// On page load > documents
	var xin_table_document = $('#xin_table_document').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"employees/user_documents_list/"+$('#user_id').val(),
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
	// On page load 
	var xin_table_allowances_ad = $('#xin_table_all_allowances').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"employees/allowances_list/"+$('#user_id').val(),
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
	var xin_table_commissions_ad = $('#xin_table_all_commissions').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"employees/commissions_list/"+$('#user_id').val(),
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
	var xin_table_statutory_deductions_ad = $('#xin_table_all_statutory_deductions').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"employees/statutory_list/"+$('#user_id').val(),
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
	
	var xin_table_other_payments_ad = $('#xin_table_all_other_payments').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"employees/other_payments_list/"+$('#user_id').val(),
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
	/* Edit data */ /*Form Submit*/
	$("#edit_user").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#edit_bio").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#edit_social").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#edit_bankinfo").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#edit_contact").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#update_contract").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#edit_account").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#edit_user_photo").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
	/* Edit data */ /*Form Submit*/
	$("#change_password").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
					jQuery('#change_password')[0].reset(); // To reset form fields
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
	/* Add info */
	$("#user_allowance").submit(function(e){
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
					xin_table_allowances_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#user_allowance')[0].reset(); // To reset form fields
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
	/* Add info */
	$("#user_commissions").submit(function(e){
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
					xin_table_commissions_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#user_commissions')[0].reset(); // To reset form fields
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
	/* Add info */
	$("#user_statutory").submit(function(e){
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
					xin_table_statutory_deductions_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#user_statutory')[0].reset(); // To reset form fields
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
	/* Add info */
	$("#user_otherpayment").submit(function(e){
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
					xin_table_other_payments_ad.api().ajax.reload(function(){ 
						Ladda.stopAll();
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					jQuery('#user_otherpayment')[0].reset(); // To reset form fields
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
	/* Add data */ /*Form Submit*/
	$("#user_document").submit(function(e){
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
					xin_table_document.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('#user_document')[0].reset(); // To reset form fields
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
	// get data
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var field_id = button.data('field_id');
		var field_tpe = button.data('field_type');
		if(field_tpe == 'document'){
			var field_add = '&data=user_document&type=user_document&';
		} else if(field_tpe == 'allowances'){
			var field_add = '&data=user_allowance&type=user_allowance&';
		} else if(field_tpe == 'commissions'){
			var field_add = '&data=user_commission&type=user_commission&';
		} else if(field_tpe == 'statutory'){
			var field_add = '&data=user_statutory&type=user_statutory&';
		} else if(field_tpe == 'other_payments'){
			var field_add = '&data=user_other_payments&type=user_other_payments&';
		}
		var modal = $(this);
		$.ajax({
			url: main_url+'employees/dialog_user_data',
			type: "GET",
			data: 'jd=1'+field_add+'field_id='+field_id+'&uid='+$('#user_id').val(),
			success: function (response) {
				if(response) {
					$("#ajax_view_modal").html(response);
				}
			}
		});
   });
   /* Delete data */
	$("#delete_rdecord").submit(function(e){
		var tk_type = $('#token_type').val();
		
		if(tk_type == 'document'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_allowances'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_commissions'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_statutory_deductions'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_other_payments'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		}
		alert(tb_name);
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
						$('#'+tb_name).api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);		
						$('input[name="csrf_token"]').val(JSON.csrf_hash);	
						Ladda.stopAll();				
					}
				}
			});
	});
	/* Delete data */
	$("#delete_record").submit(function(e){
		var tk_type = $('#token_type').val();
		
		if(tk_type == 'document'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_allowances'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_commissions'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_statutory_deductions'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		} else if(tk_type == 'all_other_payments'){
			var field_add = '&data=delete_record&type=delete_record&';
			var tb_name = 'xin_table_'+tk_type;
		}	
		/*Form Submit*/
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$.ajax({
				url: e.target.action,
				type: "POST",
				data: obj.serialize()+"&is_ajax=2&type=delete_record&form="+action,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						Ladda.stopAll();
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					} else {
						$('.delete-modal').modal('toggle');
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						$('#'+tb_name).dataTable().api().ajax.reload(function(){ 
							toastr.success(JSON.result);
							Ladda.stopAll();
						}, true);
						
					}
				}
			});
		}); 
	
	// timesheet agenda
	// On page load > leave|agenda
	var xin_table_leave = $('#xin_table_leave').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/leave_list/"+$('#user_id').val(),
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
	// On page load > expense|agenda
	var xin_table_expense = $('#xin_table_expense').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/expense_list/"+$('#user_id').val(),
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
	// On page load > loan|agenda
	var xin_table_loan = $('#xin_table_loan').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/loan_list/"+$('#user_id').val(),
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
	// On page load > loan|agenda
	var xin_table_travel = $('#xin_table_travel').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/travel_list/"+$('#user_id').val(),
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
	// On page load > loan|agenda
	var xin_table_ad_salary = $('#xin_table_ad_salary').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/advance_salary_list/"+$('#user_id').val(),
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
	// On page load > overtime_request|agenda
	var xin_table_overtime = $('#xin_table_overtime').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/overtime_request_list/"+$('#user_id').val(),
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
	// On page load > overtime_request|agenda
	var xin_table_awards = $('#xin_table_awards').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/awards_list/"+$('#user_id').val(),
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
	// On page load > overtime_request|agenda
	var xin_table_projects = $('#xin_table_projects').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/projects_list/"+$('#user_id').val(),
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
	// On page load > tasks|agenda
	var xin_table_tasks = $('#xin_table_tasks').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/tasks_list/"+$('#user_id').val(),
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
	// On page load > tasks|agenda
	var xin_table_payslip = $('#xin_table_payslip').dataTable({
        "bDestroy": true,
		"ajax": {
            url : main_url+"agenda/payslip_history_list/"+$('#user_id').val(),
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
		
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('input[name=token_type]').val($(this).data('field_type'));
	$('#delete_record').attr('action',main_url+'employees/delete_'+$(this).data('field_type'));
});
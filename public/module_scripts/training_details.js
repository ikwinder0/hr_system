$(document).ready(function(){			
	/* Edit training data */
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
	$(".delete_data").on("click", function() {
		var field_id = $(this).data('field');
		var field_title = $(this).data('title');
		$('#option_id_'+field_id).fadeOut();
		$('.option_id_'+field_id).fadeOut();
		$.ajax({
		url : main_url+"training/delete_training_note",
		type: "GET",
		data: 'jd=1&data=training_note&field_id='+field_id,
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
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
});
$(document).ready(function() {
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
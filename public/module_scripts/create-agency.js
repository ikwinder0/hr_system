$(document).ready(function() {
    
    /* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		
		console.log(fd);
		var obj = $(this), action = obj.attr('name');
		e.preventDefault();	
		fd.append("is_ajax", 1);
		fd.append("type", 'add_agency');
		fd.append("form", action);
		//fd.append('agency_logo', $('input[name=agency_logo]')[0].files[0]);
// 		fd.append('cr_tax_card', $('.cr_tax_card')[0].files[0]); 
// 		fd.append('bank_account', $('.bank_account')[0].files[0]); 
// 		fd.append('bank_account_with_seal', $('.bank_account_with_seal')[0].files[0]); 
// 		fd.append('bank_certificate', $('.bank_certificate')[0].files[0]);
			
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			dataType:'json',
            //async:false,
			contentType: false,
			//cache: false,
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
					$('#xin-form')[0].reset(); // To reset form fields
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
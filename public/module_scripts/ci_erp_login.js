$(document).ready(function(){	
	$("#erp-form").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var obj = $(this), action = obj.attr('name'), redirect_url = obj.data('redirect'), form_table = obj.data('form-table'),  is_redirect = obj.data('is-redirect');
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&form="+form_table,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
			} else {
				toastr.clear();
				$('input[name="csrf_token"]').val(JSON.csrf_hash);
				Ladda.stopAll();
				var timerInterval;
				Swal.fire({
					title:JSON.result,
					html:processing_request,
					timer:2000,
					icon: "success",
					showConfirmButton: false,
					timerProgressBar: true,
					onBeforeOpen:function(){
						Swal.showLoading(),
						t=setInterval(function(){
							},100)}
						,onClose:function(){clearInterval(t);
						window.location = desk_url;
						}})
						.then(function(t){
							t.dismiss===Swal.DismissReason.timer&&console.log("I was closed by the timer")});
				e.preventDefault();
			}
		}
	});
	});
});
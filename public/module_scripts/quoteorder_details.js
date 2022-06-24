$(document).ready(function() {
   $('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var field_id = button.data('field_id');
	var modal = $(this);
	$.ajax({
		url :  main_url+"/orderquotes/read_quote_data",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=cancel_quote&field_id='+field_id,
		success: function (response) {
			if(response) {
				$("#ajax_view_modal").html(response);
			}
		}
		});
	});
	 $('.payroll-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var field_id = button.data('field_id');
	var modal = $(this);
	$.ajax({
		url :  main_url+"/orderquotes/read_quote_data",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=convert_quote&field_id='+field_id,
		success: function (response) {
			if(response) {
				$("#ajax_payroll_modal").html(response);
			}
		}
		});
	});
});
$(document).ready(function() {
   $('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var invoice_id = button.data('invoice_id');
	var modal = $(this);
	$.ajax({
		url :  main_url+"/invoices/read_invoice_data",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=invoice_pay&field_id='+invoice_id,
		success: function (response) {
			if(response) {
				$("#ajax_view_modal").html(response);
			}
		}
		});
	});
});
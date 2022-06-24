function update_total() { 
	var sub_total = 0;
	var st_tax = 0;
	var grand_total = 0;
	var gdTotal = 0;
	var rdiscount = 0;
	
	i = 1;
	// sub items
	$('.sub-total-item').each(function(i) {
        var total = $(this).val();
		
		total = parseFloat(total);
		
		sub_total = total+sub_total;
    });
	// discount
	var discount_figure = $('.discount_figure').val();
	if($('.discount_type').val() == '1'){
		 var fsub_total = sub_total - discount_figure;
		  $('.discount_amount').val(discount_figure); 
	 } else {
		 var discount_percent = sub_total / 100 * discount_figure;
		 var fsub_total = sub_total - discount_percent;
		$('.discount_amount').val(discount_percent.toFixed(2));	 
	 }
	// tax type/rate
	var element = $(".tax_type option:selected");
	var tax_type = element.attr("tax-type");
	if(tax_type == 'fixed'){
		var st_tax = element.attr("tax-rate");
		$('.tax_rate').val(st_tax);
	} else {
		var st_tax = element.attr("tax-rate");
		var perc_tax = sub_total / 100 * st_tax;
		var perc_tax = perc_tax.toFixed(2);
		$('.tax_rate').val(perc_tax);
	 }
	
	var discount_amount = $('.discount_amount').val();
	
	var tax_rate = $('.tax_rate').val();
	
	var gdTotal = parseFloat(sub_total) - parseFloat(discount_amount);
	var grand_total = parseFloat(gdTotal) + parseFloat(tax_rate);
	jQuery('.sub_total').html(sub_total);
	jQuery('.items-sub-total').val(sub_total);
	$('.fgrand_total').val(grand_total.toFixed(2));
	$('.grand_total').html(grand_total.toFixed(2));
}
//Update total function ends here.
  // for qty
 jQuery(document).on('click keyup change','.qty_hrs,.unit_price',function() {
	 var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var qty = $(this).closest('.item-row').find('.qty_hrs').val();
	 var unit_price = $(this).closest('.item-row').find('.unit_price').val();
	 if(qty == ''){
		 var qty = 0;
	 } if(unit_price == ''){
		 var unit_price = 0;
	 }
	 // calculation
	 var sbT = (qty * unit_price);
	 var sub_total = sbT;
	jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total); 
	jQuery(this).closest('.item-row').find('.sub-total-item').val(sub_total);
	
	update_total();
	//$('.tax-rate-item').html(taxPP.toFixed(2));
});
jQuery(document).on('change click','.discount_type',function() {
	 var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var discount_figure = $('.discount_figure').val();
	 var discount_type = $('.discount_type').val(); 
	 var sub_total = $('.items-sub-total').val();

	 if($('.discount_type').val() == '1'){
		 var grand_total = sub_total - discount_figure;
		  var discount_amval = discount_figure;
		  $('.discount_amount').val(discount_amval); 
	 } else {
		 var discount_percent = sub_total / 100 * discount_figure;
		 var grand_total = sub_total - discount_percent;
		 var discount_amval = discount_percent.toFixed(2);
		 $('.discount_amount').val(discount_amval);	 
	 }
	update_total();
});
jQuery(document).on('click keyup change','.discount_figure',function() {
	 var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var discount_figure = $('.discount_figure').val();
	 var discount_type = $('.discount_type').val(); 
	 var sub_total = $('.items-sub-total').val();

	if(parseFloat(discount_figure) <= parseFloat(sub_total)) {
	 if($('.discount_type').val() == '1'){
		 var grand_total = sub_total - discount_figure;
		  var discount_amval = discount_figure;
		  $('.discount_amount').val(discount_amval);
	 } else {
		 var discount_percent = sub_total / 100 * discount_figure;
		 var grand_total = sub_total - discount_percent;
		 var discount_amval = discount_percent.toFixed(2);
		 $('.discount_amount').val(discount_amval);
	 }
	} else {
		//
		$('.discount_amount').val(0);
		$('.discount_figure').val(0)
		alert('Discount price should be less than Sub Total.');
	}
	update_total();
});
jQuery(document).on('change click','.tax_type',function() {
	 var qty = 0;
	 var unit_price = 0;
	 var tax_rate = 0;
	 var sub_total = $('.items-sub-total').val();
	 var element = $(".tax_type option:selected");
	 var tax_type = element.attr("tax-type");
	 if(tax_type == 'fixed'){
		var st_tax = element.attr("tax-rate");
		$('.tax_rate').val(st_tax);
	 } else {
		var st_tax = element.attr("tax-rate");
		var perc_tax = sub_total / 100 * st_tax;
		var perc_tax = perc_tax.toFixed(2);
		$('.tax_rate').val(perc_tax);
	 }
	update_total();
});
jQuery(document).on('click','.remove-invoice-item', function () {
	$(this).closest('.item-row').fadeOut(300, function() {
		$(this).remove();
		update_total();
	});
});
$(document).ready(function() {	
	/* create an invoice */
	$("#xin-form").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=add_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('.save').prop('disabled', false);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
					window.location = main_url+'/estimates-list';
				}
			}
		});
	});	
	
});
jQuery(document).on('click','.remove-invoice-item-ol', function () {
	var record_id = $(this).data('record-id');
	$(this).closest('.item-row').fadeOut(300, function() {
	jQuery.get(main_url+"/estimates/delete_estimate_items?record_id="+record_id, function(data, status){
	});
	$(this).remove();
		update_total();
	});
});
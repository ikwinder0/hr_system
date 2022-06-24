<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\OrderquotesModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();	
$OrderquotesModel = new OrderquotesModel();			
$ConstantsModel = new ConstantsModel();
$get_animate = '';
if($request->getGet('data') === 'cancel_quote' && $request->getGet('field_id')){
$invoice_id = udecode($field_id);
$result = $OrderquotesModel->where('quote_id', $invoice_id)->first();
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Inventory.xin_cancel_quote').' #'.$result['quote_number'];?>
 </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'cancel_quote_record', 'id' => 'cancel_quote_record', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/orderquotes/cancel_quote_record', $attributes, $hidden);?>
<div class="modal-body">
  <div class="alert alert-danger" role="alert">
		<?= lang('Inventory.xin_cancel_quote_text');?>
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-success">
  <?= lang('Inventory.xin_cancel_quote');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');

	/* Edit data */
	$("#cancel_quote_record").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=cancel_quote_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.view-modal-data').modal('toggle');
					Ladda.stopAll();
					window.location = '';
				}
			}
		});
	});
});	
  </script>
<?php } else if($request->getGet('data') === 'convert_quote' && $request->getGet('field_id')){
$invoice_id = udecode($field_id);
$result = $OrderquotesModel->where('quote_id', $invoice_id)->first();
//$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Inventory.xin_quote_number').' #'.$result['quote_number'];?>
 </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'convert_quote_record', 'id' => 'convert_quote_record', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/orderquotes/convert_quote_record', $attributes, $hidden);?>
<div class="modal-body">
  <div class="alert alert-success" role="alert">
		<?= lang('Inventory.xin_convert_quote_to_invoice_text');?>
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-success">
  <?= lang('Main.xin_convert_estimate_to_invoice');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');

	/* Edit data */
	$("#convert_quote_record").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=convert_quote_record&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					Ladda.stopAll();
				} else {
					toastr.success(JSON.result);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.payroll-modal-data').modal('toggle');
					Ladda.stopAll();
					window.location = '';
				}
			}
		});
	});
});	
  </script>
<?php }
?>

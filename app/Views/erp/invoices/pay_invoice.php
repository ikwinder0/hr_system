<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\InvoicesModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();	
$InvoicesModel = new InvoicesModel();			
$ConstantsModel = new ConstantsModel();
$get_animate = '';
if($request->getGet('data') === 'invoice_pay' && $request->getGet('field_id')){
$invoice_id = udecode($field_id);
//$result = $InvoicesModel->where('invoice_id', $invoice_id)->first();
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Invoices.xin_pay_invoice');?>
 </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'pay_invoice_record', 'id' => 'pay_invoice_record', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/invoices/pay_invoice_record', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
          <label for="payment_method">
            <?= lang('Main.xin_payment_method');?>
          </label>
          <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_payment_method');?>">
            <option value=""></option>
            <?php foreach($payment_method as $ipayment_method) {?>
            <option value="<?php echo $ipayment_method['constants_id'];?>"> <?php echo $ipayment_method['category_name'];?></option>
            <?php } ?>
          </select>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="status"><?php echo lang('Main.dashboard_xin_status');?></label>
        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.dashboard_xin_status');?>">
          <option value=""></option>
          <option value="1"><?php echo lang('Invoices.xin_paid');?></option>
        </select>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-success">
  <?= lang('Invoices.xin_pay_invoice');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');

	/* Edit data */
	$("#pay_invoice_record").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');		
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
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
<?php }
?>

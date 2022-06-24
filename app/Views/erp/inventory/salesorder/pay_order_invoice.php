<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\OrdersModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();	
$OrdersModel = new OrdersModel();			
$ConstantsModel = new ConstantsModel();
$get_animate = '';
if($request->getGet('data') === 'invoice_pay' && $request->getGet('field_id')){
$invoice_id = udecode($field_id);
$result = $OrdersModel->where('order_id', $invoice_id)->first();
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Invoices.xin_pay_invoice');?> #<?= $result['order_number'];?>
 </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'pay_invoice_record', 'id' => 'pay_invoice_record', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/orders/pay_invoice_record', $attributes, $hidden);?>
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
          <option value="2"><?php echo lang('Main.xin_cancelled');?></option>
        </select>
      </div>
    </div>
  </div>
  <div class="alert alert-primary" role="alert">
    <?= lang('Inventory.xin_when_order_paid_text');?>
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
<?php } else if($request->getGet('data') === 'packed' && $request->getGet('field_id')){
$invoice_id = udecode($field_id);
$result = $OrdersModel->where('order_id', $invoice_id)->first();
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Inventory.xin_packing_status');?> #<?= $result['order_number'];?>
 </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'packing_status', 'id' => 'packing_status', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/orders/packing_status', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="status"><?php echo lang('Main.dashboard_xin_status');?></label>
        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.dashboard_xin_status');?>">
          <option value=""></option>
          <option value="3"><?php echo lang('Inventory.xin_packed_orders_text');?></option>
        </select>
      </div>
    </div>
  </div>
  <div class="alert alert-primary" role="alert">
    <?= lang('Inventory.xin_when_order_packed_text');?>
</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-success">
  <?= lang('Inventory.xin_update_packing_status');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');

	/* Edit data */
	$("#packing_status").submit(function(e){
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
<?php } else if($request->getGet('data') === 'delivery' && $request->getGet('field_id')){
$invoice_id = udecode($field_id);
$result = $OrdersModel->where('order_id', $invoice_id)->first();
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Inventory.xin_delivery_status');?> #<?= $result['order_number'];?>
 </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'delivery_status', 'id' => 'delivery_status', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/orders/delivery_status', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="status"><?php echo lang('Main.dashboard_xin_status');?></label>
        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo lang('Main.dashboard_xin_status');?>">
          <option value=""></option>
          <option value="4"><?php echo lang('Inventory.xin_delivered_orders_text');?></option>
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
  <?= lang('Inventory.xin_update_delivery_status');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){ 

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	 
	Ladda.bind('button[type=submit]');

	/* Edit data */
	$("#delivery_status").submit(function(e){
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

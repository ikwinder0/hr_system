<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\PayeesModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$PayeesModel = new PayeesModel();
$get_animate = '';
if($request->getGet('data') === 'payer' && $request->getGet('type') === 'payer' && $request->getGet('field_id')){
$entity_id = udecode($field_id);
$result = $PayeesModel->where('entity_id', $entity_id)->where('type','payer')->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Asset.xin_edit_assets_category');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_payer', 'id' => 'update_payer', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id, 'ext_name' => $payer_name);?>
<?php echo form_open('erp/finance/update_payer', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="payer_name"><?= lang('xin_acc_payer');?></label>
        <input type="text" class="form-control" name="name" placeholder="<?= lang('xin_acc_payer_name');?>" value="<?php echo $result['name'];?>">
      </div>
      <div class="form-group">
        <label for="contact_number"><?= lang('xin_contact_number');?></label>
        <input type="text" class="form-control" name="contact_number" placeholder="<?= lang('xin_contact_number');?>" value="<?php echo $result['contact_number'];?>">
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal"><?= lang('Main.xin_close');?></button>
  <button type="submit" class="btn btn-primary"><?= lang('Main.xin_update');?></button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){ 

		Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#update_payer").submit(function(e){
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
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("erp/finance/payers_list") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						$('.view-modal-data').modal('toggle');
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php } elseif($request->getGet('data') === 'payee' && $request->getGet('type') === 'payee' && $request->getGet('field_id')){
$entity_id = udecode($field_id);
$result = $PayeesModel->where('entity_id', $entity_id)->where('type','payee')->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Asset.xin_edit_assets_category');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'update_payee', 'id' => 'update_payee', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id, 'ext_name' => $payee_name);?>
<?php echo form_open('erp/finance/update_payee', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="payee_name"><?= lang('xin_acc_payee');?></label>
        <input type="text" class="form-control" name="name" placeholder="<?= lang('xin_acc_payee_name');?>" value="<?php echo $result['name'];?>">
      </div>
      <div class="form-group">
        <label for="contact_number"><?= lang('xin_contact_number');?></label>
        <input type="number" class="form-control" name="contact_number" placeholder="<?= lang('xin_contact_number');?>" value="<?php echo $result['contact_number'];?>">
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal"><?= lang('Main.xin_close');?></button>
  <button type="submit" class="btn btn-primary"><?= lang('Main.xin_update');?></button>
</div>
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){ 

		Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#update_payee").submit(function(e){
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
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("erp/finance/payees_list") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						$('.view-modal-data').modal('toggle');
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php }
?>

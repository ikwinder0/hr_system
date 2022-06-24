<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ContractModel;
use App\Models\UserdocumentsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();			
$ContractModel = new ContractModel();
$SystemModel = new SystemModel();
$UserdocumentsModel = new UserdocumentsModel();
$get_animate = '';
$xin_system = $SystemModel->where('setting_id', 1)->first();
if($request->getGet('data') === 'user_allowance' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $ContractModel->where('contract_option_id', $ifield_id)->first();
//$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_allowances');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_allowance', 'id' => 'edit_allowance', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_allowance', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="is_allowance_taxable">
          <?= lang('Employees.xin_allowance_option');?>
          <span class="text-danger">*</span></label>
        <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($result['contract_tax_option']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_salary_allowance_non_taxable');?>
          </option>
          <option value="2" <?php if($result['contract_tax_option']==2):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_fully_taxable');?>
          </option>
          <option value="3" <?php if($result['contract_tax_option']==3):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_partially_taxable');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="amount_option">
          <?= lang('Employees.xin_amount_option');?>
          <span class="text-danger">*</span></label>
        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_fixed');?>
          </option>
          <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_percent');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_title">
          <?= lang('Dashboard.xin_title');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_number">
          <?= lang('Invoices.xin_amount');?>
          <span class="text-danger">*</span></label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
	 Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#edit_allowance").submit(function(e){
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
					// On page load: datatable
					var xin_table_allowances = $('#xin_table_all_allowances').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/employees/allowances_list/").$request->getGet('uid'); ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_allowances.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					$('.view-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } else if($request->getGet('data') === 'user_commission' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $ContractModel->where('contract_option_id', $ifield_id)->first();
//$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_commissions');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_commission', 'id' => 'edit_commission', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_commission', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="is_allowance_taxable">
          <?= lang('Employees.xin_salary_commission_options');?>
          <span class="text-danger">*</span></label>
        <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($result['contract_tax_option']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_salary_allowance_non_taxable');?>
          </option>
          <option value="2" <?php if($result['contract_tax_option']==2):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_fully_taxable');?>
          </option>
          <option value="3" <?php if($result['contract_tax_option']==3):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_partially_taxable');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="amount_option">
          <?= lang('Employees.xin_amount_option');?>
          <span class="text-danger">*</span></label>
        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_fixed');?>
          </option>
          <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_percent');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_title">
          <?= lang('Dashboard.xin_title');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_number">
          <?= lang('Invoices.xin_amount');?>
          <span class="text-danger">*</span></label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
	 Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#edit_commission").submit(function(e){
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
					// On page load: datatable
					var xin_table_commissions = $('#xin_table_all_commissions').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/employees/commissions_list/").$request->getGet('uid'); ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_commissions.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					$('.view-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } else if($request->getGet('data') === 'user_statutory' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $ContractModel->where('contract_option_id', $ifield_id)->first();
//$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_satatutory_deductions');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_statutory', 'id' => 'edit_statutory', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_statutory', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="amount_option">
          <?= lang('Employees.xin_salary_sd_options');?>
          <span class="text-danger">*</span></label>
        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_fixed');?>
          </option>
          <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_percent');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_title">
          <?= lang('Dashboard.xin_title');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="account_number">
          <?= lang('Invoices.xin_amount');?>
          <span class="text-danger">*</span></label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
	 Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#edit_statutory").submit(function(e){
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
					// On page load: datatable
					var xin_table_all_statutory = $('#xin_table_all_statutory_deductions').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/employees/statutory_list/").$request->getGet('uid'); ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_all_statutory.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					$('.view-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } else if($request->getGet('data') === 'user_other_payments' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $ContractModel->where('contract_option_id', $ifield_id)->first();
//$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_reimbursements');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_other_payments', 'id' => 'edit_other_payments', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open('erp/employees/update_other_payments', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="is_allowance_taxable">
          <?= lang('Employees.xin_reimbursements_option');?>
          <span class="text-danger">*</span></label>
        <select name="contract_tax_option" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($result['contract_tax_option']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_salary_allowance_non_taxable');?>
          </option>
          <option value="2" <?php if($result['contract_tax_option']==2):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_fully_taxable');?>
          </option>
          <option value="3" <?php if($result['contract_tax_option']==3):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_partially_taxable');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="amount_option">
          <?= lang('Employees.xin_amount_option');?>
          <span class="text-danger">*</span></label>
        <select name="is_fixed" class="form-control" data-plugin="select_hrm">
          <option value="1" <?php if($result['is_fixed']==1):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_fixed');?>
          </option>
          <option value="2" <?php if($result['is_fixed']==2):?> selected="selected"<?php endif;?>>
          <?= lang('Employees.xin_title_tax_percent');?>
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_title">
          <?= lang('Dashboard.xin_title');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Dashboard.xin_title');?>" name="option_title" type="text" value="<?= $result['option_title'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_number">
          <?= lang('Invoices.xin_amount');?>
          <span class="text-danger">*</span></label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="contract_amount" type="text" value="<?= $result['contract_amount'];?>">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
	 Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#edit_other_payments").submit(function(e){
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
					// On page load: datatable
					var xin_table_all_other_payments = $('#xin_table_all_other_payments').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/employees/other_payments_list/").$request->getGet('uid'); ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_all_other_payments.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
					}, true);
					$('.view-modal-data').modal('toggle');
					Ladda.stopAll();
				}
			}
		});
	});
});	
</script>
<?php } else if($request->getGet('data') === 'user_document' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $UserdocumentsModel->where('document_id', $ifield_id)->first();
//$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Employees.xin_edit_documents');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'edit_document', 'id' => 'edit_document', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?= form_open_multipart('erp/employees/update_document', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="date_of_expiry" class="control-label">
          <?= lang('Employees.xin_document_name');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_document_name');?>" name="document_name" type="text" value="<?= $result['document_name'];?>">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="title" class="control-label">
          <?= lang('Employees.xin_document_type');?>
          <span class="text-danger">*</span></label>
        <input class="form-control" placeholder="<?= lang('Employees.xin_document_eg_payslip_etc');?>" name="document_type" type="text" value="<?= $result['document_type'];?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="logo">
          <?= lang('Employees.xin_document_file');?>
          <span class="text-danger">*</span> </label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="document_file">
          <label class="custom-file-label">
            <?= lang('Main.xin_choose_file');?>
          </label>
          <small>
          <?= lang('Employees.xin_e_details_d_type_file');?>
          </small> </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-light" data-dismiss="modal">
  <?= lang('Main.xin_close');?>
  </button>
  <button type="submit" class="btn btn-primary">
  <?= lang('Main.xin_update');?>
  </button>
</div>
<?= form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	  
	 Ladda.bind('button[type=submit]');
	/* Edit data */
	$("#edit_document").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
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
					// On page load: datatable
					var xin_table_document = $('#xin_table_document').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?= site_url("erp/employees/user_documents_list/").$request->getGet('uid'); ?>",
							type : 'GET'
						},
						"language": {
							"lengthMenu": dt_lengthMenu,
							"zeroRecords": dt_zeroRecords,
							"info": dt_info,
							"infoEmpty": dt_infoEmpty,
							"infoFiltered": dt_infoFiltered,
							"search": dt_search,
							"paginate": {
								"first": dt_first,
								"previous": dt_previous,
								"next": dt_next,
								"last": dt_last
							},
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table_document.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.view-modal-data').modal('toggle');
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
</script>
<?php }
?>

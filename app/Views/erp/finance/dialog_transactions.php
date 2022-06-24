<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\PayeesModel;
use App\Models\RolesModel;
use App\Models\ConstantsModel;
use App\Models\AccountsModel;
use App\Models\TransactionsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$PayeesModel = new PayeesModel();
$AccountsModel = new AccountsModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();
$TransactionsModel = new TransactionsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$get_animate = '';
$xin_com_system = erp_company_settings();
$xin_system = erp_company_settings();
if($request->getGet('data') === 'deposit' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $TransactionsModel->where('transaction_id', $ifield_id)->where('entity_type','payer')->first();
// payment method
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
//get info
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$accounts = $AccountsModel->where('company_id', $user_info['company_id'])->orderBy('account_id', 'ASC')->findAll();
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','income_type')->orderBy('constants_id', 'ASC')->findAll();
	$payers_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
} else {
	$accounts = $AccountsModel->where('company_id', $usession['sup_user_id'])->orderBy('account_id', 'ASC')->findAll();
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','income_type')->orderBy('constants_id', 'ASC')->findAll();
	$payers_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
}
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Finance.xin_edit_deposit');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'deposit_update', 'id' => 'deposit_update', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/finance/update_deposit', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="account_id">
          <?= lang('Employees.xin_account_title');?> <span class="text-danger">*</span>
        </label>
        <select name="account_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_account_title');?>">
          <option value=""></option>
          <?php foreach($accounts as $iaccounts) {?>
          <option value="<?= $iaccounts['account_id'];?>" <?php if($result['account_id']==$iaccounts['account_id']):?> selected="selected"<?php endif;?>>
          <?= $iaccounts['account_name'];?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="month_year">
          <?= lang('Invoices.xin_amount');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input class="form-control" name="amount" type="text" data-placeholder="<?= lang('Invoices.xin_amount');?>" value="<?php echo $result['amount'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="deposit_date">
          <?= lang('Main.xin_e_details_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" name="deposit_date" type="text" value="<?php echo $result['transaction_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="employee">
          <?= lang('Dashboard.xin_category');?> <span class="text-danger">*</span>
        </label>
        <select name="category_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Finance.xin_acc_choose_category');?>">
          <option value=""></option>
          <?php foreach($category_info as $icategory) {?>
          <option value="<?= $icategory['constants_id'];?>" <?php if($result['entity_category_id']==$icategory['constants_id']):?> selected="selected"<?php endif;?>> <?php echo $icategory['category_name'];?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="payer_id">
          <?= lang('Dashboard.xin_acc_payer');?> <span class="text-danger">*</span>
        </label>
        <select name="payer_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_acc_payer');?>">
          <option value=""></option>
          <?php foreach($payers_info as $payer) {?>
          <option value="<?php echo $payer['user_id'];?>" <?php if($result['entity_id']==$payer['user_id']):?> selected="selected"<?php endif;?>> <?php echo $payer['first_name'].' '.$payer['last_name'];?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="payment_method">
          <?= lang('Main.xin_payment_method');?> <span class="text-danger">*</span>
        </label>
        <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_payment_method');?>">
          <option value=""></option>
          <?php foreach($payment_method as $ipayment_method) {?>
          <option value="<?php echo $ipayment_method['constants_id'];?>" <?php if($result['payment_method_id']==$ipayment_method['constants_id']):?> selected="selected"<?php endif;?>> <?php echo $ipayment_method['category_name'];?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="employee">
          <?= lang('Finance.xin_acc_ref_no');?>
        </label>
        <input class="form-control" placeholder="<?= lang('Finance.xin_acc_ref_example');?>" name="reference" type="text" value="<?php echo $result['reference'];?>">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="logo">
          <?= lang('Finance.xin_attachment_deposit');?>
          <span class="text-danger">*</span> </label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="attachment_file">
          <label class="custom-file-label">
            <?= lang('Main.xin_choose_file');?>
          </label>
          <small>
          <?= lang('Main.xin_company_file_type');?>
          </small> </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="logo">
          <?= lang('Main.xin_attachment');?> <span class="text-danger">*</span>
        </label>
        <br />
        <?php if($result['attachment_file']!='' && $result['attachment_file']!='no_file'):?>
        <a href="<?php echo site_url('download')?>?type=transactions&filename=<?php echo uencode($result['attachment_file']);?>">
        <?= lang('Main.xin_download');?>
        </a>
        <?php endif;?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="2"><?php echo $result['description'];?></textarea>
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
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){ 

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: '<?= js_set_date_format();?>',
			lang: '<?= $xin_com_system['datepicker_locale'];?>'
		});
		Ladda.bind('button[type=submit]');
						
		/* Edit data */
		$("#deposit_update").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
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
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/finance/deposit_list") ?>",
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
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
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
<?php } else if($request->getGet('data') === 'expense' && $request->getGet('field_id')){
$ifield_id = udecode($field_id);
$result = $TransactionsModel->where('transaction_id', $ifield_id)->where('entity_type','payee')->first();
// payment method
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
//get info
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$accounts = $AccountsModel->where('company_id', $user_info['company_id'])->orderBy('account_id', 'ASC')->findAll();
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','expense_type')->orderBy('constants_id', 'ASC')->findAll();
	$payers_info = $UsersModel->where('user_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
} else {
	$accounts = $AccountsModel->where('company_id', $usession['sup_user_id'])->orderBy('account_id', 'ASC')->findAll();
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','expense_type')->orderBy('constants_id', 'ASC')->findAll();
	$payers_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
}
?>
<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Finance.xin_edit_expense');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'expense_update', 'id' => 'expense_update', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/finance/update_expense', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="account_id">
          <?= lang('Employees.xin_account_title');?> <span class="text-danger">*</span>
        </label>
        <select name="account_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_account_title');?>">
          <option value=""></option>
          <?php foreach($accounts as $iaccounts) {?>
          <option value="<?= $iaccounts['account_id'];?>" <?php if($result['account_id']==$iaccounts['account_id']):?> selected="selected"<?php endif;?>>
          <?= $iaccounts['account_name'];?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="month_year">
          <?= lang('Invoices.xin_amount');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input class="form-control" name="amount" type="text" data-placeholder="<?= lang('Invoices.xin_amount');?>" value="<?php echo $result['amount'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="deposit_date">
          <?= lang('Main.xin_e_details_date');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" name="deposit_date" type="text" value="<?php echo $result['transaction_date'];?>">
          <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="employee">
          <?= lang('Dashboard.xin_category');?> <span class="text-danger">*</span>
        </label>
        <select name="category_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_acc_choose_category');?>">
          <option value=""></option>
          <?php foreach($category_info as $icategory) {?>
          <option value="<?= $icategory['constants_id'];?>" <?php if($result['entity_category_id']==$icategory['constants_id']):?> selected="selected"<?php endif;?>> <?php echo $icategory['category_name'];?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="payer_id">
          <?= lang('Dashboard.xin_acc_payee');?> <span class="text-danger">*</span>
        </label>
        <select name="payer_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_acc_payee');?>">
          <option value=""></option>
          <?php foreach($payers_info as $payer) {?>
          <option value="<?php echo $payer['user_id'];?>" <?php if($result['entity_id']==$payer['user_id']):?> selected="selected"<?php endif;?>> <?php echo $payer['first_name'].' '.$payer['last_name'];?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="payment_method">
          <?= lang('Main.xin_payment_method');?> <span class="text-danger">*</span>
        </label>
        <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_payment_method');?>">
          <option value=""></option>
          <?php foreach($payment_method as $ipayment_method) {?>
          <option value="<?php echo $ipayment_method['constants_id'];?>" <?php if($result['payment_method_id']==$ipayment_method['constants_id']):?> selected="selected"<?php endif;?>> <?php echo $ipayment_method['category_name'];?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="employee">
          <?= lang('Finance.xin_acc_ref_no');?>
        </label>
        <input class="form-control" placeholder="<?= lang('Finance.xin_acc_ref_example');?>" name="reference" type="text" value="<?php echo $result['reference'];?>">
        <br />
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="logo">
          <?= lang('Finance.xin_attachment_expense');?>
          <span class="text-danger">*</span> </label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" name="attachment_file">
          <label class="custom-file-label">
            <?= lang('Main.xin_choose_file');?>
          </label>
          <small>
          <?= lang('Main.xin_company_file_type');?>
          </small> </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="logo">
          <?= lang('Main.xin_attachment');?>
        </label>
        <br />
        <?php if($result['attachment_file']!='' && $result['attachment_file']!='no_file'):?>
        <a href="<?php echo site_url('download')?>?type=transactions&filename=<?php echo uencode($result['attachment_file']);?>">
        <?= lang('Main.xin_download');?>
        </a>
        <?php endif;?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="description">
          <?= lang('Main.xin_description');?>
        </label>
        <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="2"><?php echo $result['description'];?></textarea>
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
<?php echo form_close(); ?> 
<script type="text/javascript">
 $(document).ready(function(){ 

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: '<?= js_set_date_format();?>',
			lang: '<?= $xin_com_system['datepicker_locale'];?>'
		});
		Ladda.bind('button[type=submit]');
						
		/* Edit data */
		$("#expense_update").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("type", 'edit_record');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
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
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/finance/expense_list") ?>",
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
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
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

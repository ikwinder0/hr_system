<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AccountsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();				
$AccountsModel = new AccountsModel();
$xin_system = erp_company_settings();
$get_animate = '';
if($request->getGet('data') === 'accounts' && $request->getGet('type') === 'accounts' && $request->getGet('field_id')){
$account_id = udecode($field_id);
$result = $AccountsModel->where('account_id', $account_id)->first();
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Finance.xin_edit_account');?>
    <span class="font-weight-light">
    <?= lang('Main.xin_information');?>
    </span> <br>
    <small class="text-muted">
    <?= lang('Main.xin_below_required_info');?>
    </small> </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'bankcash_update', 'id' => 'bankcash_update', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', 'token' => $field_id);?>
<?php echo form_open('erp/finance/update_account', $attributes, $hidden);?>
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_name">
          <?= lang('Employees.xin_account_title');?> <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" name="account_name" placeholder="<?= lang('Employees.xin_account_title');?>" value="<?php echo $result['account_name'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_balance">
          <?= lang('Finance.xin_acc_initial_balance');?> <span class="text-danger">*</span>
        </label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text">
            <?= $xin_system['default_currency'];?>
            </span></div>
          <input type="text" class="form-control" name="account_balance" placeholder="<?= lang('Finance.xin_acc_initial_balance');?>" value="<?php echo $result['account_balance'];?>">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="account_number">
          <?= lang('Employees.xin_account_number');?> <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" name="account_number" placeholder="<?= lang('Employees.xin_account_number');?>" value="<?php echo $result['account_number'];?>">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="branch_code">
          <?= lang('Finance.xin_acc_branch_code');?>
        </label>
        <input type="text" class="form-control" name="branch_code" placeholder="<?= lang('Finance.xin_acc_branch_code');?>" value="<?php echo $result['branch_code'];?>">
      </div>
    </div>
    <div class="col-md-12">
      <label for="description">
        <?= lang('Employees.xin_bank_branch');?>
      </label>
      <textarea class="form-control" name="bank_branch" placeholder="<?= lang('Employees.xin_bank_branch');?>" rows="3"><?php echo $result['bank_branch'];?></textarea>
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

		Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#bankcash_update").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&type=edit_record&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_token"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("erp/finance/accounts_list") ?>",
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
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					}
				}
			});
		});
	});	
  </script>
<?php } ?>

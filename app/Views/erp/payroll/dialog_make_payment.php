<?php
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ContractModel;
use App\Models\StaffdetailsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$UsersModel = new UsersModel();		
$ContractModel = new ContractModel();	
$SystemModel = new SystemModel();
$StaffdetailsModel = new StaffdetailsModel();

$xin_system = erp_company_settings();
/* Assets view
*/
$get_animate = '';
if($request->getGet('data') === 'payroll' && $request->getGet('field_id')){
	$user_id = udecode($field_id);
	$payment_date = $request->getGet('payment_date');
	$advance_salary = $request->getGet('advance_salary');
	$loan = $request->getGet('loan');
	$user_info = $UsersModel->where('user_id', $user_id)->first();
	$user_detail = $StaffdetailsModel->where('user_id', $user_info['user_id'])->first();
	$ibasic_salary = $user_detail['basic_salary'];
	// Salary Options //
	// 1:: Allowances
	$count_allowances = $ContractModel->where('user_id',$user_id)->where('salay_type','allowances')->countAllResults();
	$salary_allowances = $ContractModel->where('user_id',$user_id)->where('salay_type','allowances')->findAll();
	$allowance_amount = 0;
	if($count_allowances > 0) {
		foreach($salary_allowances as $sl_allowances) {
			$allowance_amount += $sl_allowances['contract_amount'];
		}
	} else {
		$allowance_amount = 0;
	}
	// 2:: Commissions
	$count_commissions = $ContractModel->where('user_id',$user_id)->where('salay_type','commissions')->countAllResults();
	$salary_commissions = $ContractModel->where('user_id',$user_id)->where('salay_type','commissions')->findAll();
	$commissions_amount = 0;
	if($count_commissions > 0) {
		foreach($salary_commissions as $sl_salary_commissions) {
			$commissions_amount += $sl_salary_commissions['contract_amount'];
		}
	} else {
		$commissions_amount = 0;
	}
	// 3:: Other Payments
	$count_other_payments = $ContractModel->where('user_id',$user_id)->where('salay_type','other_payments')->countAllResults();
	$other_payments = $ContractModel->where('user_id',$user_id)->where('salay_type','other_payments')->findAll();
	$other_payments_amount = 0;
	if($count_other_payments > 0) {
		foreach($other_payments as $sl_other_payments) {
			$other_payments_amount += $sl_other_payments['contract_amount'];
		}
	} else {
		$other_payments_amount = 0;
	}
	// 4:: Statutory
	$count_statutory_deductions = $ContractModel->where('user_id',$user_id)->where('salay_type','statutory')->countAllResults();
	$statutory_deductions = $ContractModel->where('user_id',$user_id)->where('salay_type','statutory')->findAll();
	$statutory_deductions_amount = 0;
	if($count_statutory_deductions > 0) {
		foreach($statutory_deductions as $sl_salary_statutory_deductions) {
			$statutory_deductions_amount += $sl_salary_statutory_deductions['contract_amount'];
		}
	} else {
		$statutory_deductions_amount = 0;
	}
	
	// net salary
	$inet_salary = $ibasic_salary + $allowance_amount + $commissions_amount + $other_payments_amount + $advance_salary + $loan - $statutory_deductions_amount;
			
?>

<div class="modal-header">
  <h5 class="modal-title">
    <?= lang('Payroll.xin_payroll_make_payment');?>
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('Main.xin_close');?>"> <span aria-hidden="true">×</span> </button>
</div>
<?php $attributes = array('name' => 'pay_monthly', 'id' => 'pay_monthly', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('token' => $field_id,'token2' => $payment_date);?>
<?php echo form_open('erp/payroll/add_pay_monthly', $attributes, $hidden);?>
<div class="modal-body" style="overflow:auto;">
  <h6 class="m-b-15 text-primary">
    <?= lang('Employees.xin_basic_salary');?>
  </h6>
  <div class="row">
  <div class="col-md-12">
      <div class="form-group">
        <div class="input-group mb-3"> <span class="input-group-prepend">
        <label class="input-group-text"><i class="fas fa-money-check"></i></label>
        </span>
        <input type="text" class="form-control" placeholder="<?= lang('Employees.xin_basic_salary');?>" readonly="readonly" value="<?php echo $ibasic_salary;?>">
      </div>
      </div>
    </div>
   </div> 
  
  <ul class="list-group list-group-flush">
    <li class="list-group-item py-0" style="border:0">
      <div class="table-responsive">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td><p class="m-0 d-inline-block align-middle">
                  <?= lang('Employees.xin_allowances');?>
                </p></td>
              <td class="text-right"><?= number_to_currency($allowance_amount, $xin_system['default_currency'],null,2);?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </li>
    <li class="list-group-item py-0" style="border:0">
      <div class="table-responsive">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td><p class="m-0 d-inline-block align-middle">
                  <?= lang('Employees.xin_commissions');?>
                </p></td>
              <td class="text-right"><?= number_to_currency($commissions_amount, $xin_system['default_currency'],null,2);?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </li>
    <li class="list-group-item py-0" style="border:0">
      <div class="table-responsive">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td><p class="m-0 d-inline-block align-middle">
                  <?= lang('Employees.xin_reimbursements');?>
                </p></td>
              <td class="text-right"><?= number_to_currency($other_payments_amount, $xin_system['default_currency'],null,2);?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </li>
    <li class="list-group-item py-0" style="border:0">
      <div class="table-responsive">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td><p class="m-0 d-inline-block align-middle">
                  <?= lang('Employees.xin_satatutory_deductions');?>
                </p></td>
              <td class="text-right"><?= number_to_currency($statutory_deductions_amount, $xin_system['default_currency'],null,2);?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </li>
    <li class="list-group-item py-0" style="border:0">
      <div class="table-responsive">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td><p class="m-0 d-inline-block align-middle">
                  <?= lang('Main.xin_advance_salary');?>
                </p></td>
              <td class="text-right"><?= number_to_currency($advance_salary, $xin_system['default_currency'],null,2);?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </li>
    <li class="list-group-item py-0" style="border:0">
      <div class="table-responsive">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td><p class="m-0 d-inline-block align-middle">
                  <?= lang('Main.xin_loan');?>
                </p></td>
              <td class="text-right"><?= number_to_currency($loan, $xin_system['default_currency'],null,2);?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </li>
    <li class="list-group-item py-0" style="border:0">
      <div class="table-responsive">
        <table class="table table-borderless mb-0">
          <tbody>
            <tr>
              <td><p class="m-0 d-inline-block align-middle"><strong class="text-primary"><?php echo lang('Employees.xin_payroll_net_salary');?></strong></p></td>
              <td class="text-right"><strong class="text-primary">
                <?= number_to_currency($inet_salary, $xin_system['default_currency'],null,2);?>
                </strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </li>
  </ul>
  <div class="row">
  <div class="col-md-12 reject_opt">
      <div class="form-group">
        <label for="description"><?= lang('Payroll.xin_payslip_comments');?></label>
        <textarea class="form-control textarea" placeholder="<?= lang('Payroll.xin_payslip_comments');?>" name="payslip_comments" cols="30" rows="3"></textarea>
      </div>
    </div>
   </div>
</div>
<div class="modal-footer">
<?php if($inet_salary > 0) { ?>
	<button type="submit" class="btn btn-success"> <?php echo lang('Payroll.xin_payroll_make_payment');?> </button>
<?php } else {?>
<div class="alert alert-danger" role="alert">
	   <?php echo lang('Success.ci_payslip_updated_0salary_error_msg');?>
	</div>
<?php } ?>
</div>
<?= form_close(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	Ladda.bind('button[type=submit]');
	// On page load: datatable					
	$("#pay_monthly").submit(function(e){
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		//$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=11&data=monthly&type=add_monthly_payment&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_token"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				} else {
					$('.payroll-modal-data').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("erp/payroll/payslip_list") ?>?staff_id=0&payment_date=<?= udecode($payment_date);?>",
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
					Ladda.stopAll();
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } ?>

<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\PayrollModel;
use App\Models\ContractModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
use App\Models\PayallowancesModel;
use App\Models\PaycommissionsModel;
use App\Models\PayotherpaymentsModel;
use App\Models\PaystatutorydeductionsModel;

$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$SystemModel = new SystemModel();
$PayrollModel = new PayrollModel();
$ContractModel = new ContractModel();
$ConstantsModel = new ConstantsModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();
$PayallowancesModel = new PayallowancesModel();
$PaycommissionsModel = new PaycommissionsModel();
$PayotherpaymentsModel = new PayotherpaymentsModel();
$PaystatutorydeductionsModel = new PaystatutorydeductionsModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$segment_id = $request->uri->getSegment(3);
$payslip_id = udecode($segment_id);

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$payslip_data = $PayrollModel->where('company_id', $user_info['company_id'])->where('payslip_id', $payslip_id)->first();
	$user_data = $UsersModel->where('company_id', $user_info['company_id'])->where('user_id', $payslip_data['staff_id'])->first();
	// userdata
	if($user_data){
		$employee_detail = $StaffdetailsModel->where('user_id', $user_data['user_id'])->first();
		$idesignations = $DesignationModel->where('company_id', $user_info['company_id'])->where('designation_id',$employee_detail['designation_id'])->first();
		$designation_name = $idesignations['designation_name'];
		$date_of_joining = $employee_detail['date_of_joining'];
	} else {
		$designation_name = '--';
		$date_of_joining = '--';
	}
	
} else {
	$payslip_data = $PayrollModel->where('company_id', $usession['sup_user_id'])->where('payslip_id', $payslip_id)->first();
	$user_data = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_id', $payslip_data['staff_id'])->first();
	// userdata
	
	if($user_data){
		$employee_detail = $StaffdetailsModel->where('user_id', $user_data['user_id'])->first();
		$idesignations = $DesignationModel->where('company_id', $usession['sup_user_id'])->where('designation_id',$employee_detail['designation_id'])->first();
		$designation_name = $idesignations['designation_name'];
		$date_of_joining = $employee_detail['date_of_joining'];
	} else {
		$designation_name = '--';
		$date_of_joining = '--';
	}
}
// salary options
$pay_allowance = $PayallowancesModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->findAll();
$pay_commission = $PaycommissionsModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->findAll();
$pay_otherpayment = $PayotherpaymentsModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->findAll();
$pay_statutory = $PaystatutorydeductionsModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->findAll();
// salary options || rows count
$count_pay_allowance = $PayallowancesModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->countAllResults();
$count_pay_commission = $PaycommissionsModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->countAllResults();
$count_pay_otherpayment = $PayotherpaymentsModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->countAllResults();
$count_pay_statutory = $PaystatutorydeductionsModel->where('payslip_id', $payslip_id)->where('staff_id', $payslip_data['staff_id'])->countAllResults();
$xin_system = erp_company_settings();
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
?>

<div class="row"> 
  <!-- [ Payslip ] start -->
  <div class="col-md-12"> 
    <!-- [ Payslip ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></h5>
          </div>
          <div class="card-body">
            <div class="row invoive-info d-pdrint-inline-flex justify-content-md-center">
              <div class="col-md-5">
                <h5 class="text-primary m-l-10"><?php echo lang('Payroll.xin_employee_pay_summary');?></h5>
                <table class="m-t-10 table table-responsive table-borderless">
                  <tbody>
                    <tr>
                      <th><?php echo lang('Dashboard.dashboard_employee');?> :</th>
                      <td>
					  <?php if($user_data){
							echo $emp_info = $user_data['first_name'].' '.$user_data['last_name'];
						} else {
							echo $emp_info = lang('Users.xin_user_data_removed');
						}
					  ?>
					  </td>
                    </tr>
                    <tr>
                      <th><?php echo lang('Dashboard.left_designation');?> :</th>
                      <td><span class="label label-warning">
                        <?= $designation_name;?>
                        </span></td>
                    </tr>
                    <tr>
                      <th><?php echo lang('Employees.xin_employee_doj');?> :</th>
                      <td><?= $date_of_joining;?></td>
                    </tr>
                    <tr>
                      <th><?php echo lang('Payroll.xin_pay_period');?> :</th>
                      <td><?= $payslip_data['salary_month'];?></td>
                    </tr>
                    <tr>
                      <th><?php echo lang('Payroll.xin_pay_date');?> :</th>
                      <td><?= $payslip_data['created_at'];?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <h5 class="m-b-10 text-primary text-uppercase"><?php echo lang('Payroll.xin_employee_net_pay');?></h5>
                <h4 class="text-uppercase text-primary m-l-30"> <strong>
                  <?= number_to_currency($payslip_data['net_salary'], $xin_system['default_currency'],null,2);?>
                  </strong> </h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table m-b-0 f-14 b-solid requid-table">
                    <thead>
                      <tr class="text-uppercase">
                        <th><?php echo lang('Payroll.xin_earning');?></th>
                        <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <tr>
                        <td class="text-success"><?php echo lang('Employees.xin_basic_salary');?></td>
                        <td class="text-success"><?= number_to_currency($payslip_data['basic_salary'], $xin_system['default_currency'],null,2);?></td>
                      </tr>
                      <?php $allowance_amount =0; if($count_pay_allowance > 0) { ?>
                      <?php foreach($pay_allowance as $_allowance):?>
                      <?php
							if($_allowance['is_fixed']==1){
								$is_fixed = lang('Employees.xin_title_tax_fixed');
							} else {
								$is_fixed = lang('Employees.xin_title_tax_percent');
							}
							if($_allowance['is_taxable']==0){
								$contract_tax_option = lang('Employees.xin_salary_allowance_non_taxable');
							} else if($_allowance['is_taxable']==2){
								$contract_tax_option = lang('Employees.xin_fully_taxable');
							} else {
								$contract_tax_option = lang('Employees.xin_partially_taxable');
							}
							$allowance_amount += $_allowance['pay_amount'];
						?>
                      <tr>
                        <td>
                          <?= $_allowance['pay_title'];?>
                          (
                          <?= $is_fixed;?>
                          ) (
                          <?= $contract_tax_option;?>
                          )</td>
                        <td><?= number_to_currency($_allowance['pay_amount'], $xin_system['default_currency'],null,2);?></td>
                      </tr>
                      <?php endforeach?>
                      <?php } ?>
                      <?php $commission_amount =0; if($count_pay_commission > 0) { ?>
                      <?php foreach($pay_commission as $_commission):?>
                      <?php
							if($_commission['is_fixed']==1){
								$is_cfixed = lang('Employees.xin_title_tax_fixed');
							} else {
								$is_cfixed = lang('Employees.xin_title_tax_percent');
							}
							if($_commission['is_taxable']==0){
								$ccontract_tax_option = lang('Employees.xin_salary_allowance_non_taxable');
							} else if($_commission['is_taxable']==2){
								$ccontract_tax_option = lang('Employees.xin_fully_taxable');
							} else {
								$ccontract_tax_option = lang('Employees.xin_partially_taxable');
							}
							$commission_amount += $_commission['pay_amount'];
						?>
                      <tr>
                        <td>
                          <?= $_commission['pay_title'];?>
                          (
                          <?= $is_cfixed;?>
                          ) (
                          <?= $ccontract_tax_option;?>
                          )</td>
                        <td><?= number_to_currency($_commission['pay_amount'], $xin_system['default_currency'],null,2);?></td>
                      </tr>
                      <?php endforeach?>
                      <?php } ?>
                      <?php $otherpayment_amount =0; if($count_pay_otherpayment > 0) { ?>
                      <?php foreach($pay_otherpayment as $_otherpayment):?>
                      <?php
							if($_otherpayment['is_fixed']==1){
								$is_ofixed = lang('Employees.xin_title_tax_fixed');
							} else {
								$is_ofixed = lang('Employees.xin_title_tax_percent');
							}
							if($_otherpayment['is_taxable']==0){
								$ocontract_tax_option = lang('Employees.xin_salary_allowance_non_taxable');
							} else if($_otherpayment['is_taxable']==2){
								$ocontract_tax_option = lang('Employees.xin_fully_taxable');
							} else {
								$ocontract_tax_option = lang('Employees.xin_partially_taxable');
							}
							$otherpayment_amount += $_otherpayment['pay_amount'];
						?>
                      <tr>
                        <td>
                          <?= $_otherpayment['pay_title'];?>
                          (
                          <?= $is_ofixed;?>
                          ) (
                          <?= $ocontract_tax_option;?>
                          )</td>
                        <td><?= number_to_currency($_otherpayment['pay_amount'], $xin_system['default_currency'],null,2);?></td>
                      </tr>
                      <?php endforeach?>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table m-b-0 f-14 b-solid requid-table">
                    <thead>
                      <tr class="text-uppercase">
                        <th><?php echo lang('Payroll.xin_deductions');?></th>
                        <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php $statutory_amount =0; if($count_pay_statutory > 0) { ?>
                      <?php foreach($pay_statutory as $_statutory):?>
                      <?php
							if($_statutory['is_fixed']==1){
								$is_sfixed = lang('Employees.xin_title_tax_fixed');
							} else {
								$is_sfixed = lang('Employees.xin_title_tax_percent');
							}
							$statutory_amount += $_statutory['pay_amount'];
						?>
                      <tr>
                        <td>
                          <?= $_statutory['pay_title'];?>
                          (
                          <?= $is_sfixed;?>
                          )</td>
                        <td><span class="text-danger">
                          <?= number_to_currency($_statutory['pay_amount'], $xin_system['default_currency'],null,2);?>
                          </span></td>
                      </tr>
                      <?php endforeach?>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <?php $total_earning = $payslip_data['basic_salary'] + $allowance_amount + $commission_amount + $otherpayment_amount;?>
            <?php $total_deduction = $statutory_amount;?>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-responsive invoice-table invoice-total">
                  <tbody>
                    <tr>
                      <th><?= lang('Payroll.xin_total_earning');?>
                        :</th>
                      <td><?= number_to_currency($total_earning, $xin_system['default_currency'],null,2);?></td>
                    </tr>
                    <tr>
                      <th><?= lang('Payroll.xin_total_deductions');?>
                        :</th>
                      <td><?= number_to_currency($total_deduction, $xin_system['default_currency'],null,2);?></td>
                    </tr>
                    <tr class="text-info">
                      <td><hr>
                        <h5 class="text-primary m-r-10"><?php echo lang('Payroll.xin_net_pay');?> :</h5></td>
                      <td><hr>
                        <h5 class="text-primary">
                          <?= number_to_currency($payslip_data['net_salary'], $xin_system['default_currency'],null,2);?>
                        </h5></td>
                    </tr>
                    <tr class="text-info">
                      <td colspan="2"><h5 class="text-primary">
                          <?= ucwords(convertNumberToWord($payslip_data['net_salary']));?>
                        </h5></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h6>
                  <?= lang('Payroll.xin_payslip_comments');?>
                  :</h6>
                <p>
                  <?= $payslip_data['pay_comments'];?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center d-print-none">
          <div class="col-sm-12 invoice-btn-group text-center">
            <button type="button" class="btn btn-print-invoice waves-effect waves-light btn-primary m-b-10">
            <?= lang('Main.xin_print');?>
            </button>
            <button type="button" class="btn waves-effect waves-light btn-secondary m-b-10 ">
            <?= lang('Main.xin_cancel');?>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Payslip ] end --> 
  </div>
</div>

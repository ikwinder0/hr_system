<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\DepartmentModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$DepartmentModel = new DepartmentModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user['user_type'] == 'staff'){
   $main_department = $DepartmentModel->where('company_id', $user['company_id'])->findAll();
   $staff_info = $UsersModel->where('company_id', $user['company_id'])->where('user_type','staff')->findAll();
} else {
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
}
$locale = service('request')->getLocale();
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('pay1',staff_role_resource()) || $user['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/payroll-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calculator"></span>
      <?= lang('Dashboard.left_payroll');?>
      <div class="text-muted small">
        <?= lang('Payroll.xin_setup_payroll');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('pay_history',staff_role_resource()) || $user['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/payslip-history');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice-dollar"></span>
      <?= lang('Dashboard.xin_payslip_history');?>
      <div class="text-muted small">
        <?= lang('Payroll.xin_view_payroll_history');?>
      </div>
   </a> </li>
   <?php } ?>
   <?php if(in_array('advance_salary1',staff_role_resource()) || $user['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/advance-salary');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice-dollar"></span>
      <?= lang('Main.xin_advance_salary');?>
      <div class="text-muted small">
        <?= lang('Main.xin_request_advance_salary');?>
      </div>
   </a> </li>
   <?php } ?>
   <?php if(in_array('loan1',staff_role_resource()) || $user['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/loan-request');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice-dollar"></span>
      <?= lang('Main.xin_loan');?>
      <div class="text-muted small">
        <?= lang('Main.xin_request_loan');?>
      </div>
   </a> </li>
   <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
  <div class="col-sm-12">
    <div class="card mb-2">
      <div class="card-body">
      <?php $attributes = array('name' => 'set_salary_details', 'id' => 'set_salary_details');?>
			  <?php $hidden = array('user_id' => 0);?>
              <?php echo form_open('ero/payroll/set_salary_details', $attributes, $hidden);?>
        <div class="row justify-content-center">
          <div class="col-sm-12">
            <div class="row align-items-center">
              <div class="col">
                <label for="department">
                  <?= lang('Dashboard.dashboard_employee');?>
                </label>
                <select id="staff_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>" name="staff_id">
                  <option value="0">
                  <?= lang('Payroll.xin_all_employees');?>
                  </option>
                  <?php foreach($staff_info as $_user) {?>
                  <option value="<?= $_user['user_id']?>">
                  <?= $_user['first_name'].' '.$_user['last_name'];?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col">
                <label class="form-label">
                  <?= lang('Payroll.xin_select_month');?>
                </label>
                <input class="form-control hr_month_year" placeholder="<?= lang('Payroll.xin_select_month');?>" id="month_year" name="month_year" type="text" value="<?= date('Y-m');?>">
              </div>
              <div class="col">
                <label class="form-label">&nbsp;</label>
                <br />
                <button type="submit" class="btn btn-primary"><i data-feather="search"></i></button>
              </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<div class="card user-profile-list">
  <div class="box-header with-border">
    <div id="accordion">
      <div class="card-header">
        <h5>
          <?= lang('Payroll.xin_payment_info_for');?>
          <span id="get_date">
          <?= date('Y-m');?></span>
        </h5>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?= lang('Dashboard.dashboard_employee');?></th>
            <th><?= lang('Employees.dashboard_employee_id');?></th>
            <th><?= lang('Employees.xin_employee_type_wages');?></th>
            <th><?= lang('Employees.xin_basic_salary');?></th>
            <th><?= lang('Employees.xin_payroll_net_salary');?></th>
            <th><?= lang('Main.dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>

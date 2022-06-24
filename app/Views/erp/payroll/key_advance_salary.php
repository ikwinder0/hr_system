<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AssetsModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();	
$SystemModel = new SystemModel();		
$ConstantsModel = new ConstantsModel();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','award_type')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','award_type')->findAll();
}
/* Awards view
*/
$get_animate = '';
?>
<?php if(in_array('award1',staff_role_resource()) || in_array('award_type1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('pay1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/payroll-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calculator"></span>
      <?= lang('Dashboard.left_payroll');?>
      <div class="text-muted small">
        <?= lang('Payroll.xin_setup_payroll');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('pay_history',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/payslip-history');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice-dollar"></span>
      <?= lang('Dashboard.xin_payslip_history');?>
      <div class="text-muted small">
        <?= lang('Payroll.xin_view_payroll_history');?>
      </div>
   </a> </li>
   <?php } ?>
   <?php if(in_array('advance_salary1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/advance-salary');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice-dollar"></span>
      <?= lang('Main.xin_advance_salary');?>
      <div class="text-muted small">
        <?= lang('Main.xin_request_advance_salary');?>
      </div>
   </a> </li>
   <?php } ?>
   <?php if(in_array('loan1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
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
<?php } ?>
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <?php if(in_array('advance_salary2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_advance_salary', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('_user' => 1);?>
      <?php echo form_open_multipart('erp/payroll/add_advance_salary', $attributes, $hidden);?>
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-2">
            <div id="accordion">
              <div class="card-header">
                <h5>
                  <?= lang('Main.xin_request_advance_salary');?>
                </h5>
                <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
                  <?= lang('Main.xin_hide');?>
                  </a> </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <?php if($user_info['user_type'] == 'company'){?>
                  <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="first_name">
                        <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
                      </label>
                      <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>">
                        <?php foreach($staff_info as $staff) {?>
                        <option value="<?= $staff['user_id']?>">
                        <?= $staff['first_name'].' '.$staff['last_name'] ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php $colmd = 'col-md-4'?>
                  <?php } else {?>
                  <?php $colmd = 'col-md-4'?>
                  <?php } ?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="month_year">
                        <?= lang('Employees.xin_award_month_year');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input class="form-control hr_month_year" placeholder="<?= lang('Employees.xin_award_month_year');?>" name="month_year" type="text">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cash">
                        <?= lang('Invoices.xin_amount');?> <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <div class="input-group-append"><span class="input-group-text">
                          <?= $xin_system['default_currency'];?>
                          </span></div>
                        <input class="form-control" placeholder="<?= lang('Invoices.xin_amount');?>" name="advance_amount" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label for="one_time_deduct">
                      <?= lang('Main.xin_one_time_deduct');?> <span class="text-danger">*</span>
                    </label>
                    <select class="form-control one_time_deduct" name="one_time_deduct" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_one_time_deduct');?>">
                      <option value="0">
                      <?= lang('Main.xin_no');?>
                      </option>
                      <option value="1">
                      <?= lang('Main.xin_yes');?>
                      </option>
                    </select>
                  </div>
                </div>
               <div class="col-md-4">
                <div class="form-group">
                  <label for="emi_amount">
                    <?= lang('Main.xin_emi_full_text');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <div class="input-group-append"><span class="input-group-text">
                      <?= $xin_system['default_currency'];?>
                      </span></div>
                    <input class="form-control" placeholder="<?= lang('Main.xin_emi_full_text');?>" name="emi_amount" id="monthly_installment" type="text" value="0">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="award_information">
                    <?= lang('Main.xin_reason');?> <span class="text-danger">*</span>
                  </label>
                  <textarea class="form-control" placeholder="<?= lang('Main.xin_reason');?>" name="reason" cols="30" rows="3" id="reason"></textarea>
                </div>
              </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
                <?= lang('Main.xin_reset');?>
                </button>
                &nbsp;
                <button type="submit" class="btn btn-primary">
                <?= lang('Main.xin_save');?>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?= form_close(); ?>
    </div>
    <?php } ?>
    <div class="card user-profile-list <?php echo $get_animate;?>">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Main.xin_advance_salary');?>
        </h5>
        <?php if(in_array('advance_salary2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
        <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
          <?= lang('Main.xin_add_new');?>
          </a> </div>
        <?php } ?>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th width="200"><?= lang('Dashboard.dashboard_employee');?></th>
                <th><?= lang('Invoices.xin_amount');?></th>
                <th> <?= lang('Employees.xin_award_month_year');?></th>
                <th> <?= lang('Main.xin_one_time_deduct');?></th>
                <th> <?= lang('Main.xin_emi');?></th>
                <th> <?= lang('Main.xin_created_at');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>

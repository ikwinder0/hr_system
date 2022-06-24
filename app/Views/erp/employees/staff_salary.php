<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\StaffdetailsModel;
//$encrypter = \Config\Services::encrypter();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$CountryModel = new CountryModel();
$ConstantsModel = new ConstantsModel();
$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$StaffdetailsModel = new StaffdetailsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

///
$segment_id = $request->uri->getSegment(3);
$user_id = udecode($segment_id);
$result = $UsersModel->where('user_id', $user_id)->first();
$employee_detail = $StaffdetailsModel->where('user_id', $result['user_id'])->first();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->where('department_id',$employee_detail['department_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->where('department_id',$employee_detail['department_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
}

$all_countries = $CountryModel->orderBy('country_id', 'ASC')->findAll();
$religion = $ConstantsModel->where('type','religion')->orderBy('constants_id', 'ASC')->findAll();
$roles = $RolesModel->orderBy('role_id', 'ASC')->findAll();
$selected_shift = $ShiftModel->where('office_shift_id', $employee_detail['office_shift_id'])->first();
?>
<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <ul class="nav nav-tabs step-anchor">
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-details/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon ion lnr lnr-users"></span> <span class="sw-icon lnr lnr-users"></span> <?= lang('xin_general');?>
        <div class="text-muted small"><?= lang('xin_e_details_basic');?></div>
        </a> </li>
      <?php //if(in_array('351',$role_resources_ids)) { ?>  
      <li class="nav-item active"> <a href="<?= site_url('erp/employee-salary/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-highlight"></span> <span class="sw-icon lnr lnr-highlight"></span> <?= lang('xin_employee_set_salary');?>
        <div class="text-muted small"><?= lang('xin_set_up').' '. lang('xin_employee_set_salary');?></div>
        </a> </li>
        <?php //} ?>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-leave/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-calendar-full"></span> <span class="sw-icon lnr lnr-calendar-full"></span> <?= lang('left_leaves');?>
        <div class="text-muted small"><?= lang('xin_view_leave_all');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-corehr/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-earth"></span> <span class="sw-icon lnr lnr-earth"></span> <?= lang('xin_hr');?>
        <div class="text-muted small"><?= lang('xin_view_core_hr_modules');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-projects-tasks/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-layers"></span> <span class="sw-icon lnr lnr-layers"></span> <?= lang('xin_hr_m_project_task');?>
        <div class="text-muted small"><?= lang('xin_view_all_projects');?></div>
        </a> </li>
      <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-payslip/').$segment_id;?>" class="mb-3 nav-link"> <span class="sw-done-icon lnr lnr-keyboard"></span> <span class="sw-icon lnr lnr-keyboard"></span> <?= lang('left_payslips');?>
        <div class="text-muted small"><?= lang('xin_view_payslips_all');?></div>
        </a> </li>
    </ul>
    <hr class="border-light mb-3 m-0">
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-update_salary"> <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?= lang('xin_employee_update_salary');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-allowances"> <i class="lnr lnr-car text-lightest"></i> &nbsp; <?= lang('xin_employee_set_allowances');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-commissions"> <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp; <?= lang('xin_hr_commissions');?></a>  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-statutory_deductions"> <i class="lnr lnr-store text-lightest"></i> &nbsp; <?= lang('xin_employee_set_statutory_deductions');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-other_payment"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?= lang('xin_employee_set_other_payment');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-overtime"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?= lang('dashboard_overtime');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-loan_deductions"> <i class="lnr lnr-location text-lightest"></i> &nbsp; <?= lang('xin_employee_set_loan_deductions');?></a></div>
    </div>
    <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-update_salary">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_salary', 'id' => 'employee_update_salary', 'autocomplete' => 'off');?>
                      <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                      <?= form_open('admin/employees/update_salary_option', $attributes, $hidden);?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="wages_type"><?= lang('xin_employee_type_wages');?><i class="ici-star">*</i></label>
                              <select name="wages_type" id="wages_type" class="form-control" data-plugin="select_hrm">
                                <option value="1" <?php if($wages_type==1):?> selected="selected"<?php endif;?>><?= lang('xin_payroll_basic_salary');?></option>
                                <option value="2" <?php if($wages_type==2):?> selected="selected"<?php endif;?>><?= lang('xin_employee_daily_wages');?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="basic_salary"><?= lang('xin_salary_title');?><i class="ici-star">*</i></label>
                              <input class="form-control basic_salary" placeholder="<?= lang('xin_salary_title');?>" name="basic_salary" type="text" value="<?= $basic_salary;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?= form_button(array('name' => 'ci_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.lang('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-allowances">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_list_all');?></strong> <?= lang('xin_employee_set_allowances');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_allowances" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?= lang('xin_action');?></th>
                                <th><?= lang('dashboard_xin_title');?></th>
                                <th><?= lang('xin_amount');?></th>
                                <th><?= lang('xin_salary_allowance_options');?></th>
                                <th><?= lang('xin_amount_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_employee_set_allowances');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_allowance', 'id' => 'employee_update_allowance', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?= form_open('admin/employees/employee_allowance_option', $attributes, $hidden);?>
                      <?php
                              $data_usr4 = array(
                                'type'  => 'hidden',
                                'name'  => 'user_id',
                                'value' => $user_id,
                             );
                            echo form_input($data_usr4);
                          ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_allowance_taxable"><?= lang('xin_salary_allowance_options');?><i class="ici-star">*</i></label>
                            <select name="is_allowance_taxable" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?= lang('xin_salary_allowance_non_taxable');?></option>
                              <option value="1"><?= lang('xin_fully_taxable');?></option>
                              <option value="2"><?= lang('xin_partially_taxable');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount_option"><?= lang('xin_amount_option');?><i class="ici-star">*</i></label>
                            <select name="amount_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?= lang('xin_title_tax_fixed');?></option>
                              <option value="1"><?= lang('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="account_title"><?= lang('dashboard_xin_title');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('dashboard_xin_title');?>" name="allowance_title" type="text" value="" id="allowance_title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="account_number"><?= lang('xin_amount');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_amount');?>" name="allowance_amount" type="text" value="" id="allowance_amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?= form_button(array('name' => 'ci_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.lang('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-commissions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_list_all');?></strong> <?= lang('xin_hr_commissions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_commissions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?= lang('xin_action');?></th>
                                <th><?= lang('dashboard_xin_title');?></th>
                                <th><?= lang('xin_amount');?></th>
                                <th><?= lang('xin_salary_commission_options');?></th>
                                <th><?= lang('xin_amount_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_hr_commissions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_commissions', 'id' => 'employee_update_commissions', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?= form_open('admin/employees/employee_commissions_option', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_commission_taxable"><?= lang('xin_salary_commission_options');?><i class="ici-star">*</i></label>
                            <select name="is_commission_taxable" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?= lang('xin_salary_allowance_non_taxable');?></option>
                              <option value="1"><?= lang('xin_fully_taxable');?></option>
                              <option value="2"><?= lang('xin_partially_taxable');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount_option"><?= lang('xin_amount_option');?><i class="ici-star">*</i></label>
                            <select name="amount_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?= lang('xin_title_tax_fixed');?></option>
                              <option value="1"><?= lang('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="title"><?= lang('dashboard_xin_title');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount"><?= lang('xin_amount');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?= form_button(array('name' => 'ci_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.lang('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-loan_deductions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_list_all');?></strong> <?= lang('xin_employee_set_loan_deductions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_deductions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?= lang('xin_action');?></th>
                                <th><?= lang('xin_employee_set_loan_deductions');?></th>
                                <th><?= lang('xin_employee_monthly_installment_title');?></th>
                                <th><?= lang('xin_employee_loan_time');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_employee_set_loan_deductions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'add_loan_info', 'id' => 'add_loan_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?= form_open('admin/employees/employee_loan_info', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
									'type'  => 'hidden',
									'name'  => 'user_id',
									'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="loan_options"><?= lang('xin_salary_loan_options');?><i class="ici-star">*</i></label>
                            <select name="loan_options" id="loan_options" class="form-control" data-plugin="select_hrm">
                              <option value="1"><?= lang('xin_loan_ssc_title');?></option>
                              <option value="2"><?= lang('xin_loan_hdmf_title');?></option>
                              <option value="0"><?= lang('xin_loan_other_sd_title');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="month_year"><?= lang('dashboard_xin_title');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('dashboard_xin_title');?>" name="loan_deduction_title" type="text">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="edu_role"><?= lang('xin_employee_monthly_installment_title');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_employee_monthly_installment_title');?>" name="monthly_installment" type="text" id="m_monthly_installment">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="month_year"><?= lang('xin_start_date');?><i class="ici-star">*</i></label>
                            <input class="form-control date" placeholder="<?= lang('xin_start_date');?>" readonly="readonly" name="start_date" type="text">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="end_date"><?= lang('xin_end_date');?><i class="ici-star">*</i></label>
                            <input class="form-control date" readonly="readonly" placeholder="<?= lang('xin_end_date');?>" name="end_date" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description"><?= lang('xin_reason');?></label>
                            <textarea class="form-control textarea" placeholder="<?= lang('xin_reason');?>" name="reason" cols="30" rows="2" id="reason2"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?= form_button(array('name' => 'ci_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.lang('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-statutory_deductions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_list_all');?></strong> <?= lang('xin_employee_set_statutory_deductions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_statutory_deductions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?= lang('xin_action');?></th>
                                <th><?= lang('dashboard_xin_title');?></th>
                                <th><?= lang('xin_amount');?></th>
                                <th><?= lang('xin_salary_sd_options');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_employee_set_statutory_deductions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'statutory_deductions_info', 'id' => 'statutory_deductions_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?= form_open('admin/employees/set_statutory_deductions', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="statutory_options"><?= lang('xin_salary_sd_options');?><i class="ici-star">*</i></label>
                            <select name="statutory_options" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?= lang('xin_title_tax_fixed');?></option>
                              <option value="1"><?= lang('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label for="title"><?= lang('dashboard_xin_title');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount"><?= lang('xin_amount');?>
                              <i class="ici-star">*</i> </label>
                            <input class="form-control" placeholder="<?= lang('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?= form_button(array('name' => 'ci_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.lang('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-other_payment">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_list_all');?></strong> <?= lang('xin_employee_set_other_payment');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_other_payments" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?= lang('xin_action');?></th>
                                <th><?= lang('dashboard_xin_title');?></th>
                                <th><?= lang('xin_amount');?></th>
                                <th><?= lang('xin_salary_otherpayment_options');?></th>
                                <th><?= lang('xin_amount_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_employee_set_other_payment');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'other_payments_info', 'id' => 'other_payments_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?= form_open('admin/employees/set_other_payments', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_otherpayment_taxable"><?= lang('xin_salary_otherpayment_options');?><i class="ici-star">*</i></label>
                            <select name="is_otherpayment_taxable" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?= lang('xin_salary_allowance_non_taxable');?></option>
                              <option value="1"><?= lang('xin_fully_taxable');?></option>
                              <option value="2"><?= lang('xin_partially_taxable');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount_option"><?= lang('xin_amount_option');?><i class="ici-star">*</i></label>
                            <select name="amount_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?= lang('xin_title_tax_fixed');?></option>
                              <option value="1"><?= lang('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="title"><?= lang('dashboard_xin_title');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount"><?= lang('xin_amount');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?= form_button(array('name' => 'ci_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.lang('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-overtime">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('xin_list_all');?></strong> <?= lang('dashboard_overtime');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_emp_overtime" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?= lang('xin_action');?></th>
                                <th><?= lang('xin_employee_overtime_title');?></th>
                                <th><?= lang('xin_employee_overtime_no_of_days');?></th>
                                <th><?= lang('xin_employee_overtime_hour');?></th>
                                <th><?= lang('xin_employee_overtime_rate');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?= lang('dashboard_overtime');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'overtime_info', 'id' => 'overtime_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?= form_open('admin/employees/set_overtime', $attributes, $hidden);?>
                      <?php
						  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
						 );
						echo form_input($data_usr4);
					  ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_type"><?= lang('xin_employee_overtime_title');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_employee_overtime_title');?>" name="overtime_type" type="text" value="" id="overtime_type">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="no_of_days"><?= lang('xin_employee_overtime_no_of_days');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_employee_overtime_no_of_days');?>" name="no_of_days" type="text" value="" id="no_of_days">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_hours"><?= lang('xin_employee_overtime_hour');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_employee_overtime_hour');?>" name="overtime_hours" type="text" value="" id="overtime_hours">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_rate"><?= lang('xin_employee_overtime_rate');?><i class="ici-star">*</i></label>
                            <input class="form-control" placeholder="<?= lang('xin_employee_overtime_rate');?>" name="overtime_rate" type="text" value="" id="overtime_rate">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?= form_button(array('name' => 'ci_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.lang('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?> </div>
                  </div>
                </div>
              </div>
  </div>
</div>
</div></div>
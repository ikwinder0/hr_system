<?php
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\ShiftModel;
use App\Models\ConstantsModel;
use App\Models\SystemModel;

$DepartmentModel = new DepartmentModel();
$DesignationModel = new DesignationModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();
$ShiftModel = new ShiftModel();
$SystemModel = new SystemModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$departments = $DepartmentModel->where('company_id',$user_info['company_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$user_info['company_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$user_info['company_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$user_info['company_id'])->orderBy('role_id', 'ASC')->findAll();
} else {
	$departments = $DepartmentModel->where('company_id',$usession['sup_user_id'])->orderBy('department_id', 'ASC')->findAll();
	$designations = $DesignationModel->where('company_id',$usession['sup_user_id'])->orderBy('designation_id', 'ASC')->findAll();
	$office_shifts = $ShiftModel->where('company_id',$usession['sup_user_id'])->orderBy('office_shift_id', 'ASC')->findAll();
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$roles = $RolesModel->where('company_id',$usession['sup_user_id'])->orderBy('role_id', 'ASC')->findAll();
}
		

$xin_system = $SystemModel->where('setting_id', 1)->first();
$employee_id = generate_random_employeeid();
$get_animate='';
?>
<?php if(in_array('staff2',staff_role_resource()) || in_array('shift1',staff_role_resource()) || in_array('staffexit1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('staff2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/staff-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-friends"></span>
      <?= lang('Dashboard.dashboard_employees');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.dashboard_employees');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if($user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/set-roles');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-lock"></span>
      <?= lang('Main.xin_roles_privileges');?>
      <div class="text-muted small">
        <?= lang('Dashboard.left_set_roles');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('shift1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/office-shifts');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-clock"></span>
      <?= lang('Dashboard.left_office_shifts');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_manage_shifts');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('staffexit1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/employee-exit');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-log-out"></span>
      <?= lang('Dashboard.left_employees_exit');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_employees_exit');?>
      </div>
      </a> </li>
     <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<?php if(in_array('staff3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="accordion">
  <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
    <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => 0);?>
    <?= form_open_multipart('erp/employees/add_employee', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-8">
        <div class="card mb-2">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Dashboard.dashboard_employee');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="company_name">
                    <?= lang('Main.xin_employee_first_name');?>
                    <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input type="text" class="form-control" placeholder="<?= lang('Main.xin_employee_first_name');?>" name="first_name">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="last_name" class="control-label">
                    <?= lang('Main.xin_employee_last_name');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input type="text" class="form-control" placeholder="<?= lang('Main.xin_employee_last_name');?>" name="last_name">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="employee_id">
                    <?= lang('Employees.dashboard_employee_id');?>
                  </label>
                  <span class="text-danger">*</span>
                  <input class="form-control" placeholder="<?= lang('Employees.dashboard_employee_id');?>" name="employee_id" type="text" value="<?php echo $employee_id;?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_number">
                    <?= lang('Main.xin_contact_number');?>
                    <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_contact_number');?>" name="contact_number" type="text">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="gender" class="control-label">
                    <?= lang('Main.xin_employee_gender');?>
                  </label>
                  <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_gender');?>">
                    <option value="1">
                    <?= lang('Main.xin_gender_male');?>
                    </option>
                    <option value="2">
                    <?= lang('Main.xin_gender_female');?>
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Main.xin_email');?>
                    <span class="text-danger">*</span> </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.xin_email');?>" name="email" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">
                    <?= lang('Main.dashboard_username');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.dashboard_username');?>" name="username" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="website">
                    <?= lang('Main.xin_employee_password');?>
                    <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-eye-slash"></i></span></div>
                    <input class="form-control" placeholder="<?= lang('Main.xin_employee_password');?>" name="password" type="text">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="office_shift_id" class="control-label">
                    <?= lang('Employees.xin_employee_office_shift');?>
                  </label>
                  <span class="text-danger">*</span>
                  <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_employee_office_shift');?>">
                    <option value="">
                    <?= lang('Employees.xin_employee_office_shift');?>
                    </option>
                    <?php foreach($office_shifts as $ioffice_shift):?>
                    <option value="<?= $ioffice_shift['office_shift_id'];?>">
                    <?= $ioffice_shift['shift_name'];?>
                    </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="role">
                    <?= lang('Main.xin_employee_role');?>
                    <span class="text-danger">*</span></label>
                  <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_employee_role');?>">
                    <option value=""></option>
                    <?php foreach($roles as $role) {?>
                    <?php /*?><?php if($iuser[0]->user_role_id==1):?>
                    <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                  <?php else:?><?php */?>
                    <?php //if($role->role_id!=1):?>
                    <option value="<?php echo $role['role_id']?>"><?php echo $role['role_name']?></option>
                    <?php //endif;?>
                    <?php /*?><?php endif;?><?php */?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="department">
                    <?= lang('Dashboard.left_department');?>
                  </label>
                  <span class="text-danger">*</span>
                  <select class="form-control" name="department_id" id="department_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>">
                    <option value="">
                    <?= lang('Dashboard.left_department');?>
                    </option>
                    <?php foreach($departments as $idepartment):?>
                    <option value="<?= $idepartment['department_id'];?>">
                    <?= $idepartment['department_name'];?>
                    </option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-6" id="designation_ajax">
                <div class="form-group">
                  <label for="designation">
                    <?= lang('Dashboard.left_designation');?>
                  </label>
                  <span class="text-danger">*</span>
                  <select class="form-control" disabled="disabled" name="designation_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_designation');?>">
                    <option value="">
                    <?= lang('Dashboard.left_designation');?>
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                    <label>
                      <?= lang('Employees.xin_basic_salary');?>
                      <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text">
                        <?= $xin_system['default_currency'];?>
                        </span></div>
                      <input type="text" class="form-control" name="basic_salary" placeholder="<?= lang('Employees.xin_gross_salary');?>" value="0">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>
                      <?= lang('Employees.xin_hourly_rate');?>
                      <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text">
                        <?= $xin_system['default_currency'];?>
                        </span></div>
                      <input type="text" class="form-control" name="hourly_rate" placeholder="<?= lang('Employees.xin_hourly_rate');?>" value="0">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="salay_type">
                      <?= lang('Employees.xin_employee_type_wages');?>
                      <i class="text-danger">*</i></label>
                    <select name="salay_type" id="salay_type" class="form-control" data-plugin="select_hrm">
                      <option value="1">
                      <?= lang('Membership.xin_per_month');?>
                      </option>
                      <?php /*?><option value="2">
                      <?= lang('Membership.xin_per_hour');?>
                      </option><?php */?>
                    </select>
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
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_e_details_profile_picture');?>
            </h5>
          </div>
          <div class="card-body py-2">
            <div class="row">
              <div class="col-md-12">
                <label for="logo">
                  <?= lang('Main.xin_e_details_profile_picture');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file">
                  <label class="custom-file-label">
                    <?= lang('Main.xin_choose_file');?>
                  </label>
                  <small>
                  <?= lang('Main.xin_company_file_type');?>
                  </small> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?= form_close(); ?>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.dashboard_employees');?>
    </h5>
    <div class="card-header-right"> <a href="<?= site_url().'erp/staff-grid';?>" class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_grid_view');?>"> <i class="fas fa-th-large"></i> </a> 
    <?php if(in_array('staff3',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <a data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
    </a>
    <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?= lang('Main.xin_name');?></th>
            <th><?= lang('Dashboard.left_designation');?></th>
            <th><?= lang('Main.xin_contact_number');?></th>
            <th><?= lang('Main.xin_employee_gender');?></th>
            <th><?= lang('Main.xin_country');?></th>
            <th><?= lang('Main.xin_employee_role');?></th>
            <th><?= lang('Main.dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

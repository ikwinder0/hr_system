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
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','exit_type')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','exit_type')->findAll();
}
/* Assets view
*/
$get_animate = '';
?>
<?php if(in_array('staff2',staff_role_resource()) || in_array('shift1',staff_role_resource()) || in_array('staffexit1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('staff2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/staff-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-friends"></span>
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
    <li class="nav-item active"> <a href="<?= site_url('erp/employee-exit');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-log-out"></span>
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
<?php if(in_array('staffexit2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_exit', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/leaving/add_exit', $attributes, $hidden);?>
      <div class="row">
        <div class="col-md-8">
          <div class="card mb-2 <?php echo $get_animate;?>">
            <div id="accordion">
              <div class="card-header">
                <h5>
                  <?= lang('Main.xin_add_new');?>
                  <?= lang('Employees.xin_employee_exit');?>
                </h5>
                <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
                  <?= lang('Main.xin_hide');?>
                  </a> </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <?php if($user_info['user_type'] == 'company'){?>
                  <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name">
                        <?= lang('Employees.xin_employee_to_exit');?>
                        <span class="text-danger">*</span> </label>
                      <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_employee_to_exit');?>">
                        <?php foreach($staff_info as $staff) {?>
                        <option value="<?= $staff['user_id']?>">
                        <?= $staff['first_name'].' '.$staff['last_name'] ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <?php } ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exit_date">
                        <?= lang('Employees.xin_exit_date');?>
                        <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input class="form-control date" placeholder="<?= lang('Employees.xin_exit_date');?>" name="exit_date" type="text">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="type">
                        <?= lang('Employees.xin_exit_type');?>
                        <span class="text-danger">*</span></label>
                      <select class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_type_of_exit');?>" name="exit_type">
                        <option value=""></option>
                        <?php foreach($category_info as $icategory) {?>
                        <option value="<?= $icategory['constants_id']?>">
                        <?= $icategory['category_name']?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exit_interview">
                        <?= lang('Employees.xin_exit_interview');?>
                        <span class="text-danger">*</span></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_exit_interview');?>" name="exit_interview">
                        <option value="1">
                        <?= lang('Main.xin_yes');?>
                        </option>
                        <option value="0">
                        <?= lang('Main.xin_no');?>
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="is_inactivate_account">
                        <?= lang('Employees.xin_exit_inactive_employee_account');?>
                        <span class="text-danger">*</span></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_exit_inactive_employee_account');?>" name="is_inactivate_account">
                        <option value="1">
                        <?= lang('Main.xin_yes');?>
                        </option>
                        <option value="0">
                        <?= lang('Main.xin_no');?>
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description">
                        <?= lang('Main.xin_description');?>
                      </label>
                      <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="reason" rows="5" id="reason"></textarea>
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
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5>
                <?= lang('Employees.xin_exit_contract');?>
              </h5>
            </div>
            <div class="card-body py-2">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="logo">
                      <?= lang('Main.xin_attachment');?>
                      </label>
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
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<?php } ?>
<div class="card user-profile-list <?php echo $get_animate;?>">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Employees.xin_employee_exit');?>
    </h5>
    <div class="card-header-right">
    <?php if(in_array('exit_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    	<a href="<?= site_url('erp/exit-type');?>" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="plus"></i>
      <?= lang('Employees.xin_exit_type');?>
      </a> 
      <?php }?>
      <?php if(in_array('staffexit2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a>
      <?php }?>
      </div>
  </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th width="200"><i class="fa fa-user"></i>
              <?= lang('Employees.xin_employee_to_exit');?></th>
            <th><?= lang('Employees.xin_exit_type');?></th>
            <th><i class="fa fa-calendar"></i>
              <?= lang('Employees.xin_exit_date');?></th>
            <th><?= lang('Employees.xin_exit_interview');?></th>
            <th><?= lang('Employees.xin_exit_inactive_employee_account');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

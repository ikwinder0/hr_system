<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\WarningModel;
use App\Models\ConstantsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();		
$ConstantsModel = new ConstantsModel();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','warning_type')->findAll();
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_id!=', $usession['sup_user_id'])->where('user_type','staff')->findAll();
} else {
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','warning_type')->findAll();
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
}
/* Warning view
*/
$get_animate = '';
?>
<?php if(in_array('disciplinary1',staff_role_resource()) || in_array('case_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('disciplinary1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/disciplinary-cases');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-alert-circle"></span>
      <?= lang('Dashboard.left_warnings');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_warnings');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('case_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/case-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Employees.xin_case_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Employees.xin_case_type');?>
      </div>
    </a> </li>
   <?php } ?> 
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<?php if(in_array('disciplinary2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
  <?php $attributes = array('name' => 'add_warning', 'id' => 'xin-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('user_id' => 1);?>
  <?php echo form_open('erp/warning/add_warning', $attributes, $hidden);?>
  <div class="row">
    <div class="col-md-8">
      <div class="card mb-2 <?php echo $get_animate;?>">
        <div id="accordion">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Dashboard.left_case');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="warning_to">
                    <?= lang('Dashboard.dashboard_employee');?> <span class="text-danger">*</span>
                  </label>
                  <select name="warning_to" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>">
                    <option value=""></option>
                    <?php foreach($staff_info as $staff) {?>
                    <option value="<?= $staff['user_id']?>">
                    <?= $staff['first_name'].' '.$staff['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="type">
                    <?= lang('Employees.xin_case_type');?> <span class="text-danger">*</span>
                  </label>
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_case_type');?>" name="warning_type">
                    <option value=""></option>
                    <?php foreach($category_info as $assets_category) {?>
                    <option value="<?= $assets_category['constants_id']?>">
                    <?= $assets_category['category_name']?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="subject">
                    <?= lang('Main.xin_subject');?> <span class="text-danger">*</span>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Main.xin_subject');?>" name="subject" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="warning_date">
                    <?= lang('Employees.xin_case_date');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?= lang('Employees.xin_case_date');?>" name="warning_date" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description">
                    <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
                  </label>
                  <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="3"></textarea>
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
            <?= lang('Employees.xin_case_attachment');?>
          </h5>
        </div>
        <div class="card-body py-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="logo">
                  <?= lang('Main.xin_attachment');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="attachment">
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
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.left_cases');?>
    </h5>
    <?php if(in_array('disciplinary2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
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
            <th><i class="fa fa-user"></i>
              <?= lang('Dashboard.dashboard_employee');?></th>
            <th><?= lang('Employees.xin_case_type');?></th>
            <th><i class="fa fa-calendar"></i>
              <?= lang('Employees.xin_case_date');?></th>
            <th><?= lang('Main.xin_subject');?></th>
            <th><i class="fa fa-user"></i>
              <?= lang('Employees.xin_case_by');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

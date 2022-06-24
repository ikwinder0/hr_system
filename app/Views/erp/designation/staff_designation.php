<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\DepartmentModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$DepartmentModel = new DepartmentModel();
$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
   $main_department = $DepartmentModel->where('company_id', $user_info['company_id'])->findAll();
} else {
	$main_department = $DepartmentModel->where('company_id', $usession['sup_user_id'])->findAll();
}
$get_animate ='';
?>
<?php if(in_array('news1',staff_role_resource()) || in_array('department1',staff_role_resource()) || in_array('designation1',staff_role_resource()) || in_array('policy1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('department1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/departments-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-align-justify"></span>
      <?= lang('Dashboard.left_department');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_departments');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('designation1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/designation-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-list"></span>
      <?= lang('Dashboard.left_designation');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_designations');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('news1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/news-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-speaker"></span>
      <?= lang('Dashboard.left_announcements');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_announcements');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('policy1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/policies-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-pocket"></span>
      <?= lang('Dashboard.header_policies');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.header_policies');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php if(in_array('designation2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_add_new');?>
        </strong>
        <?= lang('Dashboard.left_designation');?>
        </span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_designation', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 1);?>
        <?php echo form_open('erp/designation/add_designation', $attributes, $hidden);?>
        <div class="form-group" id="department_ajax">
          <label for="name">
            <?= lang('Dashboard.left_department');?> <span class="text-danger">*</span>
          </label>
          <select class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.left_department');?>" name="department">
            <option value=""></option>
            <?php foreach($main_department as $idepartment) {?>
            <option value="<?= $idepartment['department_id']?>">
            <?= $idepartment['department_name']?>
            </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="name">
            <?= lang('Dashboard.left_designation_name');?> <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control" name="designation_name" placeholder="<?= lang('Dashboard.left_designation_name');?>">
        </div>
        <div class="form-group">
          <label for="description">
            <?= lang('Main.xin_description');?>
          </label>
          <textarea type="text" class="form-control" name="description" placeholder="<?= lang('Main.xin_description');?>"></textarea>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
        <?= lang('Main.xin_save');?>
        </button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card user-profile-list">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_list_all');?>
        </strong>
        <?= lang('Dashboard.left_designations');?>
        </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?= lang('Dashboard.left_designation');?></th>
                <th><?= lang('Dashboard.left_department');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

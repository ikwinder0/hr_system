<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<?php if(in_array('news1',staff_role_resource()) || in_array('department1',staff_role_resource()) || in_array('designation1',staff_role_resource()) || in_array('policy1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('department1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/departments-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-align-justify"></span>
      <?= lang('Dashboard.left_department');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_departments');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('designation1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/designation-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-list"></span>
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
<div class="row m-b-1">
  <?php if(in_array('department2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_add_new');?>
        </strong>
        <?= lang('Dashboard.left_department');?>
        </span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_department', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 1);?>
        <?php echo form_open('erp/department/add_department', $attributes, $hidden);?>
        <div class="form-group">
          <label for="name">
            <?= lang('Dashboard.xin_name');?> <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control" name="department_name" placeholder="<?= lang('Dashboard.xin_name');?>">
        </div>
        <?php if($user_info['user_type'] == 'company'){?>
        <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="first_name">
                <?= lang('Dashboard.xin_department_head');?>
              </label>
              <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_department_head');?>">
                <option value=""><?= lang('Dashboard.xin_department_head');?></option>
				<?php foreach($staff_info as $staff) {?>
                <option value="<?= $staff['user_id']?>">
                <?= $staff['first_name'].' '.$staff['last_name'] ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <?php } ?>
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
  <?php  } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card user-profile-list">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_list_all');?>
        </strong>
        <?= lang('Dashboard.left_departments');?>
        </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?= lang('Dashboard.xin_department_name');?></th>
                <th><i class="fa fa-user small"></i>
                  <?= lang('Dashboard.xin_department_head');?></th>
                <th><i class="far fa-calendar-alt small"></i>
                  <?= lang('Main.xin_created_at');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

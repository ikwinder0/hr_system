<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\AssetsModel;
use App\Models\AssetscategoryModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
/*
* Leave Type - View Page
*/
?>
<?php if(in_array('leave2',staff_role_resource()) || in_array('leave_calendar',staff_role_resource()) || in_array('leave_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('leave2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/leave-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-plus-square"></span>
      <?= lang('Dashboard.xin_manage_leaves');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Leave.left_leave');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('leave_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/leave-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Leave.xin_leave_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Leave.xin_leave_type');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('leave_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/leave-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Leave.xin_leave_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row m-b-1 animated fadeInRight">
  <?php if(in_array('leave_type2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_add_new');?>
        </strong>
        <?= lang('Leave.xin_leave_type');?>
        </span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_leave_type', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?= form_open('erp/types/add_leave_type', $attributes, $hidden);?>
        <div class="form-group">
          <label for="name">
            <?= lang('Leave.xin_leave_type');?>
            <span class="text-danger">*</span> </label>
          <input type="text" class="form-control" name="name" placeholder="<?= lang('Leave.xin_leave_type');?>">
        </div>
        <div class="form-group">
          <label for="name">
            <?= lang('Leave.xin_leave_days_per_year');?>
            <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="days_per_year" placeholder="<?= lang('Leave.xin_leave_days_per_year');?>">
        </div>
        <div class="form-group">
          <label for="gender" class="control-label">
            <?= lang('Leave.left_requires_approval');?>
          </label>
          <select class="form-control" name="requires_approval" data-plugin="select_hrm" data-placeholder="<?= lang('Leave.left_requires_approval');?>">
            <option value="1">
            <?= lang('Main.xin_yes');?>
            </option>
            <option value="0">
            <?= lang('Main.xin_no');?>
            </option>
          </select>
          <small class="form-text text-muted">
          <?= lang('Leave.left_requires_approval_text');?>
          </small> </div>
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
  <div class="<?= $colmdval;?>">
    <div class="card user-profile-list">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_list_all');?>
        </strong>
        <?= lang('Leave.xin_leave_type');?>
        </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><i class="fas fa-braille"></i>
                  <?= lang('Leave.xin_leave_type');?></th>
                <th> <?= lang('Leave.xin_leave_days_per_year');?></th>
                <th> <?= lang('Leave.left_requires_approval');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

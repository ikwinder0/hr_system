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
<?php if(in_array('holiday1',staff_role_resource()) || in_array('holidays_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('holiday1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/holidays-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-sun"></span>
      <?= lang('Dashboard.left_holidays');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_holidays');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('holidays_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/holidays-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Employees.xin_holidays_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row m-b-1">
<?php if(in_array('holiday2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_add_new');?>
        </strong>
        <?= lang('Dashboard.left_holiday');?>
        </span> </div>
      <?php $attributes = array('name' => 'add_holiday', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/holidays/add_holiday', $attributes, $hidden);?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="name">
                <?= lang('Conference.xin_event_title');?> <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" name="event_name" placeholder="<?= lang('Conference.xin_event_title');?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="start_date">
                <?= lang('Projects.xin_start_date');?> <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="start_date" type="text">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="end_date">
                <?= lang('Projects.xin_end_date');?> <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="end_date" type="text">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description">
                <?= lang('Main.xin_description');?> <span class="text-danger">*</span>
              </label>
              <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" id="description"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="is_publish">
                <?= lang('Main.dashboard_xin_status');?>
              </label>
              <select name="is_publish" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                <option value="1">
                <?= lang('Recruitment.xin_published');?>
                </option>
                <option value="0">
                <?= lang('Recruitment.xin_published');?>
                </option>
              </select>
            </div>
          </div>
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
        <?= lang('Dashboard.left_holidays');?>
        </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th width="200"><?= lang('Conference.xin_event_title');?></th>
                <th><i class="fa fa-calendar"></i>
                  <?= lang('Projects.xin_start_date');?></th>
                <th><i class="fa fa-calendar"></i>
                  <?= lang('Projects.xin_end_date');?></th>
                <th><?= lang('Main.dashboard_xin_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>

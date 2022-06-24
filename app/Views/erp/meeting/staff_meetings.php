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
<?php if(in_array('conference1',staff_role_resource()) || in_array('conference_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('conference1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/meeting-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_hr_meetings');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Conference.xin_conference');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('conference_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/meetings-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-check"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Conference.xin_conference_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row m-b-1">
  <?php if(in_array('conference2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_add_new');?>
        </strong>
        <?= lang('Dashboard.xin_hr_meetings');?>
        </span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_meeting', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
        <?php $hidden = array('user_id' => 1);?>
        <?php echo form_open('erp/conference/add_meeting', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-12"> </div>
        </div>
        <?php if($user_info['user_type'] == 'company'){?>
        <?php $staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" value="0" name="employee_id[]" />
              <label for="first_name">
                <?= lang('Dashboard.dashboard_employees');?>
              </label>
              <select class="form-control" multiple="multiple" name="employee_id[]" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employees');?>">
                <option value=""></option>
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
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="meeting_title">
                <?= lang('Conference.xin_hr_meeting_title');?> <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" name="conference_title" placeholder="<?= lang('Conference.xin_hr_meeting_title');?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="meeting_date">
                <?= lang('Main.xin_e_details_date');?> <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <input class="form-control date" placeholder="<?= lang('Main.xin_e_details_date');?>" name="conference_date" type="text">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="meeting_time">
                <?= lang('Conference.xin_hr_meeting_time');?> <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <input class="form-control timepicker" placeholder="<?= lang('Conference.xin_hr_meeting_time');?>" name="conference_time" type="text">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="meeting_room">
                <?= lang('Conference.xin_meeting_room');?> <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" name="conference_room" placeholder="<?= lang('Conference.xin_meeting_room');?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="meeting_color">
                <?= lang('Conference.xin_meeting_color');?> <span class="text-danger">*</span>
              </label>
              <div class="input-group hr_color" title="<?= lang('Conference.xin_meeting_color');?>"> <span class="input-group-append"> <span class="input-group-text colorpicker-input-addon"><i></i></span> </span>
                <input class="form-control hr_color" type="text" value="#2655ff" name="conference_color">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="event_note">
                <?= lang('Conference.xin_hr_meeting_note');?> <span class="text-danger">*</span>
              </label>
              <textarea class="form-control textarea" placeholder="<?= lang('Conference.xin_hr_meeting_note');?>" name="conference_note" id="meeting_note"></textarea>
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
        <?= lang('Dashboard.xin_hr_meetings');?>
        </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?= lang('Conference.xin_hr_meeting_title');?></th>
                <th><?= lang('Dashboard.dashboard_employees');?></th>
                <th><?= lang('Main.xin_e_details_date');?></th>
                <th><?= lang('Conference.xin_hr_meeting_time');?></th>
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

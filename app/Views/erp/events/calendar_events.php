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
<?php if(in_array('hr_event1',staff_role_resource()) || in_array('events_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
    <ul class="nav nav-tabs step-anchor">
        <?php if(in_array('hr_event1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/events-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-disc"></span><?= lang('Dashboard.xin_hr_events');?>
                <div class="text-muted small"><?= lang('Main.xin_set_up');?> <?= lang('Dashboard.xin_hr_events');?></div>
            </a>
        </li>
        <?php } ?>
		<?php if(in_array('events_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
        <li class="nav-item active">
            <a href="<?= site_url('erp/events-calendar');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-calendar"></span><?= lang('Dashboard.xin_acc_calendar');?>
                <div class="text-muted small"><?= lang('Conference.xin_events_calendar');?></div>
            </a>
        </li>
       <?php } ?>
    </ul>
</div>
<hr class="border-light m-0 mb-3"> 
<?php } ?>
<div class="card">
  <div class="card-body">
    <div class="card-block">
      <div class="row">
        <div class="col-md-12">
          <div id='calendar_hr'></div>
        </div>
      </div>
    </div>
  </div>
</div>

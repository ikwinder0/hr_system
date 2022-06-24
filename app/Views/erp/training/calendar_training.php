<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
$i=1;
?>
<?php if(in_array('training2',staff_role_resource()) || in_array('trainer1',staff_role_resource()) || in_array('training_skill1',staff_role_resource()) || in_array('training_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('training2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/training-sessions');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-target"></span>
      <?= lang('Dashboard.left_training');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_training');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('trainer1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/trainers-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-user-plus"></span>
      <?= lang('Dashboard.left_trainers');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_trainers');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('training_skill1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/training-skills');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.left_training_skills');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_training_skills');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('training_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/training-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.left_training_calendar');?>
      </div>
    </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-xl-2 col-md-12">
        <div id="external-events" class="external-events">
          <h4>
            <?= lang('Dashboard.xin_hr_events');?>
          </h4>
          <div class="fc-event">
            <?= lang('Projects.xin_started');?>
          </div>
          <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff">
            <?= lang('Main.xin_pending');?>
          </div>
          <div class="fc-event" style="background-color:#3ebfea;border-color:#3ebfea;color:#fff">
            <?= lang('Projects.xin_completed');?>
          </div>
          <div class="fc-event" style="background-color:#f44236;border-color:#f44236;color:#fff">
            <?= lang('Main.xin_rejected');?>
          </div>
        </div>
      </div>
      <div class="col-xl-10 col-md-12">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>

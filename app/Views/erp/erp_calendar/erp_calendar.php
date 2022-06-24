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
$locale = service('request')->getLocale();
?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-xl-2 col-md-12">
        <div id="external-events" class="external-events">
          <h4><?= lang('Dashboard.xin_hr_events');?></h4>
          <?php if(in_array('project1',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#3ebfea;border-color:#3ebfea;color:#fff"><?= lang('Dashboard.left_projects');?></div>
          <?php } ?>
          <?php if(in_array('task1',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event"><?= lang('Dashboard.left_tasks');?></div>
          <?php } ?>
          <?php if(in_array('hr_event1',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#1de9b6;border-color:#1de9b6;color:#fff"><?= lang('Dashboard.xin_hr_events');?></div>
          <?php } ?>
          <?php if(in_array('conference1',staff_role_resource()) || $user['user_type']== 'company') {?>
          <div class="fc-event" style="background-color:#f44236;border-color:#f44236;color:#fff"><?= lang('Conference.xin_conference');?></div>
          <?php } ?>
          <?php if(in_array('leave2',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff"><?= lang('Leave.left_leave_request');?></div>
          <?php } ?>
		  <?php if(in_array('travel1',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#a389d4;border-color:#a389d4;color:#fff"><?= lang('Dashboard.dashboard_travel_request');?></div>
          <?php } ?>
		  <?php if(in_array('training1',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#36a934;border-color:#36a934;color:#fff"><?= lang('Dashboard.left_training');?></div>
          <?php } ?>
		  <?php if(in_array('holiday1',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#dd8030;border-color:#dd8030;color:#fff"><?= lang('Dashboard.left_holidays');?></div>
          <?php } ?>
		  <?php if(in_array('invoice2',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#98b815;border-color:#98b815;color:#fff"><?= lang('Dashboard.xin_invoices_title');?></div>
          <?php } ?>
		  <?php if(in_array('tracking1',staff_role_resource()) || $user['user_type'] == 'company') {?> 
          <div class="fc-event" style="background-color:#e13faf;border-color:#e13faf;color:#fff"><?= lang('Dashboard.xin_hr_goal_tracking');?></div>
          <?php } ?>
        </div>
      </div>
      <div class="col-xl-10 col-md-12">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>

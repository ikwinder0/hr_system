<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\ProjectsModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();
$ProjectsModel = new ProjectsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<?php if(in_array('project1',staff_role_resource()) || in_array('projects_calendar',staff_role_resource()) || in_array('projects_sboard',staff_role_resource()) || $user_info['user_type'] == 'company') {?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('project1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/projects-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-layers"></span>
      <?= lang('Dashboard.left_projects');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.left_projects');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('projects_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/projects-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Projects.xin_projects_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('projects_sboard',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/projects-scrum-board');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_projects_scrm_board');?>
      <div class="text-muted small">
        <?= lang('Main.xin_view');?>
        <?= lang('Projects.xin_projects_kanban_board');?>
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
          <div class="fc-event" style="background-color:#3ebfea;border-color:#3ebfea;color:#fff">
            <?= lang('Projects.xin_not_started');?>
          </div>
          <div class="fc-event">
            <?= lang('Projects.xin_in_progress');?>
          </div>
          <div class="fc-event" style="background-color:#1de9b6;border-color:#1de9b6;color:#fff">
            <?= lang('Projects.xin_completed');?>
          </div>
          <div class="fc-event" style="background-color:#f44236;border-color:#f44236;color:#fff">
            <?= lang('Projects.xin_project_cancelled');?>
          </div>
          <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff">
            <?= lang('Projects.xin_project_hold');?>
          </div>
        </div>
      </div>
      <div class="col-xl-10 col-md-12">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>

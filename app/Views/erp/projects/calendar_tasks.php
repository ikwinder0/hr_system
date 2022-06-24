<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tasks-grid');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-edit"></span>
      <?= lang('Dashboard.left_tasks');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_tasks');?>
      </div>
      </a> </li>
    <li class="nav-item active"> <a href="<?= site_url('erp/tasks-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_tasks_calendar');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tasks-scrum-board');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_projects_scrm_board');?>
      <div class="text-muted small">
        <?= lang('Main.xin_view');?>
        <?= lang('Dashboard.xin_tasks_sboard');?>
      </div>
      </a> </li>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-xl-2 col-md-12">
        <div id="external-events" class="external-events">
          <h4><?= lang('Dashboard.xin_hr_events');?></h4>
          <div class="fc-event" style="background-color:#3ebfea;border-color:#3ebfea;color:#fff"><?= lang('Projects.xin_not_started');?></div>
          <div class="fc-event"><?= lang('Projects.xin_in_progress');?></div>
          <div class="fc-event" style="background-color:#1de9b6;border-color:#1de9b6;color:#fff"><?= lang('Projects.xin_completed');?></div>
          <div class="fc-event" style="background-color:#f44236;border-color:#f44236;color:#fff"><?= lang('Projects.xin_project_cancelled');?></div>
          <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff"><?= lang('Projects.xin_project_hold');?></div>
        </div>
      </div>
      <div class="col-xl-10 col-md-12">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>

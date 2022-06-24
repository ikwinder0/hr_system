<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?= site_url('erp/performance-indicator-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-aperture"></span>
      <?= lang('Dashboard.left_performance_indicator');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?> <?= lang('Dashboard.left_performance_xindicator');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/performance-appraisal-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-slack"></span>
      <?= lang('Dashboard.left_performance_appraisal');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?> <?= lang('Dashboard.left_performance_xappraisal');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/track-goals');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-target"></span>
      <?= lang('Dashboard.xin_hr_goal_tracking');?>
      <div class="text-muted small">
        <?= lang('Performance.xin_set_up_goals');?>
      </div>
      </a> </li>
    <li class="nav-item active"> <a href="<?= site_url('erp/goals-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Performance.xin_goals_calendar');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/competencies');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-sliders-h"></span>
      <?= lang('Performance.xin_competencies');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Performance.xin_competencies');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/goal-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_hr_goal_tracking_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_hr_goal_tracking_type');?>
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
          <h4>
            <?= lang('Dashboard.xin_hr_events');?>
          </h4>
          <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff">
            <?= lang('Projects.xin_not_started');?>
          </div>
          <div class="fc-event">
            <?= lang('Projects.xin_in_progress');?>
          </div>
          <div class="fc-event" style="background-color:#f44236;border-color:#f44236;color:#fff">
            <?= lang('Projects.xin_completed');?>
          </div>
        </div>
      </div>
      <div class="col-xl-10 col-md-12">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>

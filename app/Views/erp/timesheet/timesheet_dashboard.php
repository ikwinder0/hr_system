<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
    <ul class="nav nav-tabs step-anchor">
        <li class="nav-item active">
            <a href="<?= site_url('erp/timesheet-dashboard');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-friends"></span><?= lang('Dashboard.dashboard_hr');?>
                <div class="text-muted small">Set up shortcuts</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/attendance-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-lock"></span><?= lang('Dashboard.left_attendance');?>
                <div class="text-muted small">Add effects</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/manual-attendance');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span><?= lang('Dashboard.left_update_attendance');?>
                <div class="text-muted small">Select pager options</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/attendance-calendar');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span><?= lang('Calendar');?>
                <div class="text-muted small">Select pager options</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/overtime-request');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span><?= lang('Overtime Request');?>
                <div class="text-muted small">Select pager options</div>
            </a>
        </li>
    </ul>
</div>
<hr class="border-light m-0 mb-3">

<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-primary border-feed"> <i class="fas fa-user-tie f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">2,672</h2>
              <p class="text-muted m-0">Last week <span class="text-primary f-w-400">user's</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-success border-feed"> <i class="fas fa-wallet f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">$6391</h2>
              <p class="text-muted m-0">Total <span class="text-success f-w-400">earning</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-danger border-feed"> <i class="fas fa-sitemap f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">3,619</h2>
              <p class="text-muted m-0">New <span class="text-danger f-w-400">order</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-warning border-feed"> <i class="fas fa-users f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">9,276</h2>
              <p class="text-muted m-0">Today <span class="text-warning f-w-400">visitors</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-6 col-md-12">
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>Attendance Status</h6>
            <span>It takes continuous effort to maintain high.</span>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="satisfaction-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <h6>Overtime Request Status</h6>
        <span>It takes continuous effort to maintain high.</span>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="satisfaction-chart2"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

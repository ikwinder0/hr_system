<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\LeaveModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$LeaveModel = new LeaveModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$leave_types = $ConstantsModel->where('company_id',$user_info['company_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$total_leave = $LeaveModel->where('employee_id',$usession['sup_user_id'])->countAllResults();
	$leave_pending = $LeaveModel->where('employee_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
	$total_accepted = $LeaveModel->where('employee_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
	$total_rejected = $LeaveModel->where('employee_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
} else {
	$leave_types = $ConstantsModel->where('company_id',$usession['sup_user_id'])->where('type','leave_type')->orderBy('constants_id', 'ASC')->findAll();
	$total_leave = $LeaveModel->where('company_id',$usession['sup_user_id'])->orderBy('leave_id', 'ASC')->countAllResults();
	$leave_pending = $LeaveModel->where('company_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
	$total_accepted = $LeaveModel->where('company_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
	$total_rejected = $LeaveModel->where('company_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
}
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
    <ul class="nav nav-tabs step-anchor">
        <li class="nav-item active">
            <a href="<?= site_url('erp/leave-status');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span>Leave Status
                <div class="text-muted small">Select pager options</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/leave-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-friends"></span><?= lang('Dashboard.xin_manage_leaves');?>
                <div class="text-muted small">Set up shortcuts</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/leave-type');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-user-lock"></span>Leave Type
                <div class="text-muted small">Add effects</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/leave-calendar');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span>Leave Calendar
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
              <h2 class="f-w-400 m-b-10"><?= $total_leave;?></h2>
              <p class="text-muted m-0">Total <span class="text-primary f-w-400">leave</span></p>
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
              <h2 class="f-w-400 m-b-10"><?= $total_accepted;?></h2>
              <p class="text-muted m-0">Total <span class="text-success f-w-400">accepted</span></p>
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
              <h2 class="f-w-400 m-b-10"><?= $total_rejected;?></h2>
              <p class="text-muted m-0">Total <span class="text-danger f-w-400">rejected</span></p>
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
              <h2 class="f-w-400 m-b-10"><?= $leave_pending;?></h2>
              <p class="text-muted m-0">Total <span class="text-warning f-w-400">pending</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
<div class="col-xl-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <h6>Leave Status</h6>
        <span>It takes continuous effort to maintain high.</span>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="leave-status-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-12">
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>Leave Type Status</h6>
            <span>It takes continuous effort to maintain high.</span>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="leave-type-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

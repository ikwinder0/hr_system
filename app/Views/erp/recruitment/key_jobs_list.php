<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\JobsModel;
use App\Models\ConstantsModel;
use App\Models\JobcandidatesModel;
use App\Models\JobinterviewsModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$JobsModel = new JobsModel();
$ConstantsModel = new ConstantsModel();
$JobcandidatesModel = new JobcandidatesModel();
$JobinterviewsModel = new JobinterviewsModel();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$get_jobs = $JobsModel->where('company_id',$user_info['company_id'])->orderBy('job_id', 'ASC')->paginate(9);
	$pager = $JobsModel->pager;
} else {
	$get_jobs = $JobsModel->where('company_id',$usession['sup_user_id'])->orderBy('job_id', 'ASC')->paginate(9);
	$pager = $JobsModel->pager;
}
/*
* Jobs List - View Page
*/
?>
<?php if(in_array('ats2',staff_role_resource()) || in_array('candidate',staff_role_resource()) || in_array('interview',staff_role_resource()) || in_array('promotion',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2 mb-3">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('ats2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/jobs-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-gitlab"></span>
      <?= lang('Recruitment.xin_new_opening');?>
      <div class="text-muted small">
        <?= lang('Recruitment.xin_add_new_jobs');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('candidate',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/candidates-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-users"></span>
      <?= lang('Recruitment.xin_candidates');?>
      <div class="text-muted small">
        <?= lang('Dashboard.left_job_candidates');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('interview',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/jobs-interviews');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Recruitment.xin_interviews');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Recruitment.xin_interviews');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('promotion',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/promotion-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-user-plus"></span>
      <?= lang('Dashboard.left_promotions');?>
      <div class="text-muted small">
        <?= lang('Dashboard.dashboard_employee');?>
        <?= lang('Dashboard.left_promotions');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="row"> 
  <!-- [ jobs ] start --> 
  <!-- [ left ] end --> 
  <!-- [ right ] start -->
  <div class="col-xl-12 col-lg-12 filter-bar invoice-list">
    <nav class="navbar m-b-30 p-10">
      <ul class="nav">
        <li class="nav-item dropdown"> <a class="nav-link text-secondary" href="#" id="bydate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>
          <?= lang('Dashboard.left_jobs_listing');?>
          </strong></a> </li>
      </ul>
      <?php if(in_array('ats3',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <div class="nav-item nav-grid f-view"> <a href="<?= site_url().'erp/create-new-job';?>" class="btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
        <?= lang('Main.xin_add_new');?>
        <?= lang('Recruitment.xin_job');?>
        </a> </div>
     <?php } ?>
    </nav>
    <div class="row">
      <?php foreach($get_jobs as $r) {?>
      <?php
		$created_at = set_date_format($r['created_at']);
		$date_of_closing = set_date_format($r['date_of_closing']);
		// status
		if($r['status']==1){
			$status = '<span class="badge badge-light-success">'.lang('Recruitment.xin_published').'</span>';
		} else {
			$status = '<span class="badge badge-light-danger">'.lang('Recruitment.xin_unpublished').'</span>';
		}
		// gender
		if($r['gender']==0){
			$gender = lang('Main.xin_gender_male');
		} else if($r['gender']==1){
			$gender = lang('Main.xin_gender_female');
		} else {
			$gender = lang('Recruitment.xin_no_reference');
		}
		if($r['job_type']==1){
			$job_type = lang('Recruitment.xin_full_time');
		} else if($r['job_type']==2){
			$job_type = lang('Recruitment.xin_part_time');
		} else if($r['job_type']==3){
			$job_type = lang('Recruitment.xin_internship');
		} else {
			$job_type = lang('Recruitment.xin_freelance');
		}
		
		?>
      <div class="col-lg-4 col-md-12">
        <div class="card card-border-c-blue">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="d-inline-block m-b-10"><a href="<?= site_url().'erp/view-job/'.uencode($r['job_id']);?>">
                <?= $r['job_title']?>
                </a></h5>
              <div class="dropdown-secondary dropdown float-right">
                <?= $status;?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <ul class="list list-unstyled">
                  <li>
                    <?= lang('Recruitment.xin_job_type');?>
                    :
                    <?= $job_type;?>
                  </li>
                  <li>
                    <?= lang('Recruitment.xin_posted_on');?>
                    : <span class="text-semibold">
                    <?= $created_at;?>
                    </span></li>
                </ul>
              </div>
              <div class="col-md-5">
                <ul class="list list-unstyled text-right">
                  <li>
                    <?= lang('Recruitment.xin_positions');?>
                    : <span class="text-semibold">
                    <?= $r['job_vacancy']?>
                    </span></li>
                  <li> <span class="text-semibold">
                    <?= $gender;?>
                    <i class="fas fa-question-circle" data-toggle="tooltip" title="" data-original-title="<?= lang('Main.xin_employee_gender');?>"></i> </span></li>
                </ul>
              </div>
            </div>
            <div class="m-t-30">
              <div class="task-list-table">
                <p class="task-due"><strong>
                  <?= lang('Recruitment.xin_closing_date');?>
                  : </strong><strong class="label label-primary">
                  <?= $date_of_closing;?>
                  </strong></p>
              </div>
              <div class="task-board m-0 float-right">
                <?php if($r['status']==1){ ?>
                <a href="<?= site_url().'erp/view-job/'.uencode($r['job_id']);?>" data-toggle="tooltip" data-placement="top" title="<?= lang('Recruitment.xin_view_job');?>" class="btn btn-primary"><i class="fas fa-eye m-0"></i></a>
                <?php } ?>
                <?php if(in_array('ats4',staff_role_resource()) || in_array('ats5',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
                <div class="dropdown-secondary dropdown d-inline">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                  <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                  <?php if(in_array('ats4',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
                  	<a class="dropdown-item" href="<?= site_url().'erp/edit-a-job/'.uencode($r['job_id']);?>"><i data-feather="edit"></i>
                    <?= lang('Recruitment.xin_edit_job');?>
                    </a> 
                  <?php } ?>
				  <?php if(in_array('ats5',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
                  <a href="#!" class="dropdown-item delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?= uencode($r['job_id']);?>"><i class="feather icon-trash-2"></i>
                    <?= lang('Recruitment.xin_delete_job');?>
                    </a>
                  <?php } ?>
                  </div>
                </div>
                <?php  }?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <!-- [ jobs ] end --> 
</div>
<hr>
<div class="p-2">
<?= $pager->links() ?>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
  <div class="col-xl-4 col-md-12">
    <div class="card">
      <div class="card-body">
        <h6>
          <?= lang('Recruitment.xin_jobs_status');?>
        </h6>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="jobs-status-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-12">
    <div class="card">
      <div class="card-body">
        <h6>
          <?= lang('Recruitment.xin_job_types_status');?>
        </h6>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="jobs-type-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-12">
    <div class="card">
      <div class="card-body">
        <h6>
          <?= lang('Recruitment.xin_job_by_designation');?>
        </h6>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="job-by-designation-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

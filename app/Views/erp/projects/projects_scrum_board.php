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
if($user_info['user_type'] == 'staff'){
	$staff_projects_board = assigned_staff_projects_board($usession['sup_user_id']);
	$not_started_projects = $staff_projects_board['not_started_projects'];
	$inprogress_projects = $staff_projects_board['inprogress_projects'];
	$completed_projects = $staff_projects_board['completed_projects'];
	$cancelled_projects = $staff_projects_board['cancelled_projects'];
	$hold_projects = $staff_projects_board['hold_projects'];
} else {
	$not_started_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status',0)->orderBy('project_id', 'ASC')->findAll();
	$inprogress_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status',1)->orderBy('project_id', 'ASC')->findAll();
	$completed_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status',2)->orderBy('project_id', 'ASC')->findAll();
	$cancelled_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status',3)->orderBy('project_id', 'ASC')->findAll();
	$hold_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status',4)->orderBy('project_id', 'ASC')->findAll();
}
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
    <li class="nav-item clickable"> <a href="<?= site_url('erp/projects-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Projects.xin_projects_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('projects_sboard',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/projects-scrum-board');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
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
<div class="form-row">
  <div class="col-md">
    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp;
        <?= lang('Projects.xin_not_started');?>
      </h6>
      <div class="kanban-box first-notstarted px-2 pt-2" id="first-notstarted" data-status="0">
        <?php foreach($not_started_projects as $ntprojects) {?>
        <?php if($ntprojects['status'] == 0) {?>
        <?php
		$cc = explode(',',$ntprojects['assigned_to']);
		$iuser = 0;
		// project progress
		if($ntprojects['project_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($ntprojects['project_progress'] > 20 && $ntprojects['project_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($ntprojects['project_progress'] > 50 && $ntprojects['project_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.lang('xin_completed').' <span class="pull-xs-right">'.$ntprojects['project_progress'].'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ntprojects['project_progress'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ntprojects['project_progress'].'%"></div></div></p>';
		?>
        <div class="ui-bordered notstarted_<?php echo $ntprojects['project_id'];?> p-2 mb-2" data-id="<?php echo $ntprojects['project_id'];?>" data-status="0" id="notstarted"> <a target="_blank" href="<?php echo site_url('erp/project-detail').'/'.uencode($ntprojects['project_id']);?>"><?php echo $ntprojects['title'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $ntprojects['project_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $ntprojects['project_progress'];?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2">
            <?= lang('Projects.xin_project_users');?>
          </div>
          <div class="d-flex flex-wrap mt-1">
            <?= multi_user_profile_photo($cc);?>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/projects-grid');?>" class="edit-data add-task">
        <?= lang('Projects.xin_add_project');?>
        </a> </div>
      <?php } ?>
    </div>
  </div>
  <div class="col-md">
    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp;
        <?= lang('Projects.xin_in_progress');?>
      </h6>
      <div class="kanban-box first-inprogress px-2 pt-2" id="first-inprogress" data-status="1">
        <?php foreach($inprogress_projects as $ntprojects) {?>
        <?php if($ntprojects['status'] == 1) {?>
        <?php
		$cc = explode(',',$ntprojects['assigned_to']);
		$iuser = 0;
		// project progress
		if($ntprojects['project_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($ntprojects['project_progress'] > 20 && $ntprojects['project_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($ntprojects['project_progress'] > 50 && $ntprojects['project_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.lang('xin_completed').' <span class="pull-xs-right">'.$ntprojects['project_progress'].'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ntprojects['project_progress'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ntprojects['project_progress'].'%"></div></div></p>';
		?>
        <div class="ui-bordered in-progress_<?php echo $ntprojects['project_id'];?> p-2 mb-2" data-id="<?php echo $ntprojects['project_id'];?>" data-status="1" id="in-progress"> <a target="_blank" href="<?php echo site_url('erp/project-detail').'/'.uencode($ntprojects['project_id']);?>"><?php echo $ntprojects['title'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $ntprojects['project_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $ntprojects['project_progress'];?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2">
            <?= lang('Projects.xin_project_users');?>
          </div>
          <div class="d-flex flex-wrap mt-1">
            <?= multi_user_profile_photo($cc);?>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/projects-grid');?>" class="edit-data add-task">
        <?= lang('Projects.xin_add_project');?>
        </a> </div>
      <?php } ?>
    </div>
  </div>
  <div class="col-md">
    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp;
        <?= lang('Projects.xin_completed');?>
      </h6>
      <div class="kanban-box first-completed px-2 pt-2" id="first-completed" data-status="2">
        <?php foreach($completed_projects as $ntprojects) {?>
        <?php if($ntprojects['status'] == 2) {?>
        <?php
		$cc = explode(',',$ntprojects['assigned_to']);
		$iuser = 0;
		// project progress
		if($ntprojects['project_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($ntprojects['project_progress'] > 20 && $ntprojects['project_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($ntprojects['project_progress'] > 50 && $ntprojects['project_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.lang('xin_completed').' <span class="pull-xs-right">'.$ntprojects['project_progress'].'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ntprojects['project_progress'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ntprojects['project_progress'].'%"></div></div></p>';
		?>
        <div class="ui-bordered complete_<?php echo $ntprojects['project_id'];?> p-2 mb-2" data-id="<?php echo $ntprojects['project_id'];?>" data-status="2" id="complete"> <a target="_blank" href="<?php echo site_url('erp/project-detail').'/'.uencode($ntprojects['project_id']);?>"><?php echo $ntprojects['title'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $ntprojects['project_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $ntprojects['project_progress'];?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2">
            <?= lang('Projects.xin_project_users');?>
          </div>
          <div class="d-flex flex-wrap mt-1">
            <?= multi_user_profile_photo($cc);?>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/projects-grid');?>" class="edit-data add-task">
        <?= lang('Projects.xin_add_project');?>
        </a> </div>
      <?php } ?>
    </div>
  </div>
  <div class="col-md">
    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp;
        <?= lang('Projects.xin_project_cancelled');?>
      </h6>
      <div class="kanban-box first-cancelled px-2 pt-2" id="first-cancelled" data-status="3">
        <?php foreach($cancelled_projects as $ntprojects) {?>
        <?php if($ntprojects['status'] == 3) {?>
        <?php
		$cc = explode(',',$ntprojects['assigned_to']);
		$iuser = 0;
		// project progress
		if($ntprojects['project_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($ntprojects['project_progress'] > 20 && $ntprojects['project_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($ntprojects['project_progress'] > 50 && $ntprojects['project_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.lang('xin_completed').' <span class="pull-xs-right">'.$ntprojects['project_progress'].'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ntprojects['project_progress'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ntprojects['project_progress'].'%"></div></div></p>';
		?>
        <div class="ui-bordered cancelled_<?php echo $ntprojects['project_id'];?> p-2 mb-2" data-id="<?php echo $ntprojects['project_id'];?>" data-status="3" id="cancelled"> <a target="_blank" href="<?php echo site_url('erp/project-detail').'/'.uencode($ntprojects['project_id']);?>"><?php echo $ntprojects['title'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $ntprojects['project_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $ntprojects['project_progress'];?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2">
            <?= lang('Projects.xin_project_users');?>
          </div>
          <div class="d-flex flex-wrap mt-1">
            <?= multi_user_profile_photo($cc);?>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/projects-grid');?>" class="edit-data add-task">
        <?= lang('Projects.xin_add_project');?>
        </a> </div>
      <?php } ?>
    </div>
  </div>
  <div class="col-md">
    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp;
        <?= lang('Projects.xin_project_hold');?>
      </h6>
      <div class="kanban-box first-hold px-2 pt-2" id="first-hold" data-status="4">
        <?php foreach($hold_projects as $ntprojects) {?>
        <?php if($ntprojects['status'] == 4) {?>
        <?php
		$cc = explode(',',$ntprojects['assigned_to']);
		$iuser = 0;
		// project progress
		if($ntprojects['project_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($ntprojects['project_progress'] > 20 && $ntprojects['project_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($ntprojects['project_progress'] > 50 && $ntprojects['project_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.lang('xin_completed').' <span class="pull-xs-right">'.$ntprojects['project_progress'].'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ntprojects['project_progress'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ntprojects['project_progress'].'%"></div></div></p>';
		?>
        <div class="ui-bordered hold_<?php echo $ntprojects['project_id'];?> p-2 mb-2" data-id="<?php echo $ntprojects['project_id'];?>" data-status="4" id="hold"> <a target="_blank" href="<?php echo site_url('erp/project-detail').'/'.uencode($ntprojects['project_id']);?>"><?php echo $ntprojects['title'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $ntprojects['project_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $progress_class;?>" style="width: <?php echo $ntprojects['project_progress'];?>%"></div>
          </div>
          <div class="text-muted small mb-1 mt-2">
            <?= lang('Projects.xin_project_users');?>
          </div>
          <div class="d-flex flex-wrap mt-1">
            <?= multi_user_profile_photo($cc);?>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/projects-grid');?>" class="edit-data add-task">
        <?= lang('Projects.xin_add_project');?>
        </a> </div>
      <?php } ?>
    </div>
  </div>
</div>

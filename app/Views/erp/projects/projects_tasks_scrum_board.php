<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\TasksModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();
$TasksModel = new TasksModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_tasks_board = assigned_staff_tasks_board($usession['sup_user_id']);
	$not_started_tasks = $staff_tasks_board['not_started_tasks'];
	$inprogress_tasks = $staff_tasks_board['inprogress_tasks'];
	$completed_tasks = $staff_tasks_board['completed_tasks'];
	$cancelled_tasks = $staff_tasks_board['cancelled_tasks'];
	$hold_tasks = $staff_tasks_board['hold_tasks'];
} else {
	$not_started_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status',0)->orderBy('task_id', 'ASC')->findAll();
	$inprogress_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status',1)->orderBy('task_id', 'ASC')->findAll();
	$completed_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status',2)->orderBy('task_id', 'ASC')->findAll();
	$cancelled_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status',3)->orderBy('task_id', 'ASC')->findAll();
	$hold_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status',4)->orderBy('task_id', 'ASC')->findAll();
}
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tasks-grid');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-edit"></span>
      <?= lang('Dashboard.left_tasks');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_tasks');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tasks-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_tasks_calendar');?>
      </div>
      </a> </li>
    <li class="nav-item active"> <a href="<?= site_url('erp/tasks-scrum-board');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_projects_scrm_board');?>
      <div class="text-muted small">
        <?= lang('Main.xin_view');?>
        <?= lang('Dashboard.xin_tasks_sboard');?>
      </div>
      </a> </li>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="form-row">
  <div class="col-md">
    <div class="card mb-3">
      <h6 class="card-header"><i class="ion ion-md-football text-info"></i> &nbsp;
        <?= lang('Projects.xin_not_started');?>
      </h6>
      <div class="kanban-box first-notstarted px-2 pt-2" id="first-notstarted" data-status="0">
        <?php foreach($not_started_tasks as $hltask) {?>
        <?php if($hltask['task_status'] == 0) {?>
        <?php
		$ol = '';
		$cc = explode(',',$hltask['assigned_to']);
		$iuser = 0;
		$start_date = set_date_format($hltask['start_date']);
		$end_date = set_date_format($hltask['end_date']);
			 
		//$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		// task progress
		if($hltask['task_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask['task_progress'] > 20 && $hltask['task_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask['task_progress'] > 50 && $hltask['task_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered notstarted_<?php echo $hltask['task_id'];?> p-2 mb-2" data-id="<?php echo $hltask['task_id'];?>" data-status="0" id="notstarted"> <a href="<?= site_url('erp/task-detail').'/'.uencode($hltask['task_id']);?>"><?php echo $hltask['task_name'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $hltask['task_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped <?php echo $progress_class;?>" style="width: <?php echo $hltask['task_progress'];?>%"></div>
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
      <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/tasks-grid');?>" class="edit-data add-task"><?= lang('Projects.xin_add_task');?>
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
        <?php foreach($inprogress_tasks as $hltask) {?>
        <?php if($hltask['task_status'] == 1) {?>
        <?php
		$ol = '';
		$cc = explode(',',$hltask['assigned_to']);
		$iuser = 0;
		$start_date = set_date_format($hltask['start_date']);
		$end_date = set_date_format($hltask['end_date']);
			 
		//$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		// task progress
		if($hltask['task_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask['task_progress'] > 20 && $hltask['task_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask['task_progress'] > 50 && $hltask['task_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered in-progress_<?php echo $hltask['task_id'];?> p-2 mb-2" data-id="<?php echo $hltask['task_id'];?>" data-status="1" id="in-progress"> <a href="<?= site_url('erp/task-detail').'/'.uencode($hltask['task_id']);?>"><?php echo $hltask['task_name'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $hltask['task_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped <?php echo $progress_class;?>" style="width: <?php echo $hltask['task_progress'];?>%"></div>
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
      <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/tasks-grid');?>" class="edit-data add-task"><?= lang('Projects.xin_add_task');?>
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
        <?php foreach($completed_tasks as $hltask) {?>
        <?php if($hltask['task_status'] == 2) {?>
        <?php
		$ol = '';
		$cc = explode(',',$hltask['assigned_to']);
		$iuser = 0;
		$start_date = set_date_format($hltask['start_date']);
		$end_date = set_date_format($hltask['end_date']);
			 
		//$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		// task progress
		if($hltask['task_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask['task_progress'] > 20 && $hltask['task_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask['task_progress'] > 50 && $hltask['task_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered complete_<?php echo $hltask['task_id'];?> p-2 mb-2" data-id="<?php echo $hltask['task_id'];?>" data-status="2" id="complete"> <a href="<?= site_url('erp/task-detail').'/'.uencode($hltask['task_id']);?>"><?php echo $hltask['task_name'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $hltask['task_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped <?php echo $progress_class;?>" style="width: <?php echo $hltask['task_progress'];?>%"></div>
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
      <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/tasks-grid');?>" class="edit-data add-task"><?= lang('Projects.xin_add_task');?>
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
        <?php foreach($cancelled_tasks as $hltask) {?>
        <?php if($hltask['task_status'] == 3) {?>
        <?php
		$ol = '';
		$cc = explode(',',$hltask['assigned_to']);
		$iuser = 0;
		$start_date = set_date_format($hltask['start_date']);
		$end_date = set_date_format($hltask['end_date']);
		// task progress
		if($hltask['task_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask['task_progress'] > 20 && $hltask['task_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask['task_progress'] > 50 && $hltask['task_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered cancelled_<?php echo $hltask['task_id'];?> p-2 mb-2" data-id="<?php echo $hltask['task_id'];?>" data-status="3" id="cancelled"> <a href="<?= site_url('erp/task-detail').'/'.uencode($hltask['task_id']);?>"><?php echo $hltask['task_name'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $hltask['task_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped <?php echo $progress_class;?>" style="width: <?php echo $hltask['task_progress'];?>%"></div>
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
      <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/tasks-grid');?>" class="edit-data add-task"><?= lang('Projects.xin_add_task');?>
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
        <?php foreach($hold_tasks as $hltask) {?>
        <?php if($hltask['task_status'] == 4) {?>
        <?php
		$ol = '';
		$cc = explode(',',$hltask['assigned_to']);
		$iuser = 0;
		$start_date = set_date_format($hltask['start_date']);
		$end_date = set_date_format($hltask['end_date']);
			 
		//$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		// task progress
		if($hltask['task_progress'] <= 20) {
			$progress_class = 'bg-danger';
		} else if($hltask['task_progress'] > 20 && $hltask['task_progress'] <= 50){
			$progress_class = 'bg-warning';
		} else if($hltask['task_progress'] > 50 && $hltask['task_progress'] <= 75){
			$progress_class = 'bg-info';
		} else {
			$progress_class = 'bg-success';
		}
		?>
        <div class="ui-bordered hold_<?php echo $hltask['task_id'];?> p-2 mb-2" data-id="<?php echo $hltask['task_id'];?>" data-status="4" id="hold"> <a href="<?= site_url('erp/task-detail').'/'.uencode($hltask['task_id']);?>"><?php echo $hltask['task_name'];?></a>
          <div><small class="text-muted">
            <?= lang('Projects.xin_completed');?>
            <?php echo $hltask['task_progress'];?>%</small></div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar progress-bar-striped <?php echo $progress_class;?>" style="width: <?php echo $hltask['task_progress'];?>%"></div>
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
      <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
      <div class="card-footer text-center py-2"> <a href="<?= site_url('erp/tasks-grid');?>" class="edit-data add-task"><?= lang('Projects.xin_add_task');?>
        </a> </div>
      <?php } ?>  
    </div>
  </div>
</div>

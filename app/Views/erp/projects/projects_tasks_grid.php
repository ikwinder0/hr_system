<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\TasksModel;
use App\Models\ProjectsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$TasksModel = new TasksModel();
$ProjectsModel = new ProjectsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$id = $usession['sup_user_id'];
	$get_tasks = $TasksModel->where('company_id',$user_info['company_id'])->where("assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id' or created_by = '$id'")->paginate(9);
	$total_tasks = $TasksModel->where('company_id',$user_info['company_id'])->orderBy('task_id', 'ASC')->countAllResults();
	$not_started = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 0)->countAllResults();
	$in_progress = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 1)->countAllResults();
	$completed = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 2)->countAllResults();
	$cancelled = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 3)->countAllResults();
	$hold = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 4)->countAllResults();
	$projects = $ProjectsModel->where('company_id', $user_info['company_id'])->findAll();
	$pager = $TasksModel->pager;
} else {
	$projects = $ProjectsModel->where('company_id', $usession['sup_user_id'])->findAll();
	$get_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->orderBy('task_id', 'ASC')->paginate(9);
	$total_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->orderBy('task_id', 'ASC')->countAllResults();
	$not_started = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 0)->countAllResults();
	$in_progress = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 1)->countAllResults();
	$completed = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 2)->countAllResults();
	$cancelled = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 3)->countAllResults();
	$hold = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 4)->countAllResults();
	$pager = $TasksModel->pager;
}
$get_animate='';
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('task1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/tasks-grid');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-edit"></span>
      <?= lang('Dashboard.left_tasks');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.left_tasks');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('tasks_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tasks-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_tasks_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('tasks_sboard',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tasks-scrum-board');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_projects_scrm_board');?>
      <div class="text-muted small">
        <?= lang('Main.xin_view');?>
        <?= lang('Dashboard.xin_tasks_sboard');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="card feed-card">
      <div class="card-body p-t-0 p-b-0">
        <div class="row">
          <div class="col-4 bg-success border-feed"> <i class="fas fa-user-tie f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $completed;?>
              </h2>
              <p class="text-muted m-0">
                <?= lang('Main.xin_total');?>
                <span class="text-success f-w-400">
                <?= lang('Projects.xin_completed');?>
                </span></p>
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
          <div class="col-4 bg-primary border-feed"> <i class="fas fa-wallet f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $in_progress;?>
              </h2>
              <p class="text-muted m-0">
                <?= lang('Main.xin_total');?>
                <span class="text-primary f-w-400">
                <?= lang('Projects.xin_in_progress');?>
                </span></p>
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
          <div class="col-4 bg-info border-feed"> <i class="fas fa-sitemap f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $not_started;?>
              </h2>
              <p class="text-muted m-0">
                <?= lang('Main.xin_total');?>
                <span class="text-info f-w-400">
                <?= lang('Projects.xin_not_started');?>
                </span></p>
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
          <div class="col-4 bg-danger border-feed"> <i class="fas fa-users f-40"></i> </div>
          <div class="col-8">
            <div class="p-t-25 p-b-25">
              <h2 class="f-w-400 m-b-10">
                <?= $hold;?>
              </h2>
              <p class="text-muted m-0">
                <?= lang('Main.xin_total');?>
                <span class="text-danger f-w-400">
                <?= lang('Projects.xin_project_hold');?>
                </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row"> 
  <!-- [ task-board-right ] start -->
  <div class="col-xl-12 col-lg-12 filter-bar">
    <nav class="navbar m-b-30 p-10">
      <ul class="nav">
        <li class="nav-item dropdown"> <a class="nav-link text-secondary" href="#" id="bydate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Projects.xin_tasks');?>
          </strong></a> </li>
      </ul>
      <div class="nav-item nav-grid f-view"> <span class="m-r-15">
        <?= lang('Projects.xin_view_mode');?>
        :</span> <a href="<?= site_url().'erp/tasks-list';?>" class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_list_view');?>"> <i class="fas fa-list-ul"></i> </a> <a href="<?= site_url().'erp/tasks-grid';?>" class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_grid_view');?>"> <i class="fas fa-th-large"></i> </a>
        <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
        <?= lang('Projects.xin_add_task');?>
        </a>
        <?php } ?>
      </div>
    </nav>
    <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card">
        <div id="accordion">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Projects.xin_task');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <?php $attributes = array('name' => 'add_task', 'id' => 'xin-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => 0);?>
          <?php echo form_open('erp/tasks/add_task', $attributes, $hidden);?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="task_name"><?php echo lang('Dashboard.xin_title');?> <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="task_name" type="text" value="">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="task_hour" class="control-label"><?php echo lang('Projects.xin_estimated_hour');?></label>
                  <div class="input-group">
                    <input class="form-control" placeholder="<?php echo lang('Projects.xin_estimated_hour');?>" name="task_hour" type="text" value="">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group" id="project_ajax">
                  <label for="project_ajax" class="control-label"><?php echo lang('Projects.xin_project');?> <span class="text-danger">*</span></label>
                  <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_project');?>">
                    <option value=""></option>
                    <?php foreach($projects as $iprojects) {?>
                    <option value="<?= $iprojects['project_id']?>">
                    <?= $iprojects['title'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="summary"><?php echo lang('Main.xin_summary');?> <span class="text-danger">*</span></label>
                  <textarea class="form-control" placeholder="<?php echo lang('Main.xin_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo lang('Projects.xin_description');?></label>
                  <textarea class="form-control editor" placeholder="<?php echo lang('Projects.xin_description');?>" name="description" id="description"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
            <?= lang('Main.xin_reset');?>
            </button>
            &nbsp;
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="row">
      <?php $i=1;foreach($get_tasks as $r) { ?>
      <?php
		 $start_date = set_date_format($r['start_date']);
		 $end_date = set_date_format($r['end_date']);
		// task status			
		if($r['task_status'] == 0) {
			$status = '<button class="btn waves-effect waves-light btn-light-warning btn-sm" type="button">'.lang('Projects.xin_not_started').'</button>';
		} else if($r['task_status'] ==1){
			$status = '<button class="btn waves-effect waves-light btn-light-primary btn-sm" type="button">'.lang('Projects.xin_in_progress').'</button>';
		} else if($r['task_status'] ==2){
			$status = '<button class="btn waves-effect waves-light btn-light-success btn-sm" type="button">'.lang('Projects.xin_completed').'</button>';
		} else if($r['task_status'] ==3){
			$status = '<button class="btn waves-effect waves-light btn-light-danger btn-sm" type="button">'.lang('Projects.xin_project_cancelled').'</button>';
		} else {
			$status = '<button class="btn waves-effect waves-light btn-light-danger btn-sm" type="button">'.lang('Projects.xin_project_hold').'</button>';
		}
		// task progress
		if($r['task_progress'] <= 20) {
			$progress_class = 'progress-bar bg-danger';
		} else if($r['task_progress'] > 20 && $r['task_progress'] <= 50){
			$progress_class = 'progress-bar bg-warning';
		} else if($r['task_progress'] > 50 && $r['task_progress'] <= 75){
			$progress_class = 'progress-bar bg-info';
		} else {
			$progress_class = 'progress-bar bg-success';
		}
		//assigned user
		$assigned_to = explode(',',$r['assigned_to']);
	   ?>
      <div class="col-md-4 col-sm-12">
        <div class="card card-border-c-blue">
          <div class="card-header"> <a href="<?= site_url('erp/task-detail').'/'.uencode($r['task_id']);?>" class="text-secondary">#
            <?= $i;?>
            .
            <?= $r['task_name'];?>
            </a> <span class="label label-primary float-right">
            <?= $start_date;?>
            </span> </div>
          <div class="card-body card-task">
            <div class="row">
              <div class="col-sm-12">
                <p class="task-detail">
                  <?= substr($r['summary'],0,70);?>
                </p>
                <p class="task-due"><strong>
                  <?= lang('Invoices.xin_due');?>
                  : </strong><strong class="label label-primary">
                  <?= $end_date;?>
                  </strong></p>
              </div>
              <div class="col-sm-12">
                <div class="progress" style="height: 10px;">
                  <div class="<?= $progress_class;?>" role="progressbar" style="width: <?= $r['task_progress'];?>%;" aria-valuenow="<?= $r['task_progress'];?>" aria-valuemin="0" aria-valuemax="100">
                    <?= $r['task_progress'];?>
                    %</div>
                </div>
              </div>
            </div>
            <hr>
            <div class="task-list-table">
              <?= multi_user_profile_photo($assigned_to);?>
              <a href="#!"><i class="fas fa-plus"></i></a> </div>
            <div class="task-board" style="float: inherit;">
              <div class="dropdown-secondary dropdown"> <a href="<?= site_url('erp/task-detail').'/'.uencode($r['task_id']);?>">
                <?= $status?>
                </a> </div>
              <div class="dropdown-secondary dropdown"> <a href="<?= site_url('erp/task-detail').'/'.uencode($r['task_id']);?>">
                <button class="btn waves-effect waves-light btn-primary btn-sm b-none txt-muted" type="button"><i data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_view_task');?>" class="fas fa-eye m-0"></i></button>
                </a> </div>
              <div class="dropdown-secondary dropdown">
                <button class="btn waves-effect waves-light btn-primary btn-sm dropdown-toggle b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="fas fa-bars"></i></button>
                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut"> <a class="dropdown-item" href="<?= site_url('erp/task-detail').'/'.uencode($r['task_id']);?>"> <i class="feather icon-eye"></i>
                  <?= lang('Projects.xin_view_task');?>
                  </a>
                  <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                  <a class="dropdown-item" href="<?= site_url('erp/task-detail').'/'.uencode($r['task_id']);?>?type=edit"> <i class="feather icon-edit"></i>
                  <?= lang('Projects.xin_edit_task');?>
                  </a>
                  <?php } ?>
                  <?php if(in_array('task4',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
                  <div class="dropdown-divider"></div>
                  <a href="#!" class="dropdown-item delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?= uencode($r['task_id']);?>"><i class="feather icon-trash-2"></i>
                  <?= lang('Projects.xin_remove_task');?>
                  </a>
                  <?php } ?>
                </div>
              </div>
              <div class="dropdown-secondary dropdown"> </div>
            </div>
          </div>
        </div>
      </div>
      <?php $i++;} ?>
    </div>
  </div>
  <!-- [ task-board-right ] end --> 
</div>
<hr>
<div class="p-2">
  <?= $pager->links() ?>
</div>

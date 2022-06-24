<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\TasksModel;
use App\Models\ProjectsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$ProjectsModel = new ProjectsModel();
$TasksModel = new TasksModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$projects = $ProjectsModel->where('company_id', $user_info['company_id'])->findAll();
	$total_tasks = $TasksModel->where('company_id',$user_info['company_id'])->orderBy('task_id', 'ASC')->countAllResults();
	$not_started = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 0)->countAllResults();
	$in_progress = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 1)->countAllResults();
	$completed = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 2)->countAllResults();
	$cancelled = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 3)->countAllResults();
	$hold = $TasksModel->where('company_id',$user_info['company_id'])->where('task_status', 4)->countAllResults();
} else {
	$projects = $ProjectsModel->where('company_id', $usession['sup_user_id'])->findAll();
	$total_tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->orderBy('task_id', 'ASC')->countAllResults();
	$not_started = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 0)->countAllResults();
	$in_progress = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 1)->countAllResults();
	$completed = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 2)->countAllResults();
	$cancelled = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 3)->countAllResults();
	$hold = $TasksModel->where('company_id',$usession['sup_user_id'])->where('task_status', 4)->countAllResults();
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
<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-12">
    <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div id="add_form" class="collapse add-form <?= $get_animate;?>" data-parent="#accordion" style="">
      <div class="card mb-2">
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
    <div class="card user-profile-list">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Projects.xin_tasks');?>
        </h5>
        <div class="card-header-right"> <a href="<?= site_url().'erp/tasks-grid';?>" class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_grid_view');?>"> <i class="fas fa-th-large"></i> </a> 
        <?php if(in_array('task2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
        <a data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
          <?= lang('Main.xin_add_new');?>
        </a>
        <?php }?></div>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo lang('Dashboard.xin_title');?></th>
                <th><i class="fa fa-user"></i> <?php echo lang('Projects.xin_project_users');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                <th><?php echo lang('Projects.xin_status');?></th>
                <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

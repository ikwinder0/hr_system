<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\ProjectsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();
$ProjectsModel = new ProjectsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
	$all_clients = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','customer')->findAll();
	$total_projects = $ProjectsModel->where('company_id',$user_info['company_id'])->countAllResults();
	$not_started = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 0)->countAllResults();
	$in_progress = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 1)->countAllResults();
	$completed = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 2)->countAllResults();
	$cancelled = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 3)->countAllResults();
	$hold = $ProjectsModel->where('company_id',$user_info['company_id'])->where('status', 4)->countAllResults();
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$all_clients = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','customer')->findAll();
	$total_projects = $ProjectsModel->where('company_id',$usession['sup_user_id'])->countAllResults();
	$not_started = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 0)->countAllResults();
	$in_progress = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 1)->countAllResults();
	$completed = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 2)->countAllResults();
	$cancelled = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 3)->countAllResults();
	$hold = $ProjectsModel->where('company_id',$usession['sup_user_id'])->where('status', 4)->countAllResults();
}
$get_animate='';
?>
<?php if(in_array('project1',staff_role_resource()) || in_array('projects_calendar',staff_role_resource()) || in_array('projects_sboard',staff_role_resource()) || $user_info['user_type'] == 'company') {?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('project1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/projects-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-layers"></span>
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
    <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <div id="add_form" class="collapse add-form <?= $get_animate;?>" data-parent="#accordion" style="">
      <?php $attributes = array('name' => 'add_project', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 0);?>
      <?php echo form_open('erp/projects/add_project', $attributes, $hidden);?>
      <div class="card mb-2">
        <div id="accordion">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Projects.xin_project');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="title"><?php echo lang('Dashboard.xin_title');?> <span class="text-danger">*</span></label>
                  <input class="form-control" placeholder="<?php echo lang('Dashboard.xin_title');?>" name="title" type="text">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="client_id"><?php echo lang('Projects.xin_client');?> <span class="text-danger">*</span></label>
                  <select name="client_id" id="client_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_client');?>">
                    <option value=""></option>
                    <?php foreach($all_clients as $client) {?>
                    <option value="<?= $client['user_id']?>">
                    <?= $client['first_name'].' '.$client['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <input type="hidden" value="0" name="assigned_to[]" />
              <div class="col-md-2">
                <div class="form-group">
                  <label for="budget_hours"><?php echo lang('Projects.xin_estimated_hour');?></label>
                  <div class="input-group">
                    <input class="form-control" placeholder="<?php echo lang('Projects.xin_estimated_hour');?>" name="budget_hours" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="employee"><?php echo lang('Projects.xin_p_priority');?></label>
                  <select name="priority" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_p_priority');?>">
                    <option value="1"><?php echo lang('Projects.xin_highest');?></option>
                    <option value="2"><?php echo lang('Projects.xin_high');?></option>
                    <option value="3"><?php echo lang('Projects.xin_normal');?></option>
                    <option value="4"><?php echo lang('Projects.xin_low');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="start_date"><?php echo lang('Projects.xin_start_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_start_date');?>" name="start_date" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="end_date"><?php echo lang('Projects.xin_end_date');?> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo lang('Projects.xin_end_date');?>" name="end_date" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="summary"><?php echo lang('Main.xin_summary');?> <span class="text-danger">*</span></label>
                  <textarea class="form-control" placeholder="<?php echo lang('Main.xin_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo lang('Projects.xin_project_users');?></label>
                  <select multiple name="assigned_to[]" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_project_users');?>">
                    <option value=""></option>
                    <?php foreach($staff_info as $staff) {?>
                    <option value="<?= $staff['user_id']?>">
                    <?= $staff['first_name'].' '.$staff['last_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo lang('Main.xin_description');?></label>
                  <textarea class="form-control editor" placeholder="<?php echo lang('Main.xin_description');?>" name="description" cols="30" rows="2" id="description"></textarea>
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
        </div>
      </div>
      <?= form_close(); ?>
    </div>
    <?php } ?>
    <div class="card user-profile-list">
      <div class="card-header">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Dashboard.left_projects');?>
        </h5>
        <div class="card-header-right"> <a href="<?= site_url().'erp/projects-grid';?>" class="btn btn-sm waves-effect waves-light btn-primary btn-icon m-0" data-toggle="tooltip" data-placement="top" title="<?= lang('Projects.xin_list_view');?>"> <i class="fas fa-th-large"></i> </a>
          <?php if(in_array('project2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
          <a data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
          <?= lang('Main.xin_add_new');?>
          </a>
          <?php } ?>
        </div>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo lang('Dashboard.left_projects');?></th>
                <th><?php echo lang('Projects.xin_client');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_start_date');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo lang('Projects.xin_end_date');?></th>
                <th><i class="fa fa-user"></i> <?php echo lang('Projects.xin_project_users');?></th>
                <th><?php echo lang('Projects.xin_p_priority');?></th>
                <th><?php echo lang('Projects.dashboard_xin_progress');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

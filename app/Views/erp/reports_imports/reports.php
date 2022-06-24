<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\TasksModel;
use App\Models\AccountsModel;
use App\Models\ProjectsModel;
use App\Models\LanguageModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$TasksModel = new TasksModel();
$AccountsModel = new AccountsModel();
$ProjectsModel = new ProjectsModel();
$LanguageModel = new LanguageModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$xin_system = $SystemModel->where('setting_id', 1)->first();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
if($user_info['user_type'] == 'staff'){
   $staff_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
   $tasks = $TasksModel->where('company_id',$user_info['company_id'])->orderBy('task_id', 'ASC')->findAll();
   $accounts = $AccountsModel->where('company_id', $user_info['company_id'])->orderBy('account_id', 'ASC')->findAll();
   $projects = $ProjectsModel->where('company_id', $user_info['company_id'])->findAll();
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$tasks = $TasksModel->where('company_id',$usession['sup_user_id'])->orderBy('task_id', 'ASC')->findAll();
	$accounts = $AccountsModel->where('company_id', $usession['sup_user_id'])->orderBy('account_id', 'ASC')->findAll();
	$projects = $ProjectsModel->where('company_id', $usession['sup_user_id'])->findAll();
}
?>
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="row justify-content-center text-center">
            <div class="col-xl-8 col-md-10">
                <h2 class="mt-2">
                    <?= lang('Main.xin_daily_live_reports');?>
                </h2>
                <p class="my-4"><?= lang('Main.xin_daily_live_report_details_text');?>
</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card user-card user-card-1">
            <div class="nav flex-column nav-pills list-group list-group-flush list-pills" id="user-set-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link list-group-item list-group-item-action active" id="user-set-attendance-tab" data-toggle="pill" href="#user-set-attendance" role="tab" aria-controls="user-set-attendance" aria-selected="true">
                    <span class="f-w-500"><i class="feather icon-clock m-r-10 h5 "></i><?= lang('Dashboard.left_attendance');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-payroll-tab" data-toggle="pill" href="#user-set-payroll" role="tab" aria-controls="user-set-payroll" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-speaker m-r-10 h5 "></i><?= lang('Dashboard.left_payroll');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-projects-tab" data-toggle="pill" href="#user-set-projects" role="tab" aria-controls="user-set-projects" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-layers m-r-10 h5 "></i><?= lang('Dashboard.left_projects');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-tasks-tab" data-toggle="pill" href="#user-set-tasks" role="tab" aria-controls="user-set-tasks" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-edit m-r-10 h5 "></i><?= lang('Dashboard.left_tasks');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-invoices-tab" data-toggle="pill" href="#user-set-invoices" role="tab" aria-controls="user-set-invoices" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-calendar m-r-10 h5 "></i><?= lang('Dashboard.xin_invoices_title');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-leave-tab" data-toggle="pill" href="#user-set-leave" role="tab" aria-controls="user-set-leave" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-plus-square m-r-10 h5 "></i><?= lang('Leave.left_leave');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-training-tab" data-toggle="pill" href="#user-set-training" role="tab" aria-controls="user-set-training" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-target m-r-10 h5 "></i><?= lang('Dashboard.left_training');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-statement-tab" data-toggle="pill" href="#user-set-statement" role="tab" aria-controls="user-set-statement" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-credit-card m-r-10 h5 "></i><?= lang('Main.xin_account_statement');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-purchases-tab" data-toggle="pill" href="#user-set-purchases" role="tab" aria-controls="user-set-purchases" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-calendar m-r-10 h5 "></i><?= lang('Inventory.xin_purchases');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
                <a class="nav-link list-group-item list-group-item-action" id="user-set-sales_order-tab" data-toggle="pill" href="#user-set-sales_order" role="tab" aria-controls="user-set-sales_order" aria-selected="false">
                    <span class="f-w-500"><i class="feather icon-codepen m-r-10 h5 "></i><?= lang('Inventory.xin_sales_order');?></span>
                    <span class="float-right"><i class="feather icon-chevron-right"></i></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="tab-content" id="user-set-tabContent">
            <div class="tab-pane fade show active" id="user-set-attendance" role="tabpanel" aria-labelledby="user-set-attendance-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_monthly_attendance_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'monthly_attendance_report', 'id' => 'monthly_attendance', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/attendance-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Dashboard.dashboard_employee');?></h6>
                        <?php if($user_info['user_type'] == 'staff'){?>
                        <select id="S" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>" name="S">
                          <?php foreach($staff_info as $_user) {?>
                          <?php if($usession['sup_user_id']== $_user['user_id']):?>
                          <option value="<?= uencode($_user['user_id'])?>">
                          <?= $_user['first_name'].' '.$_user['last_name'];?>
                          </option>
                          <?php endif;?>
                          <?php } ?>
                        </select>
                        <?php } else {?>
                        <select id="S" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>" name="S">
                          <?php foreach($staff_info as $_user) {?>
                          <option value="<?= uencode($_user['user_id'])?>">
                          <?= $_user['first_name'].' '.$_user['last_name'];?>
                          </option>
                          <?php } ?>
                        </select>
                        <?php } ?>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Payroll.xin_select_month');?></h6>
                        <div class="input-group mb-3">
                            <input class="form-control hr_month_year" readonly="readonly" placeholder="<?= lang('Payroll.xin_select_month');?>" name="M" type="text" value="<?= date('Y-m');?>">
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-payroll" role="tabpanel" aria-labelledby="user-set-payroll-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_payroll_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'payroll_report', 'id' => 'payroll_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/payroll-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Dashboard.dashboard_employee');?></h6>
                        <?php if($user_info['user_type'] == 'staff'){?>
                        <select class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>" name="S">
						  <?php foreach($staff_info as $_user) {?>
                          <?php if($usession['sup_user_id']== $_user['user_id']):?>
                          <option value="<?= uencode($_user['user_id'])?>">
                          <?= $_user['first_name'].' '.$_user['last_name'];?>
                          </option>
                          <?php endif;?>
                          <?php } ?>
                        </select>
                        <?php } else {?>
                        <select class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.dashboard_employee');?>" name="S">
                          <?php foreach($staff_info as $_user) {?>
                          <option value="all_employees"><?= lang('Main.xin_all_employees');?></option>
                          <option value="<?= uencode($_user['user_id'])?>">
                          <?= $_user['first_name'].' '.$_user['last_name'];?>
                          </option>
                          <?php } ?>
                        </select>
                        <?php } ?>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Payroll.xin_select_month');?></h6>
                        <div class="input-group mb-3">
                            <input class="form-control hr_month_year" readonly="readonly" placeholder="<?= lang('Payroll.xin_select_month');?>" name="M" type="text" value="<?= date('Y-m');?>">
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-projects" role="tabpanel" aria-labelledby="user-set-projects-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_project_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'project_report', 'id' => 'project_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/project-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Projects.xin_project');?></h6>
                          <select class="form-control" name="P" data-plugin="select_hrm" data-placeholder="<?php echo lang('Projects.xin_project');?>">
                            <option value="all_project"><?= lang('Main.xin_all_projects');?></option>
                            <?php foreach($projects as $iprojects) {?>
                            <option value="<?= uencode($iprojects['project_id']);?>">
                            <?= $iprojects['title'] ?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Main.dashboard_xin_status');?></h6>
                        <div class="input-group mb-3">
                            <select class="form-control" data-plugin="select_hrm" name="S">
                            <option value="all_status"><?= lang('Main.xin_all_status');?></option>
                            <option value="0">
                            <?= lang('Projects.xin_not_started');?>
                            </option>
                            <option value="1">
                            <?= lang('Projects.xin_in_progress');?>
                            </option>
                            <option value="3">
                            <?= lang('Projects.xin_project_cancelled');?>
                            </option>
                            <option value="4">
                            <?= lang('Projects.xin_project_hold');?>
                            </option>
                            <option value="2">
                            <?= lang('Projects.xin_completed');?>
                            </option>
                          </select>
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-tasks" role="tabpanel" aria-labelledby="user-set-tasks-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_task_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'task_report', 'id' => 'task_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/task-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Dashboard.left_tasks');?></h6>
                          <select class="form-control" name="T" data-plugin="select_hrm" data-placeholder="<?php echo lang('Dashboard.left_tasks');?>">
                            <option value="all_tasks"><?= lang('Main.xin_all_tasks');?></option>
                            <?php foreach($tasks as $_task) {?>
                            <option value="<?= uencode($_task['task_id']);?>">
                            <?= $_task['task_name'] ?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Main.dashboard_xin_status');?></h6>
                        <div class="input-group mb-3">
                            <select class="form-control" data-plugin="select_hrm" name="S">
                            <option value="all_status"><?= lang('Main.xin_all_status');?></option>
                            <option value="0">
                            <?= lang('Projects.xin_not_started');?>
                            </option>
                            <option value="1">
                            <?= lang('Projects.xin_in_progress');?>
                            </option>
                            <option value="3">
                            <?= lang('Projects.xin_project_cancelled');?>
                            </option>
                            <option value="4">
                            <?= lang('Projects.xin_project_hold');?>
                            </option>
                            <option value="2">
                            <?= lang('Projects.xin_completed');?>
                            </option>
                          </select>
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-invoices" role="tabpanel" aria-labelledby="user-set-invoices-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_invoice_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'invoice_report', 'id' => 'invoice_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/invoice-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_start_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="S" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_end_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="E" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Main.dashboard_xin_status');?></h6>
                        <div class="input-group mb-3">
                            <select class="form-control" data-plugin="select_hrm" name="P">
                            <option value="all_status"><?= lang('Main.xin_all_status');?></option>
                            <option value="0">
                            <?= lang('Invoices.xin_unpaid');?>
                            </option>
                            <option value="1">
                            <?= lang('Invoices.xin_paid');?>
                            </option>
                          </select>
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-leave" role="tabpanel" aria-labelledby="user-set-leave-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_leave_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'leave_report', 'id' => 'leave_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/leave-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_start_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="S" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_end_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="E" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Main.dashboard_xin_status');?></h6>
                        <div class="input-group mb-3">
                            <select class="form-control" data-plugin="select_hrm" name="P" autocomplete="off">
                              <option value="all_status"><?= lang('Main.xin_all_status');?></option>
                              <option value="1">
                              <?= lang('Main.xin_pending');?>
                              </option>
                              <option value="2">
                              <?= lang('Main.xin_approved');?>
                              </option>
                              <option value="3">
                              <?= lang('Main.xin_rejected');?>
                              </option>
                            </select>
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-training" role="tabpanel" aria-labelledby="user-set-training-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_training_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'training_report', 'id' => 'training_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/training-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_start_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="S" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_end_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="E" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Main.dashboard_xin_status');?></h6>
                        <select class="form-control" name="P" data-plugin="select_hrm" data-placeholder="<?= lang('Main.dashboard_xin_status');?>">
                           <option value="all_status"><?= lang('Main.xin_all_status');?></option>
                           <option value="0">
                          <?= lang('Main.xin_pending');?>
                          </option>
                          <option value="1">
                          <?= lang('Projects.xin_started');?>
                          </option>
                          <option value="2">
                          <?= lang('Projects.xin_completed');?>
                          </option>
                          <option value="3">
                          <?= lang('Main.xin_rejected');?>
                          </option>
                        </select>
                        </div>
                        </div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-statement" role="tabpanel" aria-labelledby="user-set-statement-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Main.xin_account_statement_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'account_statement', 'id' => 'account_statement', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/account-statement', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_start_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="S" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_end_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="E" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Employees.xin_account_title');?></h6>
                        <select class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_account_title');?>" name="A">
                          <?php foreach($accounts as $iaccounts) {?>
                          <option value="<?php echo uencode($iaccounts['account_id']);?>"><?php echo $iaccounts['account_name'];?></option>
                          <?php } ?>
                        </select>
                        </div>
                        </div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-purchases" role="tabpanel" aria-labelledby="user-set-purchases-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Inventory.xin_purchases_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'purchases_report', 'id' => 'purchases_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/purchases-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_start_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="S" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_end_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="E" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Main.dashboard_xin_status');?></h6>
                        <div class="input-group mb-3">
                            <select class="form-control" data-plugin="select_hrm" name="P" autocomplete="off">
                              <option value="all_status"><?= lang('Main.xin_all_status');?></option>
                              <option value="0">
                              <?= lang('Main.xin_pending');?>
                              </option>
                              <option value="1">
                              <?= lang('Inventory.xin_delivered');?>
                              </option>
                              <option value="2">
                              <?= lang('Main.xin_cancelled');?>
                              </option>
                            </select>
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="user-set-sales_order" role="tabpanel" aria-labelledby="user-set-sales_order-tab">
                <div class="card recent-operations-card">
                    <div class="card-header">
                        <h5><?= lang('Inventory.xin_sales_order_report');?></h5>
                    </div>
                    <?php $attributes = array('name' => 'sales_report', 'id' => 'sales_report', 'method' => 'GET', 'target' => '_blank');?>
					<?php $hidden = array('token' => uencode(date('Y-m')));?>
                    <?php echo form_open('erp/sales-order-report', $attributes, $hidden);?>
                    <div class="card-body">
                    	<div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_start_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_start_date');?>" name="S" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                        	<h6 class="m-b-15 text-primary"><?= lang('Projects.xin_end_date');?></h6>
                            <div class="input-group mb-3">
                            <input class="form-control date" placeholder="<?= lang('Projects.xin_end_date');?>" name="E" type="text" value="<?= date('Y-m-d');?>">
                        </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <h6 class="m-b-15 text-primary"><?= lang('Main.dashboard_xin_status');?></h6>
                        <div class="input-group mb-3">
                            <select class="form-control" data-plugin="select_hrm" name="P" autocomplete="off">
                              <option value="all_status"><?= lang('Main.xin_all_status');?></option>
                              <option value="0">
                              <?= lang('Invoices.xin_unpaid');?>
                              </option>
                              <option value="1">
                              <?= lang('Invoices.xin_paid');?>
                              </option>
                              <option value="2">
                              <?= lang('Projects.xin_project_cancelled');?>
                              </option>
                              <option value="3">
                              <?= lang('Inventory.xin_packed_orders_text');?>
                              </option>
                              <option value="4">
                              <?= lang('Inventory.xin_delivered_orders_text');?>
                              </option>
                            </select>
                        </div>
                        </div></div></div>
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                    <?= lang('Main.xin_filter');?>
                    </button>
                  </div>
                  <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\InvoicesModel;
use App\Models\ProjectsModel;
use App\Models\TasksModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$InvoicesModel = new InvoicesModel();
$ProjectsModel = new ProjectsModel();
$TasksModel = new TasksModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$get_projects = $ProjectsModel->where('client_id',$usession['sup_user_id'])->findAll();
$completed_projects = $ProjectsModel->where('client_id',$usession['sup_user_id'])->where('status',2)->countAllResults();
$total_invoices = $InvoicesModel->where('client_id',$usession['sup_user_id'])->countAllResults();
$total_projects = $ProjectsModel->where('client_id',$usession['sup_user_id'])->countAllResults();
$total_tasks = 0;
foreach($get_projects as $_project){
	$total_tasks += $TasksModel->where('project_id',$_project['project_id'])->countAllResults();
}
?>

<div class="row">
  <div class="col-xl-6 col-md-12">
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="row">
          <div class="col-sm-6">
            <div class="card prod-p-card background-pattern">
              <div class="card-body">
                <div class="row align-items-center m-b-0">
                  <div class="col">
                    <h6 class="m-b-5">
                      <?= lang('Projects.xin_total_projects');?>
                    </h6>
                    <h3 class="m-b-0">
                      <?= $total_projects;?>
                    </h3>
                  </div>
                  <div class="col-auto"> <i class="fas fa-money-bill-alt text-primary"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card prod-p-card bg-primary background-pattern-white">
              <div class="card-body">
                <div class="row align-items-center m-b-0">
                  <div class="col">
                    <h6 class="m-b-5 text-white">
                      <?= lang('Projects.xin_total_tasks');?>
                    </h6>
                    <h3 class="m-b-0 text-white">
                      <?= $total_tasks;?>
                    </h3>
                  </div>
                  <div class="col-auto"> <i class="fas fa-database text-white"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card prod-p-card bg-success background-pattern-white">
              <div class="card-body">
                <div class="row align-items-center m-b-0">
                  <div class="col">
                    <h6 class="m-b-5 text-white">
                      <?= lang('Projects.xin_total_invoices');?>
                    </h6>
                    <h3 class="m-b-0 text-white">
                      <?= $total_invoices;?>
                    </h3>
                  </div>
                  <div class="col-auto"> <i class="fas fa-dollar-sign text-white"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card prod-p-card background-pattern">
              <div class="card-body">
                <div class="row align-items-center m-b-0">
                  <div class="col">
                    <h6 class="m-b-5">
                      <?= lang('Projects.xin_completed_projects');?>
                    </h6>
                    <h3 class="m-b-0">
                      <?= $completed_projects;?>
                    </h3>
                  </div>
                  <div class="col-auto"> <i class="fas fa-tags text-primary"></i> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h6>
              <?= lang('Projects.xin_tasks_status');?>
            </h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="client-task-status-chart"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-md-12">
            <div class="card table-card">
              <div class="card-header">
                <h5>
                  <?= lang('Dashboard.left_projects');?>
                </h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <div class="sale-scroll" style="height:220px;position:relative;">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th><?= lang('Dashboard.left_projects');?>
                          </th>
                          <th><?= lang('Projects.xin_p_priority');?></th>
                          <th><?= lang('Invoices.xin_due_date');?></th>
                          <th class="text-right"><?= lang('Main.dashboard_xin_status');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($get_projects as $r){ ?>
                        <?php
						// status			
						if($r['status'] == 0) {
							$status = '<label class="badge badge-light-warning">'.lang('Projects.xin_not_started').'</label>';
						} else if($r['status'] ==1){
							$status = '<label class="badge badge-light-primary">'.lang('Projects.xin_in_progress').'</label>';
						} else if($r['status'] ==2){
							$status = '<label class="badge badge-light-success">'.lang('Projects.xin_completed').'</label>';
						} else if($r['status'] ==3){
							$status = '<label class="badge badge-light-danger">'.lang('Projects.xin_project_cancelled').'</label>';
						} else {
							$status = '<label class="badge badge-light-danger">'.lang('Projects.xin_project_hold').'</label>';
						}
						// priority
						if($r['priority'] == 1) {
							$priority = '<label class="badge badge-light-danger">'.lang('Projects.xin_highest').'</label>';
						} else if($r['priority'] ==2){
							$priority = '<label class="badge badge-light-danger">'.lang('Projects.xin_high').'</label>';
						} else if($r['priority'] ==3){
							$priority = '<label class="badge badge-light-primary">'.lang('Projects.xin_normal').'</label>';
						} else {
							$priority = '<label class="badge badge-light-success">'.lang('Projects.xin_low').'</label>';
						}
						// project progress
						if($r['project_progress'] <= 20) {
							$progress_class = 'bg-danger';
						} else if($r['project_progress'] > 20 && $r['project_progress'] <= 50){
							$progress_class = 'bg-warning';
						} else if($r['project_progress'] > 50 && $r['project_progress'] <= 75){
							$progress_class = 'bg-info';
						} else {
							$progress_class = 'bg-success';
						}
						
						$progress_bar = '<div class="progress" style="height: 10px;"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" style="width: '.$r['project_progress'].'%;" aria-valuenow="'.$r['project_progress'].'" aria-valuemin="0" aria-valuemax="100">'.$r['project_progress'].'%</div></div>';
						?>
                        <tr>
                          <td><div class="d-inline-block align-middle">
                              <div class="d-inline-block">
                                <h6 class="text-muted m-b-0">
                                  <?= $r['title'];?>
                                </h6>
                                <?= $progress_bar;?>
                              </div>
                            </div></td>
                          <td><?= $priority;?></td>
                          <td><?= set_date_format($r['end_date']);?></td>
                          <td class="text-right"><?= $status;?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-12">
    <div class="card">
      <div class="card-header">
        <h5>
          <?= lang('Dashboard.xin_acc_invoice_payments');?>
        </h5>
      </div>
      <div class="card-body">
        <div class="row pb-2">
          <div class="col-auto m-b-10">
            <h3 class="mb-1">
              <?= number_to_currency(client_total_paid_invoices(), $xin_system['default_currency'],null,2);?>
            </h3>
            <span>
            <?= lang('Invoices.xin_total_paid');?>
            </span> </div>
          <div class="col-auto m-b-10">
            <h3 class="mb-1">
              <?= number_to_currency(client_total_unpaid_invoices(), $xin_system['default_currency'],null,2);?>
            </h3>
            <span>
            <?= lang('Invoices.xin_total_unpaid');?>
            </span> </div>
        </div>
        <div id="client-paid-invoice-chart"></div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h6>
          <?= lang('Projects.xin_projects_status');?>
        </h6>
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col">
            <div id="client-project-status-chart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

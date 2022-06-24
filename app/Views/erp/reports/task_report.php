<?php
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\MainModel;
use App\Models\TasksModel;
use App\Models\ProjectsModel;

$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$MainModel = new MainModel();
$TasksModel = new TasksModel();
$ProjectsModel = new ProjectsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
if($_REQUEST['T']=='all_tasks'){
	$get_id = $_REQUEST['T'];
} else {
	$get_id = udecode($_REQUEST['T']);
}

$get_id = $get_id;
$status = $_REQUEST['S'];

//$attendance_date = $date_info;

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	if($get_id == 'all_tasks' && $status == 'all_status'){
		$task_data = $TasksModel->where('company_id', $user_info['company_id'])->findAll();
	} else if($get_id == 'all_tasks' && $status != 'all_status'){
		$task_data = $TasksModel->where('company_id', $user_info['company_id'])->where('status', $status)->findAll();
	} else if($get_id != 'all_tasks' && $status == 'all_status'){
		$task_data = $TasksModel->where('company_id', $user_info['company_id'])->where('task_id', $get_id)->findAll();
	} else {
		$task_data = $TasksModel->where('company_id', $user_info['company_id'])->where('task_id', $get_id)->where('status', $status)->findAll();
	}
} else {
	if($get_id == 'all_tasks' && $status == 'all_status'){
		$task_data = $TasksModel->where('company_id', $usession['sup_user_id'])->findAll();
	} else if($get_id == 'all_tasks' && $status != 'all_status'){
		$task_data = $TasksModel->where('company_id', $usession['sup_user_id'])->where('status', $status)->findAll();
	} else if($get_id != 'all_tasks' && $status == 'all_status'){
		$task_data = $TasksModel->where('company_id', $usession['sup_user_id'])->where('task_id', $get_id)->findAll();
	} else {
		$task_data = $TasksModel->where('company_id', $usession['sup_user_id'])->where('task_id', $get_id)->where('status', $status)->findAll();
	}
}
$xin_system = erp_company_settings();
$ci_erp_settings = $SystemModel->where('setting_id', 1)->first();
?>
<?php
?>
<?php
/*$date_info = strtotime($req_month_year.'-01');
$imonth_year = explode('-',$req_month_year);
$day = date('d', $date_info);
$month = date($imonth_year[1], $date_info);
$year = date($imonth_year[0], $date_info);


$date = date("F, Y", strtotime($req_month_year.'-01'));//strtotime(date("Y-m-d"),$date_info);
// total days in month
$daysInMonth =  date('t');
//$date = strtotime(date("Y-m-d"));
$day = date('d', $date_info);
$month = date('m', $date_info);
$year = date('Y', $date_info);
$month_year = date('Y-m');*/
?>

<div class="row justify-content-md-center"> 
  <!-- [ Attendance view ] start -->
  <div class="col-md-10"> 
    <!-- [ Attendance view ] start -->
    <div class="container">
      <div>
        <div class="card" id="printTable">
          <div class="card-header">
            <h5><img class="img-fluid" width="171" height="30" src="<?= base_url();?>/public/uploads/logo/other/<?= $ci_erp_settings['other_logo'];?>" alt=""></h5>
          </div>
          <div class="card-body pb-0">
            <div class="row invoive-info d-pdrint-inline-flex">
              <div class="col-md-8">
                    <h6 class="text-primary">Tasks Report</h6>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                  <table class="table m-b-0 f-14 b-solid requid-table">
                    <thead>
                      <tr class="text-uppercase">
                        <th><?php echo lang('Dashboard.xin_title');?></th>
                        <th><?php echo lang('Projects.xin_project_users');?></th>
                        <th><?php echo lang('Projects.xin_start_date');?></th>
                        <th><?php echo lang('Projects.xin_end_date');?></th>
                        <th><?php echo lang('Projects.xin_status');?></th>
                        <th><?php echo lang('Projects.xin_completed');?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($task_data as $_task) { ?>
                      <?php
                      	$_assigned_to = explode(',',$_task['assigned_to']);
					  	$multi_users = multi_users_info($_assigned_to);
						$start_date = set_date_format($_task['start_date']);
						$end_date = set_date_format($_task['end_date']);
						// task status			
						if($_task['task_status'] == 0) {
							$status = '<span class="text-warning">'.lang('Projects.xin_not_started').'</span>';
						} else if($_task['task_status'] ==1){
							$status = '<span class="text-primary">'.lang('Projects.xin_in_progress').'</span>';
						} else if($_task['task_status'] ==2){
							$status = '<span class="text-success">'.lang('Projects.xin_completed').'</span>';
						} else if($_task['task_status'] ==3){
							$status = '<span class="text-danger">'.lang('Projects.xin_project_cancelled').'</span>';
						} else {
							$status = '<span class="text-danger">'.lang('Projects.xin_project_hold').'</span>';
						}
					  ?>
                      <tr>
                        <td width="150"><?= $_task['task_name'];?></td>
                        <td width="200"><?= $multi_users;?></td>
                        <td><?= $start_date;?></td>
                        <td><?= $end_date;?></td>
                        <td><?= $status;?></td>
                        <td><?= $_task['task_progress'].'%';?></td>
                      </tr>
                    <?php } ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center d-print-none">
          <div class="col-sm-12 invoice-btn-group text-center">
            <button type="button" class="btn btn-print-invoice waves-effect waves-light btn-success m-b-10">
            <?= lang('Main.xin_print');?>
            </button>
           </div>
        </div>
      </div>
    </div>
    <!-- [ Attendance view ] end --> 
  </div>
</div>

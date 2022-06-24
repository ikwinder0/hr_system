<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$LanguageModel = new LanguageModel();

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
} else {
	$staff_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
	$all_clients = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','customer')->findAll();
}
?>

<div class="card user-profile-list">
<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo lang('Main.xin_list_all');?></strong> <?php echo lang('Dashboard.left_projects');?></span> </div>
<div class="card-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
            <th><?php echo lang('Dashboard.left_projects');?></th>
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

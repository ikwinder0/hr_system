<?php
use App\Models\SystemModel;
use App\Models\SuperroleModel;
use App\Models\UsersModel;
use App\Models\MembershipModel;
use App\Models\CompanymembershipModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$SuperroleModel = new SuperroleModel();
$MembershipModel = new MembershipModel();
$CompanymembershipModel = new CompanymembershipModel();
$session = \Config\Services::session();
$router = service('router');
$usession = $session->get('sup_username');
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$xin_system = $SystemModel->where('setting_id', 1)->first();
?>
<?php $arr_mod = select_module_class($router->controllerName(),$router->methodName()); ?>
<?php 
if($user_info['user_type'] == 'staff'){
	$cmembership = $CompanymembershipModel->where('company_id', $user_info['company_id'])->first();
} else {
	$cmembership = $CompanymembershipModel->where('company_id', $usession['sup_user_id'])->first();
}

//$mem_info = $MembershipModel->where('membership_id', $cmembership['membership_id'])->first();
//$modules_permission = unserialize($mem_info['modules_permission']);
$xin_com_system = erp_company_settings();
$setup_modules = unserialize($xin_com_system['setup_modules']);
?>

<ul class="pc-navbar">
  <li class="pc-item pc-caption">
    <label>
      <?= lang('Dashboard.dashboard_your_company');?>
    </label>
  </li>
  <!-- Dashboard|Home -->
  <li class="pc-item"><a href="<?= site_url('erp/desk');?>" class="pc-link "><span class="pc-micon"><i data-feather="home"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.dashboard_title');?>
    </span></a></li>
  <!-- Employees -->
  <li class="pc-item"><a href="<?= site_url('erp/staff-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="users"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.dashboard_employees');?>
    </span></a></li>

</ul>

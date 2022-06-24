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

<ul class="pc-navbar">
  <li class="pc-item pc-caption">
    <label>
      <?= lang('Main.xin_navigation');?>
    </label>
  </li>
  <!-- Dashboard|Home -->
  <li class="pc-item"><a href="<?= site_url('erp/desk');?>" class="pc-link "><span class="pc-micon"><i data-feather="home"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.dashboard_title');?>
    </span></a></li>
  <!-- Companies -->
  <li class="pc-item <?php if(!empty($arr_mod['companies_active']))echo $arr_mod['companies_active'];?>"><a href="<?= site_url('erp/companies-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="users"></i></span><span class="pc-mtext">
    <?= lang('Company.xin_companies');?>
    </span></a></li>
  
</ul>

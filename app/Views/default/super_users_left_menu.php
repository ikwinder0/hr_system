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
  <!-- Membership -->
  <li class="pc-item <?php if(!empty($arr_mod['membership_active']))echo $arr_mod['membership_active'];?>"><a href="<?= site_url('erp/membership-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="calendar"></i></span><span class="pc-mtext">
    <?= lang('Membership.xin_membership');?>
    </span></a></li>
  <!-- Super Users -->
  <li class="pc-item <?php if(!empty($arr_mod['users_active']))echo $arr_mod['users_active'];?>"><a href="<?= site_url('erp/super-users');?>" class="pc-link "><span class="pc-micon"><i data-feather="user-plus"></i></span><span class="pc-mtext">
    <?= lang('Main.xin_super_users');?>
    </span></a></li>
  <!-- User Roles -->
  <li class="pc-item"><a href="<?= site_url('erp/users-role');?>" class="pc-link "><span class="pc-micon"><i data-feather="lock"></i></span><span class="pc-mtext">
    <?= lang('Users.xin_hr_report_user_roles');?>
    </span></a></li>
  <!-- Billing Invoices -->
  <li class="pc-item <?php if(!empty($arr_mod['billing_details_active']))echo $arr_mod['billing_details_active'];?>"><a href="<?= site_url('erp/billing-invoices');?>" class="pc-link "><span class="pc-micon"><i data-feather="credit-card"></i></span><span class="pc-mtext">
    <?= lang('Membership.xin_billing_invoices');?>
    </span></a></li>
  <li class="pc-item pc-caption">
    <label>
      <?= lang('Main.left_settings');?>
    </label>
    <span>
    <?= lang('Main.header_configuration');?>
    </span> </li>
  <!-- COnfiguration Wizard -->
  <li class="pc-item <?php if(!empty($arr_mod['constants_active']))echo $arr_mod['constants_active'];?>"><a href="<?= site_url('erp/system-settings');?>" class="pc-link "><span class="pc-micon"><i data-feather="settings"></i></span><span class="pc-mtext">
    <?= lang('Main.xin_configuration_wizard');?>
    </span></a></li>
  <!-- Currency Converter -->
  <li class="pc-item"><a href="<?= site_url('erp/currency-converter');?>" class="pc-link "><span class="pc-micon"><i data-feather="pocket"></i></span><span class="pc-mtext">
    <?= lang('Main.xin_currency_converter');?>
    </span></a></li>
  <!-- Database Backup -->
  <li class="pc-item"><a href="<?= site_url('erp/system-backup');?>" class="pc-link "><span class="pc-micon"><i data-feather="download-cloud"></i></span><span class="pc-mtext">
    <?= lang('Main.header_db_log');?>
    </span></a></li>
</ul>

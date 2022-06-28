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
    <!-- CoreHR -->
  <li class="pc-item <?php if(!empty($arr_mod['corehr_open']))echo $arr_mod['corehr_open'];?>"> <a href="#" class="pc-link sidenav-toggle"> <span class="pc-micon"><i data-feather="crosshair"></i></span>
    <?= lang('Dashboard.dashboard_core_hr');?>
    </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span> </a>
    <ul class="pc-submenu" <?php if(!empty($arr_mod['core_style_ul']))echo $arr_mod['core_style_ul'];?>>
      <li class="pc-item <?php if(!empty($arr_mod['department_active']))echo $arr_mod['department_active'];?>"> <a class="pc-link" href="<?= site_url('erp/departments-list');?>" >
        <?= lang('Dashboard.left_department');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['designation_active']))echo $arr_mod['designation_active'];?>"> <a class="pc-link" href="<?= site_url('erp/designation-list');?>" >
        <?= lang('Dashboard.left_designation');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['policies_active']))echo $arr_mod['policies_active'];?>"> <a class="pc-link" href="<?= site_url('erp/policies-list');?>" >
        <?= lang('Dashboard.header_policies');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['announcements_active']))echo $arr_mod['announcements_active'];?>"> <a class="pc-link" href="<?= site_url('erp/news-list');?>" >
        <?= lang('Dashboard.left_announcement_make');?>
        </a> </li>
        <?php if(isset($setup_modules['orgchart'])): if($setup_modules['orgchart']==1):?>
      <li class="pc-item <?php if(!empty($arr_mod['org_chart']))echo $arr_mod['org_chart'];?>"> <a class="pc-link" href="<?= site_url('erp/chart');?>" >
        <?= lang('Dashboard.xin_org_chart_title');?>
        </a> </li>
        <?php endif; endif;?>
    </ul>
  </li>
  <!-- Attendance -->
  <li class="pc-item pc-hasmenu <?php if(!empty($arr_mod['attendance_open']))echo $arr_mod['attendance_open'];?>"> <a href="#" class="pc-link sidenav-toggle"><span class="pc-micon"><i data-feather="clock"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_attendance');?>
    </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
    <ul class="pc-submenu" <?php if(!empty($arr_mod['attendance_style_ul']))echo $arr_mod['attendance_style_ul'];?>>
      <li class="pc-item <?php if(!empty($arr_mod['attnd_active']))echo $arr_mod['attnd_active'];?>"> <a class="pc-link" href="<?= site_url('erp/attendance-list');?>" >
        <?= lang('Dashboard.left_attendance');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['upd_attnd_active']))echo $arr_mod['upd_attnd_active'];?>"> <a class="pc-link" href="<?= site_url('erp/manual-attendance');?>" >
        <?= lang('Dashboard.left_update_attendance');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['timesheet_active']))echo $arr_mod['timesheet_active'];?>"> <a class="pc-link" href="<?= site_url('erp/monthly-attendance');?>" >
        <?= lang('Dashboard.xin_month_timesheet_title');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['timesheet_active']))echo $arr_mod['timesheet_active'];?>"> <a class="pc-link" href="<?= site_url('erp/overtime-request');?>" >
        <?= lang('Dashboard.xin_overtime_request');?>
        </a> </li>
    </ul>
  </li>
  <!-- Finance -->
  <li class="pc-item"> <a href="<?= site_url('erp/accounts-list');?>" class="pc-link"> <span class="pc-micon"><i data-feather="credit-card"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_hr_finance');?>
    </span> </a> </li>
  <!-- Payroll -->
  <li class="pc-item"> <a href="<?= site_url('erp/payroll-list');?>" class="pc-link"> <span class="pc-micon"><i data-feather="speaker"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_payroll');?>
    </span> </a> </li>
    <?php if(isset($setup_modules['inventory'])): if($setup_modules['inventory']==1):?>
    <li class="pc-item pc-hasmenu">
        <a href="#!" class="pc-link"><span class="pc-micon"><i data-feather="menu"></i></span><span class="pc-mtext"><?= lang('Inventory.xin_inventory_control');?></span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
        <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/warehouse-list');?>"><?= lang('Inventory.xin_warehouses');?></a></li>
            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link"><?= lang('Inventory.xin_products');?><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/product-list');?>"><?= lang('Inventory.xin_products');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/out-of-stock-products');?>"><?= lang('Inventory.xin_out_of_stock');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/expired-products');?>"><?= lang('Inventory.xin_expired_products');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/tax-type');?>"><?= lang('Inventory.xin_product_tax');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/products-category');?>"><?= lang('Inventory.xin_product_category');?></a></li>
                </ul>
            </li>
            <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/suppliers-list');?>"><?= lang('Inventory.xin_suppliers');?></a></li>
            <li class="pc-item pc-hasmenu">
            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link"><?= lang('Inventory.xin_purchases');?><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/create-purchase');?>"><?= lang('Inventory.xin_new_purchase');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/stock-purchases');?>"><?= lang('Inventory.xin_purchase_list');?></a></li>
                </ul>
            </li>
            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link"><?= lang('Inventory.xin_sales_order');?><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/stock-orders');?>"><?= lang('Inventory.xin_sales_manage');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/create-order');?>"><?= lang('Inventory.xin_add_new_order');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/paid-orders');?>"><?= lang('Inventory.xin_paid_orders');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/unpaid-orders');?>"><?= lang('Inventory.xin_unpaid_orders');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/packed-orders');?>"><?= lang('Inventory.xin_packed_orders');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/delivered-orders');?>"><?= lang('Inventory.xin_delivered_orders');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/cancelled-orders');?>"><?= lang('Inventory.xin_cancelled_orders');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/order-quotes');?>"><?= lang('Inventory.xin_quote_orders');?></a></li>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/create-quote');?>"><?= lang('Inventory.xin_add_quote_order');?></a></li>
                </ul>
            </li>
        </ul>
    </li>
    <?php endif; endif;?>
    <!-- Tasks -->
  <li class="pc-item"> <a href="<?= site_url('erp/tasks-grid');?>" class="pc-link"><span class="pc-micon"><i data-feather="edit"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_tasks');?>
    </span> </a> </li>
  <!-- Projects -->
  <li class="pc-item"> <a href="<?= site_url('erp/projects-grid');?>" class="pc-link"><span class="pc-micon"><i data-feather="layers"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_projects');?>
    </span> </a> </li>
  <!-- Clients -->
  <li class="pc-item"><a href="<?= site_url('erp/clients-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="user-check"></i></span><span class="pc-mtext">
    <?= lang('Projects.xin_manage_clients');?>
    </span></a></li>
  <!-- Leads -->
  <li class="pc-item"><a href="<?= site_url('erp/leads-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="user-plus"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_leads');?>
    </span></a></li>  
  <!-- Performance -->
  <?php if(isset($setup_modules['performance'])): if($setup_modules['performance']==1):?>
  <li class="<?php if(!empty($arr_mod['talent_open']))echo $arr_mod['talent_open'];?> pc-item"> <a href="#" class="pc-link sidenav-toggle"> <span class="pc-micon"><i data-feather="aperture"></i></span>
    <?= lang('Dashboard.left_talent_management');?>
    </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span> </a>
    <ul class="pc-submenu" <?php if(!empty($arr_mod['talent_style_ul']))echo $arr_mod['talent_style_ul'];?>>
      <li class="pc-item <?php if(!empty($arr_mod['indicator_active']))echo $arr_mod['indicator_active'];?>"> <a class="pc-link" href="<?= site_url('erp/performance-indicator-list');?>" >
        <?= lang('Dashboard.left_performance_indicator');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['appraisal_active']))echo $arr_mod['appraisal_active'];?>"> <a class="pc-link" href="<?= site_url('erp/performance-appraisal-list');?>">
        <?= lang('Dashboard.left_performance_appraisal');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['competencies_active']))echo $arr_mod['competencies_active'];?>"> <a class="pc-link" href="<?= site_url('erp/competencies');?>">
        <?= lang('Performance.xin_competencies');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['goal_track_active']))echo $arr_mod['goal_track_active'];?>"> <a class="pc-link" href="<?= site_url('erp/track-goals');?>" >
        <?= lang('Dashboard.xin_hr_goal_tracking');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['tracking_type_active']))echo $arr_mod['tracking_type_active'];?>"> <a class="pc-link" href="<?= site_url('erp/goal-type');?>" >
        <?= lang('Dashboard.xin_hr_goal_tracking_type');?>
        </a> </li>
      <li class="pc-item <?php if(!empty($arr_mod['goals_calendar_active']))echo $arr_mod['goals_calendar_active'];?>"> <a class="pc-link" href="<?= site_url('erp/goals-calendar');?>" >
        <?= lang('Performance.xin_goals_calendar');?>
        </a> </li>
    </ul>
  </li>
  <?php endif; endif;?>
  <?php if(isset($setup_modules['recruitment'])): if($setup_modules['recruitment']==1):?>
  <!-- Recruitment -->
  <li class="pc-item"> <a href="<?= site_url('erp/jobs-list');?>" class="pc-link"> <span class="pc-micon"><i data-feather="gitlab"></i></span><span class="pc-mtext">
    <?= lang('Recruitment.xin_recruitment_ats');?>
    </span> </a> </li>
  <?php endif; endif;?>
  <!-- Tickets -->
  <li class="pc-item"> <a href="<?= site_url('erp/support-tickets');?>" class="pc-link"> <span class="pc-micon"><i data-feather="help-circle"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.dashboard_helpdesk');?>
    </span> </a> </li>
  <!-- Invoices -->
  <li class="pc-item"><a href="<?= site_url('erp/invoices-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="calendar"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_invoices_title');?>
    </span></a></li>
 <!-- Estimates -->
  <li class="pc-item"><a href="<?= site_url('erp/estimates-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="calendar"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_estimates');?>
    </span></a></li>   
  <!-- Leave -->
  <li class="pc-item"> <a href="<?= site_url('erp/leave-list');?>" class="pc-link"> <span class="pc-micon"><i data-feather="plus-square"></i></span><span class="pc-mtext">
    <?= lang('Leave.left_leave_request');?>
    </span> </a> </li>
    <?php if(isset($setup_modules['training'])): if($setup_modules['training']==1):?>
  <!-- Training Session -->
  <li class="pc-item"> <a href="<?= site_url('erp/training-sessions');?>" class="pc-link"> <span class="pc-micon"><i data-feather="target"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_training');?>
    </span> </a> </li>
    <?php endif; endif;?>
  <!-- Disciplinary -->
  <li class="pc-item"> <a href="<?= site_url('erp/disciplinary-cases');?>" class="pc-link"> <span class="pc-micon"><i data-feather="alert-circle"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_warnings');?>
    </span> </a> </li>
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

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
$xin_com_system = erp_company_settings();
$setup_modules = unserialize($xin_com_system['setup_modules']);
?>
<ul class="pc-navbar">
  <li class="pc-item pc-caption">
    <label>
      <?= lang('Main.xin_your_apps');?>
    </label>
  </li>
  <!-- Dashboard|Home -->
  <li class="pc-item"><a href="<?= site_url('erp/desk');?>" class="pc-link "><span class="pc-micon"><i data-feather="home"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.dashboard_title');?>
    </span></a></li>
  <?php if(in_array('attendance',staff_role_resource())) {?>  
  <!-- Attendance -->
  <li class="pc-item"><a href="<?= site_url('erp/attendance-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="clock"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_attendance');?>
    </span></a></li>
  <?php } ?>  
  <?php if(in_array('project1',staff_role_resource())) {?> 
  <!-- Projects -->
  <li class="pc-item"><a href="<?= site_url('erp/projects-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="layers"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_projects');?>
    </span></a></li>
  <?php } ?>  
  <!-- Tasks -->
  <?php if(in_array('task1',staff_role_resource())) {?> 
  <li class="pc-item"><a href="<?= site_url('erp/tasks-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="edit"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_tasks');?>
    </span></a></li>
  <?php } ?>
  <!-- Payroll -->
  <?php if(in_array('pay_history',staff_role_resource())) {?> 
  <li class="pc-item"><a href="<?= site_url('erp/payslip-history');?>" class="pc-link "><span class="pc-micon"><i data-feather="speaker"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_payroll');?>
    </span></a></li>
  <?php } ?>
  <?php if(in_array('leave1',staff_role_resource()) || in_array('expense1',staff_role_resource()) || in_array('overtime_req1',staff_role_resource()) || in_array('travel1',staff_role_resource())) {?>
  <!-- Requests -->
  <li class="pc-item <?php if(!empty($arr_mod['core_request_active']))echo $arr_mod['core_request_active'];?>"> <a href="#" class="pc-link sidenav-toggle"> <span class="pc-micon"><i data-feather="list"></i></span>
    <?= lang('Dashboard.dashboard_requests');?>
    </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span> </a>
    <ul class="pc-submenu">
      <?php if(in_array('leave2',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['leave_request_active']))echo $arr_mod['leave_request_active'];?>"> <a class="pc-link" href="<?= site_url('erp/leave-list');?>" >
        <?= lang('Leave.left_leave_request');?>
        </a> </li>
      <?php } ?>
	  <?php if(in_array('expense1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['expense_active']))echo $arr_mod['expense_active'];?>"> <a class="pc-link" href="<?= site_url('erp/expense-list');?>" >
        <?= lang('Dashboard.dashboard_expense_claim');?>
        </a> </li>
      <?php } ?>
	  <?php if(in_array('loan1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['travel_active']))echo $arr_mod['travel_active'];?>"> <a class="pc-link" href="<?= site_url('erp/loan-request');?>" >
        <?= lang('Main.xin_request_loan');?>
        </a> </li>
      <?php } ?>
      <?php if(isset($setup_modules['travel'])): if($setup_modules['travel']==1):?>
	  <?php if(in_array('travel1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['travel_active']))echo $arr_mod['travel_active'];?>"> <a class="pc-link" href="<?= site_url('erp/business-travel');?>" >
        <?= lang('Dashboard.dashboard_travel_request');?>
        </a> </li>
      <?php } ?>
      <?php endif; endif;?>
      <?php if(in_array('advance_salary1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['travel_active']))echo $arr_mod['travel_active'];?>"> <a class="pc-link" href="<?= site_url('erp/advance-salary');?>" >
        <?= lang('Main.xin_advance_salary');?>
        </a> </li>
      <?php } ?>
      <?php if(in_array('overtime_req1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['overtime_active']))echo $arr_mod['overtime_active'];?>"> <a class="pc-link" href="<?= site_url('erp/overtime-request');?>" >
        <?= lang('Dashboard.xin_overtime_request');?>
        </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <!-- Tickets -->
  <?php if(in_array('helpdesk1',staff_role_resource())) {?> 
  <li class="pc-item"><a href="<?= site_url('erp/support-tickets');?>" class="pc-link "><span class="pc-micon"><i data-feather="help-circle"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.dashboard_helpdesk');?>
    </span></a></li>
  <?php } ?>
  <?php if(isset($setup_modules['training'])): if($setup_modules['training']==1):?>
  <?php if(in_array('training1',staff_role_resource()) || in_array('trainer1',staff_role_resource()) || in_array('training_skill1',staff_role_resource()) || in_array('training_calendar',staff_role_resource())) {?> 
  <!-- Training Session -->
  <li class="pc-item"> <a href="<?= site_url('erp/training-sessions');?>" class="pc-link"> <span class="pc-micon"><i data-feather="target"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_training');?>
    </span> </a> </li>
  <?php } ?>
  <?php endif; endif;?>
  <?php if(in_array('staff2',staff_role_resource()) || in_array('shift1',staff_role_resource()) || in_array('staffexit1',staff_role_resource()) || in_array('news1',staff_role_resource()) || in_array('department1',staff_role_resource()) || in_array('designation1',staff_role_resource()) || in_array('policy1',staff_role_resource()) || in_array('accounts1',staff_role_resource()) || in_array('deposit1',staff_role_resource()) || in_array('expense1',staff_role_resource()) || in_array('dep_cat1',staff_role_resource()) || in_array('exp_cat1',staff_role_resource()) || in_array('indicator1',staff_role_resource()) || in_array('appraisal1',staff_role_resource()) || in_array('competency1',staff_role_resource()) || in_array('tracking1',staff_role_resource()) || in_array('track_type1',staff_role_resource()) || in_array('track_calendar',staff_role_resource()) || in_array('client1',staff_role_resource()) || in_array('invoice2',staff_role_resource()) || in_array('invoice_payments',staff_role_resource()) || in_array('invoice_calendar',staff_role_resource()) || in_array('tax_type1',staff_role_resource()) || in_array('training1',staff_role_resource()) || in_array('trainer1',staff_role_resource()) || in_array('training_skill1',staff_role_resource()) || in_array('training_calendar',staff_role_resource()) || in_array('disciplinary1',staff_role_resource()) || in_array('case_type1',staff_role_resource())) {?>
  <li class="pc-item pc-caption">
    <label>
      <?= lang('Dashboard.dashboard_your_company');?>
    </label>
  </li>
  <?php }?>
  <?php if(in_array('staff2',staff_role_resource()) || in_array('shift1',staff_role_resource()) || in_array('staffexit1',staff_role_resource())) {?>
  <!-- Employees -->
  <li class="pc-item"><a href="<?= site_url('erp/staff-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="users"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.dashboard_employees');?>
    </span></a></li>
  <?php } ?>
  <?php if(isset($setup_modules['recruitment'])): if($setup_modules['recruitment']==1):?>
  <?php if(in_array('ats2',staff_role_resource()) || in_array('candidate',staff_role_resource()) || in_array('interview',staff_role_resource()) || in_array('promotion',staff_role_resource())) {?>
  <!-- Recruitment -->
  <li class="pc-item"> <a href="<?= site_url('erp/jobs-list');?>" class="pc-link"> <span class="pc-micon"><i data-feather="gitlab"></i></span><span class="pc-mtext">
    <?= lang('Recruitment.xin_recruitment_ats');?>
    </span> </a> </li>
  <?php } ?>
  <?php endif; endif;?>
  <?php if(in_array('news1',staff_role_resource()) || in_array('department1',staff_role_resource()) || in_array('designation1',staff_role_resource()) || in_array('policy1',staff_role_resource())) {?>
  <!-- CoreHR -->
  <li class="pc-item <?php if(!empty($arr_mod['corehr_open']))echo $arr_mod['corehr_open'];?>"> <a href="#" class="pc-link sidenav-toggle"> <span class="pc-micon"><i data-feather="crosshair"></i></span>
    <?= lang('Dashboard.dashboard_core_hr');?>
    </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span> </a>
    <ul class="pc-submenu" <?php if(!empty($arr_mod['core_style_ul']))echo $arr_mod['core_style_ul'];?>>
      <?php if(in_array('department1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['department_active']))echo $arr_mod['department_active'];?>"> <a class="pc-link" href="<?= site_url('erp/departments-list');?>" >
        <?= lang('Dashboard.left_department');?>
        </a> </li>
       <?php } ?>
      <?php if(in_array('designation1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['designation_active']))echo $arr_mod['designation_active'];?>"> <a class="pc-link" href="<?= site_url('erp/designation-list');?>" >
        <?= lang('Dashboard.left_designation');?>
        </a> </li>
       <?php } ?>
      <?php if(in_array('policy1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['policies_active']))echo $arr_mod['policies_active'];?>"> <a class="pc-link" href="<?= site_url('erp/policies-list');?>" >
        <?= lang('Dashboard.header_policies');?>
        </a> </li>
       <?php } ?>
      <?php if(in_array('news1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['announcements_active']))echo $arr_mod['announcements_active'];?>"> <a class="pc-link" href="<?= site_url('erp/news-list');?>" >
        <?= lang('Dashboard.left_announcement_make');?>
        </a> </li>
       <?php } ?>
       <?php if(in_array('org_chart',staff_role_resource())) {?>
       <li class="pc-item <?php if(!empty($arr_mod['announcements_active']))echo $arr_mod['announcements_active'];?>"> <a class="pc-link" href="<?= site_url('erp/chart');?>" >
        <?= lang('Dashboard.xin_org_chart_title');?>
        </a> </li>
       <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if(in_array('accounts1',staff_role_resource()) || in_array('deposit1',staff_role_resource()) || in_array('expense1',staff_role_resource()) || in_array('dep_cat1',staff_role_resource()) || in_array('exp_cat1',staff_role_resource())) {?>
  <!-- Finance -->
  <li class="pc-item"> <a href="<?= site_url('erp/accounts-list');?>" class="pc-link"> <span class="pc-micon"><i data-feather="credit-card"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_hr_finance');?>
    </span> </a> </li>
  <?php } ?>  
  <?php if(isset($setup_modules['performance'])): if($setup_modules['performance']==1):?>
  <?php if(in_array('indicator1',staff_role_resource()) || in_array('appraisal1',staff_role_resource()) || in_array('competency1',staff_role_resource()) || in_array('tracking1',staff_role_resource()) || in_array('track_type1',staff_role_resource()) || in_array('track_calendar',staff_role_resource())) {?>  
  <!-- Performance -->
  <li class="<?php if(!empty($arr_mod['talent_open']))echo $arr_mod['talent_open'];?> pc-item"> <a href="#" class="pc-link sidenav-toggle"> <span class="pc-micon"><i data-feather="aperture"></i></span>
    <?= lang('Dashboard.left_talent_management');?>
    </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span> </a>
    <ul class="pc-submenu" <?php if(!empty($arr_mod['talent_style_ul']))echo $arr_mod['talent_style_ul'];?>>
      <?php if(in_array('indicator1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['indicator_active']))echo $arr_mod['indicator_active'];?>"> <a class="pc-link" href="<?= site_url('erp/performance-indicator-list');?>" >
        <?= lang('Dashboard.left_performance_indicator');?>
        </a> </li>
      <?php } ?>
      <?php if(in_array('appraisal1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['appraisal_active']))echo $arr_mod['appraisal_active'];?>"> <a class="pc-link" href="<?= site_url('erp/performance-appraisal-list');?>">
        <?= lang('Dashboard.left_performance_appraisal');?>
        </a> </li>
      <?php } ?>
      <?php if(in_array('competency1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['competencies_active']))echo $arr_mod['competencies_active'];?>"> <a class="pc-link" href="<?= site_url('erp/competencies');?>">
        <?= lang('Performance.xin_competencies');?>
        </a> </li>
      <?php } ?>
      <?php if(in_array('tracking1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['goal_track_active']))echo $arr_mod['goal_track_active'];?>"> <a class="pc-link" href="<?= site_url('erp/track-goals');?>" >
        <?= lang('Dashboard.xin_hr_goal_tracking');?>
        </a> </li>
      <?php } ?>
      <?php if(in_array('track_type1',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['tracking_type_active']))echo $arr_mod['tracking_type_active'];?>"> <a class="pc-link" href="<?= site_url('erp/goal-type');?>" >
        <?= lang('Dashboard.xin_hr_goal_tracking_type');?>
        </a> </li>
      <?php } ?>
      <?php if(in_array('track_calendar',staff_role_resource())) {?>
      <li class="pc-item <?php if(!empty($arr_mod['goals_calendar_active']))echo $arr_mod['goals_calendar_active'];?>"> <a class="pc-link" href="<?= site_url('erp/goals-calendar');?>" >
        <?= lang('Performance.xin_goals_calendar');?>
        </a> </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php endif; endif;?>
  <?php if(isset($setup_modules['inventory'])): if($setup_modules['inventory']==1):?>
  <?php if(in_array('warehouse1',staff_role_resource()) || in_array('product1',staff_role_resource()) || in_array('out_of_stock',staff_role_resource()) || in_array('expired_product',staff_role_resource()) || in_array('product_category1',staff_role_resource()) || in_array('supplier1',staff_role_resource()) || in_array('purchases1',staff_role_resource()) || in_array('purchases2',staff_role_resource()) || in_array('sales_order1',staff_role_resource()) || in_array('sales_order2',staff_role_resource()) || in_array('quote_order1',staff_role_resource()) || in_array('quote_order2',staff_role_resource()) || in_array('paid_orders',staff_role_resource()) || in_array('unpaid_orders',staff_role_resource()) || in_array('packed_orders',staff_role_resource()) || in_array('delivered_orders',staff_role_resource()) || in_array('tax_type1',staff_role_resource()) || in_array('cancelled_orders',staff_role_resource())) {?>
    <li class="pc-item pc-hasmenu">
        <a href="#!" class="pc-link"><span class="pc-micon"><i data-feather="menu"></i></span><span class="pc-mtext"><?= lang('Inventory.xin_inventory_control');?></span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
        <ul class="pc-submenu">
        	<?php if(in_array('track_calendar',staff_role_resource())) {?>
            <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/warehouse-list');?>"><?= lang('Inventory.xin_warehouses');?></a></li>
            <?php } ?>
            <?php if(in_array('product1',staff_role_resource()) || in_array('out_of_stock',staff_role_resource()) || in_array('expired_product',staff_role_resource()) || in_array('product_category1',staff_role_resource()) || in_array('tax_type1',staff_role_resource())) {?>
            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link"><?= lang('Inventory.xin_products');?><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                	<?php if(in_array('product1',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/product-list');?>"><?= lang('Inventory.xin_products');?></a></li>
                    <?php } ?>
                    <?php if(in_array('out_of_stock',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/out-of-stock-products');?>"><?= lang('Inventory.xin_out_of_stock');?></a></li>
                    <?php } ?>
                    <?php if(in_array('expired_product',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/expired-products');?>"><?= lang('Inventory.xin_expired_products');?></a></li>
                    <?php } ?>
                    <?php if(in_array('tax_type1',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/tax-type');?>"><?= lang('Inventory.xin_product_tax');?></a></li>
                    <?php } ?>
                    <?php if(in_array('product_category1',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/products-category');?>"><?= lang('Inventory.xin_product_category');?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if(in_array('supplier1',staff_role_resource())) {?>
            <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/suppliers-list');?>"><?= lang('Inventory.xin_suppliers');?></a></li>
            <?php } ?>
            <?php if(in_array('purchases1',staff_role_resource()) || in_array('purchases2',staff_role_resource())) {?>
            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link"><?= lang('Inventory.xin_purchases');?><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                	<?php if(in_array('purchases1',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/create-purchase');?>"><?= lang('Inventory.xin_new_purchase');?></a></li>
                    <?php } ?>
                    <?php if(in_array('purchases2',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/stock-purchases');?>"><?= lang('Inventory.xin_purchase_list');?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if(in_array('sales_order1',staff_role_resource()) || in_array('sales_order2',staff_role_resource()) || in_array('paid_orders',staff_role_resource()) || in_array('unpaid_orders',staff_role_resource()) || in_array('packed_orders',staff_role_resource()) || in_array('delivered_orders',staff_role_resource()) || in_array('cancelled_orders',staff_role_resource()) || in_array('quote_order1',staff_role_resource()) || in_array('quote_order2',staff_role_resource())) {?>
            <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link"><?= lang('Inventory.xin_sales_order');?><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                    <?php if(in_array('sales_order1',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/stock-orders');?>"><?= lang('Inventory.xin_sales_manage');?></a></li>
                    <?php } ?>
                    <?php if(in_array('sales_order2',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/create-order');?>"><?= lang('Inventory.xin_add_new_order');?></a></li>
                    <?php } ?>
                    <?php if(in_array('paid_orders',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/paid-orders');?>"><?= lang('Inventory.xin_paid_orders');?></a></li>
                    <?php } ?>
                    <?php if(in_array('unpaid_orders',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/unpaid-orders');?>"><?= lang('Inventory.xin_unpaid_orders');?></a></li>
                    <?php } ?>
                    <?php if(in_array('packed_orders',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/packed-orders');?>"><?= lang('Inventory.xin_packed_orders');?></a></li>
                    <?php } ?>
                    <?php if(in_array('delivered_orders',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/delivered-orders');?>"><?= lang('Inventory.xin_delivered_orders');?></a></li>
                    <?php } ?>
                    <?php if(in_array('cancelled_orders',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/cancelled-orders');?>"><?= lang('Inventory.xin_cancelled_orders');?></a></li>
                    <?php } ?>
                    <?php if(in_array('quote_order1',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/order-quotes');?>"><?= lang('Inventory.xin_quote_orders');?></a></li>
                    <?php } ?>
                    <?php if(in_array('quote_order2',staff_role_resource())) {?>
                    <li class="pc-item"><a class="pc-link" href="<?= site_url('erp/create-quote');?>"><?= lang('Inventory.xin_add_quote_order');?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
    <?php endif; endif;?>
  <?php if(in_array('client1',staff_role_resource())) {?> 
  <!-- Clients -->
  <li class="pc-item"><a href="<?= site_url('erp/clients-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="user-check"></i></span><span class="pc-mtext">
    <?= lang('Projects.xin_manage_clients');?>
    </span></a></li>
  <?php } ?>
  <?php if(in_array('leads1',staff_role_resource())) {?> 
  <!-- Leads -->
  <li class="pc-item"><a href="<?= site_url('erp/leads-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="user-plus"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_leads');?>
    </span></a></li>
  <?php } ?>  
  <?php if(in_array('invoice2',staff_role_resource()) || in_array('invoice_payments',staff_role_resource()) || in_array('invoice_calendar',staff_role_resource()) || in_array('tax_type1',staff_role_resource())) {?>   
  <!-- Invoices -->
  <li class="pc-item"><a href="<?= site_url('erp/invoices-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="calendar"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_invoices_title');?>
    </span></a></li>
  <?php } ?>
  <?php if(in_array('estimate2',staff_role_resource())) {?> 
  <!-- Estimates -->
  <li class="pc-item"><a href="<?= site_url('erp/estimates-list');?>" class="pc-link "><span class="pc-micon"><i data-feather="calendar"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.xin_estimates');?>
    </span></a></li>
  <?php } ?>
  <?php if(in_array('disciplinary1',staff_role_resource()) || in_array('case_type1',staff_role_resource())) {?>   
  <!-- Disciplinary -->
  <li class="pc-item"> <a href="<?= site_url('erp/disciplinary-cases');?>" class="pc-link"> <span class="pc-micon"><i data-feather="alert-circle"></i></span><span class="pc-mtext">
    <?= lang('Dashboard.left_warnings');?>
    </span> </a> </li>
  <?php } ?>
</ul>

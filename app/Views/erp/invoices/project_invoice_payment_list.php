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
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$locale = service('request')->getLocale();
$i=1;
?>
<?php
/*
* Projects invoice list
*/
?>

<?php if(in_array('invoice2',staff_role_resource()) || in_array('invoice_payments',staff_role_resource()) || in_array('invoice_calendar',staff_role_resource()) || in_array('tax_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('invoice2',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoices-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Invoices.xin_billing_invoices');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Dashboard.xin_invoices_title');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('invoice_calendar',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoice-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_invoice_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('invoice_payments',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/invoice-payments-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-money-check-alt"></span>
      <?= lang('Dashboard.xin_acc_invoice_payments');?>
      <div class="text-muted small">
        <?= lang('Main.xin_view');?>
        <?= lang('Dashboard.xin_acc_invoice_payments');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('tax_type1',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tax-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-tasks"></span>
      <?= lang('Dashboard.xin_invoice_tax_type');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_invoice_tax_type');?>
      </div>
      </a> </li>
   <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
    <?= lang('Main.xin_list_all');?>
    </strong>
    <?= lang('Invoices.xin_billing_invoices');?>
    </span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>#</th>
            <th width="170px"><?= lang('Invoices.xin_bill_for');?></th>
            <th><?= lang('Invoices.xin_invoice_date');?></th>
            <th><?= lang('Invoices.xin_amount');?></th>
            <th><?= lang('Invoices.xin_payment_method');?></th>
            <th><?= lang('Main.dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

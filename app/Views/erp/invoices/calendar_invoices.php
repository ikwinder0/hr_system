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
    <li class="nav-item active"> <a href="<?= site_url('erp/invoice-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-plus"></span>
      <?= lang('Dashboard.xin_acc_calendar');?>
      <div class="text-muted small">
        <?= lang('Dashboard.xin_invoice_calendar');?>
      </div>
      </a> </li>
    <?php } ?>
	<?php if(in_array('invoice_payments',staff_role_resource()) || $user_info['user_type'] == 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoice-payments-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-money-check-alt"></span>
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
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-xl-2 col-md-12">
        <div id="external-events" class="external-events">
          <h4><?= lang('Dashboard.xin_hr_events');?></h4>
          <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff"><?= lang('Invoices.xin_unpaid');?></div>
          <div class="fc-event" style="background-color:#1de9b6;border-color:#1de9b6;color:#fff"><?= lang('Invoices.xin_paid');?></div>
        </div>
      </div>
      <div class="col-xl-10 col-md-12">
        <div id='calendar_hr'></div>
      </div>
    </div>
  </div>
</div>

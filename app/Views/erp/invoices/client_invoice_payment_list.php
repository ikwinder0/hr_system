<?php
/*
* All Transactions - Finance View
*/
?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
    <ul class="nav nav-tabs step-anchor">
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/my-invoices-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-calendar"></span><?= lang('Invoices.xin_billing_invoices');?>
                <div class="text-muted small"><?= lang('Invoices.xin_view_all_invoices');?></div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/my-invoices-calendar');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon fas fa-calendar-check"></span><?= lang('Dashboard.xin_invoice_calendar');?>
                <div class="text-muted small"><?= lang('Invoices.xin_view_invoice_calendar');?></div>
            </a>
        </li>
        <li class="nav-item active">
            <a href="<?= site_url('erp/my-invoice-payments-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-credit-card"></span><?= lang('Dashboard.xin_acc_invoice_payments');?>
                <div class="text-muted small"><?= lang('Invoices.xin_view_paid_invoices');?></div>
            </a>
        </li>
    </ul>
</div>
<hr class="border-light m-0 mb-3">

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
            <th width="170px"><?php echo lang('Projects.xin_project');?></th>
            <th><?= lang('Main.xin_e_details_date');?></th>
            <th><?= lang('Invoices.xin_amount');?></th>
            <th><?= lang('Invoices.xin_payment_method');?></th>
            <th><?= lang('Main.dashboard_xin_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

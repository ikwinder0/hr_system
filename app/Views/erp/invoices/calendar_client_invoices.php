<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item clickable"> <a href="<?= site_url('erp/my-invoices-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-calendar"></span>
      <?= lang('Invoices.xin_billing_invoices');?>
      <div class="text-muted small">
        <?= lang('Invoices.xin_view_all_invoices');?>
      </div>
      </a> </li>
    <li class="nav-item active"> <a href="<?= site_url('erp/my-invoices-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-calendar-check"></span>
      <?= lang('Dashboard.xin_invoice_calendar');?>
      <div class="text-muted small">
        <?= lang('Invoices.xin_view_invoice_calendar');?>
      </div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/my-invoice-payments-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-credit-card"></span>
      <?= lang('Dashboard.xin_acc_invoice_payments');?>
      <div class="text-muted small">
        <?= lang('Invoices.xin_view_paid_invoices');?>
      </div>
      </a> </li>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card">
  <div class="card-body">
    <div class="card-block">
      <div class="row">
        <div class="col-xl-2 col-md-12">
          <div id="external-events" class="external-events">
            <h4>
              <?= lang('Dashboard.xin_hr_events');?>
            </h4>
            <div class="fc-event" style="background-color:#f4c22b;border-color:#f4c22b;color:#fff">
              <?= lang('Invoices.xin_unpaid');?>
            </div>
            <div class="fc-event" style="background-color:#1de9b6;border-color:#1de9b6;color:#fff">
              <?= lang('Invoices.xin_paid');?>
            </div>
          </div>
        </div>
        <div class="col-xl-10 col-md-12">
          <div id='calendar_hr'></div>
        </div>
      </div>
    </div>
  </div>
</div>

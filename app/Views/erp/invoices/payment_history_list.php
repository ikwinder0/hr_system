<?php
/*
* All Transactions - Finance View
*/
?>
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
            <th>#Test</th>
            <th width="170px"><?= lang('Invoices.xin_bill_for');?></th>
            <th><?= lang('Membership.xin_subscription');?></th>
            <th><?= lang('Main.xin_price');?></th>
            <th><?= lang('Invoices.xin_payment_method');?></th>
            <th><?= lang('Invoices.xin_invoice_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

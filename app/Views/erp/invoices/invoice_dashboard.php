<?php
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\SystemModel;
use App\Models\ConstantsModel;
use App\Models\InvoicesModel;
//$encrypter = \Config\Services::encrypter();
$SystemModel = new SystemModel();
$RolesModel = new RolesModel();
$UsersModel = new UsersModel();
$InvoicesModel = new InvoicesModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();

$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$company_id = $user_info['company_id'];
} else {
	$company_id = $usession['sup_user_id'];
}
$unpaid = $InvoicesModel->where('company_id',$company_id)->where('status', 0)->countAllResults();
$paid = $InvoicesModel->where('company_id',$company_id)->where('status', 1)->countAllResults();

$paid_invoice = $InvoicesModel->where('company_id',$company_id)->like('created_at', 'match', 'both')->countAllResults();
?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active"> <a href="<?= site_url('erp/invoice-dashboard');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-friends"></span>
      <?= lang('Invoice Summary');?>
      <div class="text-muted small">Set up shortcuts</div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoices-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-friends"></span>
      <?= lang('Invoices.xin_billing_invoices');?>
      <div class="text-muted small">Set up shortcuts</div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoice-calendar');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-user-lock"></span>Invoice Calendar
      <div class="text-muted small">Add effects</div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/invoice-payments-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-copy"></span>Invoice Payments
      <div class="text-muted small">Select pager options</div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/tax-type');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-copy"></span>Tax Type
      <div class="text-muted small">Select pager options</div>
      </a> </li>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="row">
  <div class="col-sm-3">
    <div class="card prod-p-card background-pattern">
      <div class="card-body">
        <div class="row align-items-center m-b-0">
          <div class="col">
            <h6 class="m-b-5">Paid Amount</h6>
            <h3 class="m-b-0">$1,783</h3>
          </div>
          <div class="col-auto"> <i class="fas fa-money-bill-alt text-primary"></i> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card prod-p-card bg-primary background-pattern-white">
      <div class="card-body">
        <div class="row align-items-center m-b-0">
          <div class="col">
            <h6 class="m-b-5 text-white">Paid Invoices</h6>
            <h3 class="m-b-0 text-white">
              <?= $paid;?>
            </h3>
          </div>
          <div class="col-auto"> <i class="fas fa-database text-white"></i> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card prod-p-card bg-primary background-pattern-white">
      <div class="card-body">
        <div class="row align-items-center m-b-0">
          <div class="col">
            <h6 class="m-b-5 text-white">Due Amount</h6>
            <h3 class="m-b-0 text-white">$6,780</h3>
          </div>
          <div class="col-auto"> <i class="fas fa-dollar-sign text-white"></i> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card prod-p-card background-pattern">
      <div class="card-body">
        <div class="row align-items-center m-b-0">
          <div class="col">
            <h6 class="m-b-5">Unpaid Invoices</h6>
            <h3 class="m-b-0">
              <?= $unpaid;?>
            </h3>
          </div>
          <div class="col-auto"> <i class="fas fa-tags text-primary"></i> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-6 col-md-12">
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>Invoice Payments</h6>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="paid-invoice-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-12">
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h6>Invoice Status</h6>
            <span>It takes continuous effort to maintain high.</span>
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col">
                <div id="invoice-status-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

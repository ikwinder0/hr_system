<?php
use App\Models\SystemModel;
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\PayeesModel;
use App\Models\RolesModel;
use App\Models\ConstantsModel;
use App\Models\AccountsModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$PayeesModel = new PayeesModel();
$AccountsModel = new AccountsModel();
$LanguageModel = new LanguageModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$router = service('router');
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>
<?php if(in_array('accounts1',staff_role_resource()) || in_array('deposit1',staff_role_resource()) || in_array('expense1',staff_role_resource()) || in_array('transaction1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('accounts1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/accounts-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-money-check-alt"></span>
      <?= lang('Finance.xin_accounts');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Finance.xin_accounts');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('deposit1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/deposit-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-dollar-sign"></span>
      <?= lang('Dashboard.xin_acc_deposit');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_acc_deposit');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('expense1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/expense-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice-dollar"></span>
      <?= lang('Dashboard.xin_acc_expense');?>
      <div class="text-muted small">
        <?= lang('Main.xin_add');?>
        <?= lang('Dashboard.xin_acc_expense');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('transaction1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/transactions-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-donate"></span>
      <?= lang('Dashboard.xin_acc_transactions');?>
      <div class="text-muted small">
        <?= lang('Main.xin_view_all');?>
        <?= lang('Dashboard.xin_acc_transactions');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.xin_acc_transactions');?>
    </h5>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?= lang('Employees.xin_account_title');?></th>
            <th><?= lang('Main.xin_e_details_date');?></th>
            <th>&nbsp;</th>
            <th><?= lang('Finance.xin_type');?></th>
            <th><?= lang('Invoices.xin_amount');?></th>
            <th><?= lang('Finance.xin_acc_ref_no');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

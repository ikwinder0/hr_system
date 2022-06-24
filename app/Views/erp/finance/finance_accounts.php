<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\PayeesModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$SystemModel = new SystemModel();
$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
/*
* Finance||Accounts - View Page
*/
?>
<?php if(in_array('accounts1',staff_role_resource()) || in_array('deposit1',staff_role_resource()) || in_array('expense1',staff_role_resource()) || in_array('transaction1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>

<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('accounts1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
    <li class="nav-item active"> <a href="<?= site_url('erp/accounts-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-money-check-alt"></span>
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
    <li class="nav-item clickable"> <a href="<?= site_url('erp/transactions-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-donate"></span>
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
<div class="row m-b-1">
<?php if(in_array('accounts2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements">
        <h5>
          <?= lang('Main.xin_add_new');?>
          <?= lang('Finance.xin_account');?>
        </h5>
      </div>
      <?php $attributes = array('name' => 'add_account', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/finance/add_account', $attributes, $hidden);?>
      <div class="card-body">
        <div class="form-group">
          <label for="account_name">
            <?= lang('Employees.xin_account_title');?> <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control" name="account_name" placeholder="<?= lang('Employees.xin_account_title');?>">
        </div>
        <div class="form-group">
          <label for="account_balance">
            <?= lang('Finance.xin_acc_initial_balance');?> <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">
              <?= $xin_system['default_currency'];?>
              </span></div>
            <input type="text" class="form-control" name="account_balance" placeholder="<?= lang('Finance.xin_acc_initial_balance');?>">
          </div>
        </div>
        <div class="form-group">
          <label for="account_number">
            <?= lang('Employees.xin_account_number');?> <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control" name="account_number" placeholder="<?= lang('Employees.xin_account_number');?>">
        </div>
        <div class="form-group">
          <label for="branch_code">
            <?= lang('Finance.xin_acc_branch_code');?>
          </label>
          <input type="text" class="form-control" name="branch_code" placeholder="<?= lang('Finance.xin_acc_branch_code');?>">
        </div>
        <div class="form-group">
          <label for="description">
            <?= lang('Employees.xin_bank_branch');?>
          </label>
          <textarea class="form-control" name="bank_branch" placeholder="<?= lang('Employees.xin_bank_branch');?>" rows="3"></textarea>
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
        <?= lang('Main.xin_save');?>
        </button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?= $colmdval;?>">
    <div class="card user-profile-list">
      <div class="card-header with-elements">
        <h5>
          <?= lang('Main.xin_list_all');?>
          <?= lang('Finance.xin_accounts');?>
        </h5>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?= lang('Employees.xin_account_title');?></th>
                <th><?= lang('Employees.xin_account_number');?></th>
                <th><?= lang('Finance.xin_balance');?></th>
                <th><?= lang('Employees.xin_bank_branch');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

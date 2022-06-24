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

$xin_system = erp_company_settings();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
if($user_info['user_type'] == 'staff'){
	$accounts = $AccountsModel->where('company_id', $user_info['company_id'])->orderBy('account_id', 'ASC')->findAll();
	$category_info = $ConstantsModel->where('company_id', $user_info['company_id'])->where('type','expense_type')->orderBy('constants_id', 'ASC')->findAll();
	$payers_info = $UsersModel->where('company_id', $user_info['company_id'])->where('user_type','staff')->findAll();
} else {
	$accounts = $AccountsModel->where('company_id', $usession['sup_user_id'])->orderBy('account_id', 'ASC')->findAll();
	$category_info = $ConstantsModel->where('company_id', $usession['sup_user_id'])->where('type','expense_type')->orderBy('constants_id', 'ASC')->findAll();
	$payers_info = $UsersModel->where('company_id', $usession['sup_user_id'])->where('user_type','staff')->findAll();
}
// payment method
$payment_method = $ConstantsModel->where('type','payment_method')->orderBy('constants_id', 'ASC')->findAll();
$get_animate = '';
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
    <li class="nav-item active"> <a href="<?= site_url('erp/expense-list');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon fas fa-file-invoice-dollar"></span>
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
<?php if(in_array('expense2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
<div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
  <?php $attributes = array('name' => 'add_expense', 'id' => 'xin-form', 'autocomplete' => 'off');?>
  <?php $hidden = array('_user' => 1);?>
  <?php echo form_open('erp/finance/add_expense', $attributes, $hidden);?>
  <div class="row">
    <div class="col-md-8">
      <div class="card mb-2">
        <div id="accordion">
          <div class="card-header">
            <h5>
              <?= lang('Main.xin_add_new');?>
              <?= lang('Dashboard.xin_acc_expense');?>
            </h5>
            <div class="card-header-right"> <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="minus"></i>
              <?= lang('Main.xin_hide');?>
              </a> </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account_id">
                    <?= lang('Employees.xin_account_title');?> <span class="text-danger">*</span>
                  </label>
                  <select name="account_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Employees.xin_account_title');?>">
                    <option value=""></option>
                    <?php foreach($accounts as $iaccounts) {?>
                    <option value="<?php echo $iaccounts['account_id'];?>"><?php echo $iaccounts['account_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="month_year">
                    <?= lang('Invoices.xin_amount');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                      <?= $xin_system['default_currency'];?>
                      </span></div>
                    <input class="form-control" name="amount" type="text" placeholder="<?= lang('Invoices.xin_amount');?>">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="deposit_date">
                    <?= lang('Main.xin_e_details_date');?> <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" name="deposit_date" type="text">
                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="employee">
                    <?= lang('Dashboard.xin_category');?> <span class="text-danger">*</span>
                  </label>
                  <select name="category_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Finance.xin_acc_choose_category');?>">
                    <option value=""></option>
                    <?php foreach($category_info as $icategory) {?>
                    <option value="<?= $icategory['constants_id']?>">
                    <?= $icategory['category_name']?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="employee">
                    <?= lang('Dashboard.xin_acc_payee');?> <span class="text-danger">*</span>
                  </label>
                  <select name="payer_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_acc_payee');?>">
                    <option value=""></option>
                    <?php foreach($payers_info as $payer) {?>
                    <option value="<?php echo $payer['user_id'];?>"> <?php echo $payer['first_name'].' '.$payer['last_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="payment_method">
                    <?= lang('Main.xin_payment_method');?> <span class="text-danger">*</span>
                  </label>
                  <select name="payment_method" class="form-control" data-plugin="select_hrm" data-placeholder="<?= lang('Main.xin_payment_method');?>">
                    <option value=""></option>
                    <?php foreach($payment_method as $ipayment_method) {?>
                    <option value="<?php echo $ipayment_method['constants_id'];?>"> <?php echo $ipayment_method['category_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="employee">
                    <?= lang('Finance.xin_acc_ref_no');?>
                  </label>
                  <input class="form-control" placeholder="<?= lang('Finance.xin_acc_ref_example');?>" name="reference" type="text">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description">
                    <?= lang('Main.xin_description');?>
                  </label>
                  <textarea class="form-control textarea" placeholder="<?= lang('Main.xin_description');?>" name="description" cols="30" rows="2"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="reset" class="btn btn-light" href="#add_form" data-toggle="collapse" aria-expanded="false">
            <?= lang('Main.xin_reset');?>
            </button>
            &nbsp;
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5>
            <?= lang('Finance.xin_attachment_expense');?>
          </h5>
        </div>
        <div class="card-body py-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="logo">
                  <?= lang('Main.xin_attachment');?>
                  <span class="text-danger">*</span> </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="attachment">
                  <label class="custom-file-label">
                    <?= lang('Main.xin_choose_file');?>
                  </label>
                  <small>
                  <?= lang('Main.xin_company_file_type');?>
                  </small> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= form_close(); ?>
</div>
<?php } ?>
<div class="card user-profile-list">
  <div class="card-header">
    <h5>
      <?= lang('Main.xin_list_all');?>
      <?= lang('Dashboard.xin_acc_expense');?>
    </h5>
    <div class="card-header-right">
      <?php if(in_array('exp_cat1',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <a href="<?= site_url('erp/expense-type');?>" class="collapsed btn btn-sm waves-effect waves-light btn-primary m-0"> <i data-feather="plus"></i>
      <?= lang('Dashboard.xin_categories');?>
      </a>
      <?php } ?>
      <?php if(in_array('expense2',staff_role_resource()) || $user_info['user_type'] == 'company') {?>
      <a  data-toggle="collapse" href="#add_form" aria-expanded="false" class="collapsed btn waves-effect waves-light btn-primary btn-sm m-0"> <i data-feather="plus"></i>
      <?= lang('Main.xin_add_new');?>
      </a>
      <?php } ?>
    </div>
  </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?= lang('Employees.xin_account_title');?></th>
            <th><?= lang('Dashboard.xin_acc_payee');?></th>
            <th><?= lang('Invoices.xin_amount');?></th>
            <th><?= lang('Dashboard.xin_category');?></th>
            <th><?= lang('Finance.xin_acc_ref_no');?></th>
            <th><?= lang('Main.xin_payment_method');?></th>
            <th><?= lang('Main.xin_e_details_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

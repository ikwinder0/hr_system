<?php 
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\PayeesModel;

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$UsersModel = new UsersModel();
$RolesModel = new RolesModel();
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
/*
* Finance||Payee - View Page
*/
?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
    <ul class="nav nav-tabs step-anchor">        
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/expense-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span><?= lang('Dashboard.xin_acc_expense');?>
                <div class="text-muted small">Select pager options</div>
            </a>
        </li>
        <li class="nav-item clickable">
            <a href="<?= site_url('erp/expense-type');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span><?= lang('xin_acc_category');?>
                <div class="text-muted small">Select pager options</div>
            </a>
        </li>
        <li class="nav-item active">
            <a href="<?= site_url('erp/payees-list');?>" class="mb-3 nav-link">
                <span class="sw-done-icon feather icon-check-circle"></span>
                <span class="sw-icon feather icon-copy"></span><?= lang('xin_acc_payees');?>
                <div class="text-muted small">Select pager options</div>
            </a>
        </li>
    </ul>
</div>
<hr class="border-light m-0 mb-3">

<div class="row m-b-1">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements">
        <h5>
          <?= lang('xin_add_new');?>
          <?= lang('xin_acc_payee');?>
        </h5>
      </div>
      <?php $attributes = array('name' => 'add_payee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => 1);?>
      <?php echo form_open('erp/finance/add_payee', $attributes, $hidden);?>
      <div class="card-body">
        <div class="form-group">
          <label for="account_name">
            <?= lang('xin_acc_payee');?>
          </label>
          <input type="text" class="form-control" name="name" placeholder="<?= lang('xin_acc_payee_name');?>">
        </div>
        <div class="form-group">
          <label for="account_balance">
            <?= lang('xin_contact_number');?>
          </label>
          <input type="text" class="form-control" name="contact_number" placeholder="<?= lang('xin_contact_number');?>">
        </div>
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary"><?= lang('Main.xin_save');?></button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card user-profile-list">
      <div class="card-header with-elements">
        <h5>
          <?= lang('xin_list_all');?>
          <?= lang('xin_acc_payees');?>
        </h5>
      </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?= lang('xin_acc_payee');?></th>
                <th><?= lang('xin_contact_number');?></th>
                <th><?= lang('xin_acc_created_at');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
/*
* Languages - View Page
*/
?>
<?php
use App\Models\UsersModel;
use App\Models\LanguageModel;
use App\Models\SystemModel;
use App\Models\CountryModel;
use App\Models\ConstantsModel;
$LanguageModel = new LanguageModel();
$SystemModel = new SystemModel();
$CountryModel = new CountryModel();
$UsersModel = new UsersModel();
$ConstantsModel = new ConstantsModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$request = \Config\Services::request();
$router = service('router');

$user = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
$language = $LanguageModel->where('is_active', 1)->orderBy('language_id', 'ASC')->findAll();
$xin_system = $SystemModel->where('setting_id', 1)->first();
?>
<div id="smartwizard-2" class="border-bottom smartwizard-example sw-main sw-theme-default mt-2">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('settings1',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/system-settings');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-settings"></span>
      <?= lang('Main.left_settings');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_settings');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings2',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/system-constants');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-activity"></span>
      <?= lang('Main.left_constants');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_constants');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings3',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/email-templates');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-mail"></span>
      <?= lang('Main.left_email_templates');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.left_email_templates');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings7',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item clickable"> <a href="<?= site_url('erp/sms-templates');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-message-circle"></span>
      <?= lang('Main.xin_sms_templates');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.xin_sms_templates');?>
      </div>
      </a> </li>
    <?php } ?>
    <?php if(in_array('settings4',staff_role_resource()) || $user['user_type']== 'company') { ?>
    <li class="nav-item active"> <a href="<?= site_url('erp/all-languages');?>" class="mb-3 nav-link"> <span class="sw-done-icon feather icon-check-circle"></span> <span class="sw-icon feather icon-flag"></span>
      <?= lang('Main.xin_multi_language');?>
      <div class="text-muted small">
        <?= lang('Main.xin_set_up');?>
        <?= lang('Main.xin_multi_language');?>
      </div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">

<div class="row m-b-1">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_add_new');?>
        </strong>
        <?= lang('Language.xin_language');?>
        </span> </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_language', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?php echo form_open('erp/languages/add_language', $attributes, $hidden);?>
        <div class="form-group">
          <label for="account_name">
            <?= lang('Main.xin_name');?>
            <span class="text-danger">*</span> </label>
          <input type="text" class="form-control" name="language_name" placeholder="<?= lang('Main.xin_name');?>">
        </div>
        <div class="form-group">
          <label for="account_balance">
            <?= lang('Main.xin_code');?>
            <span class="text-danger">*</span> </label>
          <input type="text" class="form-control" name="language_code" placeholder="<?= lang('Main.xin_code');?>">
        </div>
        <div class="form-group">
          <label for="logo">
            <?= lang('Language.xin_flag');?>
            <span class="text-danger">*</span> </label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="language_flag" name="language_flag">
            <label class="custom-file-label">Choose file...</label>
            <small>
            <?= lang('Main.xin_company_file_type');?>
            </small> </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
            <?= lang('Main.xin_save');?>
            </button>
          </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card user-profile-list">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>
        <?= lang('Main.xin_list_all');?>
        </strong>
        <?= lang('Language.xin_languages');?>
        </span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?= lang('Main.xin_name');?></th>
                <th><?= lang('Main.xin_code');?></th>
                <th><?= lang('Main.dashboard_xin_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
